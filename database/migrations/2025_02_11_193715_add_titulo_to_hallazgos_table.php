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
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->string('titulo')->nullable(); // Agregar el campo 'titulo'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->dropColumn('titulo'); // Eliminar el campo 'titulo' si se revierte la migración
        });
    }
};
