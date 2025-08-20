<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\EntregaAuditoria;
use App\Models\ConfigEntregaAuditoria;

class UpdateFechaHabilitadaCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:create-new-entrega';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo registro de entrega de auditoría con fecha habilitada actualizada según el periodo (semanal o mensual), si no existe un registro pendiente con la misma fecha habilitada y reporte';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener todas las entregas de auditoría con estatus pendiente
        $entregas = EntregaAuditoria::where('estatus', 'pendiente')->get();

        foreach ($entregas as $entrega) {
            $nuevaFechaHabilitada = null;

            // Si el periodo es 'Semanal'
            if ($entrega->configEntregaAuditoria->periodo == 'Semanal') {
                // Establecer la nueva fecha como el primer día de la siguiente semana
                $nuevaFechaHabilitada = Carbon::parse($entrega->fecha_habilitada)->addWeek()->startOfWeek();
            }
            // Si el periodo es 'Mensual'
            elseif ($entrega->configEntregaAuditoria->periodo == 'Mensual') {
                // Obtener el día del mes de la fecha habilitada actual
                $diaDelMes = Carbon::parse($entrega->fecha_habilitada)->day;
                // Verificar si el mes siguiente tiene ese día
                $nuevaFechaHabilitada = Carbon::parse($entrega->fecha_habilitada)->addMonth()->day($diaDelMes);

                // Si el mes siguiente no tiene ese día, usar el último día del mes
                if ($nuevaFechaHabilitada->month != Carbon::parse($entrega->fecha_habilitada)->addMonth()->month) {
                    $nuevaFechaHabilitada = Carbon::parse($entrega->fecha_habilitada)->addMonth()->endOfMonth();
                }
            }

            // Verificar si ya existe un registro pendiente con el mismo id_reporte y fecha_habilitada
            $existePendiente = EntregaAuditoria::where('id_reporte', $entrega->id_reporte)
                                                ->where('fecha_habilitada', $nuevaFechaHabilitada)
                                                ->where('estatus', 'pendiente')
                                                ->exists();

            // Si no existe, crear un nuevo registro
            if (!$existePendiente) {
                EntregaAuditoria::create([
                    'id_reporte' => $entrega->id_reporte, // Reutilizamos el id del reporte actual
                    'fecha_de_entrega' => $entrega->fecha_de_entrega, // La fecha original de entrega
                    'responsable' => $entrega->responsable,
                    'jefe_directo' => $entrega->jefe_directo,
                    'estatus' => 'pendiente', // Mantener el estatus
                    'fecha_habilitada' => $nuevaFechaHabilitada, // Nueva fecha habilitada calculada
                ]);
            }
        }
    }
}
