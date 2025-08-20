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
        Schema::create('puestos', function (Blueprint $table) {
            $table->id(); // bigint IDENTITY(1,1) PRIMARY KEY
            $table->integer('idpuesto');
            $table->integer('numeropuesto');
            $table->integer('company_id');
            $table->integer('departamento_id');
            $table->string('puesto', 255);
            $table->float('presupuesto')->default(0.00);
            $table->integer('jerarquia')->nullable();
            $table->integer('padre')->nullable();
            $table->string('estatus', 255)->default('inactivo');
            $table->text('perfil')->nullable();
            $table->text('codigo')->nullable();
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
        Schema::dropIfExists('puestos');
    }
};
