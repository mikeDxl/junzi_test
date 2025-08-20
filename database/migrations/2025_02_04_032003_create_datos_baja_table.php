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
        Schema::create('datos_baja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_id');
            $table->string('fecha_baja');
            $table->string('motivo_baja')->nullable();
            $table->string('salario_radio', 10, 2)->nullable();
            $table->string('salario_diario', 10, 2)->nullable();
            $table->string('salario_diario_integral', 10, 2)->nullable();
            $table->string('salario_nuevo', 10, 2)->nullable();
            $table->string('s_salario_normal', 10, 2)->nullable();
            $table->string('d_salario_normal', 10, 2)->nullable();
            $table->string('salario_normal', 10, 2)->nullable();
            $table->string('s_aguinaldo', 10, 2)->nullable();
            $table->string('d_aguinaldo', 10, 2)->nullable();
            $table->string('d2_aguinaldo', 10, 2)->nullable();
            $table->string('aguinaldo', 10, 2)->nullable();
            $table->string('s_vacaciones', 10, 2)->nullable();
            $table->string('d_vacaciones', 10, 2)->nullable();
            $table->string('vacaciones', 10, 2)->nullable();
            $table->string('s_vacaciones_pend', 10, 2)->nullable();
            $table->string('d_vacaciones_pend', 10, 2)->nullable();
            $table->string('vacaciones_pend', 10, 2)->nullable();
            $table->string('s_primavacacional', 10, 2)->nullable();
            $table->string('d_primavacacional', 10, 2)->nullable();
            $table->string('prima_vacacional', 10, 2)->nullable();
            $table->string('s_primavacacional_pend', 10, 2)->nullable();
            $table->string('d_primavacacional_pend', 10, 2)->nullable();
            $table->string('prima_vacacional_pend', 10, 2)->nullable();
            $table->string('s_incentivo', 10, 2)->nullable();
            $table->string('d_incentivo', 10, 2)->nullable();
            $table->string('incentivo', 10, 2)->nullable();
            $table->string('s_prima_de_antiguedad', 10, 2)->nullable();
            $table->string('d_prima_de_antiguedad', 10, 2)->nullable();
            $table->string('prima_de_antiguedad', 10, 2)->nullable();
            $table->string('s_gratificacion', 10, 2)->nullable();
            $table->string('d_gratificacion', 10, 2)->nullable();
            $table->string('gratificacion', 10, 2)->nullable();
            $table->string('s_veinte_dias', 10, 2)->nullable();
            $table->string('d_veinte_dias', 10, 2)->nullable();
            $table->string('veinte_dias', 10, 2)->nullable();
            $table->string('s_despensa', 10, 2)->nullable();
            $table->string('d_despensa', 10, 2)->nullable();
            $table->string('despensa', 10, 2)->nullable();
            $table->string('s_isr', 10, 2)->nullable();
            $table->string('isr', 10, 2)->nullable();
            $table->string('s_imss', 10, 2)->nullable();
            $table->string('imss', 10, 2)->nullable();
            $table->string('s_deudores', 10, 2)->nullable();
            $table->string('deudores', 10, 2)->nullable();
            $table->string('s_isr_finiquito', 10, 2)->nullable();
            $table->string('isr_finiquito', 10, 2)->nullable();
            $table->string('percepciones', 10, 2)->nullable();
            $table->string('deducciones', 10, 2)->nullable();
            $table->string('total', 10, 2)->nullable();
            $table->string('comprobante')->nullable();
            $table->string('fecha_elaboracion')->nullable();
            $table->string('periodo_isr')->nullable();
            $table->string('baja_id')->nullable();
            $table->string('uma', 10, 2)->nullable();
            $table->string('salario_minimo', 10, 2)->nullable();
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
        Schema::dropIfExists('datos_baja');
    }
};
