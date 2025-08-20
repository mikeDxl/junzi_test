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
            $table->text('respuestaid')->nullable(); // cambia 'columna_existente' por la columna que quieres que vaya antes
        });
    }

    public function down()
    {
        Schema::table('hallazgos', function (Blueprint $table) {
            $table->dropColumn('respuestaid');
        });
    }

};
