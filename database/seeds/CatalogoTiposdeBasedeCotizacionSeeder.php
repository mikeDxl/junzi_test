<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeBasedeCotizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_base_de_cotizacion')->truncate();

        DB::table('catalogo_de_tipos_de_base_de_cotizacion')->insert([
            ['tipo' => 'Fijo'],
            ['tipo' => 'Variable' ],
            ['tipo' => 'Mixto'],
        ]);
    }
}
