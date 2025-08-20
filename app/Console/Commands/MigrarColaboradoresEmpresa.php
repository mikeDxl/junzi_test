<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarColaboradoresEmpresa extends Command
{
    protected $signature = 'migrar:colaboradores_empresa';
    protected $description = 'Migrar datos de la tabla colaboradores_empresa de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla colaboradores_empresa...');

        $datos = DB::connection('sqlsrv')->table('colaboradores_empresa')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('colaboradores_empresa')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
