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
        Schema::create('altas', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->unsignedBigInteger('candidato_id'); // El campo 'candidato_id'
            $table->unsignedBigInteger('company_id'); // El campo 'company_id'
            $table->date('fecha_alta'); // El campo 'fecha_alta'
            $table->string('estatus'); // El campo 'estatus'
            $table->unsignedBigInteger('jefe_directo_id'); // El campo 'jefe_directo_id'
            $table->string('centro_de_costos'); // El campo 'centro_de_costos'
            $table->string('motivo'); // El campo 'motivo'
            $table->unsignedBigInteger('id_puesto'); // El campo 'id_puesto'
            $table->unsignedBigInteger('id_vacante'); // El campo 'id_vacante'
            $table->string('codigo'); // El campo 'codigo'
            $table->timestamps(); // Crea los campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('altas');
    }
};
