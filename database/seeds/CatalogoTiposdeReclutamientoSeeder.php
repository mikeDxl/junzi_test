<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeReclutamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_de_reclutamiento')->truncate();

        DB::table('tipos_de_reclutamiento')->insert([
            ['tipo' => 'entrevista'],
            ['tipo' => 'examen psicometrico'],
            ['tipo' => 'documento']
        ]);
    }
}
