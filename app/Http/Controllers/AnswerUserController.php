<?php

namespace App\Http\Controllers;

use App\Models\answerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnswerUserController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        if($request->input('tipo') === '1'){
            $data = $request->input('answer');
            $respDta = [];
            foreach ($data as $key=>$item) {
                $AnswerUser = new AnswerUser();
                $AnswerUser->users_id = $request->input('id_user');
                $AnswerUser->question_id = $item['id_question'];

                // Guardar el nombre del archivo con su extensión
                $archivo = $request->file('answer.' . $key . '.answer');
                $nombreCampo = 'answer.' . $key . '.answer';

                if ($request->hasFile($nombreCampo)) {
                    $archivo = $request->file($nombreCampo);
                    // Generar un nombre único para el archivo
                    $nombreArchivo = $archivo->hashName();

                    // Crear la estructura de carpetas si no existe
                    $carpeta = 'imgquestion/user_' . $request->input('id_user') . '/question_' . $item['id_question'];
                    Storage::makeDirectory($carpeta);

                    // Mover el archivo a la carpeta de almacenamiento
                    $archivo->move(storage_path('app/' . $carpeta), $nombreArchivo);

                    $AnswerUser->answer = $nombreArchivo;
                    $rutaGuardado = $carpeta . '/' . $nombreArchivo;
                }
                // $nombreArchivo = $archivo->getClientOriginalName();
                $AnswerUser->save();
                $respDta[$key]= $AnswerUser;
                // Guardar la imagen en el servidor
                // $archivo->store('ruta_de_guardado');
            }
            return $AnswerUser ? response()->json(['message'=>"Operacón realizado con éxito", 'data'=>$respDta],200) : response()->json(['message'=>"Error al realizar esta operacón"],500);

        }else{
            $data = $request->input('answer');
            $respDta = [];
           foreach ($data as $key=> $item) {
                $AnswerUser = new AnswerUser();
                $AnswerUser->users_id = $request->input('id_user');
                $AnswerUser->question_id = $item['id_question'];
                $AnswerUser->answer = $item['answer'];
                $AnswerUser->save();
                $respDta[$key] = $AnswerUser;
            }

            return $AnswerUser ? response()->json(['message'=>"Operacón realizado con éxito", 'data'=>$respDta],200) : response()->json(['message'=>"Error al realizar esta operacón"],500);
        }
    }
}
