<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoCentrosDeCostosTable extends Migration
{
    public function up()
    {
        Schema::create('catalogo_centros_de_costos', function (Blueprint $table) {
            $table->id();
            $table->string('centro_de_costo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogo_centros_de_costos');
    }
}
