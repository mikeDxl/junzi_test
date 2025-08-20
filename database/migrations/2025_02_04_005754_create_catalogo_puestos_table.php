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
        Schema::create('catalogo_puestos', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('puesto')->nullable(); // El campo 'puesto'
            $table->string('tipo')->nullable(); // El campo 'tipo'
            $table->string('perfil')->nullable(); // El campo 'perfil'
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
        Schema::dropIfExists('catalogo_puestos');
    }
};
