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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('clave'); // El campo 'clave' (clave del banco)
            $table->string('banco'); // El campo 'banco' (nombre del banco)
            $table->string('descripcion'); // El campo 'descripcion' (descripción del banco)
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
        Schema::dropIfExists('bancos');
    }
};
