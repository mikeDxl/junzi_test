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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('Headcount');
            $table->string('Empresa');
            $table->string('TipoEmpresa');
            $table->string('OrgMatricial');
            $table->string('RazonSocial');
            $table->date('FechaAlta');
            $table->string('EmpleadoCod');
            $table->string('EmpleadoNombreLargo');
            $table->string('DeptoNombre');
            $table->string('PuestoNombre');
            $table->string('ConceptoBandera');
            $table->string('Ubicacion');
            $table->string('EmpleadoEstatus');
            $table->date('FechaBaja')->nullable();
            $table->integer('Ejercicio');
            $table->date('PeriodoInicio');
            $table->date('PeriodoFin');
            $table->string('PeriodoTipoNombre');
            $table->integer('PeriodoNumero');
            $table->string('Periodo');
            $table->string('PeriodoNombre');
            $table->string('ConceptoNombre');
            $table->string('ConceptoTipo');
            $table->decimal('Importe', 10, 2);
            $table->string('TipoDato');
            $table->string('Agrupador');
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
        Schema::dropIfExists('movimientos');
    }
};
