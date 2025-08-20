<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarMensajes extends Command
{
    protected $signature = 'migrar:mensajes';
    protected $description = 'Migrar datos de la tabla mensajes de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla mensajes...');

        $datos = DB::connection('sqlsrv')->table('mensajes')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('mensajes')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
