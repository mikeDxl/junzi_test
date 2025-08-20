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
            //tipo_planta
        $table->boolean('es_planta')
                ->default(false)
                ->after('clave'); 
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
            $table->dropColumn('es_planta');
        });
    }
};
