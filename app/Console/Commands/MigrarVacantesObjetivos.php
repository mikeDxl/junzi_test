<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarVacantesObjetivos extends Command
{
    protected $signature = 'migrar:vacantes_objetivos';
    protected $description = 'Migrar datos de la tabla vacantes_objetivos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla vacantes_objetivos...');

        $datos = DB::connection('sqlsrv')->table('vacantes_objetivos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('vacantes_objetivos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
