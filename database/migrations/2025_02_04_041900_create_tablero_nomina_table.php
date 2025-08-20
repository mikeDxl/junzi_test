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
        Schema::create('tablero_nomina', function (Blueprint $table) {
            $table->id();
            $table->integer('headcount')->nullable();
            $table->string('empresa');
            $table->string('tipo_empresa');
            $table->string('org_matricial')->nullable();
            $table->string('razon_social');
            $table->date('fecha_alta')->nullable();
            $table->string('empleado_cod')->unique();
            $table->string('empleado_nombre_largo');
            $table->string('depto_nombre');
            $table->string('puesto_nombre');
            $table->string('concepto_bandera')->nullable();
            $table->string('ubicacion');
            $table->string('empleado_estatus');
            $table->date('fecha_baja')->nullable();
            $table->integer('ejercicio');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->string('periodo_tipo_nombre');
            $table->integer('periodo_numero');
            $table->string('periodo');
            $table->string('periodo_nombre');
            $table->string('concepto_nombre');
            $table->string('concepto_tipo');
            $table->decimal('importe', 15, 2);
            $table->string('tipo_dato');
            $table->string('agrupador')->nullable();
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
        Schema::dropIfExists('tablero_nomina');
    }
};
