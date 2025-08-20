<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Models\Bajas;
use App\Models\Vacantes;
use App\Models\Desvinculados;
use App\Models\ProcesoRH;
use App\Models\Headcount;
use App\Models\Vacaciones;
use App\Models\HorasExtra;
use App\Models\Altas;
use App\Models\Mensaje;
use App\Models\Grupo;
use App\Models\GrupoColaborador;
use App\Models\Gratificaciones;
use App\Models\Notificaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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

    public function logoutOtherDevices()
    {
        // Invalida todas las sesiones activas en la base de datos
        Session::getHandler()->flush();

        return response()->json([
            'message' => 'Todas las sesiones de usuarios han sido cerradas. Todos los usuarios deberán iniciar sesión nuevamente.'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    
    public function index()
    {
        
      $pendientes=Notificaciones::where('email',auth()->user()->email)->get();

      $mesActual = Carbon::now()->month;

    if (auth()->user()->perfil=='Reclutamiento') {

        return redirect('/vacantes');
    }

    
 
    if (auth()->user()->perfil=='Colaborador') {

      $usuariocolab = auth()->user()->colaborador_id;
      $mensajes = Colaboradores::findOrFail($usuariocolab)
                               ->mensajes()
                               ->where('fecha_inicio', '<=', now())  // Fecha de inicio menor o igual a hoy
                               ->where('fecha_fin', '>=', now())     // Fecha de fin mayor o igual a hoy
                               ->get();
      

        // Filtrar colaboradores con estatus activo y cuyo cumpleaños sea en el mes actual
        $colaboradores = Colaboradores::where('estatus', 'activo')
                                      ->whereMonth('fecha_nacimiento', $mesActual)
                                      ->orderByRaw('DAY(fecha_nacimiento)') // Ordenar por el día del mes
                                      ->get();

        // Formatear los datos para mostrar nombre, apellidos y el día de cumpleaños
        $cumpleaneros = $colaboradores->map(function($colaborador) {
        $fechaNacimiento = Carbon::parse($colaborador->fecha_nacimiento);
        // Formatear el día y nombre del día en español
        $diaSemana = $fechaNacimiento->locale('es')->isoFormat('dddd D'); // Ejemplo: 'jueves 18'
            return [
                'nombre' => $colaborador->nombre,
                'apellido_paterno' => $colaborador->apellido_paterno,
                'apellido_materno' => $colaborador->apellido_materno,
                'puesto' => $colaborador->puesto,
                'company_id' => $colaborador->company_id,
                'dia_cumple' => ucfirst($diaSemana) // Capitaliza el primer carácter
            ];
        });

        $mesActual = date('n');
        $anioActual = date('Y');

        return view('pages.partials.dashboard_colaborador',compact('cumpleaneros','mensajes'));

    }



    if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Nómina') {

        $mesActual = date('n');
        $anioActual = date('Y');

        $headcount = Headcount::where('mes', $mesActual)
        ->where('anio', $anioActual)
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->get();


        // Calcular la suma de activos, vacantes y desvinculados.
        $totalActivos = $headcount->sum('activos');
        $totalVacantes = $headcount->sum('vacantes');
        $totalDesvinculados = Desvinculados::whereMonth('fecha_baja', $mesActual)
                                   ->whereYear('fecha_baja', $anioActual)
                                   ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                       return $query->where('company_id', session('company_active_id'));
                                   })
                                   ->count();

        // Calcular el total de activos y vacantes.
        $totalPorcentaje = $totalActivos + $totalVacantes;

        // Calcular el porcentaje de activos, verificando primero que el divisor no sea cero.
        if ($totalPorcentaje > 0) {
            $porcentajeActivos = ($totalActivos / $totalPorcentaje) * 100;
        } else {
            // Si el totalPorcentaje es 0, se puede asumir que el porcentaje de activos es 0,
            // o manejar de otra manera según la lógica de negocio.
            $porcentajeActivos = 0; // O manejar de otra forma
        }

        // A partir de aquí, $porcentajeActivos está listo para ser utilizado de manera segura
        // sin el riesgo de una división por cero.

        // Calcular el mes y el año del mes anterior
        $mesAnterior = $mesActual - 1;
        $anioAnterior = $anioActual;

        // Si el mes actual es enero, el mes anterior es diciembre del año anterior
        if ($mesActual == 1) {
            $mesAnterior = 12;
            $anioAnterior = $anioActual - 1;
        }

        // Consulta para obtener los datos del mes anterior
        $headcountMesAnterior = Headcount::where('mes', $mesAnterior)
                                          ->where('anio', $anioAnterior)
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->get();

        // Suma de activos y vacantes del mes anterior
        $totalActivosMesAnterior = $headcountMesAnterior->sum('activos');
        $totalVacantesMesAnterior = $headcountMesAnterior->sum('vacantes');
        $totalPorcentajeMesAnterior = $totalActivosMesAnterior + $totalVacantesMesAnterior;

        // Calcular el porcentaje de activos del mes anterior
        $porcentajeActivosMesAnterior = 0; // Por defecto asignamos 0 en caso de división por cero
        if ($totalPorcentajeMesAnterior != 0) {
            $porcentajeActivosMesAnterior = ($totalActivosMesAnterior / $totalPorcentajeMesAnterior) * 100;
        }

        $totalBajas = Bajas::whereMonth('fecha_baja', $mesActual)
                   ->whereYear('fecha_baja', $anioActual)
                   ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                       return $query->where('company_id', session('company_active_id'));
                   })
                   ->count();


        //grafica 1

        $fechaActual = Carbon::now();
        $fechaActualInicio = $fechaActual->copy();


        $primerDiaHace6Meses = $fechaActual->subMonths(6)->startOfMonth();
        $ultimoDiaMesActual = $fechaActual->endOfMonth();

        $vacantesEnRango = Vacantes::whereBetween('fecha', [$primerDiaHace6Meses, $ultimoDiaMesActual])
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->get();

        $vacantesPendientes = $vacantesEnRango->where('estatus', 'pendiente')->count();
        $vacantesCompletadas = $vacantesEnRango->where('estatus', 'completada')->count();

        $primerDiaHace6Meses = $fechaActual->subMonths(6)->startOfMonth()->toDateString();
        $ultimoDiaMesActual = $fechaActualInicio->endOfMonth()->toDateString();

        $primerDiaHace6Meses_g1 = $fechaActual->subMonths(6)->startOfMonth()->toDateString();
        $ultimoDiaMesActual_g1 = $fechaActualInicio->endOfMonth()->toDateString();

        // Obtener el año actual
        $anioActual = date('Y');

        //grafica2

        $primerDiaHace6Meses_g2 = $request->primerDiaHace6Meses_g2 ?? $fechaActual->subMonths(6)->startOfMonth()->toDateString();
        $ultimoDiaMesActual_g2 = $request->ultimoDiaMesActual_g2 ?? $fechaActualInicio->endOfMonth()->toDateString();

        $fechaActual = Carbon::now();

        // Obtener todos los colaboradores activos
        $colaboradoresActivos = Colaboradores::where('estatus', 'activo')
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->whereBetween('fecha_alta', [$primerDiaHace6Meses_g2, $ultimoDiaMesActual_g2])
        ->get();

        $colaboradoresActivos = Colaboradores::where('estatus', 'activo')
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->get();

        $totalActivos = $colaboradoresActivos->count();
        // Contadores para cada rango de antigüedad
        $menosDeTresMeses = 0;
        $tresASeisMeses = 0;
        $masDeSeisMeses = 0;
        $menosDeUnAno = 0;
        $masDeUnAno = 0;

        // Calcular la antigüedad de cada colaborador
        foreach ($colaboradoresActivos as $colaborador) {
            // Calcular la diferencia en meses desde la fecha de alta hasta la fecha actual
            $antiguedad = $colaborador->fecha_alta->diffInMonths($fechaActual);

            // Incrementar el contador correspondiente al rango de antigüedad
            if ($antiguedad < 3) {
                $menosDeTresMeses++;
            } elseif ($antiguedad >= 3 && $antiguedad <= 6) {
                $tresASeisMeses++;
            } elseif ($antiguedad < 12) {
                $menosDeUnAno++;
            } else {
                $masDeUnAno++;
            }
        }

        // Datos del objetivo
        $objetivo = [30, 30, 30, 30, 30, 30]; // Puedes cambiar esto si es dinámico

        $vacantesall = Vacantes::query()
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->count();

        $vacantespendientesall = Vacantes::where('estatus', 'pendiente')
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->count();

        $totaldecolaboradores=$masDeUnAno+$menosDeUnAno;
        $indiceDeEstabilidad=(($masDeUnAno)/($totaldecolaboradores))*100;

          return view('pages.partials.dashboard_nomina' ,
            compact(
            'porcentajeActivos',
            'porcentajeActivosMesAnterior',
            'totalDesvinculados',
            'totalBajas',
            'fechaActual',
            'primerDiaHace6Meses',
            'ultimoDiaMesActual',
            'totalActivos',
            'menosDeTresMeses',
            'tresASeisMeses',
            'masDeSeisMeses',
            'menosDeUnAno',
            'masDeUnAno',
            'indiceDeEstabilidad',
            'primerDiaHace6Meses_g1',
            'ultimoDiaMesActual_g1',
            'primerDiaHace6Meses_g2',
            'ultimoDiaMesActual_g2',
            'vacantespendientesall',
            'vacantesall',
            'pendientes'
            )
          );
    }



    if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina') {

        return view('pages.partials.dashboard_jefatura',compact('pendientes'));

    }


    if (auth()->user()->email=='reclutamiento@gonie.com') 
    {

        return redirect('/vacantes');

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

        // Calcular el porcentaje de activos, verificando primero que el divisor no sea cero.
        if ($totalPorcentaje > 0) {
            $porcentajeActivos = ($totalActivos / $totalPorcentaje) * 100;
        } else {
            // Si el totalPorcentaje es 0, se puede asumir que el porcentaje de activos es 0,
            // o manejar de otra manera según la lógica de negocio.
            $porcentajeActivos = 0; // O manejar de otra forma
        }

        // Calcular el mes y el año del mes anterior
        $mesAnterior = $mesActual - 1;
        $anioAnterior = $anioActual;

        // Si el mes actual es enero, el mes anterior es diciembre del año anterior
        if ($mesActual == 1) {
            $mesAnterior = 12;
            $anioAnterior = $anioActual - 1;
        }

        // Consulta para obtener los datos del mes anterior
        $headcountMesAnterior = Headcount::where('mes', $mesAnterior)
                                          ->where('anio', $anioAnterior)
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->get();

        // Suma de activos y vacantes del mes anterior
        $totalActivosMesAnterior = $headcountMesAnterior->sum('activos');
        $totalVacantesMesAnterior = $headcountMesAnterior->sum('vacantes');
        $totalPorcentajeMesAnterior = $totalActivosMesAnterior + $totalVacantesMesAnterior;

        // Calcular el porcentaje de activos del mes anterior
        $porcentajeActivosMesAnterior = 0; // Por defecto asignamos 0 en caso de división por cero
        if ($totalPorcentajeMesAnterior != 0) {
            $porcentajeActivosMesAnterior = ($totalActivosMesAnterior / $totalPorcentajeMesAnterior) * 100;
        }


        $totalBajas = Bajas::whereMonth('fecha_baja', $mesActual)
                   ->whereYear('fecha_baja', $anioActual)
                   ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                       return $query->where('company_id', session('company_active_id'));
                   })
                   ->count();



                   $vacantes = Vacantes::query()
               ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                   return $query->where('company_id', session('company_active_id'));
               })
               ->get();

        $procesorh=ProcesoRH::query()
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->get();

        $fechaUnMesAtras = Carbon::now()->subMonth();

              // Preparar fechas
        $fechaActual = Carbon::now();
        $primerDiaHace6Meses = $fechaActual->copy()->subMonths(6)->startOfMonth();
        $ultimoDiaMesActual = $fechaActual->copy()->endOfMonth();

        // Generar etiquetas para los últimos 6 meses
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $fechaMes = Carbon::now()->subMonths($i);
            $labels[] = $fechaMes->translatedFormat('F');
        }

        //grafica 1

        $fechaActual = Carbon::now();
        $fechaActualInicio = $fechaActual->copy();

        $objetivo = [30, 30, 30, 30, 30, 30]; // Puedes cambiar esto si es dinámico

        $primerDiaHace6Meses = $fechaActual->subMonths(6)->startOfMonth();
        $ultimoDiaMesActual = $fechaActual->endOfMonth();


        $vacantesEnRango = Vacantes::whereBetween('fecha', [$primerDiaHace6Meses, $ultimoDiaMesActual])
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->get();

        $vacantesPendientes = $vacantesEnRango->where('estatus', 'pendiente')->count();
        $vacantesCompletadas = $vacantesEnRango->where('estatus', 'completada')->count();

        $primerDiaHace6Meses = $fechaActual->subMonths(6)->startOfMonth()->toDateString();
        $ultimoDiaMesActual = $fechaActualInicio->endOfMonth()->toDateString();

        $primerDiaHace6Meses_g1 = $fechaActual->subMonths(6)->startOfMonth()->toDateString();
        $ultimoDiaMesActual_g1 = $fechaActualInicio->endOfMonth()->toDateString();

        // Contar las altas para cada mes
        $altasPorMes = [];
        $bajasPorMes = [];
        $datosAltasReferencias = [];
        $datosAltasRedesSociales = [];
        $datosAltasVolanteo = [];
        $datosAltasBolsaDeTrabajo = [];
        $datosBajasAbandonodeEmpleo = [];
        $datosBajasAusentismo = [];
        $datosBajasCambiodePuesto = [];
        $datosBajasDefuncion = [];
        $datosBajasResciciondeContrato = [];
        $datosBajasSeparacionVoluntaria = [];
        $datosBajasTerminodeContrato = [];
        $datosBajasNulo = [];
        $permanencia3meses = [];
        $permanencia12meses = [];
        $permanenciamayor1anio = [];


        foreach ($labels as $index => $mes) {
            // Obtener el mes y el año correctos considerando el cambio de año
            $fechaMes = Carbon::now()->subMonths(5 - $index); // Ajustamos el índice para iterar correctamente los meses hacia atrás
            $mesNumero = $fechaMes->month;
            $anioActual = $fechaMes->year;

            $primerDiaMes = Carbon::create($anioActual, $mesNumero, 1)->startOfMonth();
            $ultimoDiaMes = $primerDiaMes->copy()->endOfMonth();

            $altasPorMes[] = Colaboradores::where('estatus', 'activo')
                                            ->whereBetween('fecha_alta', [$primerDiaMes, $ultimoDiaMes])
                                            ->where('fecha_baja', '1899-12-30 00:00:00.000')
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $bajasPorMes[] = Colaboradores::where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosAltasReferencias[] = Altas::where('motivo', 'Referencias')
                                            ->whereBetween('fecha_alta', [$primerDiaMes, $ultimoDiaMes])
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $datosAltasRedesSociales[] = Altas::where('motivo', 'Redes Sociales')
                                            ->whereBetween('fecha_alta', [$primerDiaMes, $ultimoDiaMes])
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $datosAltasVolanteo[] = Altas::where('motivo', 'Volanteo')
                                            ->whereBetween('fecha_alta', [$primerDiaMes, $ultimoDiaMes])
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $datosAltasBolsaDeTrabajo[] = Altas::where('motivo', 'Bolsa de Trabajo')
                                            ->whereBetween('fecha_alta', [$primerDiaMes, $ultimoDiaMes])
                                            ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                return $query->where('company_id', session('company_active_id'));
                                            })
                                            ->count();

            $datosBajasAbandonodeEmpleo[] = Colaboradores::where('causabaja', 'Abandono de empleo')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasAusentismo[] = Colaboradores::where('causabaja', 'Ausentismo')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasCambiodePuesto[] = Colaboradores::where('causabaja', 'Cambio de puesto')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasDefuncion[] = Colaboradores::where('causabaja', 'Defunción')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasResciciondeContrato[] = Colaboradores::where('causabaja', 'Rescisión de contrato')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasSeparacionVoluntaria[] = Colaboradores::where('causabaja', 'Separación voluntaria')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasTerminodeContrato[] = Colaboradores::where('causabaja', 'Término de contrato')
                                          ->where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $datosBajasNulo[] = Colaboradores::where(function ($query) {
                                                        $query->where('causabaja', '=', '')
                                                              ->orWhere('causabaja', '=', 'NULL')
                                                              ->orWhere('causabaja', '=', ' ')
                                                              ->orWhereNull('causabaja');
                                                    })
                                                    ->where('estatus', 'inactivo')
                                                    ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                                    ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                                        return $query->where('company_id', session('company_active_id'));
                                                    })
                                                    ->count();

            $permanencia3meses[] = Colaboradores::where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->whereRaw('DATEDIFF(MONTH, fecha_alta, fecha_baja) <= 3')
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $permanencia12meses[] = Colaboradores::where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->whereRaw('DATEDIFF(MONTH, fecha_alta, fecha_baja) > 3 AND DATEDIFF(MONTH, fecha_alta, fecha_baja) <= 12')
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();

            $permanenciamayor1anio[] = Colaboradores::where('estatus', 'inactivo')
                                          ->whereBetween('fecha_baja', [$primerDiaMes, $ultimoDiaMes])
                                          ->whereRaw('DATEDIFF(MONTH, fecha_alta, fecha_baja) > 12')
                                          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
                                              return $query->where('company_id', session('company_active_id'));
                                          })
                                          ->count();
        }

        $vacantesall = Vacantes::query()
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->count();

        $vacantespendientesall = Vacantes::where('estatus', 'pendiente')
        ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
            return $query->where('company_id', session('company_active_id'));
        })
        ->count();

        return view('pages.partials.dashboard_reclutamiento' ,
          compact(
          'porcentajeActivos',
          'porcentajeActivosMesAnterior',
          'totalDesvinculados',
          'totalBajas',
          'fechaActual',
           'vacantes',
           'procesorh' ,
           'altasPorMes' ,
           'bajasPorMes',
           'labels',
           'datosAltasReferencias',
           'datosAltasRedesSociales',
           'datosAltasVolanteo',
           'datosAltasBolsaDeTrabajo',
           'datosBajasAbandonodeEmpleo',
           'datosBajasAusentismo',
           'datosBajasCambiodePuesto',
           'datosBajasDefuncion',
           'datosBajasResciciondeContrato',
           'datosBajasSeparacionVoluntaria',
           'datosBajasTerminodeContrato',
           'permanencia3meses',
           'permanencia12meses',
           'permanenciamayor1anio',
           'datosBajasNulo',
           'vacantesPendientes',
           'vacantesCompletadas',
           'vacantesPendientes',
           'vacantesCompletadas',
            'objetivo',
            'primerDiaHace6Meses_g1',
            'ultimoDiaMesActual_g1',
            'vacantespendientesall',
            'vacantesall',
            'pendientes'
           )
        );
    }


    }
}
