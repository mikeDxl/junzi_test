<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTrazabilidadVentas extends Command
{
    protected $signature = 'migrar:trazabilidad_ventas';
    protected $description = 'Migrar datos de la tabla trazabilidad_ventas de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla trazabilidad_ventas...');

        $datos = DB::connection('sqlsrv')->table('trazabilidad_ventas')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('trazabilidad_ventas')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
