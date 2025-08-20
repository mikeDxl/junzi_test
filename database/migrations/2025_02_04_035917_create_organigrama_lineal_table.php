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
        Schema::create('organigrama_lineal', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('area_id');
            $table->string('area');
            $table->integer('jefe_directo');
            $table->integer('niveles');
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
        Schema::dropIfExists('organigrama_lineal');
    }
};
