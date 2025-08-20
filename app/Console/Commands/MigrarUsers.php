<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarUsers extends Command
{
    protected $signature = 'migrar:users';
    protected $description = 'Migrar datos de la tabla users de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla users...');

        $datos = DB::connection('sqlsrv')->table('users')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('users')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
