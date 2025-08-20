<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarValores extends Command
{
    protected $signature = 'migrar:valores';
    protected $description = 'Migrar datos de la tabla valores de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla valores...');

        $datos = DB::connection('sqlsrv')->table('valores')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('valores')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
