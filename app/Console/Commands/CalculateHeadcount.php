<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrganigramaLinealNiveles;
use App\Models\Desvinculados;
use App\Models\Headcount; // Importa el modelo Headcount
use Carbon\Carbon;

class CalculateHeadcount extends Command
{
    protected $signature = 'calculate:headcount';

    protected $description = 'Calculate the headcount, vacancies, and desvinculados per company_id for the current month and year';

    public function handle()
    {
        $mes = 4;
        $anio = 2024;
        $totalHeadcount = 0;
        $totalVacantes = 0;
        $totalDesvinculados = 0;

        // Conteo de colaboradores activos por company_id
        $colaboradoresActivos = OrganigramaLinealNiveles::where('colaborador_id', '!=', 0)
            ->selectRaw('company_id, COUNT(*) as headcount')
            ->groupBy('company_id')
            ->get()
            ->keyBy('company_id');

        // Conteo de vacantes por company_id
        $vacantes = OrganigramaLinealNiveles::where('colaborador_id', 0)
            ->selectRaw('company_id, COUNT(*) as vacantes')
            ->groupBy('company_id')
            ->get()
            ->keyBy('company_id');

        // Conteo de desvinculados por company_id (con filtro de fecha)
        $desvinculados = Desvinculados::whereYear('fecha_baja', $anio)
            ->whereMonth('fecha_baja', $mes)
            ->selectRaw('company_id, COUNT(*) as desvinculados')
            ->groupBy('company_id')
            ->get()
            ->keyBy('company_id');

        // Combinar resultados de colaboradores activos, vacantes y desvinculados
        foreach ($colaboradoresActivos as $companyId => $colaboradorActivo) {
            $headcount = $colaboradorActivo->headcount;
            $vacantesCount = isset($vacantes[$companyId]) ? $vacantes[$companyId]->vacantes : 0;
            $desvinculadosCount = isset($desvinculados[$companyId]) ? $desvinculados[$companyId]->desvinculados : 0;

            $totalHeadcount += $headcount;
            $totalVacantes += $vacantesCount;
            $totalDesvinculados += $desvinculadosCount;

            // Buscar un registro existente o crear uno nuevo
            Headcount::updateOrCreate(
                ['mes' => $mes, 'anio' => $anio, 'id_company' => $companyId],
                ['activos' => $headcount, 'vacantes' => $vacantesCount, 'desvinculados' => $desvinculadosCount]
            );

            $this->info("Month: $mes, Year: $anio, Company ID: $companyId, Headcount: $headcount, Vacantes: $vacantesCount, Desvinculados: $desvinculadosCount");
        }

        $this->info("Total Headcount: $totalHeadcount");
        $this->info("Total Vacantes: $totalVacantes");
        $this->info("Total Desvinculados: $totalDesvinculados");
    }
}
