<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarCatalogoDepartamentos extends Command
{
    protected $signature = 'migrar:catalogo_departamentos';
    protected $description = 'Migrar datos de la tabla catalogo_departamentos de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla catalogo_departamentos...');

        $datos = DB::connection('sqlsrv')->table('catalogo_departamentos')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('catalogo_departamentos')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
