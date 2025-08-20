<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPuestosEmpresa extends Command
{
    protected $signature = 'migrar:puestos_empresa';
    protected $description = 'Migrar datos de la tabla puestos_empresa de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla puestos_empresa...');

        $datos = DB::connection('sqlsrv')->table('puestos_empresa')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('puestos_empresa')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
