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
    public function up() {
        Schema::create('tablero', function (Blueprint $table) {
            $table->id(); // Llave primaria autoincremental
            $table->string('headcount')->nullable();
            $table->string('empresa')->nullable();
            $table->string('tipo_empresa')->nullable();
            $table->string('org_matricial')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('fecha_alta')->nullable();
            $table->string('empleado_cod')->nullable();
            $table->string('empleado_nombre_largo')->nullable();
            $table->string('depto_nombre')->nullable();
            $table->string('puesto_nombre')->nullable();
            $table->string('concepto_bandera')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('empleado_estatus')->nullable();
            $table->string('fecha_baja')->nullable();
            $table->string('ejercicio')->nullable();
            $table->string('periodo_inicio')->nullable();
            $table->string('periodo_fin')->nullable();
            $table->string('periodo_tipo_nombre')->nullable();
            $table->string('periodo_numero')->nullable();
            $table->string('periodo')->nullable();
            $table->string('periodo_nombre')->nullable();
            $table->string('concepto_nombre')->nullable();
            $table->string('concepto_tipo')->nullable();
            $table->string('importe')->nullable();
            $table->string('tipo_dato')->nullable();
            $table->string('agrupador')->nullable();
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('tablero');
    }

};
