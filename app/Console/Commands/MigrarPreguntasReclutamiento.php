<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPreguntasReclutamiento extends Command
{
    protected $signature = 'migrar:preguntas_reclutamiento';
    protected $description = 'Migrar datos de la tabla preguntas_reclutamiento de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla preguntas_reclutamiento...');

        $datos = DB::connection('sqlsrv')->table('preguntas_reclutamiento')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('preguntas_reclutamiento')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
