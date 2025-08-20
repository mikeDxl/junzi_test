<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarPersonalAccessTokens extends Command
{
    protected $signature = 'migrar:personal_access_tokens';
    protected $description = 'Migrar datos de la tabla personal_access_tokens de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla personal_access_tokens...');

        $datos = DB::connection('sqlsrv')->table('personal_access_tokens')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('personal_access_tokens')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}
