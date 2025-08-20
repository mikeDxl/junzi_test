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
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->date('fecha_identificacion')->nullable()->after('fecha_compromiso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->dropColumn('fecha_identificacion');
        });
    }
};
