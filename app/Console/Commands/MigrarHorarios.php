<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarHorarios extends Command
{
    protected $signature = 'migrar:horarios';
    protected $description = 'Migrar datos de la tabla horarios de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla horarios...');

        $datos = DB::connection('sqlsrv')->table('horarios')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('horarios')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
