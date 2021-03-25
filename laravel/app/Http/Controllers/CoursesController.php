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

    //FUNCION PARA CREAR UN CURSO
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'price'             => 'required|min:1|max:20',
            'description'           => 'required|max:365',
            'daysofvalidity'         => 'required|max:20',
            'imagePath'             => 'required|image|mimes:image/jpeg, image/png'
        ]);
        $user = auth()->userOrFail();
        DB::table('products')->insert([
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'status_id' => intval($request->input('status_id')),
            'users_id' => $user->id,
            'applies_to_date' => date('d-m-y'),
            'photo' => $request->input('imagePath'), //PENDIENTE CON ESTO
            'daysofvalidity' => $request ->input('daysofvalidity'),
        ]);
        /* Comente este codigo porque de esta forma produce un error 500
         $product = new Product();
        $product->title= $request->input('title');
        $product->description   = $request->input('description');
        $product->status_id = intval($request->input('status_id'));
        $product->product_type = $request->input('product_type');
        $product->applies_to_date = date('d-m-y');
        $product->users_id = $user->id;
        $product->save();*/
        return response()->json( ['status' => 'success'] );
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