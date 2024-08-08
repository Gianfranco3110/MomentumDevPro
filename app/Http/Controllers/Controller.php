<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const LINK_CLIENT = "https://yariestilospmu.com";
    const FOLDERCOURSE = "imgcourse";


    public static function formLinkIframeVideo($linkValue)
    {
        $dataResp = "";
        $url = parse_url($linkValue);

        if (array_key_exists('host', $url)) {
            $host = $url['host'];
            $hostName = explode('.', $host)[1];

            if ($hostName == 'youtube') {
                // Extraer el ID del video de la URL
                parse_str(parse_url($linkValue, PHP_URL_QUERY), $query);
                $videoId = $query['v'] ?? null;

                if ($videoId) {
                    // Construir la nueva URL embebida
                    $dataResp = 'https://www.youtube.com/embed/' . $videoId;
                } else {
                    // Manejar el caso en el que no se encuentre el ID del video
                    $dataResp = "No se pudo extraer el ID del video de YouTube.";
                }
            } else {
                $dataResp = $url;
            }
        } else {
            $dataResp = null;
        }

        return $dataResp;
    }


    public static function notificationAsingCourse($course,$user) {
        $admins = User::where('menuroles', 'like', '%admin%')->get();

        $domain = Controller::LINK_CLIENT;
        $url = $domain."#/login";

        $data['url']= $url;
        $data["title"] = "curso asignado";

        $data['user']= $user;
        $data['course']= $course;
        $data['body']= "Porfavor haz click aqui para cambiar contraseña";


        $data['adress_company']= "Barquisimeto Estado Lara";
        $data['phone_company']= "+58412-000-00-00";
        $data['email_company']= "Yaretzystilospmu@gmail.com";

        $data['link_facebook']= "https://www.facebook.com/TeboriBrows/";
        $data['link_twitter']= "#";
        $data['link_instagram']= "https://www.instagram.com/teboribrows/";
        $data['link_linkedin']= "#";

        foreach ($admins as $value) {
            $data['admin']= $value;
            Mail::send('email.notifications.asignationcourse', $data, function ($message) use ($value) {
                $message->to($value->email)->subject('Notificación de compra');
            });
        }
    }

    public static function GenerateCodeUnique($longitud = 16) {
        // Define el conjunto de caracteres permitidos
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codigo = '';

        // Genera un código aleatorio de la longitud especificada
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $codigo;
    }
}

