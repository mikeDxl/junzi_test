<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarGratificaciones extends Command
{
    protected $signature = 'migrar:gratificaciones';
    protected $description = 'Migrar datos de la tabla gratificaciones de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla gratificaciones...');

        $datos = DB::connection('sqlsrv')->table('gratificaciones')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('gratificaciones')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
