<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Introduccion',
                'orden' => 1
            ],
            [
                'id' => 2,
                'name' => 'Desarrollo',
                'orden' => 2
            ],
            [
                'id' => 3,
                'name' => 'Cierre',
                'orden' => 3
            ],

        ];

        DB::table('course_sections')->insert($data);
    }
}
