<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarHorasExtra extends Command
{
    protected $signature = 'migrar:horas_extra';
    protected $description = 'Migrar datos de la tabla horas_extra de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla horas_extra...');

        $datos = DB::connection('sqlsrv')->table('horas_extra')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('horas_extra')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
