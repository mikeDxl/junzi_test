<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAsistencias extends Command
{
    protected $signature = 'migrar:asistencias';
    protected $description = 'Migrar datos de la tabla asistencias de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla asistencias...');

        $datos = DB::connection('sqlsrv')->table('asistencias')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('asistencias')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
