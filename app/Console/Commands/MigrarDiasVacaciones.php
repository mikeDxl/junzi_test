<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarDiasVacaciones extends Command
{
    protected $signature = 'migrar:dias_vacaciones';
    protected $description = 'Migrar datos de la tabla dias_vacaciones de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla dias_vacaciones...');

        $datos = DB::connection('sqlsrv')->table('dias_vacaciones')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('dias_vacaciones')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
