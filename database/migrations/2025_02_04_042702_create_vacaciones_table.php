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
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Sin clave foránea
            $table->unsignedBigInteger('colaborador_id'); // Sin clave foránea
            $table->unsignedBigInteger('jefe_directo_id')->nullable(); // Sin clave foránea
            $table->string('cc')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->string('estatus')->nullable();
            $table->string('autorizo')->nullable();
            $table->text('comentarios')->nullable();
            $table->string('otro')->nullable();
            $table->year('anio')->nullable();
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
        Schema::dropIfExists('vacaciones');
    }
};
