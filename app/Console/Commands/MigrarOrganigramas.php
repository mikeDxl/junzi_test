<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarOrganigramas extends Command
{
    protected $signature = 'migrar:organigramas';
    protected $description = 'Migrar datos de la tabla organigramas de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla organigramas...');

        $datos = DB::connection('sqlsrv')->table('organigramas')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('organigramas')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
