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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('departamento');
            $table->decimal('presupuesto', 15, 2)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('padre')->nullable();
            $table->string('estatus', 20)->nullable();
            $table->string('numerodepartamento', 50)->nullable();
            $table->string('iddepartamento', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
};
