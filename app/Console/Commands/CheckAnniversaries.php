<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Colaboradores;
use App\Models\DiasVacaciones;
use App\Models\VacacionesPendientes;
use Carbon\Carbon;

class CheckAnniversaries extends Command
{
    protected $signature = 'check:anniversaries';
    protected $description = 'Check and update anniversaries for collaborators';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::now();

        // Obtener todos los colaboradores con fecha de alta hoy
        $colaboradores = Colaboradores::whereMonth('fecha_alta', $today->month)
            ->whereDay('fecha_alta', $today->day)
            ->where('estatus','activo')
            ->get();

        foreach ($colaboradores as $info) {
            // Calcular los años laborados
            $fechaAlta = new Carbon($info->fecha_alta);
            $anosLaborados = $fechaAlta->diffInYears($today);
            $anosLaborados = min($anosLaborados, 35);

            // Obtener el aniversario del colaborador en el año actual
            $fechaAniversario = $fechaAlta->copy()->year($today->year);

            // Comprobar si el aniversario ya pasó en el año actual
            if ($today->greaterThanOrEqualTo($fechaAniversario)) {
                // Obtener los días de vacaciones basados en los años laborados
                $diasVacaciones = DiasVacaciones::where('anio', $today->year)
                    ->where('anio_laborado', $anosLaborados)
                    ->first();

                // Si no se encuentra información en DiasVacaciones, asignar 0
                $diasActuales = $diasVacaciones ? $diasVacaciones->dias_vacaciones : 0;
            } else {
                // Si el aniversario aún no ha pasado, asignar 0
                $diasActuales = 0;
            }

            // Comprobar si ya existe un registro para este colaborador en el año actual
            $vacacionPendiente = VacacionesPendientes::where('colaborador_id', $info->id)
                ->whereYear('fecha_alta', $today->year)
                ->first();

            if ($vacacionPendiente) {
                // Si existe, actualizar el registro
                $vacacionPendiente->update([
                    'actuales' => $diasActuales,
                ]);
            } else {
                // Si no existe, crear un nuevo registro
                VacacionesPendientes::create([
                    'company_id' => $info->company_id,
                    'colaborador_id' => $info->id,
                    'fecha_alta' => $info->fecha_alta,
                    'anteriores' => 0, // Puedes ajustar esto según tu lógica
                    'actuales' => $diasActuales, // Número de días de vacaciones actuales
                ]);
            }
        }

        $this->info('Aniversarios actualizados correctamente.');
    }
}
