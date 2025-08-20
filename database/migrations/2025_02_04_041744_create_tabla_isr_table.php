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
        Schema::create('tabla_isr', function (Blueprint $table) {
            $table->id();
            $table->decimal('limite_inferior', 10, 2);
            $table->decimal('limite_superior', 10, 2);
            $table->decimal('cuota_fija', 10, 2);
            $table->decimal('porcentaje', 5, 2);
            $table->string('anio');
            $table->string('periodo');
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
        Schema::dropIfExists('tabla_isr');
    }
};
