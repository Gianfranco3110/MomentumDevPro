<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Message;
use App\Models\User;

class MessagesController extends Controller
{
    /**
     * GET /api/messages/unread-count
     * Retorna la cantidad de mensajes no leídos recibidos por el usuario autenticado.
     */
    public function unreadCount()
    {
        $userId = auth()->id();

        $count = Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['unread' => $count]);
    }

    /**
     * GET /api/messages/conversations
     * Solo admin: lista todos los usuarios que han escrito al admin,
     * con el último mensaje y cantidad de no leídos por conversación.
     */
    public function conversations()
    {
        $adminId = auth()->id();

        // Obtener IDs únicos de usuarios que escribieron al admin
        $senderIds = Message::where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->selectRaw('IF(sender_id = ?, receiver_id, sender_id) as user_id', [$adminId])
            ->distinct()
            ->pluck('user_id')
            ->filter(fn($id) => $id != $adminId)
            ->unique()
            ->values();

        $conversations = [];

        foreach ($senderIds as $userId) {
            $user = User::find($userId);
            if (!$user) continue;

            $lastMessage = Message::where(function ($q) use ($adminId, $userId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($adminId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $adminId);
            })->latest()->first();

            $unread = Message::where('sender_id', $userId)
                ->where('receiver_id', $adminId)
                ->whereNull('read_at')
                ->count();

            $conversations[] = [
                'user_id'      => $user->id,
                'name'         => $user->name,
                'photo'        => $user->photo ?? null,
                'last_message' => $lastMessage ? $lastMessage->body : '',
                'last_time'    => $lastMessage ? $lastMessage->created_at : null,
                'unread'       => $unread,
            ];
        }

        // Ordenar por fecha del último mensaje, más reciente primero
        usort($conversations, function ($a, $b) {
            return $b['last_time'] <=> $a['last_time'];
        });

        return response()->json($conversations);
    }

    /**
     * GET /api/messages/{userId}
     * Historial completo de mensajes entre el usuario autenticado y {userId}.
     */
    public function history($userId)
    {
        $authId = auth()->id();

        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($authId) {
                return [
                    'id'             => $msg->id,
                    'body'           => $msg->body,
                    'mine'           => $msg->sender_id === $authId,
                    'read_at'        => $msg->read_at,
                    'created_at'     => $msg->created_at,
                    'sender_id'      => $msg->sender_id,
                    'sender_photo'   => $msg->sender ? $msg->sender->photo ?? null : null,
                    'receiver_id'    => $msg->receiver_id,
                    'receiver_photo' => $msg->receiver ? $msg->receiver->photo ?? null : null,
                ];
            });

        return response()->json($messages);
    }

    /**
     * POST /api/messages
     * Enviar un mensaje. Si el receptor es admin, notifica por Telegram.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'body'        => 'required|string|max:2000',
        ]);

        $sender = auth()->user();

        $message = Message::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $request->receiver_id,
            'body'        => $request->body,
        ]);

        // Notificar por Telegram si el receptor es admin
        $receiver = User::find($request->receiver_id);
        if ($receiver && $receiver->hasRole('admin')) {
            $this->notifyTelegram($sender->name, $request->body);
        }

        return response()->json([
            'id'         => $message->id,
            'body'       => $message->body,
            'mine'       => true,
            'read_at'    => null,
            'created_at' => $message->created_at,
        ], 201);
    }

    /**
     * PUT /api/messages/{userId}/read
     * Marca como leídos todos los mensajes enviados por {userId} al usuario autenticado.
     */
    public function markRead($userId)
    {
        $authId = auth()->id();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * GET /api/messages/admin-id
     * Retorna el ID del primer usuario con rol admin (para que el usuario sepa a quién escribirle).
     */
    public function adminId()
    {
        $admin = User::role('admin')->first();

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        return response()->json(['admin_id' => $admin->id, 'admin_name' => $admin->name]);
    }

    /**
     * Envía notificación al admin vía Telegram Bot.
     */
    private function notifyTelegram(string $senderName, string $body): void
    {
        $token  = env('TELEGRAM_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) {
            \Log::warning('TELEGRAM: Token o Chat ID no configurado.');
            return;
        }

        $text = "💬 Nuevo mensaje de *{$senderName}*:\n{$body}";

        try {
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $text,
                'parse_mode' => 'Markdown',
            ]);
            if (!$response->successful()) {
                \Log::error('TELEGRAM: Error en respuesta', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } else {
                \Log::info('TELEGRAM: Mensaje enviado correctamente.');
            }
        } catch (\Exception $e) {
            \Log::error('TELEGRAM: Excepción al enviar mensaje', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
