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
        Schema::create('centro_de_costos', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->string('centro_de_costos')->nullable(); // El campo 'centro_de_costos' (nombre o clave del centro de costos)
            $table->string('company_id')->constrained(); // El campo 'company_id' (relacionado con la tabla de empresas)
            $table->string('presupuesto')->nullable(); // El campo 'presupuesto' (monto presupuestado)
            $table->string('numeracion')->nullable();
            $table->timestamps(); // Crea los campos 'created_at' y 'updated_at'
             // El campo 'numeracion' (código o numeración del centro de costos), puede ser nulo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centro_de_costos');
    }
};
