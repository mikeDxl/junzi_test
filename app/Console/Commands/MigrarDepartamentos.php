<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarDepartamentos extends Command
{
    protected $signature = 'migrar:departamentos';
    protected $description = 'Migrar datos de la tabla departamentos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla departamentos...');

        $datos = DB::connection('sqlsrv')->table('departamentos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('departamentos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
