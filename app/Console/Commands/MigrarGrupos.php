<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarGrupos extends Command
{
    protected $signature = 'migrar:grupos';
    protected $description = 'Migrar datos de la tabla grupos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla grupos...');

        $datos = DB::connection('sqlsrv')->table('grupos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('grupos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
