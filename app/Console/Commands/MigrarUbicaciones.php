<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarUbicaciones extends Command
{
    protected $signature = 'migrar:ubicaciones';
    protected $description = 'Migrar datos de la tabla ubicaciones de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla ubicaciones...');

        $datos = DB::connection('sqlsrv')->table('ubicaciones')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('ubicaciones')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
