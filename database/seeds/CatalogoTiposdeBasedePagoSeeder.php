<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeBasedePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_base_de_pago')->truncate();

        DB::table('catalogo_de_tipos_de_base_de_pago')->insert([
            ['tipo' => 'Sueldo'],
            ['tipo' => 'Comisión'],
            ['tipo' => 'Destajo'],
            ['tipo' => 'Sueldo-Comisión'],
            ['tipo' => 'Sueldo-Destajo'],
        ]);
    }
}
