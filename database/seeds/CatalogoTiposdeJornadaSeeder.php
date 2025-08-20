<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeJornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_jornada')->truncate();

        DB::table('catalogo_de_tipos_de_jornada')->insert([
            ['tipo' => 'Semana normal' ],
            ['tipo' => '1 día de la semana' ],
            ['tipo' => '2 días de la semana'],
            ['tipo' => '3 días de la semana'],
            ['tipo' => '4 días de la semana'],
            ['tipo' => '5 días de la semana'],
            ['tipo' => 'Menos de 8 horas'],
        ]);
    }
}
