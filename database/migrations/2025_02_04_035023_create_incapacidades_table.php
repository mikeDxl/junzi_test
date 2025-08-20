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
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('colaborador_id');
            $table->integer('jefe_directo_id');
            $table->string('cc');
            $table->integer('dias')->nullable();
            $table->date('apartir')->nullable();
            $table->date('expedido')->nullable();
            $table->string('estatus')->nullable();
            $table->string('autorizo')->nullable();
            $table->text('comentarios')->nullable();
            $table->string('otro')->nullable();
            $table->integer('anio')->nullable();
            $table->timestamps();
            $table->string('archivo')->nullable(); // Añadir columna de archivo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incapacidades');
    }
};
