<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_civil')->truncate();

        DB::table('estado_civil')->insert([

            ['estado_civil' => 'Soltero'],
            ['estado_civil' => 'Casado'],
            ['estado_civil' => 'Viudo'],
            ['estado_civil' => 'Divorciado'],
            ['estado_civil' => 'Union Libre'],
            ['estado_civil' => 'Separado'],
        ]);
    }
}
