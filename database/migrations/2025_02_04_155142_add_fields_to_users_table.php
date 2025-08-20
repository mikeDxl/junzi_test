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
        Schema::table('users', function (Blueprint $table) {
            $table->string('perfil')->nullable();
            $table->string('rol')->nullable();
            $table->string('colaborador_id')->nullable();
            $table->string('device_key')->nullable();
            $table->string('picture')->nullable();
            $table->string('role_id')->nullable();
            $table->string('nomina')->nullable();
            $table->string('reclutamiento')->nullable();
            $table->string('auditoria')->nullable();
            $table->string('jefe_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['perfil', 'rol', 'colaborador_id', 'device_key','picture','role_id','nomina','reclutamiento','auditoria','jefe_id']);

        });
    }
};
