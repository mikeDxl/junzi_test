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
        Schema::create('tipos_de_solicitudes', function (Blueprint $table) {
            $table->id(); // bigint, auto-incremental
            $table->unsignedBigInteger('company_id'); // int NOT NULL
            $table->string('tipo', 255); // nvarchar(255) NOT NULL
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
        Schema::dropIfExists('tipos_de_solicitudes');
    }
};
