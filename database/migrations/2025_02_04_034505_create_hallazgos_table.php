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
        Schema::create('hallazgos', function (Blueprint $table) {
            $table->id();
            $table->integer('auditoria_id');
            $table->string('responsable');
            $table->date('fecha_presentacion')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->text('hallazgo')->nullable();
            $table->string('estatus')->nullable();
            $table->string('evidencia')->nullable();
            $table->text('comentarios')->nullable();
            $table->timestamps();
            $table->date('fecha_cierre')->nullable();
            $table->date('fecha_compromiso')->nullable();
            $table->string('tipo')->nullable();
            $table->string('jefe')->nullable();
            $table->text('comentarios_colaborador')->nullable();
            $table->string('evidencia_colaborador')->nullable();
            $table->date('fecha_colaborador')->nullable();
            $table->text('sugerencia')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hallazgos');
    }
};
