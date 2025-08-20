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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->unsignedBigInteger('company_id'); // El campo 'company_id'
            $table->unsignedBigInteger('colaborador_id'); // El campo 'colaborador_id'
            $table->unsignedBigInteger('jefe_directo_id'); // El campo 'jefe_directo_id'
            $table->string('cc'); // El campo 'cc' (Centro de costos)
            $table->date('fecha'); // El campo 'fecha' (fecha de asistencia)
            $table->string('asistencia'); // El campo 'asistencia' (Presente o Ausente)
            $table->time('hora'); // El campo 'hora' (hora de asistencia)
            $table->string('estatus'); // El campo 'estatus' (Aprobado, Pendiente, etc.)
            $table->string('autorizo'); // El campo 'autorizo' (quién autorizó la asistencia)
            $table->text('comentarios')->nullable(); // El campo 'comentarios' (comentarios adicionales)
            $table->string('otro')->nullable(); // El campo 'otro' (campo adicional)
            $table->year('anio'); // El campo 'anio' (Año de la asistencia)
            $table->timestamps(); // Crea los campos 'created_at' y 'updated_at'

            // Si deseas agregar claves foráneas, puedes hacerlo así:
            // $table->foreign('company_id')->references('id')->on('companies');
            // $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            // $table->foreign('jefe_directo_id')->references('id')->on('jefes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};
