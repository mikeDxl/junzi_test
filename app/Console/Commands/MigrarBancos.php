<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarBancos extends Command
{
    protected $signature = 'migrar:bancos';
    protected $description = 'Migrar datos de la tabla bancos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla bancos...');

        $datos = DB::connection('sqlsrv')->table('bancos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('bancos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
