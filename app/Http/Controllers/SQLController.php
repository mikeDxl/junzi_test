<?php


namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Movimiento;
use Illuminate\Support\Facades\File;

class SQLController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
     public function dividirJson(){

       // Definir el año
       $year = 2024;

       //chmod -R 777 directorio_de_salida
       // Nombre del archivo JSON
       $nombreArchivo = "res{$year}.json";

       // Ruta completa del archivo JSON
       $rutaArchivo = $nombreArchivo;

        $tamanioLote = 10000; // Tamaño de cada lote

        // Abrir y leer el archivo JSON
        $json = file_get_contents($rutaArchivo);
        $datos = json_decode($json, true);

        // Dividir los datos en lotes más pequeños
        $lotes = array_chunk($datos, $tamanioLote);

        // Iterar sobre cada lote y escribirlo en un archivo separado
        foreach ($lotes as $indice => $lote) {
            $nombreArchivo = 'lote_' .$year.'_'. ($indice + 1) . '.json';
            file_put_contents($nombreArchivo, json_encode($lote));
        }

        echo "El archivo se ha dividido en lotes más pequeños.";

     }


     public function insertarDesdeJson()
     {
         // Definir el año
         $year = 2024;

         // Nombre del archivo JSON
         $nombreArchivo = "res{$year}.json";

         // Ruta completa del archivo JSON
         $rutaArchivo = $nombreArchivo;

         // Abrir y leer el archivo JSON
         $json = File::get($rutaArchivo);
         $datos = json_decode($json, true);

         // Número de registros por lote
         $tamanioLote = 1000;

         // Dividir los datos en lotes más pequeños
         $lotes = array_chunk($datos, $tamanioLote);

         // Eliminar los registros del año especificado
         Movimiento::where('Ejercicio', $year)->delete();

         // Procesar cada lote por separado
         foreach ($lotes as $lote) {
             // Insertar el lote en la base de datos
             Movimiento::insert($lote);
         }

         return "Datos insertados correctamente.";
     }

    public function tableroDirectivoNomina()
    {
      $year=2024;
/*

  $query1 = DB::table('nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'CORPORATIVO' AS Empresa")
    ->selectRaw("'CORPORATIVO' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE TbDepartamentos.descripcion END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


*/

    $query2 = DB::table('ct2012LUPEQSA_SADECV.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'LUPEQSA' AS Empresa")
    ->selectRaw("'PLANTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'DISTRIBUIDORAS Y COMERCIALIZADORAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2012LUPEQSA_SADECV.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

/*
    $query3 = DB::table('ctCODICSA_2016.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN CONCAT('CODICSA', RIGHT(TbDepartamentos.descripcion, 4)) ELSE 'CODICSA' END AS Empresa")
    ->selectRaw("'PLANTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'DISTRIBUIDORAS Y COMERCIALIZADORAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN LEFT(TbDepartamentos.descripcion, LEN(TbDepartamentos.descripcion) - 4) ELSE TbDepartamentos.descripcion END AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctCODICSA_2016.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctCODICSA_2016.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctCODICSA_2016.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctCODICSA_2016.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctCODICSA_2016.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctCODICSA_2016.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctCODICSA_2016.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query4 = DB::table('ct2011_CEL_BAEZA_.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'BAEZA CEL' AS Empresa")
    ->selectRaw("'PLANTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'DISTRIBUIDORAS Y COMERCIALIZADORAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_CEL_BAEZA_.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_CEL_BAEZA_.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query5 = DB::table('ct2008_SUPER_SERV.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'SS EL SAUZ' AS Empresa")
    ->selectRaw("'GASOLINERA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'GASOLINERAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2008_SUPER_SERV.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2008_SUPER_SERV.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2008_SUPER_SERV.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2008_SUPER_SERV.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2008_SUPER_SERV.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2008_SUPER_SERV.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2008_SUPER_SERV.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    $query6 = DB::table('ct2011_NUEVO_LARE.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'SS NVO LAREDO' AS Empresa")
    ->selectRaw("'GASOLINERA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'GASOLINERAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_NUEVO_LARE.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_NUEVO_LARE.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_NUEVO_LARE.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_NUEVO_LARE.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_NUEVO_LARE.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_NUEVO_LARE.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_NUEVO_LARE.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    $query7 = DB::table('ctBAEZA_SA_DE_CV.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("CASE WHEN TbEmpleados.cidregistropatronal = 2 THEN 'EL SOL' ELSE 'LAS AMERICAS' END AS Empresa")
    ->selectRaw("'GASOLINERA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'GASOLINERAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctBAEZA_SA_DE_CV.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    $query8 = DB::table('ct2011_BAEZA_TRAN.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'T BAEZA' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_BAEZA_TRAN.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_BAEZA_TRAN.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    $query9 = DB::table('ctT_BAE_OP.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'T BAEZA (OP)' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctT_BAE_OP.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctT_BAE_OP.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctT_BAE_OP.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctT_BAE_OP.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctT_BAE_OP.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctT_BAE_OP.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctT_BAE_OP.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query10 = DB::table('ctAUTANQUES_DE_2019.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'ATQ' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctAUTANQUES_DE_2019.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctAUTANQUES_DE_2019.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query11 = DB::table('ctAUTOTANQUES_DE_QRO.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'ATQ' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctAUTOTANQUES_DE_QRO.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query12 = DB::table('ctTRANSCEN_MENSUA.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'TRANSEN' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctTRANSCEN_MENSUA.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctTRANSCEN_MENSUA.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    $query13 = DB::table('ctTRANSPORTES_LPQ.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'T LPQ' AS Empresa")
    ->selectRaw("'TRANSPORTISTA' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TRANSPORTISTAS' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ctTRANSPORTES_LPQ.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ctTRANSPORTES_LPQ.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query14 = DB::table('ct2011_QUIN_AUTOP.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN CONCAT('TA NIETO', RIGHT(TbDepartamentos.descripcion, 4)) ELSE 'TA NIETO' END AS Empresa")
    ->selectRaw("'TALLER' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TALLER Y MANTENIMIENTO' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN LEFT(TbDepartamentos.descripcion, LEN(TbDepartamentos.descripcion) - 4) ELSE TbDepartamentos.descripcion END AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_QUIN_AUTOP.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_QUIN_AUTOP.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query15 = DB::table('ct2011_TALLER_AUT.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN CONCAT('TA NIETO', RIGHT(TbDepartamentos.descripcion, 4)) ELSE 'TA NIETO' END AS Empresa")
    ->selectRaw("'TALLER' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'TALLER Y MANTENIMIENTO' END AS OrgMatricial")
    ->selectRaw("TbEmpresa.NombreEmpresaFiscal AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("CASE WHEN LEFT(RIGHT(TbDepartamentos.descripcion, 4), 1) = ' ' THEN LEFT(TbDepartamentos.descripcion, LEN(TbDepartamentos.descripcion) - 4) ELSE TbDepartamentos.descripcion END AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("CONCAT(FORMAT(MONTH(TbPeriodos.fechafin), '00'), ') ', DATENAME(month, TbPeriodos.fechafin)) AS Periodo")
    ->selectRaw("CONCAT(STR(TbPeriodos.numeroperiodo, 2), ' ', SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3), ' - ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2), ' al ', RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2)) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_TALLER_AUT.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_TALLER_AUT.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_TALLER_AUT.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_TALLER_AUT.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_TALLER_AUT.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_TALLER_AUT.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_TALLER_AUT.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();


    $query16 = DB::table('ct2011_PROTECCION.dbo.nom10007 AS TbMovimientos')
    ->selectRaw("'HEADCOUNT' AS Headcount")
    ->selectRaw("'PROTECCION GONIE' AS Empresa")
    ->selectRaw("'PROTECCION' AS TipoEmpresa")
    ->selectRaw("CASE WHEN TbEmpleados.campoextra1 <> '' THEN TbEmpleados.campoextra1 ELSE 'SERVICIOS GENERALES' END AS OrgMatricial")
    ->selectRaw("SUBSTRING(TbEmpresa.NombreEmpresaFiscal, 2, LEN(TbEmpresa.NombreEmpresaFiscal)-1) AS RazonSocial")
    ->selectRaw("CAST(TbEmpleados.fechaalta AS date) AS FechaAlta")
    ->selectRaw("TbEmpleados.codigoempleado AS EmpleadoCod")
    ->selectRaw("TbEmpleados.nombreLargo AS EmpleadoNombreLargo")
    ->selectRaw("TbDepartamentos.descripcion AS DeptoNombre")
    ->selectRaw("TbPuestos.descripcion AS PuestoNombre")
    ->selectRaw("TbEmpleados.campoextra2 AS ConceptoBandera")
    ->selectRaw("TbEmpleados.campoextra3 AS Ubicacion")
    ->selectRaw("CASE TbEmpleados.estadoempleado
                   WHEN 'A' THEN 'Alta'
                   WHEN 'B' THEN 'Alta'
                   WHEN 'R' THEN 'Reingreso'
                END AS EmpleadoEstatus")
    ->selectRaw("CAST(TbEmpleados.fechabaja AS date) AS FechaBaja")
    ->selectRaw("TbPeriodos.ejercicio AS Ejercicio")
    ->selectRaw("CAST(TbPeriodos.fechainicio AS date) AS PeriodoInicio")
    ->selectRaw("CAST(TbPeriodos.fechafin AS date) AS PeriodoFin")
    ->selectRaw("TbTipoPeriodo.nombretipoperiodo AS PeriodoTipoNombre")
    ->selectRaw("TbPeriodos.numeroperiodo AS PeriodoNumero")
    ->selectRaw("FORMAT(MONTH(TbPeriodos.fechafin), '00') + ') ' + DATENAME(month, TbPeriodos.fechafin) AS Periodo")
    ->selectRaw("STR(TbPeriodos.numeroperiodo, 2) + ' ' + SUBSTRING(DATENAME(month, TbPeriodos.fechafin), 1, 3) + ' - ' + RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechainicio, 126), 2) + ' al ' + RIGHT(CONVERT(NVARCHAR(10), TbPeriodos.fechafin, 126), 2) AS PeriodoNombre")
    ->selectRaw("TbConceptos.descripcion AS ConceptoNombre")
    ->selectRaw("CASE TbConceptos.tipoconcepto
                    WHEN 'P' THEN 'Percepción'
                    WHEN 'D' THEN 'Deducción'
                    WHEN 'O' THEN 'Obligación'
                END AS ConceptoTipo")
    ->selectRaw("TbMovimientos.importetotal * CASE WHEN TbConceptos.tipoconcepto = 'D' THEN -1 ELSE 1 END AS Importe")
    ->selectRaw("'Real' AS TipoDato")
    ->selectRaw("'' AS Agrupador")
    ->join('ct2011_PROTECCION.dbo.nom10001 AS TbEmpleados', 'TbEmpleados.idempleado', '=', 'TbMovimientos.idempleado')
    ->join('ct2011_PROTECCION.dbo.nom10002 AS TbPeriodos', 'TbPeriodos.idperiodo', '=', 'TbMovimientos.idperiodo')
    ->join('ct2011_PROTECCION.dbo.nom10003 AS TbDepartamentos', 'TbDepartamentos.iddepartamento', '=', 'TbEmpleados.iddepartamento')
    ->join('ct2011_PROTECCION.dbo.nom10004 AS TbConceptos', 'TbConceptos.idconcepto', '=', 'TbMovimientos.idconcepto')
    ->join('ct2011_PROTECCION.dbo.nom10006 AS TbPuestos', 'TbPuestos.idpuesto', '=', 'TbEmpleados.idpuesto')
    ->join('ct2011_PROTECCION.dbo.nom10023 AS TbTipoPeriodo', 'TbPeriodos.idtipoperiodo', '=', 'TbTipoPeriodo.idtipoperiodo')
    ->join('ct2011_PROTECCION.dbo.nom10000 AS TbEmpresa', 'TbEmpresa.idempresacontpaqw', '=', DB::raw('0'))
    ->where('TbPeriodos.ejercicio', '=', $year)
    ->where('TbEmpleados.estadoempleado', '<>', 'X')
    ->where('TbMovimientos.importetotal', '<>', 0)
    ->whereNotIn('TbConceptos.idconcepto', [1, 48, 116, 138, 139, 140, 141, 142, 145, 146, 147, 149, 153, 155, 156, 157, 158, 159, 162, 163, 169, 170, 171, 172, 175, 178, 179, 180, 190, 192, 193])
    ->where('TbConceptos.imprimir', '=', 1)
    ->get();

    \DB::statement('DECLARE @Year int; SET @Year = 2024; SET LANGUAGE spanish;');

    $query1 = $query1->unionAll($query2)
        ->unionAll($query3)
        ->unionAll($query4)
        ->unionAll($query5)
        ->unionAll($query6)
        ->unionAll($query7)
        ->unionAll($query8)
        ->unionAll($query9)
        ->unionAll($query10)
        ->unionAll($query11)
        ->unionAll($query12)
        ->unionAll($query13)
        ->unionAll($query14)
        ->unionAll($query15)
        ->get();


*/

    //    $results = $query2->get();
        dd($query2);

    }



}
