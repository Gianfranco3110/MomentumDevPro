<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\userCourses;


class UserCourseController extends Controller
{

   public function index($id){        
        $courses = DB::table('users_courses')->join('courses', 'courses.id', '=', 'users_courses.curso_id')
        ->join('users', 'users.id', '=', 'users_courses.usuario_id')
        ->select('courses.id','courses.CourseName','courses.image','users.id','users.name as Usuario','users.email','users_courses.Video_actual as Video', 'users_courses.id as Vinculo', 'users_courses.status')
        ->where('users_courses.usuario_id','=',$id)
        ->get();
        return response()->json( $courses );
    }

    public function changeStatus(Request $request, $id){        
        $validatedData = $request->validate([
        'status'             => 'required'
    ]);
        $vinculo = userCourses::find($id);        
        $vinculo->status      = $request->input('status');
        $vinculo->save();
        return response()->json( ['estado' => 'success'] );
    }

    public function create(Request $request){

        $user = auth()->userOrFail();
        $query = DB::table('users_courses')->insert([
            'usuario_id' => $request->input('user_id'),
            'curso_id' => $request->input('course_id'),
            'status' => $request->input('status'),
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

    public function generatePDF(){
        $data = [
            'title' => 'Welcome to MomentumDevPro',
            'date' => date('d/m/Y')
        ];
          
        $pdf = PDF::loadHTML('<h1>Test</h1>');

        $headers = [
        'Content-Type' => 'application/pdf',
            ];

        return response()->download($pdf, 'test.pdf', $headers);
    }

    public function destroy($id)
    {
        $vinculo = userCourses::find($id);
        if($vinculo){
            $vinculo->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
