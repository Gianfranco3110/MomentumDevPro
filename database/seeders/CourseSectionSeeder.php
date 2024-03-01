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
                'name' => 'Introduccion'
            ],
            [
                'id' => 2,
                'name' => 'Desarrollo'
            ],
            [
                'id' => 3,
                'name' => 'Cierre'
            ],

        ];

        DB::table('course_sections')->insert($data);
    }
}
