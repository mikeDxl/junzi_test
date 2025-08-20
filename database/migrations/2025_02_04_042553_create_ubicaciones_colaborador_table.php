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
        Schema::create('ubicaciones_colaborador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ubicacion'); // Sin clave foránea
            $table->unsignedBigInteger('id_colaborador'); // Sin clave foránea
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
        Schema::dropIfExists('ubicaciones_colaborador');
    }
};
