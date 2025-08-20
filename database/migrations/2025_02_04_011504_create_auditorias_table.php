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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('tipo')->nullable(); // El campo 'tipo' (tipo de auditoría)
            $table->string('area')->nullable(); // El campo 'area' (área relacionada con la auditoría)
            $table->string('ubicacion')->nullable(); // El campo 'ubicacion' (ubicación de la auditoría)
            $table->year('anio')->nullable(); // El campo 'anio' (año de la auditoría)
            $table->string('folio')->nullable(); // El campo 'folio' (folio asociado con la auditoría)
            $table->date('fecha_alta')->nullable(); // El campo 'fecha_alta' (fecha en que se dio de alta)
            $table->date('fecha_presentacion')->nullable(); // El campo 'fecha_presentacion' (fecha de presentación)
            $table->date('fecha_limite')->nullable(); // El campo 'fecha_limite' (fecha límite de la auditoría)
            $table->string('estatus')->nullable(); // El campo 'estatus' (estatus de la auditoría)
            $table->string('cc')->nullable(); // El campo 'cc' (Centro de costos)
            $table->timestamps(); // Crea los campos 'created_at' y 'updated_at'
            $table->softDeletes(); // Crea el campo 'deleted_at' para el soft delete

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditorias');
    }
};
