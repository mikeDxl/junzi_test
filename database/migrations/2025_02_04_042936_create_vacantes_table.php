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
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // ID de la empresa (sin FK)
            $table->unsignedBigInteger('departamento_id'); // ID del departamento (sin FK)
            $table->unsignedBigInteger('puesto_id'); // ID del puesto (sin FK)
            $table->integer('solicitadas')->default(0); // Cantidad de vacantes solicitadas
            $table->integer('completadas')->default(0); // Cantidad de vacantes cubiertas
            $table->string('codigo')->unique(); // Código único de la vacante
            $table->string('prioridad')->nullable(); // Prioridad de la vacante
            $table->string('estatus')->nullable(); // Estado de la vacante
            $table->string('jefe')->nullable(); // Nombre del jefe responsable
            $table->string('area')->nullable(); // Área de la vacante
            $table->unsignedBigInteger('area_id')->nullable(); // ID del área (sin FK)
            $table->string('proceso')->nullable(); // Descripción del proceso de contratación
            $table->date('fecha')->nullable(); // Fecha de publicación de la vacante
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
        Schema::dropIfExists('vacantes');
    }
};
