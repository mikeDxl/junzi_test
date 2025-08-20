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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_evaluador');
            $table->unsignedBigInteger('id_colaborador');
            $table->integer('pregunta1');
            $table->integer('pregunta2');
            $table->integer('pregunta3');
            $table->integer('pregunta4');
            $table->integer('pregunta5');
            $table->integer('pregunta6');
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
        Schema::dropIfExists('evaluaciones');
    }
};
