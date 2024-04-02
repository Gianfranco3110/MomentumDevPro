<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory;

class CourseSectionController extends Controller
{
    protected $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }


    public function index()
    {
        $courseSections = CourseSection::all();
        return response()->json($courseSections);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'orden' => [
                'required',
                'numeric',
            ]
        ];
        $messages = [
            'name.required' => 'El campo nombre es requerido.',
            'orden.required' => 'El campo Nº de orden es requerido.',
            'orden.numeric' => 'El campo Nº de orden debe ser numérico.',
        ];

        $validator = $this->validationFactory->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (CourseSection::where('orden', $request->orden)->exists()) {
            return response()->json(["message"=>"El numero de orden ya se encuentra registrado","status"=>422], 422);
        }

        $courseSection = CourseSection::create($request->all());
        $respData=[
            "message"=>"Creado con éxito",
            "status"=>200,
            "data"=>$courseSection,
        ];
        return response()->json($respData, 201);
    }


    public function show($id)
    {
        if (CourseSection::where('id', $id)->exists()) {
            $courseSection = CourseSection::findOrFail($id);
            return response()->json($courseSection);
        }else{
            return response()->json(["message"=>"El registro no se encuentra","status"=>422], 422);
        }
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'orden' => [
                'required',
                'numeric',
                Rule::unique('course_sections', 'orden')->ignore($id)
            ]
        ];
        $messages = [
            'name.required' => 'El campo nombre es requerido.',
            'orden.required' => 'El campo Nº de orden es requerido.',
            'orden.numeric' => 'El campo Nº de orden debe ser numérico.',
            'orden.unique' => 'El campo Nº de orden ya esta en uso.',
        ];

        $validator = $this->validationFactory->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $courseSection = CourseSection::findOrFail($id);
        $courseSection->update($request->all());
        $respData=[
            "message"=>"Editado con éxito",
            "status"=>200,
            "data"=>$courseSection,
        ];
        return response()->json($respData, 200);
    }

    public function destroy($id)
    {
        if (CourseSection::where('id', $id)->exists()) {
            CourseSection::destroy($id);
            return response()->json(["message"=>"Eliminado con éxito","status"=>200]);
        }else{
            return response()->json(["message"=>"El registro no se encuentra","status"=>422], 422);
        }

    }
}
