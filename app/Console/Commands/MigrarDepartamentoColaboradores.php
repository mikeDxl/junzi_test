<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarDepartamentoColaboradores extends Command
{
    protected $signature = 'migrar:departamento_colaboradores';
    protected $description = 'Migrar datos de la tabla departamento_colaboradores de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla departamento_colaboradores...');

        $datos = DB::connection('sqlsrv')->table('departamento_colaboradores')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('departamento_colaboradores')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
