<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarOrganigramaLineal extends Command
{
    protected $signature = 'migrar:organigrama_lineal';
    protected $description = 'Migrar datos de la tabla organigrama_lineal de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla organigrama_lineal...');

        $datos = DB::connection('sqlsrv')->table('organigrama_lineal')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('organigrama_lineal')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
