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
        Schema::create('actualizaciones', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha')->useCurrent(); // Fecha del registro
            $table->string('database'); // Nombre de la base de datos
            $table->unsignedBigInteger('id_company'); // ID de la empresa
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actualizaciones');
    }
};
