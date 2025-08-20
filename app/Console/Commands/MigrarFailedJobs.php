<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarFailedJobs extends Command
{
    protected $signature = 'migrar:failed_jobs';
    protected $description = 'Migrar datos de la tabla failed_jobs de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla failed_jobs...');

        $datos = DB::connection('sqlsrv')->table('failed_jobs')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('failed_jobs')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
