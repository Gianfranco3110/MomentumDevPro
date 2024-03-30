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
        $currentDate = now();
        $data = [
            [
                'price' => 15.99,
                'description' => "¿Sientes pasión por el mundo de la belleza y el realce de cejas y pestañas? Imagina convertir esa pasión en habilidades especializadas y, aún mejor, en un negocio rentable.",
                'applies_to_date' => $currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_curse1.png",
                'CourseName' => "Cejas y pestañas pelo a pelo, volumen ruso y lifting",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],[
                'price' => 11.99,
                'description' => "Explora tu pasión por la belleza y descubre el arte de las extensiones de pestañas. ¿Te imaginas convertir esa pasión en una destreza especializada y, aún mejor, en un emprendimiento verdaderamente rentable?",
                'applies_to_date' => $currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_course2.png",
                'CourseName' => "Pestañas pelo a pelo y volumen ruso",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],[
                'price' => 9.99,
                'description' => "Con el MasterClass CEJAS 3D MIRADA PERFECTA
                Aprenderás paso a paso como diseñar unas cejas perfectas para que luzcas una mirada sexy y cautivadora",
                'applies_to_date' =>$currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_course3.png",
                'CourseName' => "El arte de diseñar cejas como negocio",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 13.99,
                'description' => "Con este MasterClass de CEJAS PERFECTAS CON MICROBLANDING aprende como pigmentarlas con impacto. Esta es una excelente oportunidad de negocio.
                Esta MasterClass es una recopilación de años de estudio en diferentes academias reconocidas a nivel internacional y con base en la experiencia de la productora del curso con los años.",
                'applies_to_date' =>$currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_course4.png",
                'CourseName' => "Diseño de cejas con hilo y henna",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 17.99,
                'description' => "Aprendes la técnica de Diseño y perfilado de cejas desde0, Aplicar el método ideal para practicar, elaborar y obtener los mejores resultados en diseño de cejas, Conocer las diferentes formas y prácticas de elaborar un diseño según la morfología del rostro de cada persona.",
                'applies_to_date' =>$currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_course5.png",
                'CourseName' => "Curso de diseño y perfilado de cejas",
                'daysofvalidity' => "10",
                'users_id' => 1,
                'status_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'price' => 16.99,
                'description' => "Las extensiones de pestañas se utilizan para mejorar la longitud, curvatura, plenitud y grosor de las pestañas naturales. El método principal para aplicar las extensiones es mediante el uso de un pegamento adhesivo para pegar individualmente las extensiones a la línea de las pestañas. Las pestañas postizas, magnéticas y las extensiones no son lo mismo y existen diferentes técnicas. La técnica de extensión de pestañas pelo a pelo, se ha convertido en una de las más demandadas en la actualidad.",
                'applies_to_date' =>$currentDate->addDays(10)->format('Y-m-d'),
                'image' => "img_course6.png",
                'CourseName' => "Curso de pestañas Premium",
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
