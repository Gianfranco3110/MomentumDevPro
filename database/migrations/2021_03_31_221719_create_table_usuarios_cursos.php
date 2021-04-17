<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsuariosCursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_id');
            $table->integer('curso_id');
            $table->date('Fecha_registro');
            $table->date('Fecha_vence');
            $table->date('Fecha_aprobado');
            $table->date('Fecha_compra');
            $table->date('Fecha_sesion');
            $table->string('Usuario_aprueba');
            $table->string('Video_actual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_courses');
    }
}
