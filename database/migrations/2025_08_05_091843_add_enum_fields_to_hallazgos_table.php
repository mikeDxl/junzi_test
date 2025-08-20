
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
            // Criticidad como enum con valores: baja, media, alta
            $table->enum('criticidad', ['baja', 'media', 'alta'])
                  ->default('baja')
                  ->after('tipo'); // Colocar después de la columna 'tipo'
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
            $table->dropColumn('criticidad');
        });
    }
};