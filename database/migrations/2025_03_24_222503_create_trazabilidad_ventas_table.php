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
        Schema::create('trazabilidad_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('empresa'); // Campo empresa
            $table->string('planta'); // Campo planta
            $table->double('nota_de_entrega')->nullable(); // Campo nota_de_entrega
            $table->double('factura')->nullable(); // Campo factura
            $table->double('carta_porte')->nullable(); // Campo carta_porte
            $table->double('complemento_carta')->nullable(); // Campo complemento_carta
            $table->integer('anio')->nullable(); // Campo año
            $table->integer('mes')->nullable(); // Campo mes
            $table->timestamps(); // Para created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('trazabilidad_ventas');
    }
};
