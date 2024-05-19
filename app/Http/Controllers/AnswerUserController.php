<?php

namespace App\Http\Controllers;

use App\Models\answerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AnswerUserController extends Controller
{
    public function store(Request $request)
    {
        //return response($request->input('tipo'));
        if($request->input('tipo') === '1'){
            //return response($request);
            $data = $request->input('answer');
            $respDta = [];
            foreach ($data as $key=>$item) {
                $AnswerUser = new AnswerUser();
                $AnswerUser->users_id = $request->input('id_user');
                $AnswerUser->question_id = $item['id_question'];
                $AnswerUser->status = 'En revición';
                // Guardar el nombre del archivo con su extensión
                $archivo = $request->file('answer.' . $key . '.answer');
                $nombreCampo = 'answer.' . $key . '.answer';

                if ($request->hasFile($nombreCampo)) {
                    $archivo = $request->file($nombreCampo);
                    // Generar un nombre único para el archivo
                    $nombreArchivo = $archivo->hashName();

                    // Crear la estructura de carpetas si no existe
                    $carpeta = 'imgquestion/user_' . $request->input('id_user') . '/question_' . $item['id_question'];
                    
                    // Storage::makeDirectory($carpeta);

                    if (!File::exists($carpeta)) {
                        File::makeDirectory($carpeta, 0777, true);
                    }
                    // Mover el archivo a la carpeta de almacenamiento
                    // $archivo->move(storage_path('app/' . $carpeta), $nombreArchivo);
                    $archivo->move(public_path($carpeta), $nombreArchivo);

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
                $AnswerUser->status = 'En revición';
                $AnswerUser->save();
                $respDta[$key] = $AnswerUser;
            }

            return $AnswerUser ? response()->json(['message'=>"Operacón realizado con éxito", 'data'=>$respDta],200) : response()->json(['message'=>"Error al realizar esta operacón"],500);
        }
    }

    public function validateanswer(Request $request)
    {   
        //return response($request);
        $AnswerUser = answerUser::find($request->id_answer);
         
        $AnswerUser->status = $request->status;
        $AnswerUser->save();
        if ($AnswerUser) {
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    }
}
