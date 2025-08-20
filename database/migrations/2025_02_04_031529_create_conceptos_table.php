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
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->text('idconcepto')->nullable();
            $table->text('numeroconcepto')->nullable();
            $table->text('tipoconcepto')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('especie')->nullable();
            $table->text('automaticoglobal')->nullable();
            $table->text('automaticoliquidacion')->nullable();
            $table->text('imprimir')->nullable();
            $table->text('articulo86')->nullable();
            $table->text('leyendaimporte1')->nullable();
            $table->text('leyendaimporte2')->nullable();
            $table->text('leyendaimporte3')->nullable();
            $table->text('leyendaimporte4')->nullable();
            $table->text('cuentacw')->nullable();
            $table->text('tipomovtocw')->nullable();
            $table->text('contracuentacw')->nullable();
            $table->text('contabcuentacw')->nullable();
            $table->text('contabcontracuentacw')->nullable();
            $table->text('leyendavalor')->nullable();
            $table->text('formulaimportetotal')->nullable();
            $table->text('formulaimporte1')->nullable();
            $table->text('formulaimporte2')->nullable();
            $table->text('formulaimporte3')->nullable();
            $table->text('formulaimporte4')->nullable();
            $table->text('FormulaValor')->nullable();
            $table->text('CuentaGravado')->nullable();
            $table->text('CuentaExentoDeduc')->nullable();
            $table->text('CuentaExentoNoDeduc')->nullable();
            $table->text('ClaveAgrupadoraSAT')->nullable();
            $table->text('MetodoDePago')->nullable();
            $table->text('TipoClaveSAT')->nullable();
            $table->text('TipoHoras')->nullable();
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
        Schema::dropIfExists('conceptos');
    }
};
