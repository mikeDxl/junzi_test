<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarHallazgoArchivos extends Command
{
    protected $signature = 'migrar:hallazgo_archivos';
    protected $description = 'Migrar datos de la tabla hallazgo_archivos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla hallazgo_archivos...');

        $datos = DB::connection('sqlsrv')->table('hallazgo_archivos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('hallazgo_archivos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
