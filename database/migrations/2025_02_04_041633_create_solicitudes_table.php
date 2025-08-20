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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('colaborador_id');
            $table->string('solicita');
            $table->unsignedBigInteger('tiposolicitud_id');
            $table->integer('duracion');
            $table->date('desde');
            $table->date('hasta');
            $table->string('tipo_de_goce');
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('estatus');
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
        Schema::dropIfExists('solicitudes');
    }
};
