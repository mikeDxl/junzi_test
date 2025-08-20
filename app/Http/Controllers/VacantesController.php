<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacantesRequest;
use App\Http\Requests\UpdateVacantesRequest;
use App\Models\Candidatos;
use App\Models\Companies;
use App\Models\Altas;
use App\Models\Colaboradores;
use App\Models\Departamentos;
use App\Models\Entrevistas;
use App\Models\FormulariosEncuestas;
use App\Models\FormularioVacantes;
use App\Models\PerfilPuestos;
use App\Models\Procesos;
use App\Models\User;
use App\Models\Notificaciones;
use App\Models\Reclutamientos;
use App\Models\RespuestasEncuestas;
use App\Models\Vacantes;
use App\Models\Motivos;
use App\Models\ProcesoRH;
use App\Models\OrganigramaLinealNiveles;
use App\Models\OrganigramaLineal;
use App\Models\Conexiones;
use App\Models\RegistroPatronal;
use App\Models\CentrodeCostos;
use App\Models\CatalogosdeTiposdeContratos;
use App\Models\CatalogosdeTiposdePeriodo;
use App\Models\CatalogosdeTiposdeBasedeCotizacion;
use App\Models\CatalogosdeTiposdePrestacion;
use App\Models\CatalogosdeTiposdeTurnodeTrabajo;
use App\Models\CatalogosdeTiposdeBasedePago;
use App\Models\CatalogosdeTiposdeMetododePago;
use App\Models\CatalogosdeTiposdeRegimen;
use App\Models\CatalogosdeTiposdeJornada;
use App\Models\CatalogosdeTiposdeZonadeSalario;
use App\Models\EstadoCivil;
use App\Models\Afores;
use App\Models\Familiares;
use App\Models\Agrupadores;
use App\Models\TiposdeTurnodeTrabajo;
use App\Models\TiposdePeriodo;
use App\Models\Estados;
use App\Models\Bancos;
use App\Models\Generos;
use App\Models\Externos;
use App\Models\Bajas;
use App\Models\Solicitudes;
use App\Models\OrganigramaMatricial;
use App\Models\PreguntaReclutamiento;
use App\Models\TiposdeSolicitudes;
use App\Models\TiposdeDocumentos;
use App\Models\CatalogoDepartamentos;
use App\Models\CatalogoPuestos;
use App\Models\CatalogoCentrosdeCostos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\CorreoNotificaciones;
use Illuminate\Support\Facades\Mail;


class VacantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function prioridad(Request $request)
    {
        $vacante_id = $request->input('vacante_id');
        $proceso_id = $request->input('proceso_id');
        $candidato_id = $request->input('candidato_id');
        $prioridades = $request->input('prioridad');
        $idcands = $request->input('idcand');

        // Iterar sobre los candidatos y actualizar sus prioridades
        for ($i = 0; $i < count($idcands); $i++) {
            $idcand = $idcands[$i];
            $prioridad = $prioridades[$i];

            ProcesoRH::where('vacante_id', $vacante_id)
                ->where('id', $proceso_id)
                ->where('candidato_id', $idcand)
                ->update(['prioridad' => $prioridad]);
        }

        // Redirigir o devolver una respuesta adecuada
        return redirect('proceso_vacante/'.$proceso_id.'/'.$candidato_id.'/3');
    }


    public function calificar(Request $request)
    {
        $actionType = $request->input('actionType');
        // Obtener los datos del formulario
        $preguntas = $request->pregunta;
        $valoraciones = $request->valoracion;
        $vacante_id = $request->vacante_id;
        $candidato_id = $request->candidato_id;
        $company_id = $request->company_id;
        $etapa = $request->etapa;
        $perfil = $request->perfil;
        // Buscar si ya existen registros para este candidato, vacante y empresa
        $preguntasReclutamiento = PreguntaReclutamiento::where('id_vacante', $vacante_id)
            ->where('id_candidato', $candidato_id)
            ->where('company_id', $company_id)
            ->where('etapa', $etapa)
            ->where('perfil', $perfil)
            ->get();

            if ($preguntasReclutamiento->isEmpty()) {
                // No existen registros, así que creamos nuevos
                foreach ($preguntas as $key => $pregunta) {
                    PreguntaReclutamiento::create([
                        'pregunta' => $pregunta,
                        'valoracion' => $valoraciones[$key],
                        'id_vacante' => $vacante_id,
                        'id_candidato' => $candidato_id,
                        'company_id' => $company_id,
                        'etapa' => $etapa,
                        'perfil' => $perfil ?? 'Jefatura',
                    ]);
                }
            } else {
                for ($i = 0; $i < count($preguntasReclutamiento); $i++) {
                    $preguntaReclutamiento = $preguntasReclutamiento[$i];
                    $preguntaReclutamiento->update([
                        'pregunta' => $preguntas[$i],
                        'valoracion' => $valoraciones[$i]
                    ]);
                }
            }


        $idetapa=0;

        if ($etapa=='Curriculum') {
          $idetapa=0;
        }else {
          $idetapa=2;
        }


        if(auth()->user()->perfil=='Reclutamiento'){
          ProcesoRH::where('vacante_id', $vacante_id)
              ->where('candidato_id', $candidato_id)
              ->where('company_id', $company_id)
              ->update([
                'habilitado' => '1'
              ]);

              $vacante_info=Vacantes::where('id',$vacante_id)->first();
              $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();


              if ($infouser->email) {
                Notificaciones::create([
                      'email' => $infouser->email,
                      'tipo' => 'success',
                      'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$candidato_id.'/0',
                      'fecha' => now(),
                      'texto' => 'Alta de candidato',
                      'abierto' => '0',
                    ]);
              }
        }

        if ($actionType === 'approve') {
          $vacanteId = $request->input('vacante_id');
          $procesoId = $request->input('proceso_id');
          $candidatoId = $request->input('candidato_id');
          $comentarios = $request->input('comentarios');

          $orden = $request->input('orden');
          $idcand = $request->input('idcand');



          ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
              'estatus_entrevista' => 'aprobado' ,  'current' => '3'
          ]);

          Procesos::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
              'estatus' => 'Aprobado'
          ]);





          Vacantes::where('id',$vacanteId)->update([
              'proceso' => '45'
          ]);


          $vacante_info=Vacantes::where('id',$vacanteId)->first();

        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/2',
                'fecha' => now(),
                'texto' => 'Jefatura aprueba candidato',
                'abierto' => '0',
              ]);
        }

        //  echo "aprobado";
          return redirect('/proceso_vacante/'.$vacante_id.'/'.$candidato_id.'/'.$idetapa);

       } elseif ($actionType === 'reject') {
           // Lógica para rechazar al candidato
           Procesos::where('vacante_id',$request->vacante_id)
           ->where('candidato_id',$request->candidato_id)->update([
               'estatus' => 'Rechazado'
           ]);

           ProcesoRH::where('vacante_id',$request->vacante_id)
           ->where('candidato_id',$request->candidato_id)->update([
               'estatus_proceso' => 'Rechazado'
           ]);

           Vacantes::where('id',$request->vacante_id)->update([
               'proceso' => '100'
           ]);


           if (emailreclutamiento()) {
             Notificaciones::create([
                   'email' => emailreclutamiento(),
                   'tipo' => 'danger',
                   'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id,
                   'fecha' => now(),
                   'texto' => 'Candidato rechazado',
                   'abierto' => '0',
                 ]);
           }

               $vacante_info=Vacantes::where('id',$request->vacante_id)->first();
               $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();


               if ($infouser->email) {
                 Notificaciones::create([
                       'email' => $infouser->email,
                       'tipo' => 'danger',
                       'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id,
                       'fecha' => now(),
                       'texto' => 'Candidato rechazado',
                       'abierto' => '0',
                     ]);
               }

                   $procesoinfo=ProcesoRH::where('vacante_id',$request->vacante_id)->where('candidato_id',$request->candidato_id)->first();
                   $current=0;
                   if ($procesoinfo->current) {
                     $current=$procesoinfo->current;
                   }

                //   echo "rechazado";
                 return redirect('/proceso_vacante/'.$vacante_id.'/'.$candidato_id.'/'.$idetapa);

       }else {

        // echo "otro";
         return redirect('/proceso_vacante/'.$vacante_id.'/'.$candidato_id.'/'.$idetapa);
       }


    }


    public function index()
    {
        $empresas = Companies::all();
        $departamentos = CatalogoDepartamentos::all();
        $puestos = CatalogoPuestos::all();
        $colaboradores = Colaboradores::where('estatus', 'activo')->get();
        $centros = CatalogoCentrosdeCostos::all();

        // Vacantes en proceso
        // Determinar la vista a mostrar
        if (auth()->user()->perfil == 'Jefatura' &&  auth()->user()->rol != 'Nómina') {

          $vacantesEnProceso = Vacantes::where('jefe', auth()->user()->colaborador_id)
                                        ->orderBy('fecha', 'asc')
                                      ->get();
          // Vacantes en espera de ingreso (completadas >= solicitadas y fecha de alta menor a una semana)
          $vacantesEnEspera = Vacantes::where('jefe', auth()->user()->colaborador_id)
                                      ->whereColumn('completadas', '=', 'solicitadas')
                                      /*->whereHas('altas', function ($query) {
                                          $query->where('fecha_alta', '>', now()->subWeek())
                                                ->where('fecha_alta', '>=', now());
                                      })*/
                                      ->orderBy('fecha', 'asc')
                                      ->get();

          // Vacantes en histórico (completadas >= solicitadas y fecha de alta mayor a una semana)
          $vacantesHistorico = Vacantes::where('jefe', auth()->user()->colaborador_id)
                                      ->whereColumn('completadas', '>=', 'solicitadas')
                                      ->whereHas('altas', function ($query) {
                                          $query->where('fecha_alta', '<=', now()->subWeek());
                                      })
                                      ->orderBy('fecha', 'asc')
                                      ->get();
        } else {
          $vacantesEnProceso = Vacantes::orderBy('fecha', 'asc')->get();
          $vacantesEnEspera = Vacantes::whereColumn('completadas', '=', 'solicitadas')
                                      /*->whereHas('altas', function ($query) {
                                          $query->where('fecha_alta', '>', now()->subWeek())
                                                ->where('fecha_alta', '>=', now());
                                      })*/
                                      ->orderBy('fecha', 'asc')
                                      ->get();
          $vacantesHistorico = Vacantes::whereColumn('completadas', '>=', 'solicitadas')
                                      ->whereHas('altas', function ($query) {
                                          $query->where('fecha_alta', '<=', now()->subWeek());
                                      })
                                      ->orderBy('fecha', 'asc')
                                      ->get();
        }
        return view('vacantes.index', [
            'vacantesEnProceso' => $vacantesEnProceso,
            'vacantesEnEspera' => $vacantesEnEspera,
            'vacantesHistorico' => $vacantesHistorico,
            'empresas' => $empresas, 
            'departamentos' => $departamentos,
            'puestos' => $puestos,
            'colaboradores' => $colaboradores,
            'centros' => $centros
        ]);
    }


    public function historico()
    {

      if(auth()->user()->perfil == 'Jefatura' && auth()->user()->rol != 'Nómina'){
          $vacantes = Vacantes::where('jefe', auth()->user()->colaborador_id)
                              ->whereColumn('completadas', '>=', 'solicitadas') // Excluir las completadas >= solicitadas
                              ->orderBy('fecha', 'asc')
                              ->get();
      } else {
          $vacantes = Vacantes::whereColumn('completadas', '>=', 'solicitadas') // Excluir las completadas >= solicitadas
                              ->orderBy('fecha', 'asc')
                              ->get();
      }


      return view('vacantes.historico' , ['vacantes' => $vacantes ]);
    }

    public function prioridad2(Request $request)
    {

      $prioridad=$request->prioridad;
      $idvacante=$request->idvacante;


      for ($i=0; $i <count($prioridad) ; $i++) {
        Vacantes::where('id',$idvacante[$i])->update([
            'prioridad' => $prioridad[$i]
        ]);


        if($prioridad[$i]=='Alta'){

          if (emailreclutamiento()) {
            Notificaciones::create([
                  'email' => emailreclutamiento(),
                  'tipo' => 'info',
                  'ruta' => '/vacantes/',
                  'fecha' => now(),
                  'texto' => 'Vacante con prioridad Alta',
                  'abierto' => '0',
                ]);
          }

        }
      }

      return redirect('/vacantes');

    }

    public function candidatos()
    {

      $candidatos = Candidatos::all();

      return view('vacantes.candidatos' , ['candidatos' => $candidatos ]);
    }

    public function proponer_ingreso(Request $request)
    {


      $vacante_info=Vacantes::where('id',$request->vacante_id)->first();
      $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();

      if (auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Nómina') {

        ProcesoRH::where('vacante_id',$request->vacante_id)->where('candidato_id' , $request->candidato_id)->update([
            'fecha_nomina' => $request->fecha_nomina
        ]);

        if ($infouser->email) {
          Notificaciones::create([
                'email' => $infouser->email,
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
                'fecha' => now(),
                'texto' => 'Se sube fecha para ingreso por parte de Nómina',
                'abierto' => '0',
              ]);
        }


        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
                'fecha' => now(),
                'texto' => 'Se sube fecha para ingreso por parte de Nómina',
                'abierto' => '0',
              ]);
        }





        return redirect()->back()->with('success', 'Se sube fecha para ingreso por parte de Jefatura');




      }else {

        ProcesoRH::where('vacante_id',$request->vacante_id)->where('candidato_id' , $request->candidato_id)->update([
            'fecha_jefatura' => $request->fecha_jefatura
        ]);


        if (emailnomina()) {
          Notificaciones::create([
                'email' => emailnomina(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
                'fecha' => now(),
                'texto' => 'Se sube fecha para ingreso por parte de Jefatura',
                'abierto' => '0',
              ]);
        }


        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
                'fecha' => now(),
                'texto' => 'Se sube fecha para ingreso por parte de Jefatura',
                'abierto' => '0',
              ]);
        }

        return redirect()->back()->with('success', 'Se sube fecha para ingreso por parte de Jefatura');
      }



    }

    public function altacandidato()
    {

      return view('vacantes.altacandidato');
    }

    public function subircv(Request $request)
    {
      // Obtener el id de la vacante y el id del proceso de reclutamiento
      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');

      // Crear la ruta de almacenamiento
      $ruta = "curriculums/{$vacanteId}/{$procesoId}/{$candidatoId}/";

      // Verificar si la carpeta ya existe, si no, crearla
      if (!Storage::exists($ruta)) {
          Storage::makeDirectory($ruta);
      }

      // Aplicar transformaciones al nombre del archivo

      // Nombre original del archivo

      $archivo = $request->file('cv');
      $nombreOriginal = $archivo->getClientOriginalName();
      $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
      $extension = $archivo->getClientOriginalExtension(); // Obtiene la extensión original del archivo
      $nombreArchivo = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

      $archivo->storeAs($ruta, $nombreArchivo, 'public');


      // Aquí puedes guardar en la base de datos la ruta del archivo si es necesario
      // Por ejemplo, podrías tener un modelo Curriculum y guardar la ruta en la tabla correspondiente.

      // Redireccionar o realizar cualquier otra acción que necesites

      ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
          'curriculum' => $ruta.$nombreArchivo , 'current' => '1'
      ]);

      Candidatos::where('id',$candidatoId)->update([ 'cv' => $ruta.$nombreArchivo ]);

      Vacantes::where('id',$vacanteId)->update([
          'proceso' => '15'
      ]);


      $vacante_info=Vacantes::where('id',$vacanteId)->first();
      $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();

      if ($infouser->email) {
        Notificaciones::create([
              'email' => $infouser->email,
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/0',
              'fecha' => now(),
              'texto' => 'Actualización de CV',
              'abierto' => '0',
            ]);
      }

    return redirect()->back()->with('success', 'Currículum subido exitosamente.');
    }

    public function asignar_fechas_entrevista(Request $request)
    {

      $datosFormulario = $request->all();

      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');

      // También puedes acceder a variables específicas utilizando input()
      $fechas = $request->input('fecha');
      $desde = $request->input('desde');
      $hasta = $request->input('hasta');
      $comentarios = $request->input('comentarios');

      $fechasConcatenadas = implode(',', $fechas);
      $desdeConcatenado = implode(',', $desde);
      $hastaConcatenado = implode(',', $hasta);

      $infoph=ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->first();

      if($infoph->entrevista1_fecha!=""){
        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/1',
                'fecha' => now(),
                'texto' => 'Jefatura modificó fechas para entrevista.',
                'abierto' => '0'
              ]);
        }
      }else {
        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/1',
                'fecha' => now(),
                'texto' => 'Jefatura asignó fechas para entrevista.',
                'abierto' => '0'
              ]);
        }
      }

      ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
          'entrevista1_fecha' => $fechasConcatenadas ,
          'entrevista1_desde' => $desdeConcatenado ,
          'entrevista1_hasta' => $hastaConcatenado ,
          'comentarios' => $comentarios,
          'current' => '1',
      ]);



      Vacantes::where('id',$vacanteId)->update([
          'proceso' => '25'
      ]);


      $vacante_info=Vacantes::where('id',$vacanteId)->first();



    return redirect('/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/1');
    }

    public function programar_fechas_entrevista(Request $request)
    {

      $datosFormulario = $request->all();

      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');

      $horario=$request->input('horario');
      $desde=$request->input('desde');
      $hasta=$request->input('hasta');
      $fecha=$request->input('fecha');
      $comentarios = $request->input('comentarios');



      $fechafinal=$fecha[$horario];

      $horafinal=$desde[$horario];
      $horafinal2=$hasta[$horario];

      $nuevahora=$horafinal." - ".$horafinal2;


      ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
          'entrevista2_fecha' => $fechafinal ,
          'entrevista2_hora' => $nuevahora ,
          'comentarios' => $comentarios,
          'current' => '2',
      ]);



      Vacantes::where('id',$vacanteId)->update([
          'proceso' => '35'
      ]);


      $vacante_info=Vacantes::where('id',$vacanteId)->first();
      $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();

      if ($infouser->email) {
        Notificaciones::create([
              'email' => $infouser->email,
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/1',
              'fecha' => now(),
              'texto' => 'Se programa fecha para entrevista',
              'abierto' => '0',
            ]);
      }


      return redirect('/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/2');
    }

    public function subir_referencias(Request $request)
    {

      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');
      $comentarios = $request->input('comentarios');

      // Crear la ruta de almacenamiento
      $ruta = "referencias/{$vacanteId}/{$procesoId}/{$candidatoId}/";

      // Verificar si la carpeta ya existe, si no, crearla
      if (!Storage::exists($ruta)) {
          Storage::makeDirectory($ruta);
      }

      // Subir el archivo al directorio de almacenamiento
      if ($request->hasFile('buro')) {




        $archivo_buro = $request->file('buro');
        $nombreOriginal = $archivo_buro->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
        $extension = $archivo_buro->getClientOriginalExtension(); // Obtiene la extensión original del archivo
        $nombreArchivo_buro = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

        $archivo_buro->storeAs($ruta, $nombreArchivo_buro, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_nombre1' => $ruta.$nombreArchivo_buro , 'comentarios' => $comentarios , 'current' => '4'
        ]);



      }


      if ($request->hasFile('carta')) {
        $archivo_carta = $request->file('carta');


        $archivo_carta = $request->file('carta');
        $nombreOriginal = $archivo_carta->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
        $extension = $archivo_carta->getClientOriginalExtension(); // Obtiene la extensión original del archivo
        $nombreArchivo_carta = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

        $archivo_carta->storeAs($ruta, $nombreArchivo_carta, 'public');


        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_nombre2' => $ruta.$nombreArchivo_carta , 'comentarios' => $comentarios , 'current' => '4'
        ]);


      }

      if ($request->hasFile('carta2')) {
        $archivo_carta = $request->file('carta2');


        $archivo_carta2 = $request->file('carta2');
        $nombreOriginal = $archivo_carta2->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
        $extension = $archivo_carta2->getClientOriginalExtension(); // Obtiene la extensión original del archivo
        $nombreArchivo_carta2 = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

        $archivo_carta2->storeAs($ruta, $nombreArchivo_carta2, 'public');


        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_telefono2' => $ruta.$nombreArchivo_carta2 , 'comentarios' => $comentarios , 'current' => '4'
        ]);


      }

      Vacantes::where('id',$vacanteId)->update([
          'proceso' => '75'
      ]);


      $vacante_info=Vacantes::where('id',$vacanteId)->first();
      if (emailnomina()) {
        Notificaciones::create([
              'email' => emailnomina(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/3',
              'fecha' => now(),
              'texto' => 'Se suben referencias laborales',
              'abierto' => '0',
            ]);
      }

    return redirect()->back()->with('success', 'Se suben las referencias laborales.');
    }

    public function apruebaestatus(Request $request)
    {
        $vacanteId = $request->input('vacante_id');
        $procesoId = $request->input('proceso_id');
        $candidatoId = $request->input('candidato_id');
        $comentarios = $request->input('comentarios');

        $orden = $request->input('orden');
        $idcand = $request->input('idcand');



        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'estatus_entrevista' => 'aprobado' ,  'current' => '3'
        ]);

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'estatus_proceso' => 'Aprobado' ,  'current' => '3'
        ]);

        Procesos::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'estatus' => 'Aprobado'
        ]);





        Vacantes::where('id',$vacanteId)->update([
            'proceso' => '45'
        ]);


        $vacante_info=Vacantes::where('id',$vacanteId)->first();

      if (emailreclutamiento()) {
        Notificaciones::create([
              'email' => emailreclutamiento(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/2',
              'fecha' => now(),
              'texto' => 'Jefatura aprueba candidato',
              'abierto' => '0',
            ]);
      }

      return redirect()->back()->with('success', 'Se aprueba el candidato.');
    }

    public function examen(Request $request)
    {

        $vacanteId = $request->input('vacante_id');
        $procesoId = $request->input('proceso_id');
        $candidatoId = $request->input('candidato_id');
        $comentarios = $request->input('comentarios');

        $resultados = $request->input('resultados');


        // Crear la ruta de almacenamiento
        $ruta = "examen/{$vacanteId}/{$procesoId}/{$candidatoId}/";

        // Verificar si la carpeta ya existe, si no, crearla
        if (!Storage::exists($ruta)) {
            Storage::makeDirectory($ruta);
        }

          if ($request->hasFile('examenfoto')) {



            $archivo_examen = $request->file('examenfoto');
            $nombreOriginal = $archivo_examen->getClientOriginalName();
            $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
            $extension = $archivo_examen->getClientOriginalExtension(); // Obtiene la extensión original del archivo
            $nombreArchivo_examen = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

            $archivo_examen->storeAs($ruta, $nombreArchivo_examen, 'public');


            ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
                'fotoexamen' => $ruta.$nombreArchivo_examen , 'comentarios' => $comentarios ,  'current' => '5'
            ]);
          }





        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'examen' => $resultados , 'comentarios' => $comentarios
        ]);

        Vacantes::where('id',$vacanteId)->update([
            'proceso' => '55'
        ]);

        $vacante_info=Vacantes::where('id',$vacanteId)->first();
        if (emailnomina()) {
          Notificaciones::create([
                'email' => emailnomina(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/4',
                'fecha' => now(),
                'texto' => 'Se sube resultado de exámen psicométrico',
                'abierto' => '0',
              ]);
        }


        return redirect()->back()->with('success', 'Se suben los resultados del exámen psicométrico.');
    }

    public function documentacion(Request $request)
    {
      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');
      $comentarios = $request->input('comentarios');

      $nombreArchivo_documento1="";
      $nombreArchivo_documento1="";
      $nombreArchivo_documento3="";
      $nombreArchivo_documento4="";
      $nombreArchivo_documento5="";

      // Crear la ruta de almacenamiento
      $ruta = "documentos/{$vacanteId}/{$procesoId}/{$candidatoId}/";

      // Verificar si la carpeta ya existe, si no, crearla
      if (!Storage::exists($ruta)) {
          Storage::makeDirectory($ruta);
      }


      if ($request->hasFile('documento1')) {



        $archivo_documento1 = $request->file('documento1');
        $nombreOriginal = $archivo_documento1->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
        $extension = $archivo_documento1->getClientOriginalExtension();
        $nombreArchivo_documento1 = $nombreSinAcentos . '.' . $extension;

        $archivo_documento1->storeAs($ruta, $nombreArchivo_documento1, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
        ->update(['documento1' => $ruta.$nombreArchivo_documento1  , 'comentarios' => $comentarios
        , 'estatus_documento1' => 'Pendiente' , 'current' => '5'
        ]);

      }

      if ($request->hasFile('documento2')) {

        $archivo_documento2 = $request->file('documento2');
        $nombreOriginal = $archivo_documento2->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
        $extension = $archivo_documento2->getClientOriginalExtension();
        $nombreArchivo_documento2 = $nombreSinAcentos . '.' . $extension;

        $archivo_documento2->storeAs($ruta, $nombreArchivo_documento2, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
        ->update(['documento2' => $ruta.$nombreArchivo_documento2 , 'comentarios' => $comentarios
        , 'estatus_documento2' => 'Pendiente' , 'current' => '5'
        ]);

      }


      if ($request->hasFile('documento3')) {

        $archivo_documento3 = $request->file('documento3');
        $nombreOriginal = $archivo_documento3->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
        $extension = $archivo_documento3->getClientOriginalExtension();
        $nombreArchivo_documento3 = $nombreSinAcentos . '.' . $extension;

        $archivo_documento3->storeAs($ruta, $nombreArchivo_documento3, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
        ->update(['documento3' => $ruta.$nombreArchivo_documento3 , 'comentarios' => $comentarios
        , 'estatus_documento3' => 'Pendiente' , 'current' => '5'
        ]);

      }

      if ($request->hasFile('documento4')) {

        $archivo_documento4 = $request->file('documento4');
        $nombreOriginal = $archivo_documento4->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
        $extension = $archivo_documento4->getClientOriginalExtension();
        $nombreArchivo_documento4 = $nombreSinAcentos . '.' . $extension;

        $archivo_documento4->storeAs($ruta, $nombreArchivo_documento4, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
        ->update(['documento4' => $ruta.$nombreArchivo_documento4 , 'comentarios' => $comentarios
        , 'estatus_documento4' => 'Pendiente' , 'current' => '5'
        ]);

      }


      if ($request->hasFile('documento5')) {


        $archivo_documento5 = $request->file('documento5');
        $nombreOriginal = $archivo_documento5->getClientOriginalName();
        $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
        $extension = $archivo_documento5->getClientOriginalExtension();
        $nombreArchivo_documento5 = $nombreSinAcentos . '.' . $extension;

        $archivo_documento5->storeAs($ruta, $nombreArchivo_documento5, 'public');

        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
        ->update(['documento5' => $ruta.$nombreArchivo_documento5 , 'comentarios' => $comentarios
        , 'estatus_documento5' => 'Pendiente'  , 'current' => '5'
        ]);

      }




      Vacantes::where('id',$vacanteId)->update([
          'proceso' => '85'
      ]);


      $vacante_info=Vacantes::where('id',$request->vacante_id)->first();

      if (emailnomina()) {
        Notificaciones::create([
              'email' => emailnomina(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/5',
              'fecha' => now(),
              'texto' => 'Alta de documentos',
              'abierto' => '0',
            ]);
      }

      return redirect()->back()->with('success', 'Se suben los documentos del candidato.');

    }


    public function validar_documentacion(Request $request)
    {

      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');
      $comentarios = $request->input('comentarios');

      ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)
      ->update(
        [
          'estatus_documento1' => $request->estatus_documento1 ,
          'estatus_documento2' => $request->estatus_documento2 ,
          'estatus_documento3' => $request->estatus_documento3 ,
          'estatus_documento4' => $request->estatus_documento4 ,
          'estatus_documento5' => $request->estatus_documento5 ,
          'comentariodoc1' => $request->comentariodoc1 ,
          'comentariodoc2' => $request->comentariodoc2 ,
          'comentariodoc3' => $request->comentariodoc3 ,
          'comentariodoc4' => $request->comentariodoc4 ,
          'comentariodoc5' => $request->comentariodoc5 ,
          'current' => '5'
        ]);

        Vacantes::where('id',$vacanteId)->update([
            'proceso' => '95'
        ]);



        if ( $request->estatus_documento1 == 'Aprobado' && $request->estatus_documento2 == 'Aprobado' && $request->estatus_documento3 == 'Aprobado' && $request->estatus_documento4 == 'Aprobado' && $request->estatus_documento5 == 'Aprobado' ) {
          if (emailreclutamiento()) {
            Notificaciones::create([
                  'email' => emailreclutamiento(),
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/6',
                  'fecha' => now(),
                  'texto' => 'Documentos aprobados',
                  'abierto' => '0',
                ]);
          }
        } else {
          if (emailreclutamiento()) {
            Notificaciones::create([
                  'email' => emailreclutamiento(),
                  'tipo' => 'danger',
                  'ruta' => '/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/5',
                  'fecha' => now(),
                  'texto' => 'Documentos rechazados',
                  'abierto' => '0',
                ]);
          }
        }



        return redirect('/proceso_vacante/'.$vacanteId.'/'.$candidatoId.'/6')->with('success', 'Se actualizaron los estatus de los documentos.');
    }

    public function priorizar(Request $request)
    {
      Vacantes::where('id',$request->id_vacante)->update([
          'prioridad' => $request->prioridad
      ]);

      return redirect('/home');
    }

    public function generar(Request $request)
    {
      Vacantes::where('id',$request->id_vacante)->update([
          'estatus' => 'completada'
      ]);

      return redirect('/home');
    }

    public function reclutamiento()
    {

      if (session('company_id')!="0") {
          $vacantes=FormularioVacantes::where('company_id',session('company_id'))->get();
      }else {
          $vacantes = FormularioVacantes::all();
      }

      return view('vacantes.reclutamiento' , ['vacantes' => $vacantes ]);
    }


    public function alta()
    {
        $empresas = Companies::all();

        return view('vacantes.alta' , ['empresas' => $empresas ]);
    }


    public function vacantes_cubiertas()
    {
        $vacantes = Vacantes::all();

        $puestosactivos = Colaboradores::where('company_id' , session('company_id'))
        ->where('estatus' , 'activo')
        ->orderBy('fecha_alta', 'asc')
        ->orderBy('puesto', 'asc')
        ->select('puesto', 'fecha_alta')
        ->distinct()
        ->get();





        return view('vacantes.vacantes_cubiertas' , ['puestosactivos' => $puestosactivos  ]);
    }


    public function objetivo_mensual()
    {
        $vacantes = Vacantes::all();

        return view('vacantes.objetivo_mensual' , ['vacantes' => $vacantes ]);
    }


    public function nuevas_vacantes()
    {
        $vacantes = Vacantes::all();

        return view('vacantes.nuevas_vacantes' , ['vacantes' => $vacantes ]);
    }

    public function procesos_abiertos()
    {
        $vacantes = Vacantes::all();

        return view('vacantes.procesos_abiertos' , ['vacantes' => $vacantes ]);
    }

    public function alta_candidato_rh(Request $request)
    {
          $request->validate([
              'curriculum' => 'required|file|max:2048', // 2048 KB = 2 MB
          ], [
              'curriculum.max' => 'El archivo no debe pesar más de 2MB.',
          ]);


          $create=new Candidatos();
          $create->nombre=$request->nombre;
          $create->apellido_paterno=$request->apellido_paterno;
          $create->apellido_materno=$request->apellido_materno;
          $create->fecha_nacimiento=" ";
          $create->edad=' ';
          $create->cv='';
          $create->comentarios=$request->comentarios;
          $create->fuente=$request->fuente;
          $create->estatus='nuevo';
          $create->save();




          $create3=new Procesos();
          $create3->vacante_id=$request->vacante_id;
          $create3->candidato_id=$create->id;
          $create3->estatus='Pendiente';
          $create3->save();




          $create2=new ProcesoRH();
          $create2->vacante_id=$request->vacante_id;
          $create2->candidato_id=$create->id;
          $create3->habilitado='0';
          $create2->save();


          // Crear la ruta de almacenamiento
          $ruta = "curriculums/{$request->vacante_id}/{$create2->id}/{$create->id}/";

          // Verificar si la carpeta ya existe, si no, crearla
          if (!Storage::exists($ruta)) {
              Storage::makeDirectory($ruta);
          }


          $archivo = $request->file('curriculum');

          $nombreOriginal = $archivo->getClientOriginalName();
          $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
          $extension = $archivo->getClientOriginalExtension(); // Obtiene la extensión original del archivo
          $nombreArchivo = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

          $archivo->storeAs($ruta, $nombreArchivo, 'public');



          ProcesoRH::where('vacante_id',$request->vacante_id)->where('candidato_id' , $create->id)->update([
              'curriculum' => $ruta.$nombreArchivo
          ]);

          Vacantes::where('id',$request->vacante_id)->update([
              'proceso' => '15'
          ]);


          Candidatos::where('id',$create->id)->update([ 'cv' => $ruta.$nombreArchivo ]);

          //Notificaciones

          $vacante_info=Vacantes::where('id',$request->vacante_id)->first();
          $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();

          /*
          if ($infouser->email) {
            Notificaciones::create([
                  'email' => $infouser->email,
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$create->id.'/0',
                  'fecha' => now(),
                  'texto' => 'Alta de candidato',
                  'abierto' => '0',
                ]);
          }
          */

          /*
          Notificaciones::create([
                'email' => emailnomina(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$create->id.'/0',
                'fecha' => now(),
                'texto' => 'Alta de candidato',
                'abierto' => '0',
              ]);
          */
          //TERMINA NOTIFICACIONES
          return redirect('/proceso_vacante/'.$request->vacante_id.'/'.$create->id.'/0');
    }

     public function proceso_vacante($id)
    {

      /*
      Procesos::where('abierto','1')
      ->where('email',auth()->user()->email)->update([
          'estatus' => 'Aprobado'
      ]);
      */

      $procesos = Procesos::where('vacante_id',$id)->get();

      $vacante = Vacantes::where('id',$id)->first();

      $puestos = OrganigramaLinealNiveles::where('colaborador_id','0')->get();

      return view('vacantes.proceso_vacante' , ['vacante' => $vacante  , 'procesos' => $procesos  , 'vacante_id' => $id , 'puestos' => $puestos]);
    }

    public function proceso_vacante_candidato($id , $candidato)
    {

      /*
      Procesos::where('abierto','1')
      ->where('email',auth()->user()->email)->update([
          'estatus' => 'Aprobado'
      ]);
      */


      $procesos = Procesos::where('vacante_id',$id)->get();

      $vacante = Vacantes::where('id',$id)->first();

      $procesoinfo=ProcesoRH::where('vacante_id',$id)->where('candidato_id',$candidato)->first();
      $current=0;
      if ($procesoinfo->current) {
        $current=$procesoinfo->current;
      }
      $puestos = OrganigramaLinealNiveles::where('colaborador_id','0')->get();

      return redirect('proceso_vacante/'.$id.'/'.$candidato.'/'.$current);
      //return view('vacantes.proceso_vacante_candidato' , ['vacante' => $vacante  , 'procesos' => $procesos  , 'vacante_id' => $id , 'puestos' => $puestos ,  'candidato' => $candidato , 'procesoinfo' => $procesoinfo]);
    }

    public function proceso_vacante_candidato_current($id , $candidato , $current)
    {

      /*
      Procesos::where('abierto','1')
      ->where('email',auth()->user()->email)->update([
          'estatus' => 'Aprobado'
      ]);
      */
      $infodelcandidato= Candidatos::where('id',$candidato)->first();

      $procesos = Procesos::where('vacante_id',$id)->get();

      $vacante = Vacantes::where('id',$id)->first();

      $procesoinfo=ProcesoRH::where('vacante_id',$id)->where('candidato_id',$candidato)->first();

      $motivos = Motivos::where('vacante_id',$id)->where('candidato_id',$candidato)->where('proceso_id',$procesoinfo->id)->get();

      $puestos = OrganigramaLinealNiveles::where('colaborador_id','0')->get();

      $datosPreguntas=PreguntaReclutamiento::where('company_id',$vacante->company_id)
      ->where('id_vacante',$vacante->id)
      ->where('id_candidato',$candidato)
      ->where('perfil', auth()->user()->rol)
      ->get();

      $datosPreguntasAvg = PreguntaReclutamiento::where('company_id', $vacante->company_id)
      ->where('id_vacante', $vacante->id)
      ->where('id_candidato', $candidato)
      ->where('perfil', auth()->user()->rol)
      ->where('etapa', 'Curriculum')
      ->get();

        $totalValoraciones = 0;
        $sumaValoraciones = 0;

        foreach ($datosPreguntasAvg as $pregunta) {
            // Solo agregamos la valoración si es mayor a cero
            if ($pregunta->valoracion > 0) {
                $totalValoraciones++;
                $sumaValoraciones += $pregunta->valoracion;
            }
        }

        $promedio = $totalValoraciones > 0 ? $sumaValoraciones / $totalValoraciones : 0;



        $datosPreguntasAvg2 = PreguntaReclutamiento::where('company_id', $vacante->company_id)
        ->where('id_vacante', $vacante->id)
        ->where('id_candidato', $candidato)
        ->where('perfil', 'Jefatura')
        ->where('etapa', 'Entrevista')
        ->get();

          $totalValoraciones2 = 0;
          $sumaValoraciones2 = 0;

          foreach ($datosPreguntasAvg2 as $pregunta2) {
              // Solo agregamos la valoración si es mayor a cero
              if ($pregunta2->valoracion > 0) {
                  $totalValoraciones2++;
                  $sumaValoraciones2 += $pregunta2->valoracion;
              }
          }

          $promedio2 = $totalValoraciones2 > 0 ? $sumaValoraciones2 / $totalValoraciones2 : 0;

        // $promedio contiene el promedio general de todas las valoraciones que tienen un valor mayor a cero
        $orgm=OrganigramaMatricial::where('nombre',$vacante->area)->first();
        $orientacion=$orgm->orientacion ?? 'vertical';
        $tipo='administrativo';
        if ($orientacion=='horizontal') {
          $tipo='operativo';
        }else {
          $tipo='administrativo';
        }

      return view('vacantes.proceso_vacante_candidato_current' , ['tipo' => $tipo ,'vacante' => $vacante  , 'procesos' => $procesos  , 'vacante_id' => $id , 'puestos' => $puestos ,  'candidato' => $candidato , 'procesoinfo' => $procesoinfo , 'current' => $current ,
      'motivos' => $motivos , 'infodelcandidato' => $infodelcandidato , 'datosPreguntas' => $datosPreguntas , 'datosPreguntasAvg' => $datosPreguntasAvg , 'datosPreguntasAvg2' => $datosPreguntasAvg2 , 'promedio' => $promedio , 'promedio2' => $promedio2]);

    }

    public function descargarCV($ruta)
    {
        // Construir la ruta completa al archivo
        $rutaCompleta = storage_path("storage/{$ruta}");

        // Verificar si el archivo existe
        if (file_exists($rutaCompleta)) {
            // Obtener el nombre del archivo
            $nombreArchivo = pathinfo($rutaCompleta, PATHINFO_FILENAME);

            // Obtener el tipo MIME del archivo (puedes personalizarlo según el tipo de archivo)
            $tipoMIME = mime_content_type($rutaCompleta);

            // Descargar el archivo
            return response()->download($rutaCompleta, "{$nombreArchivo}.jpeg", ['Content-Type' => $tipoMIME]);
        } else {
            // Manejar el caso en el que el archivo no existe
            abort(404);
        }
    }

    public function aprobar_candidato(Request $request)
    {

      Procesos::where('vacante_id',$request->vacante_id)
      ->where('candidato_id',$request->candidato_id)->update([
          'estatus' => 'Completado'
      ]);


      /*
      Notificaciones::create([
            'email' => emailnomina(),
            'tipo' => 'success',
            'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
            'fecha' => now(),
            'texto' => 'Candidato aprobado para la vacante',
            'abierto' => '0',
          ]);
      */

          Vacantes::where('id', $request->vacante_id)->update([
              'proceso' => '100',
              'completadas' => DB::raw('completadas + 1') // Aquí puedes cambiar '1' por el número que desees sumar
          ]);

      Vacantes::where('id',$request->vacante_id)->update([
          'proceso' => '100' ,
      ]);




      return redirect('/vacantes');


    }

    public function rechazar_candidato(Request $request)
    {
      Procesos::where('vacante_id',$request->vacante_id)
      ->where('candidato_id',$request->candidato_id)->update([
          'estatus' => 'Rechazado'
      ]);

      ProcesoRH::where('vacante_id',$request->vacante_id)
      ->where('candidato_id',$request->candidato_id)->update([
          'estatus_proceso' => 'Rechazado'
      ]);

      ProcesoRH::where('vacante_id',$request->vacante_id)
      ->where('candidato_id',$request->candidato_id)->update([
          'estatus_entrevista' => 'rechazado'
      ]);

      ProcesoRH::where('vacante_id',$request->vacante_id)
      ->where('candidato_id',$request->candidato_id)->update([
          'rechazado_por' => auth()->user()->perfil
      ]);

      Vacantes::where('id',$request->vacante_id)->update([
          'proceso' => '100'
      ]);


      if($request->has('motivorechazo')) {
            foreach ($request->input('motivorechazo') as $motivo) {
                Motivos::create([
                    'candidato_id' => $request->candidato_id,
                    'vacante_id' => $request->vacante_id,
                    'proceso_id' => $request->proceso_id,
                    'motivo' => $motivo,
                    'usuario' => auth()->user()->id,
                ]);
            }
        }


      // Elimina la alta del candidato
      $existealta = Altas::where('candidato_id', $request->candidato_id)
                         ->where('id_vacante', $request->vacante_id)
                         ->delete();

      if ($existealta) {
          // Usamos DB::raw para restar 1 al campo completadas, asegurándonos de que no baje de 0
          Vacantes::where('id', $request->vacante_id)->update([
              'completadas' => DB::raw('GREATEST(completadas - 1, 0)')
          ]);
      }


      if (emailreclutamiento()) {
        Notificaciones::create([
              'email' => emailreclutamiento(),
              'tipo' => 'danger',
              'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id,
              'fecha' => now(),
              'texto' => 'Candidato rechazado',
              'abierto' => '0',
            ]);
      }

          $vacante_info=Vacantes::where('id',$request->vacante_id)->first();
          $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();


          if ($infouser->email) {
            Notificaciones::create([
                  'email' => $infouser->email,
                  'tipo' => 'danger',
                  'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id,
                  'fecha' => now(),
                  'texto' => 'Candidato rechazado',
                  'abierto' => '0',
                ]);
          }

              $procesoinfo=ProcesoRH::where('vacante_id',$request->vacante_id)->where('candidato_id',$request->candidato_id)->first();
              $current=0;


              return redirect('proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/'.$current);


    }

    public function eliminar_referencia(Request $request)
    {

      $referencia = $request->input('referencia');
      $vacanteId = $request->input('vacante_id');
      $procesoId = $request->input('proceso_id');
      $candidatoId = $request->input('candidato_id');
      $comentarios = $request->input('comentarios');

      if ($referencia=='buro') {
        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_nombre1' => NULL
        ]);
      }

      if ($referencia=='carta') {
        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_nombre2' => NULL
        ]);
      }

      if ($referencia=='carta2') {
        ProcesoRH::where('vacante_id',$vacanteId)->where('candidato_id' , $candidatoId)->update([
            'referencia_telefono2' => NULL
        ]);
      }


          if (emailreclutamiento()) {
            Notificaciones::create([
                  'email' => emailreclutamiento(),
                  'tipo' => 'danger',
                  'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/3',
                  'fecha' => now(),
                  'texto' => 'Referencias rechazadas',
                  'abierto' => '0',
                ]);
          }

          return redirect()->back()->with('error', 'Se rechazaron las referencias laborales.');
    }

    public function altas()
    {

        $altas=Altas::where('estatus','Pendiente')->get();

        return view('altas.index',compact('altas'));
    }

    public function terminaralta($id)
    {

      $alta=Altas::where('id',$id)->first();

      $vacante_info=Vacantes::where('id',$alta->id_vacante)->first();

      $datoscolab=Candidatos::where('id',$alta->candidato_id)->first();

      $departamentos = Departamentos::all();
      $colaboradores = Colaboradores::all();
      $razones = Companies::all();
      $conexiones = Conexiones::all();

      $numero_de_empleado = Colaboradores::where('company_id',$vacante_info->company_id)->max('numero_de_empleado');
      $numero_de_empleado=$numero_de_empleado+1;
      $idempleado = Colaboradores::max('idempleado');
      $idempleado=$idempleado+1;



      $datosorg=OrganigramaLinealNiveles::where('codigo',$alta->codigo)->first();

      $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();



      $puestos = PerfilPuestos::all();
      $centro_de_costos = CentrodeCostos::all()->unique('centro_de_costos');
      $tiposdecontratos = CatalogosdeTiposdeContratos::all();
      $tiposdeperiodo = CatalogosdeTiposdePeriodo::all();
      $tiposbasedecotizacion = CatalogosdeTiposdeBasedeCotizacion::all();
      $registropatronal = RegistroPatronal::all()->unique('registro_patronal');
      $tipodeprestacion = CatalogosdeTiposdePrestacion::all();
      $tipodeturnodetrabajo = CatalogosdeTiposdeTurnodeTrabajo::all();
      $tipodebasedepago = CatalogosdeTiposdeBasedePago::all();
      $tipodemetododepago = CatalogosdeTiposdeMetododePago::all();
      $tipoderegimen = CatalogosdeTiposdeRegimen::all();
      $tipodejornada = CatalogosdeTiposdeJornada::all();
      $tipodezonadesalario = CatalogosdeTiposdeZonadeSalario::all();
      $estados = Estados::all();
      $genero = Generos::all();
      $afores = Afores::all();
      $areas = Agrupadores::all();
      $estado_civil = EstadoCivil::all();
      $bancos = Bancos::all();
      return view('colaboradores.crear_vacante' , [
          'candidato_id' => $alta->candidato_id,
          'fecha_alta' => $alta->fecha_alta ,
          'company_id' => $alta->company_id ,
          'departamentos' => $departamentos  ,
          'colaboradores' => $colaboradores ,
          'razones' => $razones ,
          'estados' => $estados  ,
          'genero' => $genero ,
          'puestos' => $puestos ,
          'afores' => $afores ,
          'tiposdecontratos' => $tiposdecontratos ,
          'tiposdeperiodo' => $tiposdeperiodo ,
          'tiposbasedecotizacion' => $tiposbasedecotizacion ,
          'registropatronal' => $registropatronal ,
          'estado_civil' => $estado_civil ,
          'tipodeprestacion' => $tipodeprestacion ,
          'tipodeturnodetrabajo' => $tipodeturnodetrabajo ,
          'tipodebasedepago' => $tipodebasedepago ,
          'tipodemetododepago' => $tipodemetododepago ,
          'tipoderegimen' => $tipoderegimen ,
          'tipodejornada' => $tipodejornada ,
          'tipodezonadesalario' => $tipodezonadesalario ,
          'registropatronal' => $registropatronal ,
          'areas' => $areas ,
          'centro_de_costos' => $centro_de_costos ,
          'numero_de_empleado' => $numero_de_empleado ,
          'idempleado' => $idempleado ,
          'conexiones' => $conexiones ,
          'bancos' => $bancos  ,
          'datoscolab' => $datoscolab  ,
          'vacante_info' => $vacante_info,
          'codigoorganigrama' => $alta->codigo,
          'puesto' => $alta->id_puesto,
      ]);




        //return view('altas.index',compact('altas'));
    }

    public function contratar_colaborador(Request $request)
    {
        Procesos::where('vacante_id',$request->vacante_id)
        ->where('candidato_id',$request->candidato_id)->update([
            'estatus' => 'Contratado'
        ]);

        ProcesoRH::where('vacante_id',$request->vacante_id)
        ->where('candidato_id',$request->candidato_id)->update([
            'estatus_proceso' => 'Aprobado'
        ]);

        ProcesoRH::where('vacante_id',$request->vacante_id)
        ->where('candidato_id',$request->candidato_id)->update([
            'fecha_nomina' => $request->fecha_alta
        ]);


        Vacantes::where('id', $request->vacante_id)->update([
            'proceso' => '100',
            'completadas' => DB::raw('completadas + 1'),
            'estatus' => 'completado'
        ]);

        $datoscolab=Candidatos::where('id',$request->candidato_id)->first();

        $datosorg=OrganigramaLinealNiveles::where('id',$request->organigrama_id)->first();

        $vacante_info=Vacantes::where('id',$request->vacante_id)->first();
        $infouser=User::where('colaborador_id',$vacante_info->jefe)->first();

        if ($infouser->email) {
          Notificaciones::create([
                'email' => $infouser->email,
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
                'fecha' => now(),
                'texto' => 'Se programa alta de colaborador',
                'abierto' => '0',
              ]);
        }

      if (emailreclutamiento()) {
        Notificaciones::create([
              'email' => emailreclutamiento(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$request->vacante_id.'/'.$request->candidato_id.'/6',
              'fecha' => now(),
              'texto' => 'Se programa alta de colaborador',
              'abierto' => '0',
            ]);
      }

          $orginfo=OrganigramaLinealNiveles::where('codigo',$request->codigoorganigrama)->first();

          $yasediodealta=Altas::where('candidato_id',$request->candidato_id)->where('id_vacante',$request->vacante_id)->count();

          if ($yasediodealta==0) {
            $nuevaAlta = Altas::create([
                  'candidato_id' => $request->candidato_id,
                  'company_id' => $vacante_info->company_id,
                  'fecha_alta' => $request->fecha_alta,
                  'estatus' => 'Pendiente',
                  'jefe_directo_id' => $request->jefe_id,
                  'centro_de_costos' => $orginfo->cc,
                  'id_puesto' => $vacante_info->puesto_id,
                  'id_vacante' => $request->vacante_id,
                  'codigo' => $request->codigoorganigrama,
              ]);

              // Ahora puedes acceder al ID de la nueva alta utilizando la propiedad 'id'
              $nuevaAltaID = $nuevaAlta->id;

                return redirect('terminaralta/'.$nuevaAltaID);
          }else {
            $altainfo=Altas::where('candidato_id',$request->candidato_id)->where('id_vacante',$request->vacante_id)->first();

            return redirect('terminaralta/'.$altainfo->id);
          }
    }

    public function create()
    {
        $empresas = Companies::all();
        $departamentos = CatalogoDepartamentos::all();
        $puestos = CatalogoPuestos::all();
        $colaboradores = Colaboradores::where('estatus', 'activo')->get();
        $centros = CatalogoCentrosdeCostos::all();

        return view('vacantes.create', compact('empresas', 'departamentos', 'puestos', 'colaboradores', 'centros'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'departamento_id' => 'required|exists:catalogo_departamentos,id',
            'puesto_id' => 'required|exists:catalogo_puestos,id',
            'solicitadas' => 'required|numeric',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'jefe' => 'required|exists:colaboradores,id',
            'area_id' => 'nullable|string|max:255',
            'fecha' => 'required|date',
        ]);

        $cuantos=OrganigramaLinealNiveles::where('puesto',$request->puesto_id)->count();
        $cuantos=$cuantos+1;

        $cc=CatalogoCentrosdeCostos::where('id',$request->area_id)->first();

        $info=OrganigramaLinealNiveles::where('colaborador_id',$request->jefe)->first();

        // Crear la vacante
        Vacantes::create([
            'company_id' => $request->company_id,
            'departamento_id' => $request->departamento_id,
            'puesto_id' => $request->puesto_id,
            'solicitadas' => $request->solicitadas,
            'completadas' => 0,
            'codigo' => $request->nivel.'-'.$request->puesto_id.'-'.$cuantos,
            'prioridad' => $request->prioridad,
            'estatus' => 'pendiente',
            'jefe' => $request->jefe,
            'area_id' => $request->area_id,
            'fecha' => $request->fecha,
        ]);

        OrganigramaLinealNiveles::create([
            'organigrama_id' => '0',
            'nivel' => $request->nivel,
            'colaborador_id' => '0',
            'jefe_directo_id' => $request->jefe,
            'jefe_directo_codigo' => $info->codigo,
            'puesto' => $request->puesto_id,
            'cc' => $request->area_id,
            'codigo' => $request->nivel.'-'.$request->puesto_id.'-'.$cuantos,
            'company_id' => $request->company_id,
            'jerarquia' => $request->nivel,
        ]);

        // Redirigir a la vista de vacantes con un mensaje de éxito
        return redirect('/vacantes')->with('success', 'Vacante creada exitosamente.');
    }

    public function guardarcandidato(Request $request)
    {
        $create=new Candidatos();
        $create->nombre=$request->nombre;
        $create->apellido_paterno=$request->apellido_paterno;
        $create->apellido_materno=$request->apellido_materno;
        $create->fecha_nacimiento=" ";
        $create->edad=$request->edad;
        $create->cv='';
        $create->comentarios=$request->comentarios;
        $create->fuente=$request->fuente;
        $create->estatus='nuevo';
        $create->save();

        return redirect('/candidatos');
    }

    public function editar($id)
    {
        $vacante = Vacantes::findOrFail($id);
        $empresas = Companies::all();
        $departamentos = CatalogoDepartamentos::all();
        $puestos = CatalogoPuestos::all(); // Agregamos la consulta de puestos
        $colaboradores = Colaboradores::where('estatus', 'activo')->get();
        $centros = CatalogoCentrosdeCostos::all();

        return view('vacantes.editar', compact('vacante', 'empresas', 'departamentos', 'puestos','colaboradores','centros'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'departamento_id' => 'required|exists:catalogo_departamentos,id',
            'puesto_id' => 'required|exists:catalogo_puestos,id',
            'solicitadas' => 'required|numeric',
            'completadas' => 'nullable|numeric',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'jefe' => 'required|exists:colaboradores,id',
            'area_id' => 'nullable|string|max:255',
            'fecha' => 'required|date',
            'proceso' => 'nullable|string|max:255',
        ]);

        // Encontrar la vacante a actualizar
        $vacante = Vacantes::findOrFail($id);

        // Actualizar la vacante
        $vacante->update([
            'company_id' => $request->company_id,
            'departamento_id' => $request->departamento_id,
            'puesto_id' => $request->puesto_id,
            'solicitadas' => $request->solicitadas,
            'completadas' => $request->completadas,
            'prioridad' => $request->prioridad,
            'jefe' => $request->jefe,
            'area_id' => $request->area_id,
            'fecha' => $request->fecha,
            'proceso' => $request->proceso,
        ]);

        $info=OrganigramaLinealNiveles::where('colaborador_id',$request->jefe)->first();

        OrganigramaLinealNiveles::update([
            'colaborador_id' => '0',
            'jefe_directo_id' => $request->jefe,
            'jefe_directo_codigo' => $info->codigo,
            'puesto' => $request->puesto_id,
            'cc' => $request->area_id,
            'company_id' => $request->company_id,
        ]);

        // Redirigir a la vista de vacantes con un mensaje de éxito
        return redirect('/vacantes')->with('success', 'Vacante actualizada exitosamente.');
    }

    public function proceso($id)
    {
        $vacante=FormularioVacantes::where('id',$id)->first();

        $candidatos = Candidatos::all();

        return view('vacantes.proceso' , ['vacante' => $vacante , 'candidatos' => $candidatos]);
    }

    public function eliminar(Request $request)
    {

        FormularioVacantes::where('id', $request->idvacante)->delete();

        return redirect('/vacantes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVacantesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar_reclutamiento(Request $request)
    {
        $respuesta="";
        if($request->campo=='texto'){

            $respuesta=$request->respuesta;

        }elseif($request->campo=='multiple'){

            for($i=0; $i<count($request->pregunta_id); $i++){

                $respuesta.=$request->respuesta.' | ';

            }

        }elseif($request->campo=='opciones'){

            $respuesta=$request->respuesta;

        }

        $create=new RespuestasEncuestas();
        $create->encuesta_id=$request->encuesta_id;
        $create->proceso_id=$request->proceso_id;
        $create->reclutamiento_id=$request->reclutamiento_id;
        $create->vacante_id=$request->vacante_id;
        $create->formulario_encuesta_id='1';
        $create->candidato_id=$request->candidato_id;
        $create->pregunta_id=$request->pregunta_id;
        $create->respuesta=$respuesta;
        $create->save();

        return redirect('/vacantes');
    }

    public function vervacante(Request $request)
    {



      $vacante=Vacantes::where('id', $request->idvacante)->first();

      $colaboradores=Colaboradores::where('estatus', 'activo')->where('organigrama',$vacante->area)->get();

      $candidatos=Candidatos::all();


      return view('vacantes.vervacante' , ['vacante' => $vacante ,'colaboradores' => $colaboradores , 'candidatos' => $candidatos ]);

    }


    public function postular_candidatos(Request $request)
    {

      return view('vacantes.candidatos_postulados' );
    }

    public function cubrirvacante(Request $request)
    {
      $puesto=$request->puesto;
      $area=$request->area;
      $jefe_directo=$request->jefe_directo;
      $colaborador_id=$request->colaborador_id;


      $vacante=OrganigramaLinealNiveles::where('jefe_directo_id', $jefe_directo)
      ->where('puesto',$request->puesto)->first();




      OrganigramaLinealNiveles::where('jefe_directo_id',$request->jefe_directo)
      ->where('puesto',$request->puesto)->update([
          'colaborador_id' => $colaborador_id
      ]);



      Vacantes::where('id',$request->idvacante)->update([
          'estatus' => 'completada'
      ]);




      return redirect('/home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacantes  $vacantes
     * @return \Illuminate\Http\Response
     */
    public function reclutamiento_old()
    {
        $vacantes = Vacantes::all();
        $reclutamientos = Reclutamientos::all();
        $candidatos = Candidatos::all();
        $formularios = FormulariosEncuestas::all();
        $entrevistas = Entrevistas::all();
        return view('vacantes.reclutamiento' , ['entrevistas' => $entrevistas ,'formularios' => $formularios ,'vacantes' => $vacantes , 'reclutamientos' => $reclutamientos , 'candidatos' => $candidatos ]);
    }

    public function destroy($id)
    {
        // Encontrar la vacante por ID
        $vacante = Vacantes::findOrFail($id);

        // Eliminar la vacante
        $vacante->delete();

        $organigrama = OrganigramaLinealNiveles::where('codigo', $vacante->codigo)->first();
        if ($organigrama) {
            $organigrama->delete();
        }

        // Redirigir a la lista de vacantes con un mensaje de éxito
        return redirect('/vacantes')->with('success', 'Vacante eliminada exitosamente.');
    }

}
