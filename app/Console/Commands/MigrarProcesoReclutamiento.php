<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarProcesoReclutamiento extends Command
{
    protected $signature = 'migrar:proceso_reclutamiento';
    protected $description = 'Migrar datos de la tabla proceso_reclutamiento de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla proceso_reclutamiento...');

        $datos = DB::connection('sqlsrv')->table('proceso_reclutamiento')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('proceso_reclutamiento')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
