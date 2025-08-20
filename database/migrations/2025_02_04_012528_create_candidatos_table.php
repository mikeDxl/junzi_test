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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('nombre'); // El campo 'nombre' (nombre del candidato)
            $table->string('apellido_paterno'); // El campo 'apellido_paterno' (apellido paterno del candidato)
            $table->string('apellido_materno'); // El campo 'apellido_materno' (apellido materno del candidato)
            $table->date('fecha_nacimiento'); // El campo 'fecha_nacimiento' (fecha de nacimiento del candidato)
            $table->integer('edad'); // El campo 'edad' (edad del candidato)
            $table->string('cv')->nullable(); // El campo 'cv' (CV del candidato), puede ser nulo
            $table->string('fuente')->nullable(); // El campo 'fuente' (fuente de donde llegó el candidato), puede ser nulo
            $table->text('comentarios')->nullable(); // El campo 'comentarios' (comentarios adicionales), puede ser nulo
            $table->string('estatus'); // El campo 'estatus' (estatus del candidato)
            $table->string('email')->nullable(); // El campo 'email' (correo electrónico del candidato)
            $table->string('telefono')->nullable(); // El campo 'telefono' (número de teléfono del candidato)
            $table->string('prioridad')->nullable(); // El campo 'prioridad' (prioridad del candidato)
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
        Schema::dropIfExists('candidatos');
    }
};
