<?php

namespace App\Http\Controllers;

use App\Models\States;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function states() {
        $data = States::with('municipalitys')->get();
        return response()->json($data,200);
    }
}
