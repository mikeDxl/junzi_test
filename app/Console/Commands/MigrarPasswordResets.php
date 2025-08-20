<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPasswordResets extends Command
{
    protected $signature = 'migrar:password_resets';
    protected $description = 'Migrar datos de la tabla password_resets de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla password_resets...');

        $datos = DB::connection('sqlsrv')->table('password_resets')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('password_resets')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
