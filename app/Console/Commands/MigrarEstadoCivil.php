<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarEstadoCivil extends Command
{
    protected $signature = 'migrar:estado_civil';
    protected $description = 'Migrar datos de la tabla estado_civil de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla estado_civil...');

        $datos = DB::connection('sqlsrv')->table('estado_civil')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('estado_civil')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
