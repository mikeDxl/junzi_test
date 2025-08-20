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
        Schema::create('proceso_reclutamiento', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('vacante_id')->nullable();
            $table->integer('candidato_id')->nullable();
            $table->string('curriculum')->nullable();
            $table->string('entrevista1_fecha')->nullable();
            $table->string('entrevista1_hora')->nullable();
            $table->string('entrevista2_fecha')->nullable();
            $table->string('entrevista2_hora')->nullable();

            for ($i = 1; $i <= 3; $i++) {
                $table->string("referencia_nombre$i")->nullable();
                $table->string("referencia_telefono$i")->nullable();
                $table->string("referencia_empresa$i")->nullable();
            }

            $table->string('examen')->nullable();

            for ($i = 1; $i <= 5; $i++) {
                $table->string("documento$i")->nullable();
                $table->string("estatus_documento$i")->nullable();
                $table->string("comentariodoc$i")->nullable();
            }

            $table->string('comentarios')->nullable();
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('current')->nullable();
            $table->string('entrevista1_hasta')->nullable();
            $table->string('entrevista1_desde')->nullable();
            $table->string('estatus_entrevista')->nullable();
            $table->string('fotoexamen')->nullable();
            $table->string('orden')->nullable();
            $table->string('estatus_proceso')->nullable();
            $table->string('fecha_jefatura')->nullable();
            $table->string('fecha_nomina')->nullable();
            $table->string('fecha_reclutamiento')->nullable();
            $table->string('prioridad')->nullable();
            $table->string('habilitado')->default(0);
            $table->string('rechazado_por')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proceso_reclutamiento');
    }
};
