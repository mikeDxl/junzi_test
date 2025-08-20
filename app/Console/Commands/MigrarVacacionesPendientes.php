<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarVacacionesPendientes extends Command
{
    protected $signature = 'migrar:vacaciones_pendientes';
    protected $description = 'Migrar datos de la tabla vacaciones_pendientes de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla vacaciones_pendientes...');

        $datos = DB::connection('sqlsrv')->table('vacaciones_pendientes')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('vacaciones_pendientes')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
