<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdePeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_periodo')->truncate();

        DB::table('catalogo_de_tipos_de_periodo')->insert([
            ['tipo' => 'Semanal' , 'dias' => '7'],
            ['tipo' => 'Quincenal' , 'dias' => '15'],
            ['tipo' => 'Mensual', 'dias' => '30'],
            ['tipo' => 'Catorcenal' , 'dias' => '14'],
        ]);
    }
}
