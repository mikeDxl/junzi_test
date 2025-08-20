<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarTiposDeTurnoDeTrabajo extends Command
{
    protected $signature = 'migrar:tipos_de_turno_de_trabajo';
    protected $description = 'Migrar datos de la tabla tipos_de_turno_de_trabajo de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla tipos_de_turno_de_trabajo...');

        $datos = DB::connection('sqlsrv')->table('tipos_de_turno_de_trabajo')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('tipos_de_turno_de_trabajo')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
