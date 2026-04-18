<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\SiteResource;

class SiteResourceController extends Controller
{
    const FOLDER = 'site-resources';

    /**
     * Devuelve la ruta física del document root del servidor.
     * En local (artisan serve) usa public_path(); en Hostinger usa DOCUMENT_ROOT (public_html).
     */
    private function resourceFolder(): string
    {
        return rtrim($_SERVER['DOCUMENT_ROOT'] ?? public_path(), '/') . '/' . self::FOLDER;
    }

    /**
     * GET /api/site-resources/{section}
     * Público — retorna la URL del recurso actual para la sección indicada.
     */
    public function show($section)
    {
        $resource = SiteResource::where('section', $section)->first();

        if (!$resource || !$resource->filename) {
            return response()->json(['url' => null]);
        }

        $url = url(self::FOLDER . '/' . $resource->filename);

        return response()->json(['url' => $url]);
    }

    /**
     * POST /api/site-resources/upload
     * Admin — recibe 'section' y 'file', guarda en public/site-resources/ y actualiza la BD.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'section' => 'required|string|in:home_video,login_image,dashboard_banner,register_image',
            'file'    => 'required|file|max:204800',
        ]);

        $resource = SiteResource::where('section', $request->section)->firstOrFail();

        $folder = $this->resourceFolder();
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Eliminar archivo anterior si existe
        if ($resource->filename) {
            $oldPath = $folder . '/' . $resource->filename;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->move($folder, $filename);

        $resource->update(['filename' => $filename]);

        return response()->json([
            'message' => 'Recurso actualizado correctamente.',
            'url'     => url(self::FOLDER . '/' . $filename),
        ]);
    }

    /**
     * DELETE /api/site-resources/{section}
     * Admin — elimina el archivo personalizado y deja filename = null (vuelve al default).
     */
    public function reset($section)
    {
        $allowed = ['home_video', 'login_image', 'dashboard_banner', 'register_image'];
        if (!in_array($section, $allowed)) {
            return response()->json(['message' => 'Sección no válida.'], 422);
        }

        $resource = SiteResource::where('section', $section)->firstOrFail();

        if ($resource->filename) {
            $path = $this->resourceFolder() . '/' . $resource->filename;
            if (File::exists($path)) {
                File::delete($path);
            }
            $resource->update(['filename' => null]);
        }

        return response()->json(['message' => 'Recurso restablecido al valor por defecto.']);
    }
}
