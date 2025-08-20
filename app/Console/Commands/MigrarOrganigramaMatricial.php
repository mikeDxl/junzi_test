<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarOrganigramaMatricial extends Command
{
    protected $signature = 'migrar:organigrama_matricial';
    protected $description = 'Migrar datos de la tabla organigrama_matricial de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla organigrama_matricial...');

        $datos = DB::connection('sqlsrv')->table('organigrama_matricial')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('organigrama_matricial')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
