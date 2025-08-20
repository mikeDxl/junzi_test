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
        Schema::create('headcount', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('activos');
            $table->integer('desvinculados');
            $table->integer('vacantes');
            $table->integer('mes');
            $table->integer('anio');
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
        Schema::dropIfExists('headcount');
    }
};
