<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarCandidatos extends Command
{
    protected $signature = 'migrar:candidatos';
    protected $description = 'Migrar datos de la tabla candidatos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla candidatos...');

        $datos = DB::connection('sqlsrv')->table('candidatos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('candidatos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
