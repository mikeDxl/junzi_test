<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAgrupadoresLista extends Command
{
    protected $signature = 'migrar:agrupadores_lista';
    protected $description = 'Migrar datos de la tabla agrupadores_lista de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla agrupadores_lista...');

        $datos = DB::connection('sqlsrv')->table('agrupadores_lista')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('agrupadores_lista')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
