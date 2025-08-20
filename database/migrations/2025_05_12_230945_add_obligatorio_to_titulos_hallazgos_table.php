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
        Schema::table('titulos_hallazgos', function (Blueprint $table) {
            $table->integer('obligatorio')->default(1)->after('tipo');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('titulos_hallazgos', function (Blueprint $table) {
            $table->dropColumn('obligatorio');
        });
    }
};
