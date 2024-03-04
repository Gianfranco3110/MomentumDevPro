<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
Use PDF;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Validation\Factory;

class Pdf_CertificadoController extends Controller
{
    protected $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function getPDF(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'course_id' => 'required|numeric',
        ];
        $messages = [
            'user_id.required' => 'El campo id del usuario es requerido.',
            'course_id.required' => 'El campo id del curso es requerido.',
            'user_id.numeric' => 'El campo id del usuario debe ser numerico.',
            'course_id.numeric' => 'El campo id del curso debe ser numerico.',
        ];

        $validator = $this->validationFactory->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Course::where('id', $request->course_id)->exists()) {
            return response()->json(['message' => "Error, El curso no existe en el sistema."]);
            die;
        }
        if (!User::where('id', $request->user_id)->exists()) {
            return response()->json(['message' => "Error, El usuario no existe en el sistema."]);
            die;
        }

        $dataViews = [
            'course'=> Course::find($request->course_id),
            'user'=> User::find($request->user_id),
        ];
        // return response($dataViews);

        // $pdf = PDF::loadView('CERTIFICADO', compact('user'));
        $pdf = PDF::loadView('CERTIFICADO', compact('dataViews'))->setPaper('a4', 'landscape')->setWarnings(false)->save('Certificado.pdf');
        $pdfPath = public_path('Certificado.pdf');
        $pdf->stream($pdfPath);
        // return response()->json($pdf->stream('users.pdf'));
        // return $pdf->stream('/pepe/Certificado.pdf');
        $pdfUrl = asset('Certificado.pdf');
        return response()->json(['certificado_url' => $pdfUrl]);

	}
}
