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
        $course_videos=course_video::where('courses_id', '=', $id)->where('status_id', '=', 1)->orderBy('order', 'asc')->with(['courseSection' =>  function ($query) {
            $query->select('id', 'name');
        }, 'courses:id,courseName'])->get();



        return response()->json( $course_videos );

    }

    // GUARDA-ASOCIA LOS VIDEOS
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description'       => 'required|max:365',
            'url_video'         => 'required|max:200',
            'section_id'         => 'required',
            'order'         => 'required|numeric',
        ]);
        $user = auth()->userOrFail();
        $query=DB::table('course_videos')->insert([
            'description' => $request->input('description'),
            'url_video' => $request->input('url_video'),
            'courses_id' => $request->input('courses_id'),
            'status_id' => 1,
            'users_id' => $user->id,
            'course_section_id' => $request->input('section_id'),
            'order' => $request->input('order'),
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

    //FUNCION PARA SACAR UNA LISTA DE LOAS SECCIONES
    public function getSections(){
        $sections = DB::table('course_sections')->select('course_sections.name as label', 'course_sections.id as value')->get();
        return response()->json( $sections );
    }

    //TRAE EL CURSO CON SUS VIDEOS PARA INICIAR
    public function viewcoursestart($id){
        //return response()->json($id);
        $videos = course_video::where('courses_id', $id)
        ->with(['courseSection' => function ($query) {
            $query->select('id', 'name');
        }, 'courses:id,courseName'])
        ->get();

        $groupedVideos = $videos->groupBy('courseSection.name')->map(function ($videos) {
            return $videos->sortBy('order')->map(function ($video) {
                return [
                    'id_video' => $video->id,
                    'description_video' => $video->description,
                    'url_video' => $video->url_video,
                    'orden' => $video->order
                ];
            })->values();
        });

        return response()->json($groupedVideos);
    }
}
