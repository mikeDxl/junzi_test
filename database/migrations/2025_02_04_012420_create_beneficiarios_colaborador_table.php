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
        Schema::create('beneficiarios_colaborador', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->unsignedBigInteger('company_id'); // El campo 'company_id' (ID de la compañía)
            $table->unsignedBigInteger('colaborador_id'); // El campo 'colaborador_id' (ID del colaborador)
            $table->string('nombre'); // El campo 'nombre' (nombre del beneficiario)
            $table->string('telefono'); // El campo 'telefono' (número de teléfono del beneficiario)
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
        Schema::dropIfExists('beneficiarios_colaborador');
    }
};
