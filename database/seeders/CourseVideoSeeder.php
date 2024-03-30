<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CourseVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Videos cursos 1
        $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"Descubre Nuestro Curso Profesional de Cejas y Pestañas ¡Transforma Miradas con Maestría!",
                "url_video"=>"https://www.youtube.com/watch?v=tpxoctfQUPM",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"Curso de diseño de cejas 🔥 episodio 1",
                "url_video"=>"https://www.youtube.com/watch?v=LyfyZPaidR0",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"CURSO GRATIS DE DISEÑO DE CEJAS 🔥 Episodio 2",
                "url_video"=>"https://www.youtube.com/watch?v=MT6cWtuSB6c",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"CURSO GRATIS DE DISEÑO DE CEJAS 🔥 Episodio 3 - Toma de Medidas de Cejas en Rostro Real",
                "url_video"=>"https://www.youtube.com/watch?v=ZScoF2hkfME",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ],

            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"¿Como TOMAR MEDIDAS para CEJAS PERFECTAS? PASO A PASO 😍",
                "url_video"=>"https://www.youtube.com/watch?v=4aZlZzoCk-Q",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"Depilación de Cejas con Cera y Perfilado Paso a Paso",
                "url_video"=>"https://www.youtube.com/watch?v=t9r6b7_D8Zs",
                "courses_id"=>1,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);







         //Videos cursos 2
         $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"¡Maestría en Pestañas: Aprende Pelo a Pelo y Volumen Ruso para Crear Miradas Impactantes!",
                "url_video"=>"https://www.youtube.com/watch?v=LvD31sMlcqY",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"CEJAS PERFECTAS FACIL PASO A PASO | Mariana Zambrano",
                "url_video"=>"https://www.youtube.com/watch?v=g7jlxJ4tlbc",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"Como Maquillarse Las Cejas",
                "url_video"=>"https://www.youtube.com/watch?v=zdAtAbXTzcE",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"Como Aplicar Pestañas Postizas Facil | TRUCOS Y CONSEJOS",
                "url_video"=>"https://www.youtube.com/watch?v=1MWF1GRPP6I",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"Sombras FACIL Para Principiantes | Sin Pestañas Postizas",
                "url_video"=>"https://www.youtube.com/watch?v=wudRhaKz0BM",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"Sombras En 5 Minutos Sin Pestañas Postizas",
                "url_video"=>"https://www.youtube.com/watch?v=x-XqGU9AD_4",
                "courses_id"=>2,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);




        //Videos cursos 3
        $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"COMO HACER LAMINADO DE CEJAS (CURSO GRATIS 🤗 LAMINADO DE CEJAS 💁‍♀️)",
                "url_video"=>"https://www.youtube.com/watch?v=gnUxkVrfVb4",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"Maquillaje Morado Con Rosa | Paso a Paso | Principiantes",
                "url_video"=>"https://www.youtube.com/watch?v=7tH6g_6000k",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"Classic Golden Glitter Eye Makeup Tutorial | Holiday Eye Look",
                "url_video"=>"https://www.youtube.com/watch?v=CDxp31wJfjc",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"Como Aplicar Pestañas Postizas Facil | TRUCOS Y CONSEJOS",
                "url_video"=>"https://www.youtube.com/watch?v=1MWF1GRPP6I",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"CURSO DE DISEÑO DE CEJAS 🔥 Episodio 2",
                "url_video"=>"https://www.youtube.com/watch?v=MT6cWtuSB6c&t",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"PRESENTACION CURSO INTENSIVO DE CEJAS Y PESTAÑAS",
                "url_video"=>"https://www.youtube.com/watch?v=9dNCMleJn3k",
                "courses_id"=>3,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);




        //Videos cursos 4
        $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"PRESENTACION CURSO INTENSIVO DE CEJAS Y PESTAÑAS",
                "url_video"=>"https://www.youtube.com/watch?v=9dNCMleJn3k",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"Curso Completo de Cejas y Pestañas",
                "url_video"=>"https://www.youtube.com/watch?v=FQlIxxHKl2g",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"Curso online LIFTING Y LAMINADO DE CEJAS Y PESTAÑAS Noanox",
                "url_video"=>"https://www.youtube.com/watch?v=UQOup_MUSeE",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"LAMINADO DE CEJAS ✔️",
                "url_video"=>"https://www.youtube.com/watch?v=xIAzqFuKokQ",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"Cómo hacer un laminado de cejas paso a paso",
                "url_video"=>"https://www.youtube.com/watch?v=DEwXkrtwMrs",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"DISEÑO DE CEJAS - DEPILACION CON CERA - SOMBREADO CON HENNA",
                "url_video"=>"https://www.youtube.com/watch?v=9fFBVRmSw88",
                "courses_id"=>4,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);



         //Videos cursos 5
         $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"CURSO ONLINE DE ESTETICA - Extensiones de cejas, pelo a pelo",
                "url_video"=>"https://www.youtube.com/watch?v=m7JM7kfEXxY",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"Curso Completo de Cejas y Pestañas",
                "url_video"=>"https://www.youtube.com/watch?v=FQlIxxHKl2g",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"StudioLASH® Eyebrow Extensions & Eyebrow Henna",
                "url_video"=>"https://www.youtube.com/watch?v=vxtQd5q7M7U",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"Cejas HD Paso a Paso | Diseño de Cejas",
                "url_video"=>"https://www.youtube.com/watch?v=ZJ01k51zAeU",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"Cómo hacer un laminado de cejas paso a paso",
                "url_video"=>"https://www.youtube.com/watch?v=DEwXkrtwMrs",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"DISEÑO DE CEJAS - DEPILACION CON CERA - SOMBREADO CON HENNA",
                "url_video"=>"https://www.youtube.com/watch?v=9fFBVRmSw88",
                "courses_id"=>5,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);


         //Videos cursos 6
         $data =[
            [
                "course_section_id"=>1,
                "order"=>1,
                "description"=>"Diseño de cejas para principiantes / protocolo microblading /Curso de cejas",
                "url_video"=>"https://www.youtube.com/watch?v=wC1jCNW-j54",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>1,
                "order"=>2,
                "description"=>"Como hacer un visagismo o diseño de cejas",
                "url_video"=>"https://www.youtube.com/watch?v=3HqxxGxVEfc",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>1,
                "description"=>"Como hacer diseño de cejas con hilo paso a paso",
                "url_video"=>"https://www.youtube.com/watch?v=bWdXAJW8lXk",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>2,
                "order"=>2,
                "description"=>"Cejas HD Paso a Paso | Diseño de Cejas",
                "url_video"=>"https://www.youtube.com/watch?v=ZJ01k51zAeU",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>1,
                "description"=>"Cómo hacer un laminado de cejas paso a paso",
                "url_video"=>"https://www.youtube.com/watch?v=DEwXkrtwMrs",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ],
            [
                "course_section_id"=>3,
                "order"=>2,
                "description"=>"DISEÑO DE CEJAS - DEPILACION CON CERA - SOMBREADO CON HENNA",
                "url_video"=>"https://www.youtube.com/watch?v=9fFBVRmSw88",
                "courses_id"=>6,
                "users_id"=>1,
                "status_id"=>1,
            ]
        ];
        DB::table('course_videos')->insert($data);
    }
}
