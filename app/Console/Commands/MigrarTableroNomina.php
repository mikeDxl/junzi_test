<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTableroNomina extends Command
{
    protected $signature = 'migrar:tablero_nomina';
    protected $description = 'Migrar datos de la tabla tablero_nomina de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla tablero_nomina...');

        $datos = DB::connection('sqlsrv')->table('tablero_nomina')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('tablero_nomina')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
