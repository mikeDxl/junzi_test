<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarHallazgosEstatus extends Command
{
    protected $signature = 'migrar:hallazgos_estatus';
    protected $description = 'Migrar datos de la tabla hallazgos_estatus de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla hallazgos_estatus...');

        $datos = DB::connection('sqlsrv')->table('hallazgos_estatus')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('hallazgos_estatus')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
