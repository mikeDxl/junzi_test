<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdePrestacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_prestacion')->truncate();

        DB::table('catalogo_de_tipos_de_prestacion')->insert([
            ['tipo' => 'Confianza'],
            ['tipo' => 'De Ley'],
            ['tipo' => 'Sindicalizado']
        ]);
    }
}
