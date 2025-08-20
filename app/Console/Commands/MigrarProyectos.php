<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarProyectos extends Command
{
    protected $signature = 'migrar:proyectos';
    protected $description = 'Migrar datos de la tabla proyectos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla proyectos...');

        $datos = DB::connection('sqlsrv')->table('proyectos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('proyectos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
