<?php

namespace App\Http\Controllers;

use App\Models\ConfigEntregasAuditoria;
use App\Models\EntregaAuditoria;
use App\Models\OrganigramaLinealNiveles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class EntregaAuditoriaController extends Controller
{
    // Mostrar el formulario de creación
    public function index()
    {
        // Obtener todos los reportes de ConfigEntregasAuditoria
        $entregas_pendientes = EntregaAuditoria::where('estatus', 'pendiente')
        ->orderBy('fecha_de_entrega', 'desc')
        ->get();

        // Obtener las entregas completadas ordenadas por fecha_de_entrega (más recientes primero)
        $entregas_completadas = EntregaAuditoria::where('estatus', 'completado')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        $entregas_enviadas = EntregaAuditoria::where('estatus', 'en progreso')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        $entregas_detenidas = EntregaAuditoria::where('estatus', 'detenido')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        return view('entregas_auditoria.index', compact('entregas_pendientes', 'entregas_completadas', 'entregas_enviadas', 'entregas_detenidas'));
    }

    public function lista()
    {
        // Obtener las entregas pendientes ordenadas por fecha_de_entrega (más recientes primero)
        $entregas_pendientes = EntregaAuditoria::where('responsable', auth()->user()->colaborador_id)
            ->where('estatus', 'pendiente')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        // Obtener las entregas completadas ordenadas por fecha_de_entrega (más recientes primero)
        $entregas_completadas = EntregaAuditoria::where('responsable', auth()->user()->colaborador_id)
            ->where('estatus', 'completado')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        $entregas_enviadas = EntregaAuditoria::where('responsable', auth()->user()->colaborador_id)
            ->where('estatus', 'en progreso')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

         $entregas_detenidas = EntregaAuditoria::where('responsable', auth()->user()->colaborador_id)
            ->where('estatus', 'detenido')
            ->orderBy('fecha_de_entrega', 'desc')
            ->get();

        return view('entregas_auditoria.lista', compact('entregas_pendientes', 'entregas_completadas', 'entregas_enviadas', 'entregas_detenidas'));
    }


    public function uploadArchivo(Request $request, $id)
    {


        // Encontrar la entrega de auditoría por ID
        $entrega = EntregaAuditoria::findOrFail($id);

        // Subir el archivo y obtener la ruta
        if ($request->hasFile('archivo_adjunto')) {
            $archivo = $request->file('archivo_adjunto');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaArchivo = $archivo->storeAs('archivos_adjuntos', $nombreArchivo);

            // Guardar la ruta del archivo en la base de datos
            $entrega->archivo_adjunto = $nombreArchivo;
            $entrega->fecha_completada = Carbon::now(); // Línea corregida
            $entrega->estatus = 'en progreso';
            $entrega->save();
        }

        // Redireccionar con mensaje de éxito
        return redirect('/entregas-auditoria/lista')->with('success', 'Archivo subido correctamente.');
    }




    public function create()
    {
        // Obtener todos los reportes de ConfigEntregasAuditoria
        $configReportes = ConfigEntregasAuditoria::all();

        // Obtener colaboradores y jefes directos sin duplicados
        //$colaboradores = OrganigramaLinealNiveles::where('colaborador_id','!=','0')->pluck('colaborador_id')->unique();
        $colaboradores = DB::table('organigrama_lineal_niveles as org')
                            ->join('colaboradores as u', 'org.colaborador_id', '=', 'u.id')
                                ->select(
                                        'u.id',
                                        DB::raw("CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as name")
                                    )
                            ->get();
        //$jefe_directo = OrganigramaLinealNiveles::where('colaborador_id','!=','0')->pluck('jefe_directo_id')->unique();

        // Pasar los datos a la vista
        // return view('entregas_auditoria.create', compact('configReportes', 'colaboradores', 'jefe_directo'));
           return response()->json([
            'success' => true,
            'configReportes' => $configReportes,
            'colaboradores' => $colaboradores
            //'jefe_directo' => $jefe_directo
        ]);
    }


    // Guardar la nueva entrega de auditoría
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_reporte' => 'required|exists:config_entregas_auditoria,id',
            'responsable' => 'required|string|max:255',
        ]);

        // Obtener el reporte
        $reporte = ConfigEntregasAuditoria::find($request->id_reporte);
        $fecha_habilitada = null;

        if ($reporte->periodo == 'Semanal') {
            // La fecha_de_entrega es un nombre de día de la semana (Lunes, Martes, ...)
            $dia_semana = strtolower($request->dia_semanal); // Convertir a minúsculas para la comparación
            $dias = [
                'lunes' => Carbon::MONDAY,
                'martes' => Carbon::TUESDAY,
                'miercoles' => Carbon::WEDNESDAY,
                'jueves' => Carbon::THURSDAY,
                'viernes' => Carbon::FRIDAY,
                'sabado' => Carbon::SATURDAY,
                'domingo' => Carbon::SUNDAY,
            ];

            // Verificamos si el día es válido
            if (!isset($dias[$dia_semana])) {
                return redirect()->back()->withErrors(['fecha_de_entrega' => 'Día de la semana inválido']);
            }

            // Calcular el próximo día de la semana
            $fecha_habilitada = now()->next($dias[$dia_semana]); // Obtener el próximo día de la semana especificado

        } elseif ($reporte->periodo == 'Mensual') {
            // La fecha_de_entrega es un número (por ejemplo, 15, 30, 31)
            $dia_del_mes = (int) $request->dia_mensual;
            $ultimo_dia_mes = now()->endOfMonth()->day; // El último día del mes actual

            // Si el día proporcionado es mayor que el último día del mes, usamos el último día
            if ($dia_del_mes > $ultimo_dia_mes) {
                $fecha_habilitada = now()->endOfMonth(); // Último día del mes
            } else {
                // Crear la fecha con el día proporcionado
                $fecha_habilitada = now()->day($dia_del_mes);
            }
        }
        $jefe=OrganigramaLinealNiveles::where('colaborador_id',$request->responsable)->first();
        // Crear el nuevo registro en EntregaAuditoria
        EntregaAuditoria::create([
            'id_reporte' => $request->id_reporte,
            'fecha_de_entrega' => $fecha_habilitada,
            'responsable' => $request->responsable,
            'jefe_directo' => $jefe->jefe_directo_id,
            'estatus' => 'pendiente',  // Establecer como pendiente
            'fecha_habilitada' => $fecha_habilitada, // Establecer fecha habilitada
        ]);

        // Redirigir a una página de éxito o mostrar un mensaje
        return redirect()->route('entregas_auditoria.index')->with('success', 'Entrega de auditoría registrada con éxito');
    }

    public function pendiente(Request $request){

        EntregaAuditoria::where('id',$request->entrega_id)->update(['estatus'=>'pendiente']);
        return redirect()->route('entregas_auditoria.lista')->with('danger', 'Entregable actualizado con éxito. Estatus: Pendiente');
    }

    public function detener(Request $request){

        EntregaAuditoria::where('id',$request->entrega_id)->update(['estatus'=>'detenido']);
        return redirect()->route('entregas_auditoria.index')->with('success', 'Entregable actualizado con éxito');
    }

    public function completar(Request $request){

        EntregaAuditoria::where('id',$request->entrega_id)->update(['estatus'=>'completado']);
        return redirect()->route('entregas_auditoria.lista')->with('success', 'Entregable actualizado con éxito. Estatus: Exitoso');
    }

    public function eliminar(Request $request){

        EntregaAuditoria::where('id',$request->entrega_id)->delete();
        return redirect()->route('entregas_auditoria.index')->with('success', 'Entregable eliminado con éxito');
    }

    public function activar(Request $request){

        EntregaAuditoria::where('id',$request->entrega_id)->update(['estatus'=>'pendiente']);
        return redirect()->route('entregas_auditoria.index')->with('success', 'Entregable activada con éxito');
    }

    public function reporteEntregablesSemanal(Request $request)
{
    // Obtener todos los reportes con periodo "Semanal"
    $reportes = ConfigEntregasAuditoria::where('periodo', 'Semanal')->pluck('reporte', 'id');
    
    // Obtener el año seleccionado
    $year = $request->input('year', now()->year); // Por defecto, usamos el año actual si no se selecciona uno
    
    // Obtener el reporte seleccionado
    $id_reporte = $request->input('reporte', ''); // Por defecto, es vacío si no hay selección
    
    // Filtrar los registros por año, si es necesario funcion para SQL SERVER
    // $query = EntregaAuditoria::select(
    //         DB::raw('DATEPART(ISO_WEEK, fecha_de_entrega) as semana'),
    //         DB::raw('SUM(CASE WHEN dias_retraso < 0 THEN 0 ELSE dias_retraso END) as total_retraso')
    //     )
    //     ->groupBy(DB::raw('DATEPART(ISO_WEEK, fecha_de_entrega)'))
    //     ->whereYear('fecha_de_entrega', $year)
    //     ->whereNotNull('fecha_de_entrega');

    $query = DB::table('entregas_auditoria')
            ->selectRaw('WEEK(fecha_de_entrega, 1) as semana')
            ->selectRaw('SUM(CASE WHEN dias_retraso < 0 THEN 0 ELSE dias_retraso END) as total_retraso')
            ->whereYear('fecha_de_entrega', 2025)
            ->whereNotNull('fecha_de_entrega')
            ->groupByRaw('WEEK(fecha_de_entrega, 1)')
            ->orderBy('semana')
            ->get();

    if ($id_reporte) {
        $query->where('id_reporte', $id_reporte);
    }

    // Obtener los datos en un array [semana => total_retraso]
    $semanas = $query->pluck('total_retraso', 'semana');

    // Pasar las variables a la vista
    return view('reportes.reporte_entregables_semanal', compact('reportes', 'semanas', 'year', 'id_reporte'));
}
public function reporteEntregablesMensual(Request $request)
{
    // Obtener todos los reportes con periodo "Mensual"
    $reportes = ConfigEntregasAuditoria::where('periodo', 'Mensual')->pluck('reporte', 'id');

    // Obtener el año seleccionado
    $year = $request->input('year', now()->year); // Por defecto, usamos el año actual si no se selecciona uno

    // Obtener el reporte seleccionado
    $id_reporte = $request->input('reporte', ''); // Por defecto, es vacío si no hay selección

    // Filtrar los registros por año y reporte, si es necesario
    $query = EntregaAuditoria::select(
            DB::raw('MONTH(fecha_de_entrega) as mes'),
            DB::raw('SUM(CASE WHEN dias_retraso < 0 THEN 0 ELSE dias_retraso END) as total_retraso')
        )
        ->groupBy(DB::raw('MONTH(fecha_de_entrega)'))
        ->whereYear('fecha_de_entrega', $year)
        ->whereNotNull('fecha_de_entrega');

    if ($id_reporte) {
        $query->where('id_reporte', $id_reporte);
    }

    // Obtener los datos en un array [mes => total_retraso]
    $meses = $query->pluck('total_retraso', 'mes');

    $reportesMensuales=$reportes;

    // Pasar las variables a la vista
    return view('reportes.reporte_entregables_mensual', compact('reportes', 'meses', 'year', 'id_reporte','reportesMensuales'));
}




}
