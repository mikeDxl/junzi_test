<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAreasAuditoria extends Command
{
    protected $signature = 'migrar:areas_auditoria';
    protected $description = 'Migrar datos de la tabla areas_auditoria de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla areas_auditoria...');

        $datos = DB::connection('sqlsrv')->table('areas_auditoria')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('areas_auditoria')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
