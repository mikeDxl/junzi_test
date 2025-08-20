<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTitulosHallazgos extends Command
{
    protected $signature = 'migrar:titulos_hallazgos';
    protected $description = 'Migrar datos de la tabla titulos_hallazgos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla titulos_hallazgos...');

        $datos = DB::connection('sqlsrv')->table('titulos_hallazgos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('titulos_hallazgos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
