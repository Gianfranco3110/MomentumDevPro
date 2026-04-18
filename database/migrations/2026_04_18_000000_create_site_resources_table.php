<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteResourcesTable extends Migration
{
    public function up()
    {
        Schema::create('site_resources', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique();
            $table->string('filename')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_resources');
    }
}
