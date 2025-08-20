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
        Schema::create('hallazgo_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_auditoria');
            $table->unsignedBigInteger('id_hallazgo');
            $table->unsignedBigInteger('id_user');
            $table->string('comentario');
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
        Schema::dropIfExists('hallazgo_archivos');
    }
};
