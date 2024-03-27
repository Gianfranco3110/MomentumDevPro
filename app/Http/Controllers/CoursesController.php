<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; //PREGUNTAR SOBRE ESTE USE
use App\Models\Course;
use App\Models\Status;
use App\Models\userCourses;

class CoursesController extends Controller
{

    //FUNCION PARA MOSTRAR LOS CURSOS
    public function index()
    {
        $courses = DB::table('courses')->join('users', 'users.id', '=', 'courses.users_id')
            ->join('status', 'status.id', '=', 'courses.status_id')
            ->select('courses.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
            ->where('status_id', '=', [1,3])
            ->limit(6)
            ->get();
        return response()->json($courses);
    }

    public function allCourses()
    {
        $courses = DB::table('courses')->join('users', 'users.id', '=', 'courses.users_id')
            ->join('status', 'status.id', '=', 'courses.status_id')
            ->select('courses.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
            ->get();
        return response()->json($courses);
    }

    public function misCursos()
    {
        $user = auth()->userOrFail();
        $courses = DB::table('users_courses')->join('courses', 'courses.id', '=', 'users_courses.curso_id')
            ->select('courses.*', 'users_courses.Video_actual as Video')
            ->where('users_courses.usuario_id', '=', $user->id)
            ->where('users_courses.status', '=', 'Pagado')
            ->get();
        return response()->json($courses);
    }

    //FUNCION PARA SACAR UNA LISTA DE LOS CURSOS PERO SOLO EL NOMBRE Y EL ID
    public function nameCourses()
    {
        $courses = DB::table('courses')->select('courses.CourseName as label', 'courses.id as value')->get();
        return response()->json($courses);
    }

    public function create()
    {
        $statuses = DB::table('status')->select('status.name as label', 'status.id as value')->get();
        return response()->json($statuses);
    }

    public function show($id)
    {
        //Codigo
    }

    public function showPerUser()
    {
        $user = auth()->userOrFail();
        $courses = DB::table('courses')->join('status', 'status.id', '=', 'courses.status_id')
            ->select('courses.*', 'status.name as status', 'status.class as status_class')
            ->where('users_id', $user->id)->where('exist', '=', 0)->get();
        return response()->json($products);
    }

    //FUNCION PARA SUBIR IMG
    public function uploadImage(Request $request)
    {
        $validate = request()->validate([
            'image'          => "required"
        ]);
        if ($request->hasFile('image')) {
            $image_path = $request->file('image');
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('public')->put('curso/' . $image_path_name, File::get($image_path));
            return response()->json(['path' => $image_path_name]);
        }
        return response()->json(['path' => 'error']);
    }

    //FUNCION PARA CREAR UN CURSO
    public function store(Request $request)
    {
        // return response()->json( ['status' => 'success pedrp'] );
        $validatedData = $request->validate([
            'price'             => 'required|min:1|max:20',
            'description'           => 'required|max:365',
            'daysofvalidity'         => 'required|max:20',
            'CourseName'         => 'required|max:20',
            // 'image'             => 'required'
        ]);

        // verifica si hay img o no, si no hay guarda null
        if ($request->hasFile('image')) {
            $image_path = $request->file('image');
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('public')->put('courses/' . $image_path_name, File::get($image_path));
        }
        $currentDate = now();
        $user = auth()->userOrFail();
        $query = Course::create([
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'CourseName' => $request->input('CourseName'),
            'status_id' => 1,
            'users_id' => $user->id,
            'applies_to_date' => $currentDate->addDays($request->input('daysofvalidity'))->format('Y-m-d'),
            'daysofvalidity' => $request->input('daysofvalidity'),
            'image' =>$request->hasFile('image')?$image_path_name:"img_default.webp",
        ]);
        if ($query) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'Error en la query.']);
    }


    //METODO PARA EDITAR UN CURSO
    public function edit($id)
    {
        $courses = DB::table('courses')->where('id', '=', $id)->first();
        $statuses = DB::table('status')->select('status.name as label', 'status.id as value')->get();

        return response()->json(['statuses' => $statuses, 'course' => $courses]);
    }


    //METODO PARA ACTUALIZAR UN CURSO
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'price'             => 'required|min:1|max:20',
            'description'       => 'required|max:365',
            'daysofvalidity'    => 'required|max:20',
            'CourseName'        => 'required|max:100',
            'image'             => 'required',
            'status_id'         => 'required',
        ]);
        $currentDate = now();
        $courses = Course::find($id);
        if ($request->hasFile('image')) {
            $image_path = $request->file('image');
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('public')->put('courses/' . $image_path_name, File::get($image_path));
            $courses->image = $image_path_name;
        }
        $courses->price           = $request->input('price');
        $courses->description     = $request->input('description');
        $courses->status_id       = $request->input('status_id');
        $courses->daysofvalidity  = $request->input('daysofvalidity');
        $courses->CourseName      = $request->input('CourseName');
        $courses->applies_to_date = $currentDate->addDays($request->input('daysofvalidity'))->format('Y-m-d');
        $courses->save();
        return response()->json(['status' => 'success']);
    }

    //FUNCION CAMBIAR ELIMINAR (CAMBIO DE ESTATUS)
    public function destroy($id)
    {
        $product = DB::table('products')->find($id);
        if ($product) {
            $product->delete();
        }
        return response()->json(['status' => 'success']);
    }

    function details(Request $request) {
        if ($request->input('course_id')) {
            $course_id=$request->input('course_id');
            $course = Course::where('id',$course_id)->with('coursevideo','coursestudent')->first();
            $course['count_video']= $course->coursevideo->count();
            $course['count_estudent']= $course->coursestudent->count();
            $course['video_presentation']= Course::video_resentation($course_id);
            $data = [
                'course'=>$course
            ];
            return response()->json($data, 200);

        }
    }

    function valueDateExpirate(Request $request) {
        $validatedData = $request->validate([
            'user_id'             => 'required|numeric',
        ]);
        userCourses::verificarCursoExpirado($request->user_id);
        return response()->json(["return"=>true]);
    }
}
