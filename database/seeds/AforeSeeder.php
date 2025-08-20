<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AforeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('afores')->truncate();

        DB::table('afores')->insert([

            ['afore' => 'Azteca'],
            ['afore' => 'Citibanamex'],
            ['afore' => 'Coppel'],
            ['afore' => 'Inbursa'],
            ['afore' => 'Invercap'],
            ['afore' => 'PensionISSSTE'],
            ['afore' => 'Principal'],
            ['afore' => 'Profuturo'],
            ['afore' => 'SURA'],
            ['afore' => 'XXI Banorte'],
        ]);
    }
}
