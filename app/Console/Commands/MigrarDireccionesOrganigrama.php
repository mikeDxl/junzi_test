<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarDireccionesOrganigrama extends Command
{
    protected $signature = 'migrar:direcciones_organigrama';
    protected $description = 'Migrar datos de la tabla direcciones_organigrama de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla direcciones_organigrama...');

        $datos = DB::connection('sqlsrv')->table('direcciones_organigrama')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('direcciones_organigrama')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
