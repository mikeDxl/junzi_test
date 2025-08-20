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
        Schema::create('bajas', function (Blueprint $table) {
            $table->id(); // Crea el campo 'id' como clave primaria
            $table->unsignedBigInteger('company_id'); // El campo 'company_id'
            $table->unsignedBigInteger('colaborador_id'); // El campo 'colaborador_id'
            $table->string('area'); // El campo 'area' (área de trabajo)
            $table->unsignedBigInteger('departamento_id'); // El campo 'departamento_id'
            $table->unsignedBigInteger('puesto_id'); // El campo 'puesto_id'
            $table->date('fecha_baja'); // El campo 'fecha_baja' (fecha de baja)
            $table->string('motivo'); // El campo 'motivo' (motivo de baja)
            $table->boolean('vacante'); // El campo 'vacante' (si la vacante es para ser cubierta)
            $table->string('generada_por')->nullable(); // El campo 'generada_por' (quién generó la baja)
            $table->string('comprobante')->nullable(); // El campo 'comprobante' (comprobante relacionado, puede ser nulo)
            $table->decimal('monto', 10, 2)->nullable(); // El campo 'monto' (monto relacionado, puede ser nulo)
            $table->string('estatus')->nullable(); // El campo 'estatus' (estatus de la baja)
            $table->timestamps(); // Crea los campos 'created_at' y 'updated_at'

            // Si deseas agregar claves foráneas, puedes hacerlo así:
            // $table->foreign('company_id')->references('id')->on('companies');
            // $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            // $table->foreign('departamento_id')->references('id')->on('departamentos');
            // $table->foreign('puesto_id')->references('id')->on('puestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bajas');
    }
};
