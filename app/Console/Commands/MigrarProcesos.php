<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarProcesos extends Command
{
    protected $signature = 'migrar:procesos';
    protected $description = 'Migrar datos de la tabla procesos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla procesos...');

        $datos = DB::connection('sqlsrv')->table('procesos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('procesos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
