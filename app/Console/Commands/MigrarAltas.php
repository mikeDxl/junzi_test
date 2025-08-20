<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAltas extends Command
{
    protected $signature = 'migrar:altas';
    protected $description = 'Migrar datos de la tabla altas de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla altas...');

        $datos = DB::connection('sqlsrv')->table('altas')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('altas')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
