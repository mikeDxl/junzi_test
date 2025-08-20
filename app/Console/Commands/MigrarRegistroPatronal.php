<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarRegistroPatronal extends Command
{
    protected $signature = 'migrar:registro_patronal';
    protected $description = 'Migrar datos de la tabla registro_patronal de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla registro_patronal...');

        $datos = DB::connection('sqlsrv')->table('registro_patronal')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('registro_patronal')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
