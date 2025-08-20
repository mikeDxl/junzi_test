<?php

namespace App\Http\Controllers;

use App\Models\Vacantes;
use App\Models\Notificaciones;
use App\Models\Headcount;
use App\Models\Desvinculados;
use App\Models\Bajas;
use App\Models\Hallazgos;
use App\Models\Auditoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Companies;
use App\Models\Colaboradores;
use App\Models\AreasAuditoria;
use App\Models\CentrodeCostos;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\Ubicacion;
use App\Models\ConfigHallazgos;
use App\Events\HallazgoGuardado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionesAuditoriaService;

class DashboardController extends Controller
{
    // ========================================
    // MÉTODOS EXISTENTES (CARDS)
    // ========================================
    
    public function getCardVacantesData()
    {
        $vacantesall = Vacantes::visibleByRole()
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->count();

        $vacantespendientesall = Vacantes::visibleByRole()
            ->where('estatus', 'pendiente')
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->count();

        $porcentajeCompletadas = $vacantesall != 0 ? (($vacantesall - $vacantespendientesall) / $vacantesall) * 100 : 0;

        return response()->json([
            'vacantesall' => $vacantesall,
            'vacantespendientesall' => $vacantespendientesall,
            'porcentajeCompletadas' => $porcentajeCompletadas,
        ]);
    }

    public function getCardHeadcountData()
    {
        $mesActual = date('n');
        $anioActual = date('Y');

        $headcount = Headcount::where('mes', $mesActual)
            ->where('anio', $anioActual)
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->get();

        $totalActivos = $headcount->sum('activos');
        $totalVacantes = $headcount->sum('vacantes');
        $totalDesvinculados = Desvinculados::whereMonth('fecha_baja', $mesActual)
            ->whereYear('fecha_baja', $anioActual)
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->count();

        $totalPorcentaje = $totalActivos + $totalVacantes;
        $porcentajeActivos = $totalPorcentaje > 0 ? ($totalActivos / $totalPorcentaje) * 100 : 0;

        $mesAnterior = $mesActual - 1;
        $anioAnterior = $anioActual;

        if ($mesActual == 1) {
            $mesAnterior = 12;
            $anioAnterior = $anioActual - 1;
        }

        $headcountMesAnterior = Headcount::where('mes', $mesAnterior)
            ->where('anio', $anioAnterior)
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->get();

        $totalActivosMesAnterior = $headcountMesAnterior->sum('activos');
        $totalVacantesMesAnterior = $headcountMesAnterior->sum('vacantes');
        $totalPorcentajeMesAnterior = $totalActivosMesAnterior + $totalVacantesMesAnterior;
        $porcentajeActivosMesAnterior = $totalPorcentajeMesAnterior > 0 ? ($totalActivosMesAnterior / $totalPorcentajeMesAnterior) * 100 : 0;

        return response()->json([
            'porcentajeActivos' => $porcentajeActivos,
            'porcentajeActivosMesAnterior' => $porcentajeActivosMesAnterior,
        ]);
    }

