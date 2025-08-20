<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeTurnodeTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_turno_de_trabajo')->truncate();

        DB::table('catalogo_de_tipos_de_turno_de_trabajo')->insert([
            ['tipo' => 'Matutino' ],
            ['tipo' => 'Vespertino'],
            ['tipo' => 'Nocturno'],
            ['tipo' => 'Mixto'],
        ]);
    }
}
