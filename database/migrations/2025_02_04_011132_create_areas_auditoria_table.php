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
        Schema::create('areas_auditoria', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('nombre'); // El campo 'nombre'
            $table->string('clave'); // El campo 'clave'
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
        Schema::dropIfExists('areas_auditoria');
    }
};
