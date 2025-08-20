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
        Schema::create('vacaciones_pendientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Sin clave foránea
            $table->unsignedBigInteger('colaborador_id'); // Sin clave foránea
            $table->date('fecha_alta')->nullable(); // Fecha de alta
            $table->integer('anteriores')->default(0); // Vacaciones de periodos anteriores
            $table->integer('actuales')->default(0); // Vacaciones del periodo actual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacaciones_pendientes');
    }
};
