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
        Schema::create('organigrama_lineal_niveles', function (Blueprint $table) {
            $table->id();
            $table->integer('organigrama_id');
            $table->integer('nivel');
            $table->integer('colaborador_id');
            $table->integer('jefe_directo_id');
            $table->string('jefe_directo_codigo');
            $table->string('puesto');
            $table->string('cc');
            $table->string('codigo');
            $table->timestamps();
            $table->integer('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organigrama_lineal_niveles');
    }
};
