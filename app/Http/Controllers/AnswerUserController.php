<?php

namespace App\Http\Controllers;

use App\Models\answerUser;
use Illuminate\Http\Request;

class AnswerUserController extends Controller
{
    public function store(Request $request)
    {
        //return response ($request->input('id_user'));
        if($request->input('tipo') === '1'){
           //Save img pedro
        }else{
            $data = $request->input('answer');
           foreach ($data as $item) {
                $AnswerUser = new AnswerUser();
                $AnswerUser->users_id = $request->input('id_user');
                $AnswerUser->question_id = $item['id_question'];
                $AnswerUser->answer = $item['answer'];
                $AnswerUser->save();
            }
        }
    }
}