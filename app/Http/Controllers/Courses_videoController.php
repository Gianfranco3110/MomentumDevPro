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
        $course_videos=course_video::where('courses_id', '=', $id)->where('status_id', '=', 1)->get();
        return response()->json( $course_videos );

    }

    // GUARDA-ASOCIA LOS VIDEOS
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description'       => 'required|max:365',
            'url_video'         => 'required|max:200',
        ]);
        $user = auth()->userOrFail();
        $query=DB::table('course_videos')->insert([
            'description' => $request->input('description'),
            'url_video' => $request->input('url_video'),
            'courses_id' => $request->input('courses_id'),
            'status_id' => 1,
            'users_id' => $user->id,
        ]);
        if($query){
            return response()->json( ['status' => 'success'],$status = 200 );
         }
         return response()->json(['status' => 'Error en la query.']);
    }

       /**
        * FUNCION PARA ACTUALIZAR EL CAMPO ESTATUS_ID DE LA TABLA course_videos PARA DESACTIVAR LOS
            VIDEOS RELACIONADO A EL CURSO.
        */
        public function changeStatus(Request $request)
        {
            $validatedData = $request->validate([
                'id_video'       => 'required',
            ]);
            $course_video = course_video::find($request->input('id_video'));
            if ($course_video->id) {
                $course_video->status_id = 2;
                $course_video->save();
                return response()->json( ['status' => 'success'], $status = 200 );
            }else{
                return response()->json(['status' => 'Error en la query.']);
            }

        }
}
