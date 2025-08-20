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
        Schema::create('puestos_centros_de_costos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_catalogo_puestos_id');
            $table->unsignedBigInteger('id_catalogo_centro_de_costos_id');
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
        Schema::dropIfExists('puestos_centros_de_costos');
    }
};
