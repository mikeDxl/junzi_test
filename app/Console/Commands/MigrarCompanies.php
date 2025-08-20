<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarCompanies extends Command
{
    protected $signature = 'migrar:companies';
    protected $description = 'Migrar datos de la tabla companies de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla companies...');

        $datos = DB::connection('sqlsrv')->table('companies')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('companies')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
