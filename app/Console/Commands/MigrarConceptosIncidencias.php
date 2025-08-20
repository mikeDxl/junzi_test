<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarConceptosIncidencias extends Command
{
    protected $signature = 'migrar:conceptos_incidencias';
    protected $description = 'Migrar datos de la tabla conceptos_incidencias de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla conceptos_incidencias...');

        $datos = DB::connection('sqlsrv')->table('conceptos_incidencias')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('conceptos_incidencias')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
