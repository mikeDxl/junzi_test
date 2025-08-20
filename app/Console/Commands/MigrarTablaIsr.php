<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTablaIsr extends Command
{
    protected $signature = 'migrar:tabla_isr';
    protected $description = 'Migrar datos de la tabla tabla_isr de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla tabla_isr...');

        $datos = DB::connection('sqlsrv')->table('tabla_isr')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('tabla_isr')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
