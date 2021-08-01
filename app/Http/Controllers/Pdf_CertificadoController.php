<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use PDF;

class Pdf_CertificadoController extends Controller
{
    public function getPDF()
    {
		$data = [
            'title' => 'First PDF for Medium',
            'heading' => 'Hello from 99Points.info',
            'content' => 'Lorem Ipsum is simply dummy text remaining essentially unchanged.'
        ];
        $user = auth()->userOrFail();
        $user = $user->name;
        //$name = 'Juanito Perez';

        $pdf = PDF::loadView('CERTIFICADO', compact('user'));
        //$pdf = PDF::loadView(' PDF_Example', compact('name'));

        //return response()->json($pdf->stream('users.pdf'));   
        return $pdf->stream('Certificado.pdf');   

	}
}