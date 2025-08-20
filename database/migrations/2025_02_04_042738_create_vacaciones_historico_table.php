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
        Schema::create('vacaciones_historico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_id'); // Sin clave foránea
            $table->year('anio'); // Almacena solo el año
            $table->integer('tomadas')->default(0); // Días de vacaciones tomadas
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
        Schema::dropIfExists('vacaciones_historico');
    }
};
