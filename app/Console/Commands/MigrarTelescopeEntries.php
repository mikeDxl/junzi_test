<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTelescopeEntries extends Command
{
    protected $signature = 'migrar:telescope_entries';
    protected $description = 'Migrar datos de la tabla telescope_entries de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla telescope_entries...');

        $datos = DB::connection('sqlsrv')->table('telescope_entries')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('telescope_entries')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
