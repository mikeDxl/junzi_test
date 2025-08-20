<?php
namespace App\Exports;

use App\Models\Auditoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class AuditoriasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Auditoria::with('hallazgos')->get();
    }

    public function headings(): array
    {
        return [
            'CÓDIGO DE AUDITORIA',
            'HALLAZGO',
            'SUGERENCIA',
            'TIPO',
            'FECHA PRESENTACIÓN',
            'FECHA COMPROMISO',
            'COMENTARIOS AUDITORIA',
            'AUDITADOS',
            'JEFE AUDITADO',
            'FECHA RESPUESTA',
            'FECHA CIERRE',
            'COMENTARIOS AUDITADO',
            'DÍAS DE TOLERANCIA',
            'ESTATUS',
        ];
    }

    public function map($auditoria): array
    {
        $data = [];

        foreach ($auditoria->hallazgos as $hallazgo) {
            // Obtener y resolver los IDs de responsables
            $responsableIds = explode(',', $hallazgo->responsable);
            $auditados = array_map(function($id) {
                return qcolab($id); // Asume que qcolab() retorna el nombre completo del auditado
            }, $responsableIds);
            $nombresAuditados = implode(', ', $auditados);

            // Obtener el ID del jefe auditado
            $jefeAuditadoId = $hallazgo->jefe;
            $jefeAuditado = $jefeAuditadoId ? qcolab($jefeAuditadoId) : '';

            // Calcular días desde fecha de compromiso hasta hoy o la fecha de cierre
            // Calcular días desde fecha de compromiso hasta hoy o la fecha de cierre
            // Calcular días de tolerancia basado en el estatus
            $fechaCompromiso = Carbon::parse($hallazgo->fecha_compromiso);
            $fechaActual = Carbon::now();

            if ($hallazgo->estatus !== 'cerrado') {
                // Calcular días de tolerancia con la fecha actual (si no está cerrado)
                $diasTolerancia = $fechaActual->diffInDays($fechaCompromiso, false);
            } else {
                // Calcular días de tolerancia con la fecha de cierre (si está cerrado)
                $fechaCierre = Carbon::parse($hallazgo->fecha_cierre);
                $diasTolerancia = $fechaCierre->diffInDays($fechaCompromiso, false);
            }



            $data[] = [
                $auditoria->tipo . '-' . $auditoria->area . '-' . $auditoria->ubicacion . '-' . $auditoria->anio . '-' . $auditoria->folio, // Código de auditoría
                $hallazgo->hallazgo, // Hallazgo
                $hallazgo->sugerencia, // Hallazgo
                $hallazgo->tipo, // Tipo
                Carbon::parse($hallazgo->fecha_presentacion)->format('d/m/Y'), // Fecha de presentación
                Carbon::parse($hallazgo->fecha_compromiso)->format('d/m/Y'), // Fecha compromiso
                $hallazgo->comentarios, // Comentarios
                $nombresAuditados, // Auditados
                $jefeAuditado, // Jefe auditado
                Carbon::parse($hallazgo->fecha_colaborador)->format('d/m/Y') ?? '', // Tipo
                Carbon::parse($hallazgo->fecha_cierre)->format('d/m/Y') ?? '', // Tipo
                $hallazgo->comentarios_colaborador, // Tipo
                $diasTolerancia ?? '0', // Días de tolerancia
                $hallazgo->estatus, // Estatus
            ];
        }

        return $data;
    }
}
