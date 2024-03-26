<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\course_video;
use App\Models\User_questions;
use App\Models\Status;
use Illuminate\Validation\Rule;

class Courses_videoController extends Controller
{

    //LISTA
    public function index($id)
    {
        $course_videos = course_video::where('courses_id', '=', $id)->where('status_id', '=', 1)->orderBy('order', 'asc')->with(['courseSection' =>  function ($query) {
            $query->select('id', 'name');
        }, 'courses:id,courseName'])->get();



        return response()->json($course_videos);
    }

    // GUARDA-ASOCIA LOS VIDEOS
    public function store(Request $request)
    {
        if ($request->id == "") {
            $courseVideo = course_video::where('order', $request->order)
            ->where('course_section_id', $request->section_id)
            ->where('courses_id', $request->courses_id)
            ->where('status_id',$request->status_id)
            ->count();
            if ($courseVideo>0) {
                return response()->json(['status' => 422,'message'=>"El numero de orden ya se encuentra registrado"],$status = 200);
            }
        }
        $validatedData = $request->validate([
            'description'       => 'required|max:365',
            'url_video'         => 'required|max:200',
            'section_id'         => 'required',
            'order'             =>
            [
                'required',
                'numeric',

            ],
        ], [], [
            'description' => 'descripción',
            'url_video' => 'link del video',
            'section_id' => 'sección',
            'order' => 'nº de orden',
        ]);
        // return response($request);

        $user = auth()->userOrFail();
        $text_op = "";
        if ($request->id == "") {
            $query = DB::table('course_videos')->insert([
                'description' => $request->input('description'),
                'url_video' => $request->input('url_video'),
                'courses_id' => $request->input('courses_id'),
                'status_id' => 1,
                'users_id' => $user->id,
                'course_section_id' => $request->input('section_id'),
                'order' => $request->input('order'),
            ]);
            $text_op = "Video creado correctamente";
        } else {
            $query = course_video::where('id', $request->id)->update([
                'description' => $request->input('description'),
                'url_video' => $request->input('url_video'),
                'course_section_id' => $request->input('section_id'),
                'order' => $request->input('order'),
            ]);

            $text_op = "Video editado correctamente";
        }

        if ($query) {
            return response()->json(['status' => 200, "messague" => $text_op], $status = 200);
        }
        return response()->json(['status' => 'Error en la query.'], $status = 500);
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
            return response()->json(['status' => 'success'], $status = 200);
        } else {
            return response()->json(['status' => 'Error en la query.'],$status = 200);
        }
    }

    //FUNCION PARA SACAR UNA LISTA DE LOAS SECCIONES
    public function getSections()
    {
        $sections = DB::table('course_sections')->select('course_sections.name as label', 'course_sections.id as value')->get();
        return response()->json($sections);
    }

    //TRAE EL CURSO CON SUS VIDEOS PARA INICIAR
    public function viewcoursestart($id_curso,$id_user)
    {

        //return response()->json($id_curso);
        $videos = course_video::where('courses_id', $id_curso)
            //->where('users_id', $id_user)
            ->with(['courseSection' => function ($query) {
                $query->select('id', 'name', 'orden')->orderBy('orden');
            }, 'courses:id,courseName'])
            ->get()
            ->sortBy(function ($video) {
                return $video->courseSection->orden;
            });
        
        if($videos->count() > 0){
            $courseName = $videos->first()->courses->courseName;
           
            $groupedVideos = $videos->groupBy('courseSection.name')->map(function ($videos) use ($id_curso) {
                return $videos->sortBy('order')->map(function ($video) use ($id_curso) {
                    $additionalData = User_questions::where('courses_id', $id_curso)
                    ->where('course_section_id', $video->course_section_id)
                    ->select('course_section_id', 'question')
                    ->get();

                    return [
                        'id_video' => $video->id,
                        'description_video' => $video->description,
                        'url_video' => $video->url_video,
                        'orden' => $video->order,
                        'additional_data' => $additionalData
                    ];
                })->values();
            });

            return response()->json([
                'groupedVideos' => $groupedVideos,
                'courseName' => $courseName
            ]);
        }else{
            return response()->json('No existe informacion');
        }

    }
}
