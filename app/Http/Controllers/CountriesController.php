<?php

namespace App\Http\Controllers;

use App\Models\Countrie;
use App\Models\Municipality;
use App\Models\States;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function states(Request $request)
    {
        $data = [];
        if ($request->input('state') == "all") {
            $data = States::with('municipalitys')->get();
        } else if ($request->input('state_id')) {

            $data = Municipality::select('id', 'city_name')->where('states_id', $request->input('state_id'))->get();
        } else if ($request->input('country_id')) {
            $data = States::select('id', 'state_name')->where('countrie_id', $request->input('country_id'))->get();
        }

        return response()->json($data, 200);
    }


    public function countries()
    {
        return response()->json(Countrie::select('country_name', 'id', 'country_short_name', 'country_phone_code')->get(), 200);
    }
}
