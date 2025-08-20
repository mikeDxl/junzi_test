<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('numero_de_empleado')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('departamento_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('fotografia')->nullable();
            $table->string('genero')->nullable();
            $table->string('sueldo')->nullable();
            $table->string('puesto')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('jefe_directo')->nullable();
            $table->string('periodo_id')->nullable();
            $table->string('salario_diario')->nullable();
            $table->string('base_de_cotizacion_id')->nullable();
            $table->string('sbc_parte_fija')->nullable();
            $table->string('sbc_parte_variable')->nullable();
            $table->string('sbc')->nullable();
            $table->string('sindicalizado')->nullable();
            $table->string('prestacion_id')->nullable();
            $table->string('base_de_pago_id')->nullable();
            $table->string('metodo_de_pago_id')->nullable();
            $table->string('turno_de_trabajo_id')->nullable();
            $table->string('zona_de_salario_id')->nullable();
            $table->string('jornada_id')->nullable();
            $table->string('regimen_id')->nullable();
            $table->string('fonacot')->nullable();
            $table->string('afore_id')->nullable();
            $table->string('email')->nullable();
            $table->string('nss')->nullable();
            $table->string('registro_patronal_id')->nullable();
            $table->string('umf')->nullable()->nullable();
            $table->string('estado_civil_id')->nullable();
            $table->string('fecha_alta')->nullable();
            $table->string('fecha_baja')->nullable();
            $table->string('cuenta_cheques')->nullable();
            $table->string('banco')->nullable();
            $table->string('estado_nacimiento')->nullable();
            $table->string('clabe_interbancaria')->nullable();
            $table->string('afore')->nullable();
            $table->string('estatus')->nullable();
            $table->string('organigrama')->nullable();
            $table->string('proyectos')->nullable();
            $table->string('ubicaciones')->nullable();
            $table->string('estado')->nullable();
            $table->string('poblacion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('codigopostal')->nullable();
            $table->string('tipo_de_contrato_id')->nullable();
            $table->string('estadoempleado')->nullable();
            $table->string('idempleado')->nullable();
            $table->string('sueldovariable')->nullable();
            $table->string('sueldointegrado')->nullable();
            $table->string('csueldomixto')->nullable();
            $table->string('causabaja')->nullable();
            $table->string('inicio_infonavit')->nullable();
            $table->string('tipo_descuento')->nullable();
            $table->string('monto_descuento')->nullable();
            $table->string('infonavit')->nullable();
            $table->string('tarjeta')->nullable();
            $table->string('ciudad_nacimiento')->nullable();
            $table->string('tipo_de_sangre')->nullable();
            $table->string('tiene_alergia')->nullable();
            $table->string('alergias')->nullable();
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
        Schema::dropIfExists('colaboradores');
    }
}

