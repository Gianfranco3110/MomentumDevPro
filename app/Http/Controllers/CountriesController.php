<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\States;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function states(Request $request) {
        $data=[];
        if ($request->input('state') == "all") {
            $data = States::with('municipalitys')->get();
        }else if ($request->input('state_id')) {

            $data = Municipality::where('states_id',$request->input('state_id'))->get();

        }else{
            $data = States::all();
        }

        return response()->json($data,200);
    }
}
