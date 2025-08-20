<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarEstatusVacantes extends Command
{
    protected $signature = 'migrar:estatus_vacantes';
    protected $description = 'Migrar datos de la tabla estatus_vacantes de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla estatus_vacantes...');

        $datos = DB::connection('sqlsrv')->table('estatus_vacantes')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('estatus_vacantes')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
