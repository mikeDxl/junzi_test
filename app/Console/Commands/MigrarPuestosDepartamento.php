<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPuestosDepartamento extends Command
{
    protected $signature = 'migrar:puestos_departamento';
    protected $description = 'Migrar datos de la tabla puestos_departamento de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla puestos_departamento...');

        $datos = DB::connection('sqlsrv')->table('puestos_departamento')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('puestos_departamento')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
