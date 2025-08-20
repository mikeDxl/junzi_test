<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarGeneros extends Command
{
    protected $signature = 'migrar:generos';
    protected $description = 'Migrar datos de la tabla generos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla generos...');

        $datos = DB::connection('sqlsrv')->table('generos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('generos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
