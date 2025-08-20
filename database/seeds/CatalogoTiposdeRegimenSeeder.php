<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeRegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_regimen')->truncate();

        DB::table('catalogo_de_tipos_de_regimen')->insert([
            ['tipo' => 'Sueldos (incluye ingresos señalados en' , 'nomipaq' => '02'],
            ['tipo' => 'Jubilados' , 'nomipaq' => '03'],
            ['tipo' => 'Pensionados', 'nomipaq' => '04'],
            ['tipo' => 'Asimilados Miembros Sociedades Cooperativas' , 'nomipaq' => '05'],
            ['tipo' => 'Asimilados Integrantes Sociedades Asoc' , 'nomipaq' => '06'],
            ['tipo' => 'Asimilados Miembros consejos' , 'nomipaq' => '07'],
            ['tipo' => 'Asimilados comisionistas' , 'nomipaq' => '08'],
            ['tipo' => 'Asimilados Honorarios' , 'nomipaq' => '09'],
            ['tipo' => 'Asimilados acciones' , 'nomipaq' => '10'],
            ['tipo' => 'Asimilados otros' , 'nomipaq' => '11'],
            ['tipo' => 'Jubilados o Pensionados' , 'nomipaq' => '12'],
            ['tipo' => 'Indemnización o Separación' , 'nomipaq' => '13'],
            ['tipo' => 'Otro Régimen' , 'nomipaq' => '99'],
        ]);
    }
}
