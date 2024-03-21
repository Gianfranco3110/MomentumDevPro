<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\States;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'api-token' => 'Zg5KFEd5KFMHYXLzSTKTSX8h9xu4rq5lv8_ngN_ukGN8AmwA1HIvYQs5rN7qYst7jGM',
            'user-email' => 'peluisrodriguez2@gmail.com',
        ])->get('https://www.universal-tutorial.com/api/getaccesstoken');

        if ($response->successful()) {
            $auth_token = $response->json()['auth_token'];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $auth_token,
                'Accept' => 'application/json',
            ])->get('https://www.universal-tutorial.com/api/countries/');

            if ($response->successful()) {
                $countries = $response->json();

                $countrie_vnz = collect($countries)->firstWhere('country_phone_code', 58);

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $auth_token,
                    'Accept' => 'application/json',
                ])->get('https://www.universal-tutorial.com/api/states/' . $countrie_vnz['country_name']);

                if ($response->successful()) {
                    $stated_resp = $response->json();

                    // Guardar los estados del pais Venezuela aqui
                    foreach ($stated_resp as $key => $value) {
                        $rspEstated = States::create($value);

                           $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $auth_token,
                            'Accept' => 'application/json',
                        ])->get('https://www.universal-tutorial.com/api/cities/' . $value['state_name']);

                        if ($response->successful()) {
                            $city_resp = $response->json();

                            if (count($city_resp)) {
                                foreach ($city_resp as $key => $value_city) {
                                    Municipality::create([
                                        'city_name'=> $value_city['city_name'],
                                        'states_id'=>$rspEstated->id
                                    ]);
                                }
                            }
                        }

                    }

                }
            }


        }

    }
}
