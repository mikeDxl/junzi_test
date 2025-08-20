<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarActualizaciones extends Command
{
    protected $signature = 'migrar:actualizaciones';
    protected $description = 'Migrar datos de la tabla actualizaciones de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración...');

        // Leer desde SQL Server
        $datos = DB::connection('sqlsrv')->table('actualizaciones')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            // Convertir a array para insert
            $arrayRegistro = (array) $registro;

            // Insertar en MySQL
            DB::connection('mysql_destino')->table('actualizaciones')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}