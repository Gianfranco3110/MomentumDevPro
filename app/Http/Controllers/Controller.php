<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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
}
