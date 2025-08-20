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
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('idperiodo');
            $table->string('idtipoperiodo');
            $table->string('numeroperiodo');
            $table->string('ejercicio');
            $table->string('mes');
            $table->string('diasdepago');
            $table->string('septimos');
            $table->string('interfazcheqpaqw')->nullable();
            $table->string('modificacionneto')->nullable();
            $table->string('calculado')->nullable();
            $table->string('afectado')->nullable();
            $table->string('fechainicio')->nullable();
            $table->string('fechafin')->nullable();
            $table->string('inicioejercicio')->nullable();
            $table->string('iniciomes')->nullable();
            $table->string('finmes')->nullable();
            $table->string('finejercicio')->nullable();
            $table->string('cfinbimestreimss')->nullable();
            $table->string('ciniciobimestreimss')->nullable();
            $table->string('fechaPago')->nullable();
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
        Schema::dropIfExists('periodos');
    }
};
