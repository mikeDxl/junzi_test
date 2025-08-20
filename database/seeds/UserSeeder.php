<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([

            ['name' => 'Admin',
             'email' => 'admin@junzi.com',
             'password' => '$2y$10$M4Mzwsf4/j5z4y/Eu0P0luAFdHS6qCPN5yCDGkvKiCkRn8J.U16Lq',
             'perfil' => 'Admin',
             'rol' => NULL,
             'colaborador_id' => NULL,
             'device_key' => '0',
             'picture' => '../white/img/jana.jpg',
             'role_id' => '1',],
        ]);
    }
}
