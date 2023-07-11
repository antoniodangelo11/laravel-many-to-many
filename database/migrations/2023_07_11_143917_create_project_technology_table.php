<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('technology_id');

            $table->foreign('project_id')->references('id')->on('technologies');
            $table->foreign('technology_id')->references('id')->on('projects');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_technology');
    }
};
