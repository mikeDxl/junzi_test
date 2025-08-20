<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('cc');
            $table->time('lunes')->nullable();
            $table->time('martes')->nullable();
            $table->time('miercoles')->nullable();
            $table->time('jueves')->nullable();
            $table->time('viernes')->nullable();
            $table->time('sabado')->nullable();
            $table->time('domingo')->nullable();
            $table->string('otro')->nullable();
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
        Schema::dropIfExists('horarios');
    }
};
