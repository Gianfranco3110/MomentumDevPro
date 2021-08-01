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
        $User_questions=DB::table('User_questions')->select('User_questions.*')->where('courses_id', '=', $id)->get();
        return response()->json( $User_questions );

    }
     // GUARDA-ASOCIA LOS VIDEOS
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'question'       => 'required|max:365',
             'courses_id'         => 'required|max:200',
         ]);   
         //$user = auth()->userOrFail();
         $query=DB::table('User_questions')->insert([
             'question' => $request->input('question'),
             'courses_id' => $request->input('courses_id'),
             'status_id' => intval($request->input('status_id'))
         ]); 
         if($query){
             return response()->json( ['status' => 'success'] );
          }
          return response()->json(['status' => 'Error en la query.']);   
     }
}