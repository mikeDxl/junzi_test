<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPuestosCentrosDeCostos extends Command
{
    protected $signature = 'migrar:puestos_centros_de_costos';
    protected $description = 'Migrar datos de la tabla puestos_centros_de_costos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla puestos_centros_de_costos...');

        $datos = DB::connection('sqlsrv')->table('puestos_centros_de_costos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('puestos_centros_de_costos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
