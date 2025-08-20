<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarOrganigramaLinealNiveles extends Command
{
    protected $signature = 'migrar:organigrama_lineal_niveles';
    protected $description = 'Migrar datos de la tabla organigrama_lineal_niveles de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla organigrama_lineal_niveles...');

        $datos = DB::connection('sqlsrv')->table('organigrama_lineal_niveles')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('organigrama_lineal_niveles')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
