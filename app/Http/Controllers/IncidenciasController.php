<?php


namespace App\Http\Controllers;

use App\Models\Companies;

use App\Models\Vacaciones;
use App\Models\Gratificaciones;
use App\Models\Permisos;
use App\Models\HorasExtra;
use App\Models\Asistencias;
use App\Models\Incidencia;
use App\Models\Incapacidad;
use App\Models\CentrodeCostos;
use App\Models\Horarios;
use App\Models\VacacionesPendientes;
use App\Models\User;
use App\Models\Notificaciones;
use App\Models\Colaboradores;
use App\Models\OrganigramaLinealNiveles;
use Illuminate\Http\Request;
use App\Models\DiasVacaciones;
use App\Models\VacacionesHistorico;
use Carbon\Carbon;
use App\Models\CatalogoCentrosdeCostos;
use Excel;



class IncidenciasController extends Controller
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
     public function capturarIncidencias() {
          // Obtener la fecha de hoy
          $hoy = Carbon::now();

          // Iniciar un contador de días hábiles
          $diasHabiles = 0;

          // Definir cuántos días hábiles quieres restar (en este caso, 2 días)
          $numeroDiasHabiles = 2;

          // Realizar un bucle para restar días hábiles
          while ($diasHabiles < $numeroDiasHabiles) {
              // Restar 1 día a la fecha de hoy
              $hoy->subDay();

              // Verificar si el día actual no es un fin de semana (sábado o domingo)
              if ($hoy->dayOfWeek !== Carbon::SATURDAY && $hoy->dayOfWeek !== Carbon::SUNDAY) {
                  // Si no es un fin de semana, aumentar el contador de días hábiles
                  $diasHabiles++;
              }
          }

          // Quitar las horas y dejar solo la fecha
          $fechaDosDiasHabilesAtras = str_replace(' 00:00:00','',$hoy->startOfDay());

          // Obtener información del colaborador actual
          $info = Colaboradores::where('id', auth()->user()->colaborador_id)->first();
          
          if(auth()->user()->perfil=='Reclutamiento'){

          }else{
            $centro = CatalogoCentrosdeCostos::where('centro_de_costo', $info->organigrama)->first();

            // Obtener los colaboradores del centro de costo
            $colaboradores_jd = OrganigramaLinealNiveles::where('cc', $centro->id)->get();
            $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
            $colaboradores = Colaboradores::whereIn('id', $colaboradorIds)
                ->where('estatus', 'activo')
                ->get();
          }

          return view('incidencias.capturar', compact('colaboradores','colaboradorIds','colaboradores_jd','centro','info','fechaDosDiasHabilesAtras','diasHabiles','hoy','numeroDiasHabiles'));
      }

     public function showIncidencias(Request $request)
      {
          $companies = Companies::all();
          // Obtener el primer y último día del mes actual
          $twentyFourHoursAgo = Carbon::now()->subHours(24);

          $startOfMonth = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
          $endOfMonth = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

         if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Jefatura') {
          // $compensaciones = Gratificaciones::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_gratificacion', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
          // $permisos = Permisos::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_permiso', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
          // $horasextra = HorasExtra::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_hora_extra', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
          $compensaciones = Gratificaciones::where('jefe_directo_id', auth()->user()->colaborador_id)
            ->where(function ($query) use ($twentyFourHoursAgo) {
                $query->where('estatus', 'Pendiente')
                    ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                        $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                            ->where('updated_at', '>=', $twentyFourHoursAgo);
                    });
            })
            ->whereBetween('fecha_gratificacion', [$startOfMonth, $endOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();

          $permisos = Permisos::where('jefe_directo_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Solicitud')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->whereIn('estatus', ['Aprobada', 'Rechazada','Aprobada Jefatura', 'Rechazada Jefatura'])
                              ->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('fecha_permiso', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $incapacidades = Incapacidad::where('jefe_directo_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Solicitud')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->whereIn('estatus', ['Aprobada', 'Rechazada','Aprobada Jefatura', 'Rechazada Jefatura'])
                              ->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('apartir', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $vacaciones = Vacaciones::where('jefe_directo_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Solicitud')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->whereIn('estatus', ['Aprobada', 'Rechazada','Aprobada Jefatura', 'Rechazada Jefatura'])
                              ->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('desde', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $horasextra = HorasExtra::where('jefe_directo_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Pendiente')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                              ->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('fecha_hora_extra', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

           $asistencias = Asistencias::where('jefe_directo_id', auth()->user()->colaborador_id)->where('asistencia', '!=', 'Asistencia') ->whereBetween('fecha', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           
           return view('incidencias.incidencias_jf', compact('companies','compensaciones','permisos','horasextra','asistencias','startOfMonth','endOfMonth','incapacidades','vacaciones'));
         
          }elseif(auth()->user()->perfil=='Colaborador' || auth()->user()->perfil=='Reclutamiento'){

            $compensaciones = Gratificaciones::where('colaborador_id', auth()->user()->colaborador_id)
            ->where(function ($query) use ($twentyFourHoursAgo) {
                $query->where('estatus', 'Pendiente')
                    ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                        $query->where('updated_at', '>=', $twentyFourHoursAgo);
                    });
            })
            ->whereBetween('fecha_gratificacion', [$startOfMonth, $endOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();

          $permisos = Permisos::where('colaborador_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Pendiente')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('fecha_permiso', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $incapacidades = Incapacidad::where('colaborador_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Pendiente')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('apartir', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $vacaciones = Vacaciones::where('colaborador_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Pendiente')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('desde', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

          $horasextra = HorasExtra::where('colaborador_id', auth()->user()->colaborador_id)
              ->where(function ($query) use ($twentyFourHoursAgo) {
                  $query->where('estatus', 'Pendiente')
                      ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                          $query->where('updated_at', '>=', $twentyFourHoursAgo);
                      });
              })
              ->whereBetween('fecha_hora_extra', [$startOfMonth, $endOfMonth])
              ->orderBy('created_at', 'desc')
              ->get();

           $asistencias = Asistencias::where('jefe_directo_id', auth()->user()->colaborador_id)->where('asistencia', '!=', 'Asistencia') ->whereBetween('fecha', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           
           return view('incidencias.incidencias_colab', compact('compensaciones','permisos','horasextra','asistencias','startOfMonth','endOfMonth','incapacidades','vacaciones'));
         

         }else {
           //$compensaciones = Gratificaciones::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_gratificacion', 'desc') ->get();
         $compensaciones = Gratificaciones::whereBetween('created_at', [$startOfMonth, $endOfMonth])
             ->where(function ($query) use ($twentyFourHoursAgo) {
                 $query->where('estatus', 'Pendiente')
                     ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                         $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                             ->where('updated_at', '>=', $twentyFourHoursAgo);
                     });
             })
             ->orderBy('fecha_gratificacion', 'desc')
             ->get();
           //$permisos = Permisos::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_permiso', 'desc') ->get();
           $permisos = Permisos::whereBetween('created_at', [$startOfMonth, $endOfMonth])
               ->where(function ($query) use ($twentyFourHoursAgo) {
                   $query->where('estatus', 'Aprobada Jefatura')
                       ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                           $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                               ->where('updated_at', '>=', $twentyFourHoursAgo);
                       });
               })
               ->orderBy('fecha_permiso', 'desc')
               ->get();


         $incapacidades = Incapacidad::whereBetween('created_at', [$startOfMonth, $endOfMonth])
             ->where(function ($query) use ($twentyFourHoursAgo) {
                 $query->where('estatus', 'Aprobada Jefatura')
                     ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                         $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                             ->where('updated_at', '>=', $twentyFourHoursAgo);
                     });
             })
             ->orderBy('apartir', 'desc')
             ->get();

             $vacaciones = Vacaciones::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                 ->where(function ($query) use ($twentyFourHoursAgo) {
                     $query->where('estatus', 'Aprobada Jefatura')
                         ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                             $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                                 ->where('updated_at', '>=', $twentyFourHoursAgo);
                         });
                 })
                 ->orderBy('desde', 'desc')
                 ->get();

           //$horasextra = HorasExtra::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_hora_extra', 'desc') ->get();
           $horasextra = HorasExtra::whereBetween('created_at', [$startOfMonth, $endOfMonth])
               ->where(function ($query) use ($twentyFourHoursAgo) {
                   $query->where('estatus', 'Pendiente')
                       ->orWhere(function ($query) use ($twentyFourHoursAgo) {
                           $query->whereIn('estatus', ['Aprobada', 'Rechazada'])
                               ->where('updated_at', '>=', $twentyFourHoursAgo);
                       });
               })
               ->orderBy('fecha_hora_extra', 'desc')
               ->get();

           $asistencias = Asistencias::where('asistencia', '!=', 'Asistencia') ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha', 'desc') ->get();

           $compensacionesPendientes = $compensaciones->where('estatus', 'Pendiente')->count();
           $permisosPendientes = $permisos->whereIn('estatus',['Pendiente', 'Aprobado Jefatura'])->count();
           $incapacidadesPendientes = $incapacidades->whereIn('estatus',['Pendiente', 'Aprobado Jefatura'])->count();
           $vacacionesPendientes = $vacaciones->whereIn('estatus',['Pendiente', 'Aprobado Jefatura'])->count();
           $horasExtraPendientes = $horasextra->where('estatus', 'Pendiente')->count();

           return view('incidencias.incidencias', compact('companies','compensaciones','permisos','horasextra','asistencias','startOfMonth','endOfMonth','incapacidades','vacaciones','compensacionesPendientes', 'permisosPendientes', 'horasExtraPendientes', 'incapacidadesPendientes', 'vacacionesPendientes'));
         
          }

      }


      public function showIncidenciasHistorico(Request $request)
       {
           $companies = Companies::all();
           // Obtener el primer y último día del mes actual
           $twentyFourHoursAgo = Carbon::now()->subHours(24);

           $startOfMonth = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
           $endOfMonth = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

          if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Jefatura') {
           $compensaciones = Gratificaciones::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_gratificacion', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           $permisos = Permisos::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_permiso', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           $incapacidades = Incapacidad::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('apartir', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           $horasextra = HorasExtra::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('fecha_hora_extra', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
           $vacaciones = Vacaciones::where('jefe_directo_id', auth()->user()->colaborador_id)->whereBetween('desde', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();

            $asistencias = Asistencias::where('jefe_directo_id', auth()->user()->colaborador_id)->where('asistencia', '!=', 'Asistencia') ->whereBetween('fecha', [$startOfMonth, $endOfMonth]) ->orderBy('created_at', 'desc') ->get();
            return view('incidencias.incidencias_jf', compact('companies','compensaciones','permisos','horasextra','asistencias','startOfMonth','endOfMonth','incapacidades','vacaciones'));
          }else {
            $compensaciones = Gratificaciones::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_gratificacion', 'desc') ->get();

            $permisos = Permisos::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_permiso', 'desc') ->get();

            $vacaciones = Vacaciones::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('desde', 'desc') ->get();

            $incapacidades = Incapacidad::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('apartir', 'desc') ->get();

            $horasextra = HorasExtra::whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_hora_extra', 'desc') ->get();


            $asistencias = Asistencias::where('asistencia', '!=', 'Asistencia') ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha', 'desc') ->get();

            $compensacionesPendientes = $compensaciones->where('estatus', 'Pendiente')->count();
            $permisosPendientes = $permisos->where('estatus', 'Pendiente')->count();
            $incapacidadesPendientes = $incapacidades->where('estatus', 'Pendiente')->count();
            $vacacionesPendientes = $vacaciones->where('estatus', 'Pendiente')->count();
            $horasExtraPendientes = $horasextra->where('estatus', 'Pendiente')->count();

            return view('incidencias.historico', compact('companies','compensaciones','permisos','horasextra','asistencias','startOfMonth','endOfMonth','incapacidades','vacaciones','compensacionesPendientes', 'permisosPendientes', 'horasExtraPendientes', 'incapacidadesPendientes', 'vacacionesPendientes'));
          }

       }


      public function vacaciones_pendientes(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'anteriores' => 'required|numeric',
        ]);

        // Obtener la información del colaborador
        $info = Colaboradores::where('id', $request->input('colaborador_id'))->first();

        // Calcular los años laborados
        $fechaAlta = new Carbon($info->fecha_alta);
        $anosLaborados = $fechaAlta->diffInYears(Carbon::now());
        $anosLaborados = min($anosLaborados, 35);
        // Obtener el aniversario del colaborador en el año actual
        $fechaAniversario = $fechaAlta->copy()->year(Carbon::now()->year);

        // Comprobar si el aniversario ya pasó en el año actual
        if (Carbon::now()->greaterThanOrEqualTo($fechaAniversario)) {
            // Obtener los días de vacaciones basados en los años laborados
            $diasVacaciones = DiasVacaciones::where('anio', Carbon::now()->year)
                ->where('anio_laborado', $anosLaborados)
                ->first();

            // Si no se encuentra información en DiasVacaciones, asignar 0
            $diasActuales = $diasVacaciones ? $diasVacaciones->dias_vacaciones : 0;


        } else {
            // Si el aniversario aún no ha pasado, asignar 0
            $diasActuales = 0;
        }

        // Crear un nuevo registro en la base de datos

        VacacionesPendientes::create([
            'company_id' => $info->company_id,
            'colaborador_id' => $request->input('colaborador_id'),
            'fecha_alta' => $info->fecha_alta,
            'anteriores' => $request->input('anteriores'),
            'actuales' => $diasActuales, // Número de días de vacaciones actuales
        ]);


        // Redirigir o devolver una respuesta
        return redirect('/vacaciones')->with('success', 'Vacaciones pendientes guardadas exitosamente.');
    }

    public function vacaciones_pendientes_update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'anteriores' => 'required|numeric',
            'actuales' => 'required|numeric',
        ]);

        // Obtener el registro de vacaciones pendientes
        $vacacion = VacacionesPendientes::findOrFail($id);

        // Actualizar los datos
        $vacacion->update([
            'colaborador_id' => $request->input('colaborador_id'),
            'anteriores' => $request->input('anteriores'),
            'actuales' => $request->input('actuales'),
        ]);

        // Redirigir o devolver una respuesta
        return redirect('/vacaciones')->with('success', 'Vacación pendiente actualizada exitosamente.');
    }

    public function vacaciones()
    {
        $companies = Companies::all();
        $vacaciones = VacacionesPendientes::all();
        $vacacionesPendientesIds = VacacionesPendientes::pluck('colaborador_id')->toArray();
        $colaboradores = Colaboradores::where('estatus', 'activo')
            ->whereNotIn('id', $vacacionesPendientesIds)
            ->get();

        return view('incidencias.vacaciones',compact('vacaciones','companies','colaboradores'));

    }

    public function getFechaAlta($colaboradorId)
    {
        $colaborador = Colaboradores::find($colaboradorId);

        if ($colaborador) {
            // Formatear la fecha en el formato Y-m-d
            $fechaAlta = $colaborador->fecha_alta->format('Y-m-d');

            return response()->json([
                'fecha_alta' => $fechaAlta,
            ]);
        }

        return response()->json(['error' => 'Colaborador no encontrado'], 404);
    }



    public function buscarDiasVacaciones(Request $request){

      $colaborador_id=$request->colaborador_id;

      $colaboradorinfo = Colaboradores::where('id', '12')->first();

      $anios_laborados=anios_laborados($colaboradorinfo->fecha_alta);


      // Esto es un ejemplo, debes obtener el valor real
        $anio_actual = date('Y'); // Año actual

        // Obtén los registros relevantes de la tabla DiasVacaciones
        $diasVacaciones = DiasVacaciones::where('anio', $anio_actual)
            ->where('anio_laborado', '<=', $anios_laborados)
            ->orderBy('anio_laborado', 'desc')
            ->first();

        if ($diasVacaciones) {
            $diasDeVacaciones = $diasVacaciones->dias_vacaciones;
            //return $diasDeVacaciones;
        } else {

          $diasDeVacaciones=0;
            // Si no se encontró una coincidencia en la tabla, puedes manejarlo de la manera que desees
          //  return 'No se encontró la información correspondiente en la tabla de días de vacaciones.';
        }

      return $diasDeVacaciones;

    }

    public function solicitar_vacaciones()
    {

      $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $centro=CentrodeCostos::where('centro_de_costos',$info->organigrama)->first();

      $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
      $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
      $colaboradores = Colaboradores::whereIn('id', $colaboradorIds)
      ->where('estatus', 'activo')
      ->get();



      return view('incidencias.crear_vacaciones' , ['colaboradores' => $colaboradores ]);

    }


    public function guardar_vacaciones(Request $request)
    {

      $info=Colaboradores::where('id',$request->colaborador_id)->first();

      $cc=CentrodeCostos::where('centro_de_costos' , $info->organigrama)->first();

      $estatus='Pendiente';
      $jf=auth()->user()->colaborador_id;
      if(auth()->user()->perfil=='Colaborador'){
        $estatus='Solicitud';
        $jf=jefedirecto($request->colaborador_id,$info->company_id);
      }

      $create2=new Vacaciones();
      $create2->company_id=$info->company_id;
      $create2->colaborador_id=$request->colaborador_id;
      $create2->jefe_directo_id=$jf;
      $create2->cc=$cc->id;
      $create2->fecha_solicitud=date('Y-m-d');
      $create2->desde=$request->fecha_inicio;
      $create2->hasta=$request->fecha_fin;
      $create2->estatus=$estatus;
      $create2->autorizo='';
      $create2->comentarios=$request->comentarios;
      $create2->otro='';
      $create2->anio=date('Y');
      $create2->save();



      if (auth()->user()->perfil != 'Colaborador') {
        Notificaciones::create([
            'email' => emailnomina(),
            'tipo' => 'success',
            'ruta' => '/incidencias',
            'fecha' => now(),
            'texto' => 'Solicitud de vacaciones de ' . qcolab($request->colaborador_id),
            'abierto' => '0',
        ]);
    }
    
      
      return redirect ('/incidencias');


    }


    public function vervacaciones($id){

      $vacacion=Vacaciones::where('id',$id)->first();

      $colaborador_id=$vacacion->colaborador_id;

      $colaboradorinfo = Colaboradores::where('id', '12')->first();

      $anios_laborados=anios_laborados($colaboradorinfo->fecha_alta);


      // Esto es un ejemplo, debes obtener el valor real
        $anio_actual = date('Y'); // Año actual

        // Obtén los registros relevantes de la tabla DiasVacaciones
        $diasVacaciones = DiasVacaciones::where('anio', $anio_actual)
            ->where('anio_laborado', '<=', $anios_laborados)
            ->orderBy('anio_laborado', 'desc')
            ->first();

        if ($diasVacaciones) {
            $diasDeVacaciones = $diasVacaciones->dias_vacaciones;
            //return $diasDeVacaciones;
        } else {

          $diasDeVacaciones=0;
            // Si no se encontró una coincidencia en la tabla, puedes manejarlo de la manera que desees
          //  return 'No se encontró la información correspondiente en la tabla de días de vacaciones.';
        }

      return view ('incidencias.ver_vacaciones' , compact('vacacion' , 'diasDeVacaciones'));

    }

    public function validarVacaciones(Request $request){

      $estatus=$request->estatus;
      $idvacacion=$request->idvacacion;



      for ($i=0; $i <count($idvacacion) ; $i++) {
        Vacaciones::where('id',$idvacacion[$i])->update([
            'estatus' => $estatus[$i] ,
            'autorizo' => auth()->user()->id
        ]);

        $info=Vacaciones::where('id',$idvacacion[$i])->first();
        $userinfo=User::where('colaborador_id',$info->jefe_directo_id)->first();

        if ($estatus[$i]=='Aprobada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Vacaciones de '.qcolab($info->colaborador_id).' aprobadas',
                'abierto' => '0',
              ]);
        }elseif ($estatus[$i]=='Rechazada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'danger',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Vacaciones de '.qcolab($info->colaborador_id).' rechazadas',
                'abierto' => '0',
              ]);
        }

      }

     return redirect ('/incidencias');

    }


    public function horas_extra()
    {
        if(auth()->user()->rol=='Jefatura'){
          $horas_extra=HorasExtra::where('jefe_directo_id' , auth()->user()->colaborador_id)->orderBy('fecha_solicitud', 'asc')->get();
          return view('incidencias.horas_extra' , ['horas_extra' => $horas_extra]);
        }
        elseif (auth()->user()->rol=='Nómina') {
          $horas_extra=HorasExtra::orderBy('fecha_solicitud', 'asc')->get();
          return view('incidencias.horas_extra_nomina' , ['horas_extra' => $horas_extra]);
        }
    }



    public function capturar_horas_extra(){


      // Obtener la fecha de hoy
      $hoy = Carbon::now();

      // Iniciar un contador de días hábiles
      $diasHabiles = 0;

      // Definir cuántos días hábiles quieres restar (en este caso, 2 días)
      $numeroDiasHabiles = 2;

      // Realizar un bucle para restar días hábiles
      while ($diasHabiles < $numeroDiasHabiles) {
          // Restar 1 día a la fecha de hoy
          $hoy->subDay();

          // Verificar si el día actual no es un fin de semana (sábado o domingo)
          if ($hoy->dayOfWeek !== Carbon::SATURDAY && $hoy->dayOfWeek !== Carbon::SUNDAY) {
              // Si no es un fin de semana, aumentar el contador de días hábiles
              $diasHabiles++;
          }
      }

      // Quitar las horas y dejar solo la fecha
      $fechaDosDiasHabilesAtras = str_replace(' 00:00:00','',$hoy->startOfDay());

      $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $centro=CatalogoCentrosdeCostos::where('centro_de_costo',$info->organigrama)->first();

      $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
      $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
      $colaboradores = Colaboradores::whereIn('id', $colaboradorIds)
      ->where('estatus', 'activo')
      ->get();


      return view('incidencias.incidencias_jf' , ['colaboradores' => $colaboradores , 'fechaDosDiasHabilesAtras' => $fechaDosDiasHabilesAtras]);
    }


    public function guardar_horas_extras(Request $request){

        $colaboradorIds = $request->input('colaborador_id');
        $fechas = $request->input('fecha');
        $horas = $request->input('horas');
        $montos = $request->input('monto');
        $comentarios = $request->input('comentarios');

        foreach ($colaboradorIds as $key => $colaboradorId) {
        $fecha = $fechas[$key];
        $hora = $horas[$key];
        $comentario = $comentarios[$key];
      //  $monto = $montos[$key];
        $colaborador_id = $colaboradorIds[$key];

          if ($hora && $fecha) {

            $info=Colaboradores::where('id',$colaboradorIds[$key])->first();

            $cc=CentrodeCostos::where('centro_de_costos' , $info->organigrama)->first();

            $create2=new HorasExtra();
            $create2->company_id=$info->company_id;
            $create2->colaborador_id=$colaboradorIds[$key];
            $create2->jefe_directo_id=auth()->user()->colaborador_id;
            $create2->cc=$cc->id;
            $create2->fecha_solicitud=date('Y-m-d');
            $create2->fecha_hora_extra=$fechas[$key];
            $create2->cantidad=$horas[$key];
            $create2->monto='0';
            $create2->estatus='Pendiente';
            $create2->autorizo='';
            $create2->comentarios=$comentarios[$key];
            $create2->otro='';
            $create2->anio=date('Y');
            $create2->save();


            Notificaciones::create([
                  'email' => emailnomina(),
                  'tipo' => 'success',
                  'ruta' => '/incidencias',
                  'fecha' => now(),
                  'texto' => 'Solictud de Horas Extra',
                  'abierto' => '0',
                ]);
          }

        }

        return redirect('/incidencias')->with('success', 'Incidencia capturada');

    }


    public function validarHorasExtra(Request $request){

      $estatus=$request->estatus;
      $idhoraextra=$request->idhoraextra;


      for ($i=0; $i <count($idhoraextra) ; $i++) {
        HorasExtra::where('id',$idhoraextra[$i])->update([
            'estatus' => $estatus[$i] ,
            'autorizo' => auth()->user()->id
        ]);


        $info=HorasExtra::where('id',$idhoraextra[$i])->first();
        $userinfo=User::where('colaborador_id',$info->jefe_directo_id)->first();

        if ($estatus[$i]=='Aprobada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Horas extra aprobadas',
                'abierto' => '0',
              ]);
        }elseif ($estatus[$i]=='Rechazada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'danger',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Horas extra rechazadas',
                'abierto' => '0',
              ]);
        }


    }

    return redirect('/incidencias')->with('success', 'Incidencia validada');

  }


    public function asistencias()
    {
      if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Jefatura') {
        $asistencias = Asistencias::where('jefe_directo_id', auth()->user()->colaborador_id)
        ->whereDate('fecha', Carbon::today())
        ->where('asistencia', '!=' ,'Asistencia')
        ->orderBy('fecha', 'desc')
        ->get();
      }else {
        $asistencias = Asistencias::where('asistencia', '!=' ,'Asistencia')
        ->orderBy('fecha', 'desc')
        ->get();
      }

      return view('incidencias.incidencias_jf' , ['asistencias' => $asistencias]);
    }

    public function capturar_asistencias(){

      $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $centro=CatalogoCentrosdeCostos::where('centro_de_costo',$info->organigrama)->first();

      $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
      $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
      $colaboradores = Colaboradores::whereIn('id', $colaboradorIds)
      ->where('estatus', 'activo')
      ->get();


      return view('incidencias.crear_asistencias' , ['colaboradores' => $colaboradores]);
    }

    public function guardar_asistencias(Request $request){

        $colaboradorIds = $request->input('colaborador_id');
        $fechas = $request->input('fecha');
        $asistencias = $request->input('asistencia');
        $comentarios = $request->input('comentarios');


        foreach ($colaboradorIds as $key => $colaboradorId) {
        $fecha = $fechas[$key];
        $asistencia = $asistencias[$key];
        $colaborador_id = $colaboradorIds[$key];
        $comentario = $comentarios[$key];



            $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();

            $cc=CatalogoCentrosdeCostos::where('centro_de_costo' , $info->organigrama)->first();
            if ($asistencia!='Asistencia') {
              $create2=new Asistencias();
              $create2->company_id=$info->company_id;
              $create2->colaborador_id=$colaboradorIds[$key];
              $create2->jefe_directo_id=auth()->user()->colaborador_id;
              $create2->cc=$cc->id;
              $create2->fecha=$fechas[$key];
              $create2->hora=date('Y-m-d');
              $create2->asistencia=$asistencias[$key];
              $create2->estatus='Capturada';
              $create2->autorizo=auth()->user()->colaborador_id;
              $create2->comentarios=$comentario;
              $create2->otro='';
              $create2->anio=date('Y');
              $create2->save();
            }


        }

        return redirect('/incidencias')->with('success', 'Incidencia capturada');

    }

    public function gratificaciones()
    {

      if (auth()->user()->rol=='Jefatura') {
        $gratificaciones=Gratificaciones::where('jefe_directo_id',auth()->user()->colaborador_id)->orderBy('fecha_solicitud', 'desc')->get();
        return view('incidencias.gratificaciones' , ['gratificaciones' => $gratificaciones]);
      }

      if (auth()->user()->rol=='Nómina') {
        $gratificaciones=Gratificaciones::orderBy('fecha_solicitud', 'desc')->get();
        return view('incidencias.gratificaciones_nomina' , ['gratificaciones' => $gratificaciones]);
      }

    }


    public function capturar_gratificaciones()
    {

      $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $centro=CatalogoCentrosdeCostos::where('centro_de_costo',$info->organigrama)->first();


      $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
      $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
      $colaboradores = Colaboradores::where('organigrama', $centro->centro_de_costo)
      ->where('estatus', 'activo')
      ->get();
        return view('incidencias.crear_gratificaciones' , ['colaboradores' => $colaboradores]);
    }

    public function guardar_gratificaciones(Request $request)
    {


      $info=Colaboradores::where('id',$request->colaborador_id)->first();

      $cc=CentrodeCostos::where('centro_de_costos' , $info->organigrama)->first();

      $create2=new Gratificaciones();
      $create2->company_id=$info->company_id;
      $create2->colaborador_id=$request->colaborador_id;
      $create2->jefe_directo_id=auth()->user()->colaborador_id;
      $create2->cc=$cc->id;
      $create2->fecha_solicitud=date('Y-m-d');
      $create2->fecha_gratificacion=$request->fecha_gratificacion;
      $create2->cantidad='0';
      $create2->monto=$request->monto;
      $create2->estatus='Pendiente';
      $create2->autorizo='';
      $create2->comentarios=$request->comentarios;
      $create2->otro='';
      $create2->anio=date('Y');
      $create2->save();


      Notificaciones::create([
            'email' => emailnomina(),
            'tipo' => 'success',
            'ruta' => '/incidencias',
            'fecha' => now(),
            'texto' => 'Solictud de Gratificaciones',
            'abierto' => '0',
          ]);

      return redirect('/incidencias')->with('success', 'Incidencia capturada');


    }

    public function validarGratificaciones(Request $request){

      $estatus=$request->estatus;
      $idgratificacion=$request->idgratificacion;


      for ($i=0; $i <count($idgratificacion) ; $i++) {
        Gratificaciones::where('id',$idgratificacion[$i])->update([
            'estatus' => $estatus[$i] ,
            'autorizo' => auth()->user()->id
        ]);


        $info=Gratificaciones::where('id',$idgratificacion[$i])->first();
        $userinfo=User::where('colaborador_id',$info->jefe_directo_id)->first();

        if ($estatus[$i]=='Aprobada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Gratificaciones aprobadas',
                'abierto' => '0',
              ]);
        }elseif ($estatus[$i]=='Rechazada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'danger',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Gratificaciones rechazadas',
                'abierto' => '0',
              ]);
        }

      }

      return redirect('/incidencias')->with('success', 'Incidencia validada');


    }



    public function permisos()
    {

      if (auth()->user()->rol=='Jefatura') {
        $permisos=Permisos::where('jefe_directo_id',auth()->user()->colaborador_id)->orderBy('fecha_solicitud', 'desc')->get();
        return view('incidencias.permisos' , ['permisos' => $permisos]);
      }

      if (auth()->user()->rol=='Nómina') {
        $permisos=Permisos::orderBy('fecha_solicitud', 'desc')->get();
        return view('incidencias.permisos_nomina' , ['permisos' => $permisos]);
      }

    }


    public function capturar_permisos()
    {

      $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $centro=CatalogoCentrosdeCostos::where('centro_de_costo',$info->organigrama)->first();


      $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
      $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
      $colaboradores = Colaboradores::where('organigrama', $centro->centro_de_costo)
      ->where('estatus', 'activo')
      ->get();
        return view('incidencias.crear_permisos' , ['colaboradores' => $colaboradores]);
    }

    public function guardar_permisos(Request $request)
    {


      $info=Colaboradores::where('id',$request->colaborador_id)->first();

      $cc=CentrodeCostos::where('centro_de_costos' , $info->organigrama)->first();

      $estatus='Pendiente';
      $jf=auth()->user()->colaborador_id;
      $permiso=$request->tipo ?? 'Pendiente';
      if(auth()->user()->perfil=='Colaborador'){
        $estatus='Solicitud';
        $jf=jefedirecto($request->colaborador_id,$info->company_id);
        $permiso='Pendiente';
      }

      $create2=new Permisos();
      $create2->company_id=$info->company_id;
      $create2->colaborador_id=$request->colaborador_id;
      $create2->jefe_directo_id=$jf;
      $create2->cc=$cc->id;
      $create2->fecha_solicitud=date('Y-m-d');
      $create2->fecha_permiso=$request->fecha_permiso;
      $create2->cantidad='0';
      $create2->tipo=$permiso;
      $create2->estatus=$estatus;
      $create2->autorizo='';
      $create2->comentarios=$request->comentarios;
      $create2->anio=date('Y');
      $create2->save();


      if (auth()->user()->perfil != 'Colaborador') {
      Notificaciones::create([
            'email' => emailnomina(),
            'tipo' => 'success',
            'ruta' => '/incidencias',
            'fecha' => now(),
            'texto' => 'Solictud de Permisos',
            'abierto' => '0',
          ]);
      }

      return redirect('/incidencias')->with('success', 'Incidencia capturada');



    }

    public function validarPermisos(Request $request){

      $estatus=$request->estatus;
      $tipo=$request->tipo;
      $idpermiso=$request->idpermiso;


      for ($i=0; $i <count($idpermiso) ; $i++) {
        Permisos::where('id',$idpermiso[$i])->update([
            'estatus' => $estatus[$i] ,
            'tipo' => $tipo[$i] ,
            'autorizo' => auth()->user()->id
        ]);


        $info=Permisos::where('id',$idpermiso[$i])->first();
        $userinfo=User::where('colaborador_id',$info->jefe_directo_id)->first();

        if ($estatus[$i]=='Aprobada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Permiso aprobado',
                'abierto' => '0',
              ]);
        }elseif ($estatus[$i]=='Rechazada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'danger',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Permiso rechazado',
                'abierto' => '0',
              ]);
        }

      }

      return redirect('/incidencias')->with('success', 'Incidencia validada');


    }


    public function getVacaciones($id)
    {
        // Busca las vacaciones del colaborador
        $vacaciones = VacacionesPendientes::where('colaborador_id', $id)->first();

        // Si encuentra un registro, suma anteriores y actuales, sino retorna 0
        if ($vacaciones) {
            $dias = $vacaciones->anteriores + $vacaciones->actuales;
        } else {
            $dias = 0;
        }

        // Retorna el número de días como respuesta JSON
        return response()->json(['dias' => $dias]);
    }



    public function guardar_incapacidades(Request $request)
    {
        $request->validate([
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validación del archivo
        ]);

        $info = Colaboradores::where('id', $request->colaborador_id)->first();
        $cc = CentrodeCostos::where('centro_de_costos', $info->organigrama)->first();

        $estatus = 'Pendiente';
        $jf = auth()->user()->colaborador_id;
        if (auth()->user()->perfil == 'Colaborador') {
            $estatus = 'Solicitud';
            $jf = jefedirecto($request->colaborador_id, $info->company_id);
        }

        $create2 = new Incapacidad();
        $create2->company_id = $info->company_id;
        $create2->colaborador_id = $request->colaborador_id;
        $create2->jefe_directo_id = $jf;
        $create2->cc = $cc->id;
        $create2->apartir = $request->apartir;
        $create2->expedido = $request->expedido;
        $create2->dias = $request->dias;
        $create2->estatus = $estatus;
        $create2->autorizo = '';
        $create2->comentarios = $request->comentarios;
        $create2->otro = '';
        $create2->anio = date('Y');

        // Manejo del archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoPath = $archivo->store('incapacidades', 'public'); // Guarda en la carpeta "storage/app/public/incapacidades"
            $create2->archivo = $archivoPath; // Guarda la ruta del archivo en la base de datos
        }

        $create2->save();

        if (auth()->user()->perfil != 'Colaborador') {
            Notificaciones::create([
                'email' => emailnomina(),
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Solicitud de Incapacidad',
                'abierto' => '0',
            ]);
        }

        return redirect('/incidencias')->with('success', 'Incidencia capturada');
    }


    public function validarIncapacidades(Request $request){

      $estatus=$request->estatus;
      $idincapacidad=$request->idincapacidad;


      for ($i=0; $i <count($idincapacidad) ; $i++) {
        Incapacidad::where('id',$idincapacidad[$i])->update([
            'estatus' => $estatus[$i] ,
            'autorizo' => auth()->user()->id
        ]);


        $info=Incapacidad::where('id',$idincapacidad[$i])->first();
        $userinfo=User::where('colaborador_id',$info->jefe_directo_id)->first();

        if ($estatus[$i]=='Aprobada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'success',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Incapacidad aprobada',
                'abierto' => '0',
              ]);
        }elseif ($estatus[$i]=='Rechazada') {
          Notificaciones::create([
                'email' => $userinfo->email,
                'tipo' => 'danger',
                'ruta' => '/incidencias',
                'fecha' => now(),
                'texto' => 'Incapacidad rechazada',
                'abierto' => '0',
              ]);
        }

      }

      return redirect('/incidencias')->with('success', 'Incidencia validada');


    }





}
