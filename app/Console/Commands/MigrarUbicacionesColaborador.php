<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarUbicacionesColaborador extends Command
{
    protected $signature = 'migrar:ubicaciones_colaborador';
    protected $description = 'Migrar datos de la tabla ubicaciones_colaborador de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla ubicaciones_colaborador...');

        $datos = DB::connection('sqlsrv')->table('ubicaciones_colaborador')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('ubicaciones_colaborador')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
