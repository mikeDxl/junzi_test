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
        Schema::table('areas_auditoria', function (Blueprint $table) {
        //trazabilidad
        $table->boolean('trazabilidad')
                ->default(false)
                ->after('es_planta'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas_auditoria', function (Blueprint $table) {
            //
            $table->dropColumn('trazabilidad');
        });
    }
};
