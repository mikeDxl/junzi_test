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
        Schema::create('procesos', function (Blueprint $table) {
            $table->id(); // bigint auto-incremental
            $table->unsignedInteger('vacante_id');
            $table->unsignedInteger('candidato_id');
            $table->string('estatus')->nullable();
            $table->string('habilitado')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('procesos');
    }
};
