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
        Schema::create('preguntas_reclutamiento', function (Blueprint $table) {
            $table->id(); // bigint auto-incremental
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('id_vacante');
            $table->unsignedInteger('id_candidato');
            $table->string('etapa')->nullable();
            $table->string('perfil')->nullable();
            $table->string('pregunta')->nullable();
            $table->string('valoracion')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('preguntas_reclutamiento');
    }
};
