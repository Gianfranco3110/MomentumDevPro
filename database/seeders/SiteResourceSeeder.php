<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteResource;

class SiteResourceSeeder extends Seeder
{
    public function run()
    {
        SiteResource::firstOrCreate(['section' => 'home_video'],      ['filename' => null]);
        SiteResource::firstOrCreate(['section' => 'login_image'],     ['filename' => null]);
        SiteResource::firstOrCreate(['section' => 'dashboard_banner'], ['filename' => null]);
        SiteResource::firstOrCreate(['section' => 'register_image'],  ['filename' => null]);
    }
}
