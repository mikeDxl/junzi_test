<?php


namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Proyecto;
use App\Models\Colaboradores;
use App\Models\Vacaciones;
use App\Models\Permisos;
use App\Models\Incapacidad;
use App\Models\Vacantes;
use App\Models\Bajas;
use App\Models\Altas;
use App\Models\Procesos;
use App\Models\ProcesoRH;
use App\Models\User;
use App\Models\Hallazgos;
use Auth;
use Carbon;

use Illuminate\Http\Request;

class CalendarioController extends Controller
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
     public function calendar(Request $request)
     {
       $eventos = [];

       $filtro = $request->input('filtro', 'todo');
       $colaboradorId = auth()->user()->colaborador_id;

        $pattern = "%,".$colaboradorId.",%";
        $pattern2 = $colaboradorId.",%";
        $pattern3 = "%,".$colaboradorId;
        $pattern4 = $colaboradorId;

        $hallazgos = Hallazgos::where(function ($query) use ($colaboradorId, $pattern, $pattern2, $pattern3, $pattern4) {
            $query->where('responsable', 'like', $pattern)
                  ->orWhere('responsable', 'like', $pattern2)
                  ->orWhere('responsable', 'like', $pattern3)
                  ->orWhere('responsable', '=', $pattern4);
        })->get();


       if (auth()->user()->rol=='Jefatura') {

        $colaboradorInfo=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
        

         $entrevistas = ProcesoRH::whereNotNull('entrevista2_fecha')
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();


          $bajas = Bajas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();



           $altas = Altas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();



       }elseif (auth()->user()->rol=='Nómina') {
         $entrevistas = ProcesoRH::whereNotNull('entrevista2_fecha')
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();


          $bajas = Bajas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();



           $altas = Altas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();

       }elseif(auth()->user()->rol=='Reclutamiento') {
         $entrevistas = ProcesoRH::whereNotNull('entrevista2_fecha')
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();


          $bajas = Bajas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();



           $altas = Altas::query()
           ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
               return $query->where('company_id', session('company_active_id'));
           })
           ->get();
       }


         if (auth()->user()->perfil=='Colaborador') {
           $vacaciones = Vacaciones::where('estatus', 'Aprobada')->where('colaborador_id',auth()->user()->colaborador_id)->get();
           $permisos = Permisos::where('estatus', 'Aprobada')->get();
           $incapacidades = Permisos::where('estatus', 'Aprobada')->get();
         }elseif (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Jefatura') {
           $vacaciones = Vacaciones::where('estatus', 'Aprobada')->where('jefe_directo_id',auth()->user()->colaborador_id)->get();
           $permisos = Permisos::where('estatus', 'Aprobada')->where('jefe_directo_id', auth()->user()->colaborador_id)->get();
           $incapacidades = Incapacidad::where('estatus', 'Aprobada')->where('jefe_directo_id', auth()->user()->colaborador_id)->get();
         }else {
           $vacaciones = Vacaciones::where('estatus', 'Aprobada')->get();
           $permisos = Permisos::where('estatus', 'Aprobada')->get();
           $incapacidades = Incapacidad::where('estatus', 'Aprobada')->get();
         }



         if (auth()->user()->perfil!='Colaborador') {
           foreach ($entrevistas as $entrevista) {
               $evento = [
                   'title' => 'Entrevista',
                   'start' => $entrevista->entrevista2_fecha,
                   'end' => Carbon\Carbon::parse($entrevista->entrevista2_fecha)->addMinutes(30)->format('Y-m-d H:i:s'),
                   'url' => 'proceso_vacante/' . $entrevista->vacante_id.'/'.$entrevista->candidato_id.'/2',
                   'color' => 'green', // Color para entrevistas
               ];

               $eventos[] = $evento;
           }

           foreach ($altas as $alta) {
               $evento = [
                   'title' => 'Alta Colaborador',
                   'start' => $alta->fecha_alta,
                   'end' => $alta->fecha_alta,
                   'url' => '/terminaralta/'.$alta->id,
                   'color' => 'orange', // Color para altas
               ];

               $eventos[] = $evento;
           }

           foreach ($bajas as $baja) {
               $evento = [
                   'title' => 'Baja Colaborador ' . qcolab($baja->colaborador_id),
                   'start' => $baja->fecha_baja,
                   'end' => $baja->fecha_baja,
                   'url' => '/baja/' . $baja->id,
                   'color' => 'red', // Color para bajas
               ];

               $eventos[] = $evento;
           }
         }

         foreach ($hallazgos as $hallazgo) {
          $evento = [
              'title' => 'Hallazgo',
              'start' => $hallazgo->fecha_compromiso,
              'end' => $hallazgo->fecha_compromiso,
              'url' => '/hallazgo'.'/'.$hallazgo->id.'/edit',
              'color' => 'blue', // Color para vacaciones
          ];

          $eventos[] = $evento;
      }


         foreach ($vacaciones as $vacacion) {
             $evento = [
                 'title' => 'Vacaciones de ' . qcolab($vacacion->colaborador_id),
                 'start' => $vacacion->desde,
                 'end' => $vacacion->hasta,
                 'url' => '/incidecnias',
                 'color' => 'blue', // Color para vacaciones
             ];

             $eventos[] = $evento;
         }

         foreach ($permisos as $permiso) {
             $evento = [
                 'title' => 'Permiso de ' . qcolab($permiso->colaborador_id),
                 'start' => $permiso->fecha_permiso,
                 'end' => $permiso->fecha_permiso,
                 'url' => '/incidecnias',
                 'color' => 'blue', // Color para vacaciones
             ];

             $eventos[] = $evento;
         }


         foreach ($incapacidades as $incapacidad) {

           $fechaFin = calcularFechaFin($incapacidad->apartir, $incapacidad->dias);

             $evento = [
                 'title' => 'Incapacidad de ' . qcolab($incapacidad->colaborador_id),
                 'start' => $incapacidad->apartir,
                 'end' => $fechaFin,
                 'url' => '/incidecnias',
                 'color' => 'blue', // Color para vacaciones
             ];

             $eventos[] = $evento;
         }


         return view('pages.calendar', compact('eventos', 'filtro'));
     }



    public function filtro(Request $request)
    {
      $filtro=$request->filtro;
      $eventos = [];

      if($request->filtro=='todo'){ return redirect('/calendar'); }

      if ($request->filtro=='entrevistas') {

        if (auth()->user()->perfil=='Jefatura' || auth()->user()->rol=='Reclutamiento') {
          $entrevistas = ProcesoRH::whereNotNull('entrevista2_fecha')
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();
        }

        foreach ($entrevistas as $entrevista) {
            $evento = [
                'title' => 'Entrevista',
                'start' => $entrevista->entrevista2_fecha,
                'end' => Carbon\Carbon::parse($entrevista->entrevista2_fecha)->addMinutes(30)->format('Y-m-d H:i:s'),
                'url' => 'proceso_vacante/' . $entrevista->vacante_id.'/'.$entrevista->candidato_id.'/2',
                'color' => 'green', // Color para entrevistas
            ];

            $eventos[] = $evento;
        }
      }


      if($request->filtro=='bajas'){
        if (auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Director' || auth()->user()->perfil=='Jefatura') {
          $bajas = Bajas::query()
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();
        }
        foreach ($bajas as $baja) {

              $evento = [
                  'title' => 'Baja Colaborador '.qcolab($baja->colaborador_id),
                  'start' => $baja->fecha_baja,
                  'end' => $baja->fecha_baja,
                  'url' => '/baja/' . $baja->id,
                  'color' => 'red', // Color para bajas
              ];

              $eventos[] = $evento;
          }
      }


      if ($request->filtro=='vacaciones') {
        if (auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Jefatura') {
          $vacaciones = Vacaciones::where('estatus', 'Aprobada')
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();
        }else {
          $incapacidades = Vacaciones::where('estatus', 'Aprobada')->where('colaborador_id',auth()->user()->colaborador_id)->get();
        }

        foreach ($vacaciones as $vacacion) {
            $evento = [
                'title' => 'Vacaciones de '.qcolab($vacacion->colaborador_id),
                'start' => $vacacion->desde, // Fecha de inicio
                'end' => $vacacion->hasta,   // Fecha de fin
                'url' => '/vacacion/'.$vacacion->id,
                'color' => 'blue', // Color para vacaciones
            ];

            $eventos[] = $evento;
        }
      }



      if ($request->filtro=='ingresos') {
        if (auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Jefatura') {
          $altas = Altas::query()
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();

        }

        foreach ($altas as $alta) {
            $evento = [
                'title' => 'Alta Colaborador',
                'start' => $alta->fecha_alta, // Fecha de inicio
                'end' => $alta->fecha_alta,   // Fecha de fin (puede ser igual a la fecha de inicio)
                'url' => '/colaboradores',
                'color' => 'orange', // Color para altas
            ];

            $eventos[] = $evento;
        }
      }


      if ($request->filtro=='incapacidades') {
        if (auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Jefatura') {
          $incapacidades = Incapacidad::query()
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();

        }else {
          $incapacidades = Incapacidad::where('estatus', 'Aprobada')->where('colaborador_id',auth()->user()->colaborador_id)->get();
        }


        foreach ($incapacidades as $incapacidad) {

          $fechaFin = calcularFechaFin($incapacidad->apartir, $incapacidad->dias);

            $evento = [
                'title' => 'Incapacidad de ' . qcolab($incapacidad->colaborador_id),
                'start' => $incapacidad->apartir,
                'end' => $fechaFin,
                'url' => '/incidecnias',
                'color' => 'blue', // Color para vacaciones
            ];

            $eventos[] = $evento;
        }
      }


      if ($request->filtro=='permisos') {
        if (auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Jefatura') {
          $permisos = Permisos::query()
          ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
              return $query->where('company_id', session('company_active_id'));
          })
          ->get();


        }else {
          $permisos = Permisos::where('estatus', 'Aprobada')->where('colaborador_id',auth()->user()->colaborador_id)->get();
        }

        foreach ($permisos as $permiso) {
            $evento = [
                'title' => 'Permiso de ' . qcolab($permiso->colaborador_id),
                'start' => $permiso->fecha_permiso,
                'end' => $permiso->fecha_permiso,
                'url' => '/incidecnias',
                'color' => 'blue', // Color para vacaciones
            ];

            $eventos[] = $evento;
        }
      }

       if ($request->filtro=='hallazgos') {
        $colaboradorId = auth()->user()->colaborador_id;

        $pattern = "%,".$colaboradorId.",%";
        $pattern2 = $colaboradorId.",%";
        $pattern3 = "%,".$colaboradorId;
        $pattern4 = $colaboradorId;

        $hallazgos = Hallazgos::where(function ($query) use ($colaboradorId, $pattern, $pattern2, $pattern3, $pattern4) {
            $query->where('responsable', 'like', $pattern)
                  ->orWhere('responsable', 'like', $pattern2)
                  ->orWhere('responsable', 'like', $pattern3)
                  ->orWhere('responsable', '=', $pattern4);
        })->get();
        
         foreach ($hallazgos as $hallazgo) {
          $evento = [
              'title' => 'Hallazgo',
              'start' => $hallazgo->fecha_compromiso,
              'end' => $hallazgo->fecha_compromiso,
              'url' => '/hallazgo'.'/'.$hallazgo->id.'/edit',
              'color' => 'blue', // Color para vacaciones
          ];

          $eventos[] = $evento;
      }

      }

      return view('pages.calendar' , compact('eventos' , 'filtro'));

    }


}
