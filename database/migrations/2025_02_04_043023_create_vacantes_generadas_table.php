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
        Schema::create('vacantes_generadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vacante'); // ID de la vacante (sin FK)
            $table->date('fecha')->nullable(); // Fecha en la que se generó la vacante
            $table->string('estatus')->nullable(); // Estado de la vacante generada
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
        Schema::dropIfExists('vacantes_generadas');
    }
};
