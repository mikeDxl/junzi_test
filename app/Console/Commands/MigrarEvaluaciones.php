<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarEvaluaciones extends Command
{
    protected $signature = 'migrar:evaluaciones';
    protected $description = 'Migrar datos de la tabla evaluaciones de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla evaluaciones...');

        $datos = DB::connection('sqlsrv')->table('evaluaciones')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('evaluaciones')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
