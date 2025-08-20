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
        Schema::create('agrupadores_lista', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->unsignedBigInteger('company_id'); // El campo 'company_id'
            $table->unsignedBigInteger('agrupador_id'); // El campo 'agrupador_id'
            $table->unsignedBigInteger('departamento_id'); // El campo 'departamento_id'
            $table->string('nombre'); // El campo 'nombre'
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
        Schema::dropIfExists('agrupadores_lista');
    }
};
