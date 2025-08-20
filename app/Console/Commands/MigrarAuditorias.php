<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAuditorias extends Command
{
    protected $signature = 'migrar:auditorias';
    protected $description = 'Migrar datos de la tabla auditorias de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla auditorias...');

        $datos = DB::connection('sqlsrv')->table('auditorias')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('auditorias')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
