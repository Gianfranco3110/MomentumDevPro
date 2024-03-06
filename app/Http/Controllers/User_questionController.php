<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User_questions;
use App\Models\Status;

class User_questionController extends Controller
{
    //LISTA
    public function index($id)
    {
        // $User_questions=DB::table('User_questions')->select('User_questions.*')->where('courses_id', '=', $id)->where('status_id', '=', 1)->get();
        $User_questions = User_questions::where('courses_id', '=', $id)->where('status_id', '=', 1)->with(['courseSection' =>  function ($query) {
            $query->select('id', 'name');
        }, 'courses:id,courseName'])->get();
        return response()->json( $User_questions );

    }
     // GUARDA-ASOCIA LOS VIDEOS
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'question'       => 'required|max:365',
             'courses_id'         => 'required|max:200',
             'section_id'         => 'required|numeric',
         ]);
         $text_r = "";
         if ($request->id == "") {
            //$user = auth()->userOrFail();
            $query=DB::table('User_questions')->insert([
                'question' => $request->input('question'),
                'courses_id' => $request->input('courses_id'),
                'status_id' => intval($request->input('status_id')),
                'course_section_id' => $request->input('section_id')
            ]);
            $text_r = "Agregado correctamente";
         }else{
            $query = User_questions::where('id',$request->id)->update([
                'question'=>$request->input('question'),
                'course_section_id'=>$request->input('section_id'),
            ]);
            $text_r = "Editado correctamente";
         }

         if($query){
             return response()->json( ['status' => 'success',"messague"=>$text_r] );
          }
          return response()->json(['status' => 'Error en la query.']);
     }

    /**
    * FUNCION PARA ACTUALIZAR EL CAMPO ESTATUS_ID DE LA TABLA user_questions PARA DESACTIVAR LOS
        TEST RELACIONADO A EL CURSO.
    */
    public function changeStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id'       => 'required',
        ]);
        $question_video = User_questions::find($request->input('id'));
        if ($question_video->id) {
            $question_video->status_id = 2;
            $question_video->save();
            return response()->json( ['status' => 'success',"question"=>$question_video], $status = 200 );
        }else{
            return response()->json(['status' => 'Error en la query.']);
        }

    }
}
