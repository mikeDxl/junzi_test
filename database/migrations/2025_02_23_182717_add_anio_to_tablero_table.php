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
        Schema::table('tablero', function (Blueprint $table) {
            $table->integer('anio')->default('2025'); // Ajusta 'nombre' al campo después del cual quieres agregarlo
        });
    }


    public function down()
    {
        Schema::table('tablero', function (Blueprint $table) {
            $table->dropColumn('anio');
        });
    }
};
