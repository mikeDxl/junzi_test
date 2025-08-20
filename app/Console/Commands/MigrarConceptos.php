<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarConceptos extends Command
{
    protected $signature = 'migrar:conceptos';
    protected $description = 'Migrar datos de la tabla conceptos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla conceptos...');

        $datos = DB::connection('sqlsrv')->table('conceptos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('conceptos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