    public function getCardDesvinculados()
    {
        $mesActual = date('n');
        $anioActual = date('Y');

        $totalBajas = Bajas::whereMonth('fecha_baja', $mesActual)
            ->whereYear('fecha_baja', $anioActual)
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->count();

        $totalDesvinculados = Desvinculados::whereMonth('fecha_baja', $mesActual)
            ->whereYear('fecha_baja', $anioActual)
            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                return $query->where('company_id', session('company_active_id'));
            })
            ->count();

        return response()->json([
            'totalDesvinculados' => $totalDesvinculados,
            'totalBajas' => $totalBajas,
        ]);
    }

    public function getCardPendientes()
    {
        $pendientes = Notificaciones::where('email', auth()->user()->email)->get();
        return response()->json($pendientes);
    }

    public function getChartHeadcountData()
    {
        Carbon::setLocale('es');
        $anioActual = date('Y');

        $labels = [];
        $mesNumeros = [];
        for ($i = 5; $i >= 0; $i--) {
            $fechaMes = Carbon::now()->subMonths($i);
            $labels[] = $fechaMes->format('F');
            $mesNumeros[] = $fechaMes->month;
        }

        $vacantesPendientes = [];
        $vacantesCompletadas = [];

        foreach ($mesNumeros as $mesNumero) {
            $primerDiaMes = Carbon::create($anioActual, $mesNumero, 1)->startOfMonth();
            $ultimoDiaMes = $primerDiaMes->endOfMonth();

            $vacantesPendientes[] = Vacantes::whereMonth('fecha', $mesNumero)
                                            ->whereYear('fecha', $anioActual)
                                            ->where('estatus', 'pendiente')
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $vacantesCompletadas[] = Vacantes::whereBetween('fecha', [$primerDiaMes, $ultimoDiaMes])
                                            ->where('estatus', 'completada')
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();
        }

        return response()->json([
            'labels' => $labels,
            'vacantesPendientes' => $vacantesPendientes,
            'vacantesCompletadas' => $vacantesCompletadas,
        ]);
    }

    // ========================================
    // NUEVOS MÉTODOS SEPARADOS POR GRÁFICA
    // ========================================

    /**
     * API para obtener datos SOLO de la gráfica de ÁREAS
     */
    public function getChartAreasData(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Validar fechas
        $errors = $this->validateDateRange($fechaInicio, $fechaFin);
        if (!empty($errors)) {
            return response()->json(['error' => implode(', ', $errors)], 400);
        }

        $areasData = $this->getAreasRecurrencia($fechaInicio, $fechaFin);

        return response()->json([
            'success' => true,
            'areas_recurrencia' => $areasData,
            'filtro_aplicado' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'tiene_filtro' => !empty($fechaInicio) && !empty($fechaFin)
            ]
        ]);
    }

    /**
     * API para obtener datos SOLO de la gráfica de CRITICIDAD
     */
    public function getChartCriticidadData(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Validar fechas
        $errors = $this->validateDateRange($fechaInicio, $fechaFin);
        if (!empty($errors)) {
            return response()->json(['error' => implode(', ', $errors)], 400);
        }

        $criticidadData = $this->getHallazgosCriticidad($fechaInicio, $fechaFin);

        return response()->json([
            'success' => true,
            'hallazgos_criticidad' => $criticidadData,
            'filtro_aplicado' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'tiene_filtro' => !empty($fechaInicio) && !empty($fechaFin)
            ]
        ]);
    }

    /**
     * API para obtener datos de AMBAS gráficas (método original mantenido)
     */
    public function getChartDataApi(Request $request)
    {
        $chartData = $this->getChartData($request);
        return response()->json($chartData);
    }
    
    /**
     * Obtener datos para los gráficos CON FILTROS DE FECHA
     */
    public function getChartData(Request $request = null)
    {
        // Obtener fechas de filtros
        $fechaInicio = $request ? $request->get('fecha_inicio') : null;
        $fechaFin = $request ? $request->get('fecha_fin') : null;

        // Validar que las fechas no sean futuras
        $today = Carbon::now()->toDateString();
        
        if ($fechaInicio && $fechaInicio > $today) {
            $fechaInicio = $today;
        }
        
        if ($fechaFin && $fechaFin > $today) {
            $fechaFin = $today;
        }

        // Validar rango de fechas
        if ($fechaInicio && $fechaFin && $fechaInicio > $fechaFin) {
            $fechaFin = $fechaInicio;
        }

        return [
            // Datos para gráfico de áreas con mayor recurrencia
            'areas_recurrencia' => $this->getAreasRecurrencia($fechaInicio, $fechaFin),
            
            // Datos para gráfico de hallazgos por criticidad y área
            'hallazgos_criticidad' => $this->getHallazgosCriticidad($fechaInicio, $fechaFin),
            
            // Información del filtro aplicado
            'filtro_aplicado' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'tiene_filtro' => !empty($fechaInicio) && !empty($fechaFin)
            ]
        ];
    }
    
    /**
     * Obtener áreas con mayor recurrencia de hallazgos CON FILTROS
     */
    private function getAreasRecurrencia($fechaInicio = null, $fechaFin = null) 
    {
        $query = AreasAuditoria::select(
                'areas_auditoria.nombre', 
                'areas_auditoria.clave', 
                DB::raw('COUNT(hallazgos.id) as total_hallazgos')
            )
            ->where('areas_auditoria.es_planta', 1)
            ->join('auditorias', 'auditorias.area', '=', 'areas_auditoria.clave')
            ->join('hallazgos', 'hallazgos.auditoria_id', '=', 'auditorias.id');

        // Aplicar filtros de fecha si están presentes
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('hallazgos.fecha_presentacion', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $query->where('hallazgos.fecha_presentacion', '>=', $fechaInicio);
        } elseif ($fechaFin) {
            $query->where('hallazgos.fecha_presentacion', '<=', $fechaFin);
        }

        $areasConMasHallazgos = $query
            ->groupBy('areas_auditoria.clave', 'areas_auditoria.nombre')
            ->orderByDesc('total_hallazgos')
            ->limit(5) // Limitar a top 5
            ->get();
        
        return $areasConMasHallazgos->map(function($item) {
            return (object)[
                'area' => $item->clave,
                'total' => $item->total_hallazgos
            ];
        })->toArray();
    }
    
    /**
     * Obtener hallazgos por área y criticidad CON FILTROS
     */
    private function getHallazgosCriticidad($fechaInicio = null, $fechaFin = null) 
    {
        $query = DB::table('hallazgos')
            ->join('auditorias', 'hallazgos.auditoria_id', '=', 'auditorias.id')
            ->select(
                'auditorias.area as area',
                'hallazgos.criticidad',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('auditorias.area') // Excluir áreas nulas
            ->whereNotNull('hallazgos.criticidad'); // Excluir criticidades nulas

        // Aplicar filtros de fecha si están presentes
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('hallazgos.fecha_presentacion', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $query->where('hallazgos.fecha_presentacion', '>=', $fechaInicio);
        } elseif ($fechaFin) {
            $query->where('hallazgos.fecha_presentacion', '<=', $fechaFin);
        }

        $hallazgosPorArea = $query
            ->groupBy('auditorias.area', 'hallazgos.criticidad')
            ->get();
            
        // Organizar datos para el gráfico
        $areas = [];
        $criticidades = ['alta', 'media', 'baja'];
        
        foreach ($hallazgosPorArea as $item) {
            if (!isset($areas[$item->area])) {
                $areas[$item->area] = [
                    'alta' => 0,
                    'media' => 0,
                    'baja' => 0,
                    'total' => 0
                ];
            }
            
            // Normalizar criticidad a minúsculas para consistencia
            $criticidad = strtolower($item->criticidad);
            
            if (in_array($criticidad, $criticidades)) {
                $areas[$item->area][$criticidad] = $item->total;
                $areas[$item->area]['total'] += $item->total;
            }
        }
        
        // Ordenar áreas por total de hallazgos (opcional)
        uasort($areas, function($a, $b) {
            return $b['total'] - $a['total'];
        });
        
        return $areas;
    }
    
    /**
     * API para obtener estadísticas en tiempo real (AJAX) - SIN FILTROS
     */
    public function getStatisticsApi()
    {
        $stats = $this->getStatistics();
        
        return response()->json([
            'stats' => $stats
        ]);
    }
    
    /**
     * Obtener estadísticas principales - SIN FILTROS (siempre datos actuales)
     */
    public function getStatistics()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $today = Carbon::now()->format('Y-m-d');
        
        return [
            // 1. Auditorías del mes (realizadas)
            'auditorias_mes' => DB::table('auditorias')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
                
            // 2. Hallazgos activos (no cerrados)
            'hallazgos_activos' => DB::table('hallazgos')
                ->where('estatus', '!=', 'Cerrado')
                ->count(),
                
            // 3. Hallazgos vencidos (fecha_compromiso pasada y no cerrados)
            'hallazgos_vencidos' => DB::table('hallazgos')
                ->where('fecha_compromiso', '<', $today)
                ->where('estatus', '!=', 'Cerrado')
                ->count(),
                
            // 4. Hallazgos subsanados (cerrados)
            'hallazgos_subsanados' => DB::table('hallazgos')
                ->where('estatus', 'Cerrado')
                ->count(),
                
            // Estadísticas adicionales
            'total_auditorias' => DB::table('auditorias')->count(),
            'hallazgos_del_mes' => DB::table('hallazgos')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
        ];
    }

    /**
     * Validar rango de fechas
     */
    private function validateDateRange($fechaInicio, $fechaFin)
    {
        $today = Carbon::now()->toDateString();
        $errors = [];

        if ($fechaInicio && $fechaInicio > $today) {
            $errors[] = 'La fecha de inicio no puede ser futura';
        }

        if ($fechaFin && $fechaFin > $today) {
            $errors[] = 'La fecha fin no puede ser futura';
        }

        if ($fechaInicio && $fechaFin && $fechaInicio > $fechaFin) {
            $errors[] = 'La fecha de inicio no puede ser mayor a la fecha fin';
        }

        return $errors;
    }

    /**
     * Obtener resumen comparativo entre ambas gráficas
     */
    public function getChartsComparison(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Validar fechas
        $errors = $this->validateDateRange($fechaInicio, $fechaFin);
        if (!empty($errors)) {
            return response()->json(['error' => implode(', ', $errors)], 400);
        }

        $areasData = $this->getAreasRecurrencia($fechaInicio, $fechaFin);
        $criticidadData = $this->getHallazgosCriticidad($fechaInicio, $fechaFin);

        // Calcular estadísticas de resumen
        $totalHallazgosAreas = array_sum(array_column($areasData, 'total'));
        $totalHallazgosCriticidad = array_sum(array_map(function($area) {
            return $area['total'];
        }, $criticidadData));

        return response()->json([
            'success' => true,
            'periodo' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'dias' => $fechaInicio && $fechaFin ? Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin)) + 1 : null
            ],
            'resumen' => [
                'total_areas_con_hallazgos' => count($areasData),
                'total_hallazgos_areas' => $totalHallazgosAreas,
                'total_areas_criticidad' => count($criticidadData),
                'total_hallazgos_criticidad' => $totalHallazgosCriticidad,
                'consistencia_datos' => $totalHallazgosAreas === $totalHallazgosCriticidad
            ],
            'datos' => [
                'areas_recurrencia' => $areasData,
                'hallazgos_criticidad' => $criticidadData
            ]
        ]);
    }

    /**
     * Obtener estadísticas específicas por gráfica
     */
    public function getChartSpecificStats(Request $request)
    {
        $chartType = $request->get('chart_type'); // 'areas' o 'criticidad'
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Validar parámetros
        if (!in_array($chartType, ['areas', 'criticidad'])) {
            return response()->json(['error' => 'Tipo de gráfica no válido'], 400);
        }

        $errors = $this->validateDateRange($fechaInicio, $fechaFin);
        if (!empty($errors)) {
            return response()->json(['error' => implode(', ', $errors)], 400);
        }

        if ($chartType === 'areas') {
            $data = $this->getAreasRecurrencia($fechaInicio, $fechaFin);
            $total = array_sum(array_column($data, 'total'));
            $stats = [
                'total_areas' => count($data),
                'total_hallazgos' => $total,
                'promedio_por_area' => count($data) > 0 ? round($total / count($data), 2) : 0
            ];
        } else {
            $data = $this->getHallazgosCriticidad($fechaInicio, $fechaFin);
            $totalAlta = array_sum(array_column($data, 'alta'));
            $totalMedia = array_sum(array_column($data, 'media'));
            $totalBaja = array_sum(array_column($data, 'baja'));
            $total = $totalAlta + $totalMedia + $totalBaja;
            
            $stats = [
                'total_areas' => count($data),
                'total_hallazgos' => $total,
                'hallazgos_alta' => $totalAlta,
                'hallazgos_media' => $totalMedia,
                'hallazgos_baja' => $totalBaja,
                'porcentaje_alta' => $total > 0 ? round(($totalAlta / $total) * 100, 2) : 0,
                'porcentaje_media' => $total > 0 ? round(($totalMedia / $total) * 100, 2) : 0,
                'porcentaje_baja' => $total > 0 ? round(($totalBaja / $total) * 100, 2) : 0
            ];
        }

        return response()->json([
            'success' => true,
            'chart_type' => $chartType,
            'periodo' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin
            ],
            'estadisticas' => $stats,
            'datos' => $data
        ]);
    }

    /**
     * Exportar datos de gráfica específica
     */
    public function exportChartData(Request $request)
    {
        $chartType = $request->get('chart_type');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $formato = $request->get('formato', 'json'); // json, csv

        if (!in_array($chartType, ['areas', 'criticidad'])) {
            return response()->json(['error' => 'Tipo de gráfica no válido'], 400);
        }

        $errors = $this->validateDateRange($fechaInicio, $fechaFin);
        if (!empty($errors)) {
            return response()->json(['error' => implode(', ', $errors)], 400);
        }

        if ($chartType === 'areas') {
            $data = $this->getAreasRecurrencia($fechaInicio, $fechaFin);
        } else {
            $data = $this->getHallazgosCriticidad($fechaInicio, $fechaFin);
        }

        switch ($formato) {
            case 'csv':
                return $this->exportToCSV($data, $chartType, $fechaInicio, $fechaFin);
            
            default:
                return response()->json([
                    'success' => true,
                    'chart_type' => $chartType,
                    'periodo' => [
                        'fecha_inicio' => $fechaInicio,
                        'fecha_fin' => $fechaFin
                    ],
                    'datos' => $data
                ]);
        }
    }

    /**
     * Exportar a CSV (implementación básica)
     */
    private function exportToCSV($data, $chartType, $fechaInicio, $fechaFin)
    {
        $filename = "grafica_{$chartType}_{$fechaInicio}_{$fechaFin}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data, $chartType) {
            $file = fopen('php://output', 'w');
            
            if ($chartType === 'areas') {
                fputcsv($file, ['Area', 'Total Hallazgos']);
                foreach ($data as $item) {
                    fputcsv($file, [$item->area, $item->total]);
                }
            } else {
                fputcsv($file, ['Area', 'Alta', 'Media', 'Baja', 'Total']);
                foreach ($data as $area => $values) {
                    fputcsv($file, [
                        $area, 
                        $values['alta'], 
                        $values['media'], 
                        $values['baja'], 
                        $values['total']
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========================================
    // MÉTODOS ADICIONALES EXISTENTES
    // ========================================
    
    /**
     * Obtener hallazgos por rango de fechas
     */
    public function getHallazgosByDateRange($fechaInicio, $fechaFin)
    {
        return DB::table('hallazgos')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->select(
                'estatus',
                'criticidad',
                DB::raw('COUNT(*) as total'),
                DB::raw('DATE(created_at) as fecha')
            )
            ->groupBy('estatus', 'criticidad', DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'desc')
            ->get();
    }
    
    /**
     * Obtener auditorías programadas vs realizadas
     */
    public function getAuditoriasProgramadasVsRealizadas()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        return [
            'programadas' => DB::table('auditorias')
                ->whereMonth('fecha_programada', $currentMonth)
                ->whereYear('fecha_programada', $currentYear)
                ->count(),
                
            'realizadas' => DB::table('auditorias')
                ->whereMonth('fecha_realizacion', $currentMonth)
                ->whereYear('fecha_realizacion', $currentYear)
                ->whereNotNull('fecha_realizacion')
                ->count(),
        ];
    }
    
    /**
     * Obtener hallazgos próximos a vencer (próximos 7 días)
     */
    public function getHallazgosProximosVencer()
    {
        $hoy = Carbon::now();
        $proximos7Dias = Carbon::now()->addDays(7);
        
        return DB::table('hallazgos')
            ->join('areas_auditoria', 'hallazgos.area_id', '=', 'areas_auditoria.id')
            ->where('hallazgos.estatus', '!=', 'Cerrado')
            ->whereBetween('hallazgos.fecha_compromiso', [$hoy->format('Y-m-d'), $proximos7Dias->format('Y-m-d')])
            ->select(
                'hallazgos.*',
                'areas_auditoria.nombre as area_nombre'
            )
            ->orderBy('hallazgos.fecha_compromiso', 'asc')
            ->get();
    }
    
    /**
     * Obtener top 5 áreas con más hallazgos vencidos
     */
    public function getTopAreasHallazgosVencidos()
    {
        $today = Carbon::now()->format('Y-m-d');
        
        return DB::table('hallazgos')
            ->join('areas_auditoria', 'hallazgos.area_id', '=', 'areas_auditoria.id')
            ->where('hallazgos.fecha_compromiso', '<', $today)
            ->where('hallazgos.estatus', '!=', 'Cerrado')
            ->select(
                'areas_auditoria.nombre as area',
                DB::raw('COUNT(*) as total_vencidos')
            )
            ->groupBy('areas_auditoria.id', 'areas_auditoria.nombre')
            ->orderBy('total_vencidos', 'desc')
            ->limit(5)
            ->get();
    }
    
    /**
     * Obtener hallazgos por auditor
     */
    public function getHallazgosPorAuditor()
    {
        return DB::table('hallazgos')
            ->join('users', 'hallazgos.auditor_id', '=', 'users.id')
            ->select(
                'users.name as auditor',
                'hallazgos.estatus',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('users.id', 'users.name', 'hallazgos.estatus')
            ->orderBy('total', 'desc')
            ->get();
    }

    // ========================================
    // MÉTODOS ADICIONALES PARA DASHBOARD
    // ========================================

    /**
     * Método principal del dashboard - Vista inicial
     */
    public function index()
    {
        // Obtener estadísticas generales para las cards
        $stats = $this->getStatistics();
        
        // Obtener datos generales para las gráficas (SIN filtros)
        $chartData = $this->getChartData();
        
        return view('dashboard.index', compact('stats', 'chartData'));
    }

    /**
     * Dashboard específico de jefaturas
     */
    public function dashboardJefatura()
    {
        // Obtener estadísticas generales para las cards
        $stats = $this->getStatistics();
        
        // Obtener datos generales para las gráficas (SIN filtros)
        $chartData = $this->getChartData();
        
        return view('dashboard.jefatura', compact('stats', 'chartData'));
    }

    /**
     * Obtener resumen general del dashboard
     */
    public function getDashboardSummary()
    {
        $stats = $this->getStatistics();
        $chartData = $this->getChartData();
        
        // Calcular algunos indicadores adicionales
        $totalHallazgosAreas = 0;
        if (!empty($chartData['areas_recurrencia'])) {
            $totalHallazgosAreas = array_sum(array_column($chartData['areas_recurrencia'], 'total'));
        }
        
        $totalHallazgosCriticidad = 0;
        if (!empty($chartData['hallazgos_criticidad'])) {
            foreach ($chartData['hallazgos_criticidad'] as $area) {
                $totalHallazgosCriticidad += $area['total'];
            }
        }
        
        return response()->json([
            'success' => true,
            'resumen' => [
                'estadisticas_cards' => $stats,
                'total_hallazgos_graficas' => $totalHallazgosAreas,
                'areas_con_hallazgos' => count($chartData['areas_recurrencia'] ?? []),
                'areas_con_criticidad' => count($chartData['hallazgos_criticidad'] ?? []),
                'consistencia_datos' => $totalHallazgosAreas === $totalHallazgosCriticidad
            ],
            'datos_graficas' => $chartData
        ]);
    }

    /**
     * Obtener datos para widget de hallazgos por estado
     */
    public function getHallazgosByStatus()
    {
        $hallazgosPorEstado = DB::table('hallazgos')
            ->select(
                'estatus',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('estatus')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'datos' => $hallazgosPorEstado
        ]);
    }

    /**
     * Obtener datos para widget de auditorías por mes
     */
    public function getAuditoriasByMonth($year = null)
    {
        $year = $year ?: Carbon::now()->year;
        
        $auditoriasPorMes = DB::table('auditorias')
            ->select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('mes')
            ->get();

        // Completar todos los meses del año
        $mesesCompletos = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $auditoriasPorMes->firstWhere('mes', $i);
            $mesesCompletos[] = [
                'mes' => $i,
                'mes_nombre' => Carbon::create($year, $i, 1)->format('F'),
                'total' => $found ? $found->total : 0
            ];
        }

        return response()->json([
            'success' => true,
            'year' => $year,
            'datos' => $mesesCompletos
        ]);
    }

    /**
     * Obtener alertas y notificaciones del dashboard
     */
    public function getDashboardAlerts()
    {
        $today = Carbon::now()->format('Y-m-d');
        $nextWeek = Carbon::now()->addDays(7)->format('Y-m-d');

        // Hallazgos vencidos
        $hallazgosVencidos = DB::table('hallazgos')
            ->where('fecha_compromiso', '<', $today)
            ->where('estatus', '!=', 'Cerrado')
            ->count();

        // Hallazgos próximos a vencer
        $hallazgosProximosVencer = DB::table('hallazgos')
            ->whereBetween('fecha_compromiso', [$today, $nextWeek])
            ->where('estatus', '!=', 'Cerrado')
            ->count();

        // Auditorías pendientes de programar
        $auditoriasPendientes = DB::table('auditorias')
            ->whereNull('fecha_programada')
            ->count();

        // Hallazgos de alta criticidad sin asignar
        $hallazgosAltaSinAsignar = DB::table('hallazgos')
            ->where('criticidad', 'alta')
            ->where('estatus', 'Abierto')
            ->whereNull('responsable_id')
            ->count();

        return response()->json([
            'success' => true,
            'alertas' => [
                'hallazgos_vencidos' => $hallazgosVencidos,
                'hallazgos_proximos_vencer' => $hallazgosProximosVencer,
                'auditorias_pendientes' => $auditoriasPendientes,
                'hallazgos_alta_sin_asignar' => $hallazgosAltaSinAsignar
            ],
            'tiene_alertas' => $hallazgosVencidos > 0 || $hallazgosProximosVencer > 0 || $auditoriasPendientes > 0 || $hallazgosAltaSinAsignar > 0
        ]);
    }

    /**
     * Actualizar estado de notificación como leída
     */
    public function markNotificationAsRead(Request $request)
    {
        $notificationId = $request->get('notification_id');
        
        $updated = DB::table('notificaciones')
            ->where('id', $notificationId)
            ->where('email', auth()->user()->email)
            ->update(['leida' => true, 'fecha_lectura' => Carbon::now()]);

        return response()->json([
            'success' => $updated > 0,
            'message' => $updated > 0 ? 'Notificación marcada como leída' : 'No se pudo actualizar la notificación'
        ]);
    }

    /**
     * Obtener configuración del dashboard por usuario
     */
    public function getDashboardConfig()
    {
        $config = DB::table('dashboard_config')
            ->where('user_id', auth()->id())
            ->first();

        if (!$config) {
            // Configuración por defecto
            $config = [
                'auto_refresh' => true,
                'refresh_interval' => 5, // minutos
                'show_notifications' => true,
                'show_alerts' => true,
                'chart_theme' => 'light'
            ];
        } else {
            $config = json_decode($config->config, true);
        }

        return response()->json([
            'success' => true,
            'config' => $config
        ]);
    }

    /**
     * Guardar configuración del dashboard por usuario
     */
    public function saveDashboardConfig(Request $request)
    {
        $config = $request->only([
            'auto_refresh',
            'refresh_interval',
            'show_notifications',
            'show_alerts',
            'chart_theme'
        ]);

        $saved = DB::table('dashboard_config')->updateOrInsert(
            ['user_id' => auth()->id()],
            [
                'config' => json_encode($config),
                'updated_at' => Carbon::now()
            ]
        );

        return response()->json([
            'success' => $saved,
            'message' => $saved ? 'Configuración guardada exitosamente' : 'Error al guardar configuración',
            'config' => $config
        ]);
    }

    /**
     * Obtener datos para exportar todo el dashboard
     */
    public function exportDashboardData(Request $request)
    {
        $formato = $request->get('formato', 'json'); // json, excel, pdf
        $includeCharts = $request->get('include_charts', true);
        $includeStats = $request->get('include_stats', true);

        $data = [];

        if ($includeStats) {
            $data['estadisticas'] = $this->getStatistics();
        }

        if ($includeCharts) {
            $data['graficas'] = $this->getChartData();
        }

        $data['fecha_exportacion'] = Carbon::now()->toDateTimeString();
        $data['usuario'] = auth()->user()->name;

        switch ($formato) {
            case 'excel':
                // Implementar exportación a Excel si es necesario
                return response()->json(['message' => 'Exportación Excel no implementada']);
            
            case 'pdf':
                // Implementar exportación a PDF si es necesario
                return response()->json(['message' => 'Exportación PDF no implementada']);
            
            default:
                return response()->json([
                    'success' => true,
                    'formato' => $formato,
                    'datos' => $data
                ]);
        }
    }

    /**
     * Obtener métricas de rendimiento del dashboard
     */
    public function getDashboardMetrics()
    {
        $metricas = [
            'tiempo_respuesta_promedio' => $this->calculateAverageResponseTime(),
            'consultas_por_hora' => $this->getQueriesPerHour(),
            'usuarios_activos' => $this->getActiveUsers(),
            'ultimo_backup' => $this->getLastBackupInfo()
        ];

        return response()->json([
            'success' => true,
            'metricas' => $metricas
        ]);
    }


}