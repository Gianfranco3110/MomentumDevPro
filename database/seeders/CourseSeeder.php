<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CourseSeeder extends Seeder
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
                'price' => 15.99,
                'description' => "LOREM IPSUM IS SIMPLY DUMMY TEXT OF THE PRINTING AND OFF THU TIME",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Et quis ex quo aut c",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],[
                'price' => 11.99,
                'description' => "LOREM IPSUM IS SIMPLY DUMMY TEXT OF THE PRINTING AND FHY DOMSDUIN AK IA DOOAMKP K DKLNDS KJNDN KNKSJUBKALKNAG",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Voluptas mollit veni",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],[
                'price' => 9.99,
                'description' => "INVENTORE CUM UT EAQUE CUMQUE UT DELENITI DOLOR VOLUPTATEM RERUM TOTAM QUAE VOLUPTATEM SINT",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Consectetur dolorem",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 13.99,
                'description' => "SEQUI ERROR NON QUAS VEL NISI ET QUIA VOLUPTATE PROIDENT ACCUSAMUS QUASI DESERUNT",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Aspernatur molestiae",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 17.99,
                'description' => "NESCIUNT ARCHITECTO QUI IURE DOLOR ESSE ASPERIORES MINIMA VOLUPTATES VOLUPTATEM EX DOLOR VOLUPTATIBUS ET FUGA ODIO ANIM MOLLIT",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Cillum similique vol",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 16.99,
                'description' => "QUAM TEMPORE VERO TEMPORIBUS EX AUTE ANIM AMET VOLUPTATEM ULLAMCO EX EOS CONSEQUATUR LABORE AD VOLUPTAS DOLORIBUS QUI DOLORE",
                'applies_to_date' => "2024-03-12",
                'image' => "img_default.webp",
                'CourseName' => "Incidunt minima mol",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],


        ];

        DB::table('courses')->insert($data);
    }
}
