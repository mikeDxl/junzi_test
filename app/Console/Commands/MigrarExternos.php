<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarExternos extends Command
{
    protected $signature = 'migrar:externos';
    protected $description = 'Migrar datos de la tabla externos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla externos...');

        $datos = DB::connection('sqlsrv')->table('externos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('externos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
