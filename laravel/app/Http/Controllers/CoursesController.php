<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; //PREGUNTAR SOBRE ESTE USE
use App\Models\Course;

class CoursesController extends Controller
{

    //FUNCION PARA MOSTRAR LOS CURSOS
    public function index()
    {
        $Courses = DB::table('Courses')->join('users', 'users.id', '=', 'Courses.users_id')
        ->join('status', 'status.id', '=', 'Courses.status_id')
        ->select('Courses.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
        ->get();
        return response()->json( $Courses );
    }

    public function create()
    {        
        $statuses = DB::table('status')->select('status.name as label', 'status.id as value')->get();
        return response()->json( $statuses );
    }
    
    //FUNCION PARA SUBIR IMG
    public function uploadImage(Request $request){
        $validate = request()->validate([
             'image'          => "required"
         ]);
         if($request->hasFile('image')){
             $image_path = $request->file('image');
             $image_path_name = time().$image_path->getClientOriginalName();
             Storage::disk('public')->put($image_path_name, File::get($image_path));
             return response()->json(['path' => $image_path_name]); 
         }
         return response()->json(['path' => 'error']); 
 
     }

    //FUNCION PARA CREAR UN CURSO
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'price'             => 'required|min:1|max:20',
            'description'           => 'required|max:365',
            'daysofvalidity'         => 'required|max:20',
            'image'             => 'required'
        ]);

        if($request->hasFile('image')){
            $image_path = $request->file('image');
            $image_path_name = time().$image_path->getClientOriginalName();
			Storage::disk('public')->put($image_path_name, File::get($image_path));

        $user = auth()->userOrFail();
        $query=DB::table('Courses')->insert([
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'status_id' => intval($request->input('status_id')),
            'users_id' => $user->id,
            'applies_to_date' => date('d-m-y'),
            'daysofvalidity' => $request ->input('daysofvalidity'),
            'image' => $image_path_name,         //PENDIENTE CON ESTO
            
        ]);
        if($query){
            return response()->json( ['status' => 'success'] );
         }
         return response()->json(['status' => 'Error en la query.']);
         
    } else 
    {
        return response()->json(['message' => 'The given data was invalid.']); 
    }          
}

    //FUNCION CAMBIAR ELIMINAR (CAMBIO DE ESTATUS)
    public function destroy($id)
    {
        $product = DB::table('products')->find($id);
        if($product){
            $product->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}