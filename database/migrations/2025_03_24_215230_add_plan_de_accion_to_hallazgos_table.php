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
            $table->text('plan_de_accion')->nullable()->after('sugerencia');
        });
    }

    public function down()
    {
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->dropColumn('plan_de_accion');
        });
    }

};
