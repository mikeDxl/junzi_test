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
        Schema::create('gratificaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id'); // Se eliminó el constraint de clave foránea
            $table->integer('colaborador_id'); // Se eliminó el constraint de clave foránea
            $table->integer('jefe_directo_id'); // Se eliminó el constraint de clave foránea
            $table->string('cc')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_gratificacion')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('estatus')->nullable();
            $table->string('autorizo')->nullable();
            $table->text('comentarios')->nullable();
            $table->string('otro')->nullable();
            $table->integer('anio')->nullable();
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
        Schema::dropIfExists('gratificaciones');
    }
};
