<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarGruposColaboradores extends Command
{
    protected $signature = 'migrar:grupos_colaboradores';
    protected $description = 'Migrar datos de la tabla grupos_colaboradores de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla grupos_colaboradores...');

        $datos = DB::connection('sqlsrv')->table('grupos_colaboradores')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('grupos_colaboradores')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
