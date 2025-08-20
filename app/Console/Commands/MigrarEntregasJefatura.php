<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarEntregasJefatura extends Command
{
    protected $signature = 'migrar:entregas_jefatura';
    protected $description = 'Migrar datos de la tabla entregas_jefatura de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla entregas_jefatura...');

        $datos = DB::connection('sqlsrv')->table('entregas_jefatura')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('entregas_jefatura')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
