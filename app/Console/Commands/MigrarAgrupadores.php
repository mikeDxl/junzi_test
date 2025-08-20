<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarAgrupadores extends Command
{
    
    protected $signature = 'migrar:agrupadores';
    protected $description = 'Migrar datos de la tabla agrupadores de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración...');

        // Leer desde SQL Server
        $datos = DB::connection('sqlsrv')->table('agrupadores')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            // Convertir a array para insert
            $arrayRegistro = (array) $registro;

            // Insertar en MySQL
            DB::connection('mysql_destino')->table('agrupadores')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
