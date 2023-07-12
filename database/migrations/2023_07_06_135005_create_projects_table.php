<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title', 50);
            $table->string('slug', 50)->unique();
            $table->date('creation_date');
            $table->date('last_update');
            $table->string('author', 30);
            $table->string('collaborators', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('link_github', 150);

            $table->softDeletes();
            
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
