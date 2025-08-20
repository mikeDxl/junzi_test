<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarFamiliaresColaborador extends Command
{
    protected $signature = 'migrar:familiares_colaborador';
    protected $description = 'Migrar datos de la tabla familiares_colaborador de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla familiares_colaborador...');

        $datos = DB::connection('sqlsrv')->table('familiares_colaborador')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('familiares_colaborador')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
