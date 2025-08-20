<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ConceptoIncidencia;
use App\Models\Companies;
use App\Models\Conexiones;
use App\Models\TableroNomina;
use Carbon\Carbon;


class TableroNominaController extends Controller
{
    public function index(Request $request)
    {

        //TableroNomina::truncate();
        $year = 2024; // Default es el año actual
        TableroNomina::where('empresa','1')->where('anio',$year)->delete();
        /*
        $idCompany = 1; // ID de la empresa para obtener conceptos

        $conexion = Conexiones::where('company_id',$idCompany)->first();
        $db=$conexion->database;
        // Obtén la base de datos y el año desde la solicitud o usa valores predeterminados
        $database = $request->input('database', $db); // Default es 'ctCORPO_SERV_2019'



        $company=Companies::where('id',$idCompany)->first();
        // Obtén los conceptos a excluir según la compañía
        $conceptosExcluir = ConceptoIncidencia::where('id_company', $idCompany)
            ->pluck('id_concepto')
            ->toArray();

        // Construir la consulta dinámica
        $query = DB::connection('sqlsrv') // Cambia a la conexión que estés usando
            ->table("{$database}.dbo.nom10007 AS TbMovimientos")
            ->join("{$database}.dbo.nom10001 AS TbEmpleados", 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
            ->join("{$database}.dbo.nom10002 AS TbPeriodos", 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
            ->join("{$database}.dbo.nom10003 AS TbDepartamentos", 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
            ->join("{$database}.dbo.nom10004 AS TbConceptos", 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
            ->join("{$database}.dbo.nom10006 AS TbPuestos", 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
            ->join("{$database}.dbo.nom10023 AS TbTipoPeriodo", 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
            ->join("{$database}.dbo.nom10000 AS TbEmpresa", 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
            ->select([
                DB::raw("'HEADCOUNT' AS Headcount"),
                DB::raw("'{$idCompany}' AS Empresa"),
                DB::raw("'{$company->razon_social}' AS TipoEmpresa"),
                DB::raw("IIF(TbEmpleados.campoextra1 <> '', TbEmpleados.campoextra1, TbDepartamentos.descripcion) AS OrgMatricial"),
                'TbEmpresa.NombreEmpresaFiscal AS RazonSocial',
                DB::raw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta"),
                'TbEmpleados.codigoempleado AS EmpleadoCod',
                'TbEmpleados.nombreLargo AS EmpleadoNombreLargo',
                'TbDepartamentos.descripcion AS DeptoNombre',
                'TbPuestos.descripcion AS PuestoNombre',
                'TbEmpleados.campoextra2 AS ConceptoBandera',
                'TbEmpleados.campoextra3 AS Ubicacion',
                DB::raw("CASE TbEmpleados.estadoempleado
                            WHEN 'A' THEN 'Alta'
                            WHEN 'B' THEN 'Alta'
                            WHEN 'R' THEN 'Reingreso'
                         END AS EmpleadoEstatus"),
                DB::raw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja"),
                'TbPeriodos.ejercicio AS Ejercicio',
                DB::raw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio"),
                DB::raw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin"),
                'TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre',
                'TbPeriodos.numeroperiodo AS PeriodoNumero',
                DB::raw("FORMAT(MONTH(TbPeriodos.fechafin), '00') + ') ' + DATENAME(month, TbPeriodos.fechafin) AS Periodo"),
                DB::raw("STR(TbPeriodos.numeroperiodo, 2) + ' ' + SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3) + ' - ' + RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2) + ' al ' + RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2) AS PeriodoNombre"),
                'TbConceptos.descripcion AS ConceptoNombre',
                DB::raw("CASE TbConceptos.tipoconcepto
                            WHEN 'P' THEN 'Percepción'
                            WHEN 'D' THEN 'Deducción'
                            WHEN 'O' THEN 'Obligación'
                         END AS ConceptoTipo"),
                DB::raw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe"),
                DB::raw("'Real' AS TipoDato"),
                DB::raw("'' AS Agrupador")
            ])
            ->where('TbPeriodos.ejercicio', $year)
            ->where('TbEmpleados.estadoempleado', '<>', 'X')
            ->where('TbMovimientos.importetotal', '<>', 0)
            ->whereNotIn('TbConceptos.idconcepto', $conceptosExcluir) // Excluir conceptos dinámicos
            ->where('TbConceptos.imprimir', 1)
            ->get();


foreach ($query as $row) {
    // Creamos un array para insertar los datos
    $data = [
        'headcount' => $row->Headcount ?? null,  // Si el valor es null, dejamos null
        'empresa' =>  $idCompany,
        'tipo_empresa' => $row->TipoEmpresa ?? null,
        'org_matricial' => $row->OrgMatricial ?? null,
        'razon_social' => $row->RazonSocial ?? null,
        'fecha_alta' => $row->FechaAlta ? \Carbon\Carbon::parse($row->FechaAlta)->format('Y-m-d') : null,
        'empleado_cod' => $row->EmpleadoCod ?? null,
        'empleado_nombre_largo' => $row->EmpleadoNombreLargo ?? null,
        'depto_nombre' => $row->DeptoNombre ?? null,
        'puesto_nombre' => $row->PuestoNombre ?? null,
        'concepto_bandera' => $row->ConceptoBandera ?? null,
        'ubicacion' => $row->Ubicacion ?? null,
        'empleado_estatus' => $row->EmpleadoEstatus ?? null,
        'fecha_baja' => $row->FechaBaja ? \Carbon\Carbon::parse($row->FechaBaja)->format('Y-m-d') : null,
        'ejercicio' => $row->Ejercicio ?? null,
        'periodo_inicio' => $row->PeriodoInicio ? \Carbon\Carbon::parse($row->PeriodoInicio)->format('Y-m-d') : null,
        'periodo_fin' => $row->PeriodoFin ? \Carbon\Carbon::parse($row->PeriodoFin)->format('Y-m-d') : null,
        'periodo_tipo_nombre' => $row->PeriodoTipoNombre ?? null,
        'periodo_numero' => $row->PeriodoNumero ?? null,
        'periodo' => $row->Periodo ?? null,
        'periodo_nombre' => $row->PeriodoNombre ?? null,
        'concepto_nombre' => $row->ConceptoNombre ?? null,
        'concepto_tipo' => $row->ConceptoTipo ?? null,
        'importe' => $row->Importe ?? null,  // Si está vacío, se guarda como null
        'tipo_dato' => $row->TipoDato ?? null,
        'agrupador' => $row->Agrupador ?? null,
        'created_at' => now(),
        'updated_at' => now(),
        'anio' => $year,
    ];

    // Usar la inserción masiva en lugar de save() para mejorar la eficiencia
    TableroNomina::create($data);  // Asegúrate de que tu modelo tenga el método create habilitado
}


return $idCompany;
*/
    }

}
