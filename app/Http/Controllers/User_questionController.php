<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User_questions;
use App\Models\fields_for_simple_selection;
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
     // GUARDA-ASOCIA LOS TEST
     public function store(Request $request)
     {
        //return ($request->input('options'));
         $validatedData = $request->validate([
             'question'       => 'required|max:365',
             'courses_id'         => 'required|max:200',
             'section_id'         => 'required|numeric',
         ]);
         $text_r = "";
         if ($request->id == "") {
            //$user = auth()->userOrFail();
            $userQuestion = new User_questions();
            $userQuestion->question = $request->input('question');
            $userQuestion->courses_id = $request->input('courses_id');
            $userQuestion->status_id = intval($request->input('status_id'));
            $userQuestion->course_section_id = $request->input('section_id');
            $userQuestion->type_question = $request->input('type_question');
            $userQuestion->save();

            $text_r = "Agregado correctamente";
            if (!empty($request->input('options'))) {
                $options = $request->input('options');
                $count = count($options);
                for ($i = 0; $i < $count; $i++) {
                    fields_for_simple_selection::create([
                        'id_user_questions' => $userQuestion->id,
                        'options' => $options[$i]
                    ]);
                }
            } else {
                return response()->json(['message' => "Error, hubo un error creando las opciones del test.", 'status' => 422], 201);
            }
         }else{
            $userQuestion = User_questions::where('id',$request->id)->update([
                'question'=>$request->input('question'),
                'course_section_id'=>$request->input('section_id'),
                'type_question' => $request->input('type_question')
            ]);

            fields_for_simple_selection::where('id_user_questions', $request->id)->delete();
            if (!empty($request->input('options'))) {
                $options = $request->input('options');
                $count = count($options);
                for ($i = 0; $i < $count; $i++) {
                    fields_for_simple_selection::create([
                        'id_user_questions' => $request->id,
                        'options' => $options[$i]
                    ]);
                }
            }
            $text_r = "Editado correctamente";
        }

        if($userQuestion){
             return response()->json( ['status' => 'success',"message"=>$text_r] );
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

    public function fieldsquestion ($id){
        $result = fields_for_simple_selection::select('options as text')
            ->where('id_user_questions', '=', $id)
            ->get()
            ->toArray();
        return response()->json($result);
    }
}
