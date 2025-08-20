<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPuestos extends Command
{
    protected $signature = 'migrar:puestos';
    protected $description = 'Migrar datos de la tabla puestos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla puestos...');

        $datos = DB::connection('sqlsrv')->table('puestos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('puestos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
