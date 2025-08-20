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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id(); // bigint auto-incremental
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('colaborador_id')->nullable();
            $table->unsignedBigInteger('jefe_directo_id')->nullable();
            $table->string('cc', 255)->nullable();
            $table->string('fecha_solicitud')->nullable();
            $table->string('fecha_permiso')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('monto', 8, 2)->nullable();
            $table->string('estatus', 255)->nullable();
            $table->string('autorizo', 255)->nullable();
            $table->text('comentarios')->nullable();
            $table->string('tipo', 255)->nullable();
            $table->integer('anio')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('permisos');
    }
};
