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
        Schema::create('externos', function (Blueprint $table) {
            $table->id();
            $table->string('area');
            $table->unsignedBigInteger('company_id');
            $table->string('empresa');
            $table->string('giro');
            $table->string('tipo');
            $table->decimal('presupuesto', 10, 2);
            $table->integer('cantidad');
            $table->text('comentarios')->nullable();
            $table->string('estatus');
            $table->string('rfc');
            $table->string('jefe');
            $table->decimal('ingreso', 10, 2);
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
        Schema::dropIfExists('externos');
    }
};
