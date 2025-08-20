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
        Schema::create('entregas_auditoria', function (Blueprint $table) {
            $table->id();
            $table->integer('id_reporte');
            $table->string('fecha_de_entrega')->nullable();
            $table->integer('responsable');
            $table->integer('jefe_directo');
            $table->string('entregado')->nullable();
            $table->string('dias_retraso')->nullable();
            $table->string('archivo_adjunto')->nullable();
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
        Schema::dropIfExists('entregas_auditoria');
    }
};
