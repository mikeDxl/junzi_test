<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarDatosBaja extends Command
{
    protected $signature = 'migrar:datos_baja';
    protected $description = 'Migrar datos de la tabla datos_baja de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla datos_baja...');

        $datos = DB::connection('sqlsrv')->table('datos_baja')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('datos_baja')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
