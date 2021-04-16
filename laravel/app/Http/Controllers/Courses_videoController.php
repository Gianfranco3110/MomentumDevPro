<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\course_video;
use App\Models\Status;

class Courses_videoController extends Controller
{
    
    //LISTA
    public function index($id)
    {  
        $course_videos=DB::table('course_videos')->select('course_videos.*')->where('courses_id', '=', $id)->get();
        return response()->json( $course_videos );

    }

    // GUARDA-ASOCIA LOS VIDEOS
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description'       => 'required|max:365',
            'url_video'         => 'required|max:500',
        ]);   
        $user = auth()->userOrFail();
        $query=DB::table('course_videos')->insert([
            'description' => $request->input('description'),
            'url_video' => $request->input('url_video'),
            'courses_id' => $request->input('courses_id'),
            'status_id' => intval($request->input('status_id')),
            'users_id' => $user->id,
        ]); 
        if($query){
            return response()->json( ['status' => 'success'] );
         }
         return response()->json(['status' => 'Error en la query.']);   
}
}