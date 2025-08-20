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
        Schema::table('entregas_jefatura', function (Blueprint $table) {
            $table->enum('estatus', ['pendiente', 'completado', 'en progreso', 'detenido'])->default('pendiente');
            $table->date('fecha_habilitada')->nullable();
            $table->date('fecha_completada')->nullable();
        });
    }

    public function down()
    {
        Schema::table('entregas_jefatura', function (Blueprint $table) {
            $table->dropColumn(['estatus', 'fecha_habilitada', 'fecha_completada']);
        });
    }
};
