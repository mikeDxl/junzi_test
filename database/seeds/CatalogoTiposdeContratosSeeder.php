<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeContratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('catalogo_de_tipos_de_contratos')->truncate();



        DB::table('catalogo_de_tipos_de_contratos')->insert([
            ['tipo' => 'Contrato de trabajo por tiempo indeterminado' , 'nomipaq' => '01'],
            ['tipo' => 'Contrato de trabajo por obra determinada' , 'nomipaq' => '02'],
            ['tipo' => 'Contrato de trabajo por tiempo determinado' , 'nomipaq' => '03'],
            ['tipo' => 'Contrato de trabajo por temporada' , 'nomipaq' => '04'],
            ['tipo' => 'Contrato de trabajo sujeto a prueba' , 'nomipaq' => '05'],
            ['tipo' => 'Contrato de trabajo con capacidad incial' , 'nomipaq' => '06'],
            ['tipo' => 'Modalidad de contratación por pago de hora laborada' , 'nomipaq' => '07'],
            ['tipo' => 'Modalidad de trabajo por comisión laboral' , 'nomipaq' => '08'],
            ['tipo' => 'Modalidades de contratación donde no existe relación de trabajo' , 'nomipaq' => '09'],
            ['tipo' => 'Otro contrato' , 'nomipaq' => '99'],
        ]);
    }
}
