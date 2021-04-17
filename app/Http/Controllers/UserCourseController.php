<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCourseController extends Controller
{
    public function create(Request $request){

        $user = auth()->userOrFail();
        $query = DB::table('users_courses')->insert([
            'usuario_id' => $request->input('user_id'),
            'curso_id' => $request->input('course_id'),
            'Fecha_registro' => now(),
            'Fecha_vence' => now(),
            'Fecha_compra' => now(),
            'Fecha_aprobado' => now(),
            'Fecha_sesion' => now(),
            'Usuario_aprueba' => $user->name,
            'video_actual' => 'url'
        ]);

        if($query){
            return response()->json( ['status' => 'success'] );
         }
         return response()->json(['status' => 'Error en la query.']);
    }
}
