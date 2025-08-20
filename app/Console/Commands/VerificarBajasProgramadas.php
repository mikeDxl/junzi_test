<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VerificarBajasProgramadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verificar:bajas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar bajas programadas';

    /**
     * Execute the console command.
     *
     * @return int
     */
     public function __construct()
     {
         parent::__construct();
     }

     public function handle()
     {
         
         $fechaHoy = Carbon::now(); // Obtener la fecha actual

         // Consulta las bajas programadas para hoy
         $bajasProgramadas = Baja::whereDate('fecha_baja', $fechaHoy->toDateString())->get();

         foreach ($bajasProgramadas as $baja) {
             // Realiza acciones basadas en la fecha para cada baja programada
             // Por ejemplo, puedes enviar notificaciones o actualizar el estado de las bajas.
         }

         $this->info('Verificación de bajas programadas completada.');
     }
}
