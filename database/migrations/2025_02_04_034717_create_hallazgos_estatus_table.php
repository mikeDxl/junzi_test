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
        Schema::create('hallazgos_estatus', function (Blueprint $table) {
            $table->id();
            $table->integer('hallazgo_id');
            $table->string('responsable');
            $table->string('evidencia')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->string('estatus')->nullable();
            $table->text('comentarios')->nullable();
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
        Schema::dropIfExists('hallazgos_estatus');
    }
};
