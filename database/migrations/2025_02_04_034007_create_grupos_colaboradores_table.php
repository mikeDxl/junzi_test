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
        Schema::create('grupos_colaboradores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_id'); // Relación con grupos
            $table->unsignedBigInteger('colaborador_id'); // Relación con colaboradores
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos_colaboradores');
    }
};
