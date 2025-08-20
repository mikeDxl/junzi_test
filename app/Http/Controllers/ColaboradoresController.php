<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Config;
use App\Models\Altas;
use App\Models\Bajas;
use App\Models\Bancos;
use App\Models\Externos;
use App\Models\Generos;
use Illuminate\Support\Str;
use App\Models\Afores;
use App\Models\Estados;
use App\Models\Solicitudes;
use App\Models\Vacantes;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Conexiones;
use App\Models\Departamentos;
use App\Models\Familiares;
use App\Models\Notificaciones;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\EstadoCivil;
use App\Models\Agrupadores;
use App\Models\CatalogosdeTiposdeContratos;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\CatalogoDepartamentos;
use App\Models\CatalogoPuestos;
use App\Models\PuestosCC;
use App\Models\ColaboradoresCC;
use App\Models\CatalogosdeTiposdePeriodo;
use App\Models\CatalogosdeTiposdeBasedeCotizacion;
use App\Models\CatalogosdeTiposdePrestacion;
use App\Models\CatalogosdeTiposdeTurnodeTrabajo;
use App\Models\CatalogosdeTiposdeBasedePago;
use App\Models\CatalogosdeTiposdeMetododePago;
use App\Models\CatalogosdeTiposdeRegimen;
use App\Models\CatalogosdeTiposdeJornada;
use App\Models\CatalogosdeTiposdeZonadeSalario;
use App\Models\OrganigramaLinealNiveles;
use App\Models\TiposdeTurnodeTrabajo;
use App\Models\TiposdePeriodo;
use App\Models\CentrodeCostos;
use App\Models\PerfilPuestos;
use App\Models\ProcesoRH;
use App\Models\RegistroPatronal;
use App\Models\DireccionesColaborador;
use App\Models\DocumentosColaborador;
use App\Models\TiposdeSolicitudes;
use App\Models\TiposdeDocumentos;
use App\Http\Requests\StoreColaboradoresRequest;
use App\Http\Requests\UpdateColaboradoresRequest;
use App\Models\Colaboradores;
use App\Models\DepartamentosCC;
use App\Models\User;
use App\Models\Vacaciones;
use App\Models\Incapacidad;
use App\Models\Permisos;
use App\Models\Gratificaciones;
use App\Models\HorasExtra;
use App\Models\Asistencias;
use App\Models\Beneficiarios;
use App\Models\DepartamentosColaboradores;
use App\Models\PuestosColaboradores;





class ColaboradoresController extends Controller
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


    public function test_colab()
    {


        $colaboradores=Colaboradores::where('estatus','activo')->get();


        return view('test_colab' , [  'colaboradores' => $colaboradores ]);
    }

    public function incidencias($id)
    {


        $vacaciones=Vacaciones::where('colaborador_id',$id)->get();
        $incapacidades=Incapacidad::where('colaborador_id',$id)->get();
        $permisos=Permisos::where('colaborador_id',$id)->get();
        $asistencias=Asistencias::where('colaborador_id',$id)->get();
        $horasextra=HorasExtra::where('colaborador_id',$id)->get();
        $compensaciones=Gratificaciones::where('colaborador_id',$id)->get();



        return view('colaboradores.incidencias' , compact('vacaciones','incapacidades','permisos','asistencias','horasextra','compensaciones','id'));
    }

    public function generar_usuarios()
    {
            // Obtener todos los colaboradores activos

      /*
      // Obtener todos los colaboradores activos
      $colaboradores = Colaboradores::where('estatus', 'activo')->get();

      foreach ($colaboradores as $colaborador) {
          // Construir el correo electrónico con las reglas establecidas
          $nombre = str_replace(' ', '', $colaborador->nombre); // Eliminar espacios en el nombre
          $apellido_paterno = $colaborador->apellido_paterno;
          $apellido_materno = $colaborador->apellido_materno;

          // Generar correo electrónico
          $email = strtolower(substr($apellido_paterno, 0, 1)) . $nombre . strtolower(substr($apellido_materno, 0, 1));

          // Verificar si el correo electrónico ya existe
          $suffix = '';
          $original_email = $email;
          $count = 1;

          while (User::where('email', $email)->exists()) {
              $email = $original_email . ++$count;
          }

          // Crear el usuario con el correo electrónico generado

          $user = new User();
          $user->name = $colaborador->nombre;
          $user->email = strtolower($email.'@gonie.com');
          $user->password = bcrypt('password'); // Puedes cambiar esto según tus políticas de seguridad
          $user->save();


          // Asociar el usuario al colaborador si es necesario
          //$colaborador->user_id = $user->id;
          //$colaborador->save();
          $email=strtolower($email.'@gonie.com');
          echo "<br>Correo electrónico generado para {$colaborador->nombre} {$colaborador->apellido_paterno}: {$email}\n";
      }
      */
    }




    public function index()
    {


        if(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina'){
          $info=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
          $centro=CentrodeCostos::where('centro_de_costos',$info->organigrama)->first();

          $colaboradores_jd=OrganigramaLinealNiveles::where('cc',$centro->id)->get();
          $colaboradorIds = $colaboradores_jd->pluck('colaborador_id')->toArray();
          $colaboradores = Colaboradores::whereIn('id', $colaboradorIds)
          ->where('estatus', 'activo')
          ->get();
        }else {
          if (session('company_id')=='Todas' || session('company_id')=='0'  || session('company_id')=='' ) {
            $colaboradores = Colaboradores::where('estatus','activo')->get();
          }else {
            $colaboradores = Colaboradores::where('company_id',session('company_id'))->where('estatus','activo')->get();
          }
        }



        return view('colaboradores.index' , [  'colaboradores' => $colaboradores ]);
    }



    public function cargarDocumentos(Request $request)
  {
      $idcolab = $request->idcolab;
      $tipo = $request->tipo;
      $tipo2 = $request->tipo2;

      if ($tipo == 'Otro') {
          $tipo = $tipo2;
      }

      // Verificar si el tipo es nulo o está vacío
      if (empty($tipo)) {
          return redirect('/editar-colaborador/'.$idcolab)->with('error', 'El campo tipo es obligatorio.');
      }

      $ruta = "/var/www/proyectos/junzi/storage/app/documentos/{$idcolab}/";

      try {
          if (!file_exists($ruta)) {
              mkdir($ruta, 0777, true);
          }

          if ($request->hasFile('documento')) {
              $archivo = $request->file('documento');
              $nombreArchivo = uniqid() . '_' . $archivo->getClientOriginalName();
              $archivo->move($ruta, $nombreArchivo);

              $documentoColaborador = new DocumentosColaborador();
              $documentoColaborador->colaborador_id = $idcolab;
              $documentoColaborador->tipo = $tipo;
              $documentoColaborador->ruta = $nombreArchivo;
              $documentoColaborador->save();
          }

          return redirect('/editar-colaborador/'.$idcolab)->with('success', 'Documento cargado correctamente.');
      } catch (\Exception $e) {
          return redirect('/editar-colaborador/'.$idcolab)->with('error', 'Error al cargar el documento: ' . $e->getMessage());
      }
  }






    public function eliminarDocumento($id)
    {
        try {
            $documento = DocumentosColaborador::findOrFail($id);

            // Elimina el archivo del sistema de archivos
            Storage::delete('public/'.$documento->ruta);

            // Elimina el registro de la base de datos
            $documento->delete();

            return back()->with('success', 'Documento eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el documento.');
        }
    }

    public function update1(Request $request){


      $ruta = "fotoperfil/{$request->colaborador_id}/";

      // Verificar si la carpeta ya existe, si no, crearla
      if (!Storage::exists($ruta)) {
          Storage::makeDirectory($ruta);
      }

        if ($request->hasFile('photo')) {


          $archivo_photo = $request->file('photo');
          $nombreOriginal = $archivo_photo->getClientOriginalName();
          $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
          $extension = $archivo_photo->getClientOriginalExtension();
          $nombreArchivo_photo = $nombreSinAcentos . '.' . $extension;

          $archivo_photo->storeAs($ruta, $nombreArchivo_photo, 'public');


          Colaboradores::where('id',$request->colaborador_id)->update([
              'fotografia' => $ruta.$nombreArchivo_photo
          ]);
        }

      Colaboradores::where('id',$request->colaborador_id)->update([
          'nombre' => $request->nombre ,
          'apellido_paterno' => $request->apellido_paterno ,
          'apellido_materno' => $request->apellido_materno ,
          'rfc' => $request->rfc ,
          'curp' => $request->curp
      ]);

      return redirect()->back()->with('success', 'Datos actualizados.');
    }

    public function update2(Request $request)
    {
        try {
            // Intentar actualizar los datos del colaborador
            Colaboradores::where('id', $request->colaborador_id)->update([
                'nss' => $request->nss,
                'infonavit' => $request->infonavit,
                'monto_descuento' => $request->monto_descuento,
                'tipo_descuento' => $request->tipo_descuento,
                'inicio_infonavit' => $request->fecha_inicio,
            ]);

            // Si la actualización es exitosa, redirigir con un mensaje de éxito
            return redirect()->back()->with('success', 'Datos actualizados correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, capturarlo y redirigir con un mensaje de error
            // Puedes personalizar el mensaje de error o utilizar $e->getMessage() para detalles específicos del error
            return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }
    }

public function update3(Request $request)
{
    try {
        // Intentar actualizar los datos bancarios del colaborador
        Colaboradores::where('id', $request->colaborador_id)->update([
            'banco' => $request->banco,
            'cuenta_cheques' => $request->cuenta_cheques,
            'clabe_interbancaria' => $request->clabe_interbancaria,
            'tarjeta' => "0",
            'metodo_de_pago_id' => $request->metodo_de_pago_id,
        ]);

        // Si la actualización es exitosa, redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Datos bancarios actualizados correctamente.');
    } catch (\Exception $e) {
        // Si ocurre un error durante la actualización, capturarlo
        // Redirigir con un mensaje de error. Se puede personalizar el mensaje o usar $e->getMessage()
        return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
    }
}


public function update4(Request $request)
{

    $colabinfo = Colaboradores::where('id', $request->colaborador_id)->first();

    $centroDeCostos = $request->centro_de_costos;





    if (is_numeric($centroDeCostos)) {

        $cc = CatalogoCentrosdeCostos::where('id', $request->centro_de_costos)->first();

        $pc= PuestosCC::where('id',$request->puesto)->where('id_catalogo_centro_de_costos_id',$cc->id)->first();
        $pp = CatalogoPuestos::where('id', $pc->id_catalogo_puestos_id)->first();
        $pnom = PerfilPuestos::where('puesto',$pp->puesto)->where('company_id', $colabinfo->company_id)->first();

        $dc= DepartamentosCC::where('id',$request->departamento)->where('id_catalogo_centro_de_costos_id',$cc->id)->first();
        $dd = CatalogoDepartamentos::where('id', $dc->id_catalogo_departamento_id)->first();
        $dnom = Departamentos::where('departamento',$dd->departamento)->where('company_id', $colabinfo->company_id)->first();

        try {
            // Actualiza la información del colaborador
            Colaboradores::where('id', $request->colaborador_id)->update([
                'organigrama' => $cc->centro_de_costo,
                'departamento_id' => $dnom->departamento,
                'puesto' => $pnom->idpuesto,
                'jefe_directo' => $request->jefe_directo,
                'registro_patronal_id' => $request->registropatronal,
                'tipo_de_contrato_id' => $request->tipocontrato,
                'periodo_id' => $request->tipoperiodo,
                'prestacion_id' => $request->tipoprestacion,
                'regimen_id' => $request->tiporegimen,
                'turno_de_trabajo_id' => $request->tipoturnodetrabajo,
                'jornada_id' => $request->tipojornada,
            ]);


            ColaboradoresCC::where('colaborador_id',$request->colaborador_id)->update([
                'id_catalogo_centro_de_costos_id' => $cc->id
            ]);


            DepartamentosColaboradores::where('colaborador_id',$request->colaborador_id)->update([
                'id_catalogo_departamento_id' => $dc->id_catalogo_departamento_id
            ]);


            PuestosColaboradores::where('id_colaborador',$request->colaborador_id)->update([
                'id_catalogo_puesto_id' => $pc->id_catalogo_puestos_id
            ]);




            OrganigramaLinealNiveles::updateOrCreate(
                ['colaborador_id' => $request->colaborador_id],
                [
                    'puesto' => $request->puesto,
                    'organigrama_id' => '1',
                    'nivel' => '2',
                    'jefe_directo_id' => '0',
                    'jefe_directo_codigo' => '0',
                    'codigo' => '0',
                ]
            );

            if ($cc) {
                OrganigramaLinealNiveles::updateOrCreate(
                    ['colaborador_id' => $request->colaborador_id],
                    [
                        'cc' => $cc->id,
                        'organigrama_id' => '1',
                        'nivel' => '2',
                        'jefe_directo_id' => '0',
                        'jefe_directo_codigo' => '0',
                        'codigo' => '0',
                    ]
                );
            }

            // Valida y procesa el jefe directo

            if (!is_null($request->jefe_directo) && $request->jefe_directo !== '' && $request->jefe_directo !== '0') {
                User::where('colaborador_id', $request->colaborador_id)->update(
                    ['jefe_id' => $request->jefe_directo ?? '0']
                );

                $info_jefe = OrganigramaLinealNiveles::where('colaborador_id', $request->jefe_directo)->first();

                if ($info_jefe) {
                    OrganigramaLinealNiveles::updateOrCreate(
                        ['colaborador_id' => $request->colaborador_id],
                        [
                            'organigrama_id' => '1',
                            'jefe_directo_id' => $info_jefe->colaborador_id,
                            'jefe_directo_codigo' => $info_jefe->codigo,
                            'nivel' => $info_jefe->nivel + 1
                        ]
                    );
                }
            }

            // Si todo sale bien, redirige con un mensaje de éxito
            return redirect()->back()->with('success', 'Datos actualizados correctamente.');
        } catch (\Exception $e) {
            // En caso de error, captura la excepción y redirige con un mensaje de error
            return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }

    }else {

        try {
            // Actualiza la información del colaborador
            Colaboradores::where('id', $request->colaborador_id)->update([
                'jefe_directo' => $request->jefe_directo,
                'registro_patronal_id' => $request->registropatronal,
                'tipo_de_contrato_id' => $request->tipocontrato,
                'periodo_id' => $request->tipoperiodo,
                'prestacion_id' => $request->tipoprestacion,
                'regimen_id' => $request->tiporegimen,
                'turno_de_trabajo_id' => $request->tipoturnodetrabajo,
                'jornada_id' => $request->tipojornada,
            ]);

            // Si todo sale bien, redirige con un mensaje de éxito
            return redirect()->back()->with('success', 'Datos actualizados correctamente.');
        } catch (\Exception $e) {
            // En caso de error, captura la excepción y redirige con un mensaje de error
            return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }

    }


}



    public function update5(Request $request){



      return redirect()->back()->with('success', 'Datos actualizados.');
    }

    public function update6(Request $request)
    {
      try {
          // Intenta actualizar la información del colaborador
          Colaboradores::where('id', $request->colaborador_id)->update([
              'email' => $request->email,
              'genero' => $request->genero,
              'estado_nacimiento' => $request->estado_nacimiento,
              'ciudad_nacimiento' => $request->ciudad_nacimiento,
              'estado_civil_id' => $request->estado_civil_id,
          ]);

          // Si todo sale bien, redirige con un mensaje de éxito
          return redirect()->back()->with('success', 'Datos actualizados correctamente.');
      } catch (\Exception $e) {
          // En caso de error, captura la excepción y redirige con un mensaje de error
          return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
      }
    }
    public function update7(Request $request)
    {
        // Actualizar la dirección del colaborador
        $colaborador = Colaboradores::find($request->colaborador_id);
        if ($colaborador) {
            $colaborador->direccion = $request->direccion;
            $colaborador->save();
        }

        // Actualizar o crear registros de familiares
        if ($request->idfam) {
            foreach ($request->idfam as $index => $idFam) {
                Familiares::updateOrCreate(
                    ['id' => $idFam], // Condición para buscar el familiar
                    [
                        'colaborador_id' => $request->colaborador_id,
                        'nombre' => $request->familiar_nombre[$index] ?? null,
                        'relacion' => $request->familiar_relacion[$index] ?? null,
                    ]
                );
            }
        }

        // Crear nuevos familiares si no tienen ID
        if ($request->familiar_nombre) {
            foreach ($request->familiar_nombre as $index => $nombre) {
                if (!empty($nombre)) { // Evitar valores vacíos
                    Familiares::updateOrCreate(
                        ['id' => $request->idfam[$index] ?? null], // Condición para buscar el familiar
                        [
                            'colaborador_id' => $request->colaborador_id,
                            'company_id' => $colaborador->company_id,
                            'nombre' => $nombre,
                            'relacion' => $request->familiar_relacion[$index] ?? null,
                        ]
                    );
                }
            }
        }


        return redirect()->back()->with('success', 'Datos actualizados.');
    }

    public function update8(Request $request)
    {
        $colaborador = Colaboradores::findOrFail($request->colaborador_id);

        $colaborador->update([
            'salario_diario' => $request->salario_diario,
            'base_de_cotizacion_id' => $request->base_de_cotizacion_id,
            'sbc' => $request->sbc,
            'sindicalizado' => $request->sindicalizado,
            'base_de_pago_id' => $request->base_de_pago_id,
            'zona_de_salario_id' => $request->zona_de_salario_id,
            'fonacot' => $request->fonacot,
            'afore' => $request->afore,
            'umf' => $request->umf,
        ]);

        return redirect()->back()->with('success', 'Datos actualizados.');
    }


    public function update9(Request $request)
    {
        try {
            $colaborador = Colaboradores::find($request->colaborador_id);
            // Actualizar datos de salud
            Colaboradores::where('id', $request->colaborador_id)->update([
                'tipo_de_sangre' => $request->tipo_de_sangre,
                'tiene_alergia' => $request->tiene_alergia,
                'alergias' => $request->alergias,
            ]);

            // Actualizar beneficiarios existentes
            if (!empty($request->beneficiario_id)) {
                foreach ($request->beneficiario_id as $index => $id) {
                    Beneficiarios::where('id', $id)->update([
                        'nombre' => $request->beneficiario_nombre[$index],
                        'company_id' => $colaborador->company_id,
                        'telefono' => $request->beneficiario_telefono[$index],
                    ]);
                }
            }

            // Agregar nuevos beneficiarios
            if (!empty($request->nuevo_beneficiario_nombre)) {
                foreach ($request->nuevo_beneficiario_nombre as $index => $nombre) {
                    if (!empty($nombre)) {
                        Beneficiarios::create([
                            'colaborador_id' => $request->colaborador_id,
                            'nombre' => $nombre,
                            'company_id' => $colaborador->company_id,
                            'telefono' => $request->nuevo_beneficiario_telefono[$index],
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Información de salud y beneficiarios actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }
    }



    public function update10(Request $request){



      return redirect()->back()->with('success', 'Datos actualizados.');
    }


    public function externos(){

      $externos=Externos::all();


      return view('colaboradores.externos' , [  'externos' => $externos ]);
    }

    public function toggleStatusExterno($id)
    {


        try {
            $externo = Externos::findOrFail($id);
            $externo->estatus = $externo->estatus == 'Activo' ? 'Inactivo' : 'Activo';
            $externo->save();

            return redirect('/colaboradores/externos')->with('success', 'Estatus cambiado correctamente');
        } catch (\Exception $e) {
            // En caso de error, redirige con un mensaje de error
            return redirect('/colaboradores/externos')->with('error', 'Error al cambiar el estatus. Intenta de nuevo.');
        }


    }


    public function baja_colaboradores(Request $request)
    {

        Colaboradores::where('id',$request->id)->delete();


        $create_v=new Vacantes();
        $create_v->area_id='0';
        $create_v->company_id='1';
        $create_v->departamento_id=$iddepartamento;
        $create_v->puesto_id=$info->puesto;
        $create_v->fecha='2023-08-28';
        $create_v->area='FINANCIERA';
        $create_v->jefe='185';
        $create_v->estatus='pendiente';
        $create_v->prioridad='0';
        $create_v->save();


        return redirect('/colaboradores');
    }



    public function buscarDepartamentos(Request $request)
    {
        $cc = $request->centro_de_costos;

        // Cargar los departamentos junto con la relación catalogoDepartamentos
        $departamentos = DepartamentosCC::where('id_catalogo_centro_de_costos_id', $cc)->get();

        // Verificar si se encontraron departamentos
        if ($departamentos->isNotEmpty()) {
            // Crear un array para almacenar los departamentos
            $departamentosResponse = [];

            // Iterar sobre los departamentos y agregar al array
            foreach ($departamentos as $departamento) {
                $departamentosResponse[] = [
                    'id' => $departamento->id,
                    'departamento' => $departamento->catalogoDepartamentos->departamento
                ];
            }

            // Eliminar duplicados basados en el campo 'departamento'
            $departamentosResponse = collect($departamentosResponse)->unique('departamento')->values()->all();

            // Retornar la respuesta con los departamentos sin duplicados
            return response()->json($departamentosResponse, 200);
        }

        // Si no hay departamentos, devolver un array vacío
        return response()->json([], 200);
    }




    public function buscarPuestos(Request $request)
    {
        $cc = $request->centro_de_costos;

        $puestos = PuestosCC::where('id_catalogo_centro_de_costos_id', $cc)->get();

        if ($puestos->isNotEmpty()) {
            $puestosResponse = [];

            foreach ($puestos as $puesto) {
                $puestosResponse[] = [
                    'id' => $puesto->id,
                    'puesto' => $puesto->catalogoPuesto->puesto
                ];
            }

            $puestosResponse = collect($puestosResponse)->unique('puesto')->values()->all();

            return response()->json($puestosResponse, 200);
        }

        return response()->json([], 200);
    }

    public function buscarJefesDirectos(Request $request)
    {
        $cc = $request->centro_de_costos;

        // Obtener los colaboradores relacionados con el centro de costos
        $colaboradores = ColaboradoresCC::where('id_catalogo_centro_de_costos_id', $cc)
            ->with('colaborador') // Asegúrate de cargar la relación 'colaborador'
            ->get();

        if ($colaboradores->isNotEmpty()) {
            $colaboradoresResponse = [];

            // Recorrer los colaboradores y agregarlos al array de respuesta
            foreach ($colaboradores as $colaboradorCC) {
                $colaboradoresResponse[] = [
                    'id' => $colaboradorCC->colaborador_id, // Usar el ID del colaborador
                    'colaborador' => $colaboradorCC->colaborador->nombre . ' ' . $colaboradorCC->colaborador->apellido_paterno . ' ' . $colaboradorCC->colaborador->apellido_materno, // Obtener nombre completo
                ];
            }

            // Retornar los colaboradores como respuesta JSON
            return response()->json($colaboradoresResponse, 200);
        }

        // Si no hay colaboradores, devolver un array vacío
        return response()->json([], 200);
    }


    public function buscarColaborador(Request $request){

      $puesto=$request->puesto;

      $colaboradores=Colaboradores::where('puesto',$puesto)->where('estatus','activo')->get();

      $respuesta='<option value="">Selecciona una opción:</option>';
      $respuesta.='<option value="0">No tiene</option>';

      foreach ($colaboradores as $colab) {
            $respuesta.= '<option value="' . $colab->id . '">' . $colab->nombre .' '. $colab->apellido_paterno.' '. $colab->apellido_materno.'</option>';
      }

      return $respuesta;
    }


    public function alta_externos(Request $request){

      $create=new Externos();
      $create->area=$request->centro_de_costo;
      $create->company_id=$request->company_id;
      $create->empresa=$request->empresa;
      $create->giro=$request->giro;
      $create->presupuesto=$request->presupuesto;
      $create->cantidad=$request->cantidad;
      $create->ingreso=$request->ingreso;
      $create->rfc=$request->rfc;
      $create->jefe=$request->jefe;
      $create->tipo=$request->tipo;
      $create->comentarios=' ';
      $create->save();

      return redirect('/colaboradores/externos');

    }

    public function edit_externo($id)
    {
        $externo = Externos::findOrFail($id);
        $razones = Companies::all(); // Obtener todas las razones sociales
        $centro_de_costos = CatalogoCentrosdeCostos::all(); // Obtener todos los centros de costos
        $colaboradores = Colaboradores::where('estatus', 'activo')
          ->select('id', 'nombre', 'apellido_paterno', 'apellido_materno')
          ->orderBy('apellido_paterno')
          ->get(); // Obtener colaboradores activos

        return view('colaboradores.update_externo', compact('externo', 'razones', 'centro_de_costos', 'colaboradores'));
    }



    public function update_externo(Request $request, $id)
    {
        $externo = Externos::findOrFail($id);

        $externo->company_id = $request->company_id;
        $externo->area = $request->centro_de_costo;
        $externo->empresa = $request->empresa;
        $externo->rfc = $request->rfc;
        $externo->tipo = $request->tipo;
        $externo->giro = $request->giro;
        $externo->presupuesto = $request->presupuesto;
        $externo->ingreso = $request->ingreso;
        $externo->cantidad = $request->cantidad;
        $externo->jefe = $request->jefe;
        $externo->estatus = $request->estatus; // Manejar el campo estatus

        $externo->save();

        return redirect('/colaboradores/externos')->with('success', 'Colaborador externo actualizado correctamente.');
    }



    public function delete_externo($id) {
        $externo = Externos::findOrFail($id);
        $externo->delete();

        return redirect('/colaboradores/externos')->with('success', 'Colaborador externo eliminado correctamente.');
    }




    public function crear()
    {

        $departamentos = Departamentos::all();
        $colaboradores = Colaboradores::all();
        $razones = Companies::all();
        $conexiones = Conexiones::all();

        $numero_de_empleado = Colaboradores::max('numero_de_empleado');
        $numero_de_empleado=$numero_de_empleado+1;
        $idempleado = Colaboradores::max('idempleado');
        $idempleado=$idempleado+1;


        $puestos = PerfilPuestos::all();
        $catalogoDepartamentos = CatalogoDepartamentos::all();
        $catalogoPuestos = CatalogoPuestos::all();
        $centro_de_costos = CatalogoCentrosdeCostos::all();
        $tiposdecontratos = CatalogosdeTiposdeContratos::all();
        $tiposdeperiodo = CatalogosdeTiposdePeriodo::all();
        $tiposbasedecotizacion = CatalogosdeTiposdeBasedeCotizacion::all();
        $registropatronal = RegistroPatronal::all();
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
        return view('colaboradores.crear' , [
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
            'areas' => $areas ,
            'centro_de_costos' => $centro_de_costos ,
            'numero_de_empleado' => $numero_de_empleado ,
            'idempleado' => $idempleado ,
            'conexiones' => $conexiones ,
            'bancos' => $bancos  ,
            'catalogoDepartamentos' => $catalogoDepartamentos  ,
            'catalogoPuestos' => $catalogoPuestos  ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarDocumentos(Request $request)
    {
        $documento = $request->file('documento')->store($request->colaborador_id.'/documentos', 'public');

        $create=new DocumentosColaborador();
        $create->colaborador_id=$request->colaborador_id;
        $create->tipo=$request->tipodedocumento;
        $create->ruta=$documento;
        $create->save();


        return redirect('/vista-colaborador/'.$request->colaborador_id);
    }

    public function eliminar_externos(Request $request){

      Externos::where('id',$request->idexterno)->delete();

      return redirect('/externos');
    }

    public function crear_externos(){


      $centro_de_costos = CatalogoCentrosdeCostos::orderBy('centro_de_costo', 'asc')->get();
      $razones = Companies::all();
      $colaboradores = Colaboradores::where('estatus','activo')->get();


      $colaboradores = Colaboradores::where('estatus', 'activo')->get();

        // Eliminar duplicados en PHP
        $uniqueColaboradores = $colaboradores->unique(function($item) {
            return $item->nombre . $item->apellido_paterno . $item->apellido_materno;
        })->values();

      return view('colaboradores.crear_externos' , compact('centro_de_costos','razones','uniqueColaboradores'));

    }

    public function alta(Request $request)
    {

        $centro_de_costos = CatalogoCentrosdeCostos::where('id', $request->centro_de_costos)->first();
        $create=new Colaboradores();
        $create->organigrama=$centro_de_costos->centro_de_costo ?? '';
        $create->company_id=$request->razon_social;
        $create->nombre=$request->nombre;
        $create->idempleado=$request->numero_de_empleado;
        $create->numero_de_empleado=$request->numero_de_empleado;
        $create->apellido_paterno=$request->apellido_paterno;
        $create->apellido_materno=$request->apellido_materno;
        $create->fecha_alta=$request->fecha_alta.' 00:00:00.000';
        $create->fecha_baja="1899-12-30 00:00:00.000";
        $create->estatus='activo';
        $create->genero=$request->genero;
        $create->fecha_nacimiento=$request->fecha_nacimiento;
        $create->estado=$request->estado_nacimiento;
        $create->estadoempleado='A';
        $create->poblacion=$request->ciudad_nacimiento;
        $create->tipo_de_contrato_id=$request->tiposdecontrato;
        $create->rfc=$request->rfc;
        $create->curp=$request->curp;
        $create->periodo_id=$request->tiposdeperiodo;
        $create->salario_diario=$request->salario_diario;
        $create->base_de_cotizacion_id=$request->base_de_cotizacion;
        $create->sbc_parte_fija=$request->sbc_parte_fija;
        $create->sbc_parte_variable=$request->sbc_parte_variable;
        $create->sbc=$request->sbc;
        $create->departamento_id=$request->departamento;
        $create->jefe_directo=$request->jefe_directo;
        $create->puesto=$request->puesto;
        $create->sindicalizado=$request->sindicalizado;
        $create->prestacion_id=$request->tipodeprestacion;
        $create->base_de_pago_id=$request->tipodebasedepago;
        $create->metodo_de_pago_id=$request->tipodemetododepago;
        $create->turno_de_trabajo_id=$request->tipodeturnodetrabajo;
        $create->zona_de_salario_id=$request->tipodezonadesalario;
        $create->jornada_id=$request->tipodejornada;
        $create->regimen_id=$request->tipoderegimen;
        $create->fonacot=$request->fonacot;
        $create->afore=$request->afore;
        $create->email=$request->email;
        $create->nss=$request->nss;
        $create->registro_patronal_id=$request->registro_patronal_id;
        $create->umf=$request->umf;
        $create->estado_civil_id=$request->estado_civil;
        $create->telefono=$request->telefono;
        $create->celular=$request->celular;
        $create->codigopostal=$request->postal;
        $create->clabe_interbancaria=$request->clabe_interbancaria;
        $create->cuenta_cheques=$request->cuenta_cheques;
        $create->banco=$request->banco;
        $create->save();




        $codigoorganigrama=$request->codigoorganigrama;

        if ($codigoorganigrama) {
          OrganigramaLinealNiveles::where('codigo',$request->codigoorganigrama)->update([
            'colaborador_id' => $create->id
          ]);
        }

        if ($request->hasfile('fotografia')) {

            $ruta = $request->file('fotografia')->store($create->id.'/fotografia', 'public');
            $create_doc=new DocumentosColaborador();
            $create_doc->colaborador_id=$create->id;
            $create_doc->tipo='fotografia';
            $create_doc->ruta=$ruta;
            $create_doc->save();


            Colaboradores::where('id',$create->id)->update([
                'fotografia' => $ruta
            ]);
        }


        if ($request->hasfile('identificacion')) {


            $ruta = $request->file('identificacion')->store($create->id.'/identificacion', 'public');
            $create_doc2=new DocumentosColaborador();
            $create_doc2->colaborador_id=$create->id;
            $create_doc2->tipo='identificacion';
            $create_doc2->ruta=$ruta;
            $create_doc2->save();
        }



        if ($request->hasfile('comprobante')) {

            $ruta = $request->file('comprobante')->store($create->id.'/comprobante', 'public');

            $create_doc3=new DocumentosColaborador();
            $create_doc3->colaborador_id=$create->id;
            $create_doc3->tipo='comprobante';
            $create_doc3->ruta=$ruta;
            $create_doc3->save();
        }


        if ($request->hasfile('otro')) {

            $ruta = $request->file('otro')->store($create->id.'/otro', 'public');

            $create_doc4=new DocumentosColaborador();
            $create_doc4->colaborador_id=$create->id;
            $create_doc4->tipo='otro';
            $create_doc4->ruta=$ruta;
            $create_doc4->save();
        }

        $create2=new DireccionesColaborador();
        $create2->colaborador_id=$create->id;
        $create2->calle=$request->calle;
        $create2->colonia=$request->colonia;
        $create2->codigo_postal=$request->postal;
        $create2->municipio=" ";
        $create2->ciudad=$request->ciudad;
        $create2->estado=$request->estado;
        $create2->save();

        $companies = Companies::where('user_id',auth()->user()->id)->get();
        $departamentos = Departamentos::all();
        $colaboradores = Colaboradores::all();


        if ($request->candidato_id) {

        }

        $documentos_candidato=ProcesoRH::where('candidato_id',$request->candidato_id)->where('vacante_id',$request->vacante_id)->first();

        if ($documentos_candidato) {

        // Crear un nuevo registro en DocumentosColaborador
        if ($documentos_candidato->curriculum) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'Curriculum';
          $documentoColaborador->ruta = $documentos_candidato->curriculum;
          $documentoColaborador->save();
        }

        if ($documentos_candidato->documento1) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'Identificación';
          $documentoColaborador->ruta = $documentos_candidato->documento1;
          $documentoColaborador->save();
        }

        if ($documentos_candidato->documento2) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'Comprobante de domicilio';
          $documentoColaborador->ruta = $documentos_candidato->documento2;
          $documentoColaborador->save();
        }


        if ($documentos_candidato->documento3) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'CURP';
          $documentoColaborador->ruta = $documentos_candidato->documento3;
          $documentoColaborador->save();
        }

        if ($documentos_candidato->documento4) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'Acta de nacimiento';
          $documentoColaborador->ruta = $documentos_candidato->documento4;
          $documentoColaborador->save();
        }

        if ($documentos_candidato->documento5) {
          $documentoColaborador = new DocumentosColaborador();
          $documentoColaborador->colaborador_id = $create->id;
          $documentoColaborador->tipo = 'IMSS';
          $documentoColaborador->ruta = $documentos_candidato->documento5;
          $documentoColaborador->save();
        }


        if ($documentos_candidato->fotoexamen) {
        $documentoColaborador = new DocumentosColaborador();
        $documentoColaborador->colaborador_id = $create->id;
        $documentoColaborador->tipo = 'Psicométrico';
        $documentoColaborador->ruta = $documentos_candidato->fotoexamen;
        $documentoColaborador->save();
      }


          if ($documentos_candidato->referencia_nombre2) {
        $documentoColaborador = new DocumentosColaborador();
        $documentoColaborador->colaborador_id = $create->id;
        $documentoColaborador->tipo = 'Carta 1';
        $documentoColaborador->ruta = $documentos_candidato->referencia_nombre2;
        $documentoColaborador->save();
      }

        if ($documentos_candidato->referencia_telefono2) {
        $documentoColaborador = new DocumentosColaborador();
        $documentoColaborador->colaborador_id = $create->id;
        $documentoColaborador->tipo = 'Carta 2';
        $documentoColaborador->ruta = $documentos_candidato->referencia_telefono2;
        $documentoColaborador->save();
      }

          if ($documentos_candidato->referencia_nombre1) {
        $documentoColaborador = new DocumentosColaborador();
        $documentoColaborador->colaborador_id = $create->id;
        $documentoColaborador->tipo = 'Buró Laboral';
        $documentoColaborador->ruta = $documentos_candidato->referencia_nombre1;
        $documentoColaborador->save();
      }

    // Repite este proceso para cada campo de documento que desees copiar
}


        return redirect('/colaboradores');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreColaboradoresRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function importarNomipaq(Request $request)
    {


        $actual=session('idbaseactual');
        $conexion=Conexiones::where('id',$actual)->first();

        $host=Crypt::decryptString($conexion->host);
        $port=Crypt::decryptString($conexion->port);
        $database=Crypt::decryptString($conexion->database);
        $username=Crypt::decryptString($conexion->user);
        $password=Crypt::decryptString($conexion->password);
        $driver=$conexion->driver;

        Config::offsetUnset('database.connections.'.session('baseactual'));


        Config::set('database.connections.'.session('baseactual'), [
            'driver' => 'sqlsrv',
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        DB::purge(session('baseactual'));
        DB::reconnect(session('baseactual'));


        if (DB::connection(session('baseactual'))->getDatabaseName()) {

        }else {
          echo "Error al conectarse a ".session('baseactual');
        }



        $create=new Companies();
        $create->user_id=auth()->user()->id;
        $create->nombre=trim(str_replace('-' , '' , $request->empresa));
        $create->rfc=$request->rfc;
        $create->razon_social=$request->empresa;
        $create->calle=$request->direccion;
        $create->colonia=" ";
        $create->codigo_postal=" ";
        $create->municipio=" ";
        $create->ciudad=" ";
        $create->estado=" ";
        $create->save();

        $numerodecompany=$create->id;
        $sqlsrv=session('baseactual');

        Conexiones::where('id',$actual)->update([ 'company_id' => $numerodecompany ]);


        $nom10001=DB::connection($sqlsrv)->table('nom10001')->get();

        foreach ($nom10001 as $n1){
            $fecha=trim(str_replace('00:00:00' , '' , $n1->fechanacimiento));
            $fecha2=trim(str_replace('-' , '' , $fecha));
            $fecha2=trim(substr($fecha2, 2));

            $sexo="";
            if($n1->sexo=='M'){ $sexo='Masculino'; }
            if($n1->sexo=='F'){ $sexo='Femenino'; }

            $estatus="inactivo";
            if($n1->fechabaja=='1899-12-30 00:00:00'){ $estatus='activo'; }
            else{ $estatus='inactivo'; }

            $create1=new Colaboradores();
            $create1->company_id=$numerodecompany;
            $create1->idempleado=$n1->idempleado;
            $create1->numero_de_empleado=$n1->codigoempleado;
            $create1->departamento_id=$n1->iddepartamento;
            $create1->puesto=$n1->idpuesto;
            $create1->nombre=trim(strtoupper($n1->nombre));
            $create1->apellido_paterno=trim(strtoupper($n1->apellidopaterno));
            $create1->apellido_materno=trim(strtoupper($n1->apellidomaterno));
            $create1->fecha_nacimiento=$fecha;
            $create1->genero=$sexo;
            $create1->rfc=$n1->rfc.$fecha2.$n1->homoclave;
            $create1->curp=$n1->curpi.$fecha2.$n1->curpf;
            $create1->nss=$n1->numerosegurosocial;
            $create1->salario_diario=$n1->sueldodiario;
            $create1->turno_de_trabajo_id=$n1->idturno;
            $create1->periodo_id=$n1->idtipoperiodo;
            $create1->fecha_alta=$n1->fechaalta;
            $create1->fecha_baja=$n1->fechabaja;
            $create1->estadoempleado=$n1->estadoempleado;
            $create1->telefono=trim($n1->telefono);
            $create1->codigopostal=trim($n1->codigopostal);
            $create1->direccion=trim($n1->direccion);
            $create1->poblacion=trim($n1->poblacion);
            $create1->estado=trim($n1->estado);
            $create1->proyectos=trim($n1->campoextra3);
            $create1->ubicaciones=trim($n1->campoextra2);
            $create1->organigrama=trim($n1->campoextra1);
            $create1->estatus=$estatus;
            $create1->save();
        }


        $nom10003=DB::connection($sqlsrv)->table('nom10003')->get();
        $estatusdepa='inactivo';

        foreach ($nom10003 as $n3){

          $estatusdepa=depaactivo($n3->iddepartamento);


            $create3=new Departamentos();
            $create3->iddepartamento=$n3->iddepartamento;
            $create3->numerodepartamento=$n3->numerodepartamento;
            $create3->company_id=$numerodecompany;
            $create3->departamento=$n3->descripcion;
            $create3->estatus=$estatusdepa;
            $create3->save();
        }


        $nom10006=DB::connection($sqlsrv)->table('nom10006')->get();

        $estatuspsto='inactivo';

        foreach ($nom10006 as $n6){

          $estatuspsto=puestoactivo($n6->idpuesto);

            $create6=new PerfilPuestos();
            $create6->idpuesto=$n6->idpuesto;
            $create6->numeropuesto=$n6->numeropuesto;
            $create6->company_id=$numerodecompany;
            $create6->departamento_id=depapuesto($n6->idpuesto , $numerodecompany);
            $create6->puesto=$n6->descripcion;
            $create6->estatus=$estatuspsto;
            $create6->save();
        }



        $nom10032=DB::connection($sqlsrv)->table('nom10032')->get();

        foreach ($nom10032 as $n32){
            $create32=new TiposdeTurnodeTrabajo();
            $create32->company_id=$numerodecompany;
            $create32->tipo=$n32->descripcion;
            $create32->save();
        }


        $nom10023=DB::connection($sqlsrv)->table('nom10023')->get();

        foreach ($nom10023 as $n23){
            $create23=new TiposdePeriodo();
            $create23->company_id=$numerodecompany;
            $create23->tipo=$n23->nombretipoperiodo;
            $create23->dias='0';
            $create23->save();
        }

        $nom10035=DB::connection($sqlsrv)->table('nom10035')->get();

        foreach ($nom10035 as $n35){
            $create35=new RegistroPatronal();
            $create35->company_id=$numerodecompany;
            $create35->registro_patronal=$n35->cregistroimss;
            $create35->save();
        }


        return redirect('/empresas');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function show($colaborador_id)
    {
      $colaborador = Colaboradores::where('id',$colaborador_id)->first();

      $direccioncolaborador = DireccionesColaborador::where('colaborador_id',$colaborador_id)->first();
      $equipo = Colaboradores::
          where('departamento_id',$colaborador->departamento_id)
          ->where('company_id',$colaborador->company_id)
          ->get();

      $tipossolicitudes = TiposdeSolicitudes::all();

      $solicitudes = Solicitudes::where('colaborador_id',$colaborador_id)->get();
      $tiposdedocumentos = DocumentosColaborador::where('colaborador_id',$colaborador_id)->get();


      $registropatronal=RegistroPatronal::all();
      $tipocontratos=CatalogosdeTiposdeContratos::all();
      $tipoperiodos=CatalogosdeTiposdePeriodo::all();
      $tipobasedecotizacion=CatalogosdeTiposdeBasedeCotizacion::all();
      $tipoprestacion=CatalogosdeTiposdePrestacion::all();
      $tipoturnodetrabajo=CatalogosdeTiposdeTurnodeTrabajo::all();
      $tipobasedepago=CatalogosdeTiposdeBasedePago::all();
      $tipometododepago=CatalogosdeTiposdeMetododePago::all();
      $tiporegimen=CatalogosdeTiposdeRegimen::all();
      $tipojornada=CatalogosdeTiposdeJornada::all();
      $tipozonasalario=CatalogosdeTiposdeZonadeSalario::all();
      $centro_de_costos=CentrodeCostos::all();
      $familiares=Familiares::where('colaborador_id',$colaborador_id)->get();
      $beneficiarios=Beneficiarios::where('colaborador_id',$colaborador_id)->get();
      $bancos=Bancos::all();
      $documentos=DocumentosColaborador::where('colaborador_id',$colaborador_id)->get();

      $org=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->count();

      $orginfo=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->count();

      $organigramas = OrganigramaLinealNiveles::where('jefe_directo_id', $colaborador_id)
        ->orderBy('nivel', 'asc') // Ordena por nivel en orden ascendente
        ->get();


      $todosOrganigramas = obtenerSubordinados($colaborador_id, 1);



      return view('colaboradores.ver' ,
      [
        'org' => $org ,
        'orginfo' => $orginfo ,
        'colaborador' => $colaborador ,
        'equipo' => $equipo  ,
        'direccioncolaborador' => $direccioncolaborador ,
        'tipossolicitudes' => $tipossolicitudes ,
        'solicitudes' => $solicitudes ,
        'tiposdedocumentos' => $tiposdedocumentos ,
        'registropatronal' => $registropatronal ,
        'tipocontratos' => $tipocontratos ,
        'tipoperiodos' => $tipoperiodos ,
        'tipobasedecotizacion' => $tipobasedecotizacion ,
        'tipoprestacion' => $tipoprestacion ,
        'tipoturnodetrabajo' => $tipoturnodetrabajo ,
        'tipobasedepago' => $tipobasedepago ,
        'tipometododepago' => $tipometododepago ,
        'tiporegimen' => $tiporegimen ,
        'tipojornada' => $tipojornada ,
        'tipozonasalario' => $tipozonasalario ,
        'centro_de_costos' => $centro_de_costos ,
        'familiares' => $familiares ,
        'beneficiarios' => $beneficiarios ,
        'bancos' => $bancos ,
        'documentos' => $documentos,
        'organigramas' => $organigramas,
        'todosOrganigramas' => $todosOrganigramas,
      ]);
    }

    public function actualizar_roles(Request $request)
    {
        // Buscar el usuario por su colaborador_id
        $colab =  Colaboradores::where('id', $request->colaborador_id)->first();
        $user = User::where('colaborador_id', $request->colaborador_id)->first();

        // Si no existe el usuario, se crea uno nuevo
        if (!$user) {
            $user = new User();
            $user->colaborador_id = $request->colaborador_id;
            $user->email = $request->colaborador_email;
            $user->device_key = '0';
            $user->role_id = '1';
            $user->name = qcolab($request->colaborador_id);
            $user->password = bcrypt('Junzi2025!!!'); // Encriptamos la contraseña
        }

        // Actualiza los valores de los roles en la base de datos
        $user->nomina = $request->has('nomina') ? 1 : 0;
        $user->reclutamiento = $request->has('reclutamiento') ? 1 : 0;
        $user->auditoria = $request->has('auditoria') ? 1 : 0;
        $user->jefatura = $request->has('jefatura') ? 1 : 0;

        // Si el campo 'nomina' tiene valor, asigna el valor 'Jefatura' al campo perfil
        if ($request->has('nomina')) {
            $user->perfil = 'Jefatura';
            $user->rol = 'Nómina';
        }

        if ($request->has('jefatura')) {
            $user->perfil = 'Jefatura';
            $user->rol = 'Jefatura';
        }

         if ($request->has('colaborador')) {
            $user->perfil = 'Colaborador';
            $user->rol = 'Colaborador';
        }

      

        // Guarda el usuario (ya sea actualizado o creado)
        $user->save();

        return redirect()->back()->with('success', 'Roles actualizados correctamente.');
    }




    public function edit($colaborador_id)
    {


        $colaborador = Colaboradores::where('id',$colaborador_id)->first();

        $colaborador_baja = Bajas::where('colaborador_id',$colaborador_id)->first();

        $direccioncolaborador = DireccionesColaborador::where('colaborador_id',$colaborador_id)->first();
        $equipo = Colaboradores::
            where('departamento_id',$colaborador->departamento_id)
            ->where('company_id',$colaborador->company_id)
            ->get();

        $tipossolicitudes = TiposdeSolicitudes::all();

        $solicitudes = Solicitudes::where('colaborador_id',$colaborador_id)->get();
        $tiposdedocumentos = DocumentosColaborador::where('colaborador_id',$colaborador_id)->get();


        $registropatronal=RegistroPatronal::all();
        $tipocontratos=CatalogosdeTiposdeContratos::all();
        $tipoperiodos=CatalogosdeTiposdePeriodo::all();
        $tipobasedecotizacion=CatalogosdeTiposdeBasedeCotizacion::all();
        $tipoprestacion=CatalogosdeTiposdePrestacion::all();
        $tipoturnodetrabajo=CatalogosdeTiposdeTurnodeTrabajo::all();
        $tipobasedepago=CatalogosdeTiposdeBasedePago::all();
        $tipometododepago=CatalogosdeTiposdeMetododePago::all();
        $tiporegimen=CatalogosdeTiposdeRegimen::all();
        $tipojornada=CatalogosdeTiposdeJornada::all();
        $tipozonasalario=CatalogosdeTiposdeZonadeSalario::all();
        $centro_de_costos=CatalogoCentrosdeCostos::all();
        $departamentos=CatalogoDepartamentos::all();
        $puestos=CatalogoPuestos::all();
        $jefes=Colaboradores::where('estatus','activo')->get();
        $familiares=Familiares::where('colaborador_id',$colaborador_id)->get();
        $beneficiarios=Beneficiarios::where('colaborador_id',$colaborador_id)->get();
        $bancos=Bancos::all();
        $generos=Generos::all();
        $estadosciviles=EstadoCivil::all();
        $estados=Estados::all();
        $empresas=Companies::all();
        $documentos=DocumentosColaborador::where('colaborador_id',$colaborador_id)->get();

        $org=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->count();

        $orginfo=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->count();

        return view('colaboradores.editar' ,
        [
          'org' => $org ,
          'empresas' => $empresas ,
          'orginfo' => $orginfo ,
          'colaborador' => $colaborador ,
          'equipo' => $equipo  ,
          'direccioncolaborador' => $direccioncolaborador ,
          'tipossolicitudes' => $tipossolicitudes ,
          'solicitudes' => $solicitudes ,
          'tiposdedocumentos' => $tiposdedocumentos ,
          'registropatronal' => $registropatronal ,
          'tipocontratos' => $tipocontratos ,
          'tipoperiodos' => $tipoperiodos ,
          'tipobasedecotizacion' => $tipobasedecotizacion ,
          'tipoprestacion' => $tipoprestacion ,
          'tipoturnodetrabajo' => $tipoturnodetrabajo ,
          'tipobasedepago' => $tipobasedepago ,
          'tipometododepago' => $tipometododepago ,
          'tiporegimen' => $tiporegimen ,
          'tipojornada' => $tipojornada ,
          'tipozonasalario' => $tipozonasalario ,
          'centro_de_costos' => $centro_de_costos ,
          'familiares' => $familiares ,
          'beneficiarios' => $beneficiarios ,
          'bancos' => $bancos ,
          'generos' => $generos ,
          'estados' => $estados ,
          'estadosciviles' => $estadosciviles ,
          'departamentos' => $departamentos ,
          'jefes' => $jefes ,
          'puestos' => $puestos ,
          'documentos' => $documentos,
          'colaborador_baja' => $colaborador_baja,

        ]);
    }

    public function baja()
    {


        $colaboradores = Colaboradores::where('estatus','activo')->where('organigrama',"!=","")->get();


        return view('colaboradores.baja' , [  'colaboradores' => $colaboradores  ]);
    }

    public function verbajas(){

      if (session('company_id')=='Todas' || session('company_id')=='0'  || session('company_id')=='' ) {
        $colaboradores = Colaboradores::where('estatus','baja')->get();
      }else {
        $colaboradores = Colaboradores::where('company_id',session('company_id'))->where('estatus','baja')->get();
      }

      return view('colaboradores.verbajas' , [  'colaboradores' => $colaboradores ]);

    }

    public function generarbaja(Request $request){


      $colab=Colaboradores::where('id',$request->id)->first();

        /*
          Colaboradores::where('id',$request->colaborador_id)->update(
            [ 'fecha_baja' => $request->fecha_baja ,
              'estatus' => 'baja'
            ]
          );
        */


        $colab=Colaboradores::where('id',$request->colaborador_id)->first();

        $agrup=Agrupadores::where('nombre',$colab->organigrama)->first();

        if($agrup){
          $area=$colab->organigrama;
        }else {
          $area=" ";
        }

        $buscarcolab=OrganigramaLinealNiveles::where('colaborador_id',$request->colaborador_id)->first();
        $jefe="";
        if ($buscarcolab) {
          $jefe=$buscarcolab->jefe_directo_id;
        }

        OrganigramaLinealNiveles::where('colaborador_id',$request->colaborador_id)->update([
            'colaborador_id' => '0'
        ]);


        $company_id=$colab->company_id;
        $departamento_id=$colab->departamento_id;
        $puesto=$colab->puesto;
        $fecha=date('Y-m-d');
        $area=$colab->organigrama;


        $create=new Vacantes();
        $create->area_id='0';
        $create->company_id=$company_id;
        $create->departamento_id=$departamento_id;
        $create->puesto_id=$puesto;
        $create->fecha=$fecha;
        $create->area=$area;
        $create->jefe=$jefe;
        $create->estatus='pendiente';
        $create->prioridad='0';
        $create->proceso='0';
        $create->save();

        $create2=new Bajas();
        $create2->company_id=$colab->company_id;
        $create2->colaborador_id=$colab->id;
        $create2->area=$colab->organigrama;
        $create2->departamento_id=$colab->departamento_id;
        $create2->puesto_id=$colab->puesto;
        $create2->fecha_baja=$request->fecha_baja;
        $create2->motivo=$request->tipobaja;
        $create2->vacante='Si';
        $create2->generada_por=auth()->user()->id;
        $create2->save();


        $masinfojefe=User::where('colaborador_id',$jefe)->first();

        if ($masinfojefe) {
          Notificaciones::create([
                'email' => $masinfojefe->email,
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$create->id,
                'fecha' => now(),
                'texto' => 'Nueva Vacante',
                'abierto' => '0',
              ]);
        }

        Notificaciones::create([
              'email' => emailreclutamiento(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$create->id,
              'fecha' => now(),
              'texto' => 'Nueva Vacante',
              'abierto' => '0',
            ]);

        Notificaciones::create([
              'email' => emailnomina(),
              'tipo' => 'success',
              'ruta' => '/proceso_vacante/'.$create->id,
              'fecha' => now(),
              'texto' => 'Nueva Vacante',
              'abierto' => '0',
            ]);



        Notificaciones::create([
                  'email' => emailnomina(),
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$create2->id,
                  'fecha' => now(),
                  'texto' => 'Solicitud de baja de colaborador',
                  'abierto' => '0',
                ]);




      return redirect('/bajas');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColaboradoresRequest  $request
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColaboradoresRequest $request, Colaboradores $colaboradores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colaboradores $colaboradores)
    {
        //
    }

    public function getMaxEmployeeNumber($company_id)
    {
        $maxEmployeeNumber = Colaboradores::where('company_id', $company_id)
            ->max('numero_de_empleado');

        return response()->json(['max_employee_number' => $maxEmployeeNumber]);
    }

    public function getPuesto($colaboradorId)
    {
        // Encuentra al colaborador por ID
        $colaborador = Colaboradores::with('catalogoPuestos')->find($colaboradorId);

        if ($colaborador && $colaborador->catalogoPuestos->isNotEmpty()) {
            // Si existe un puesto asignado al colaborador
            return response()->json([
                'success' => true,
                'puesto' => $colaborador->catalogoPuestos->first()->puesto
            ]);
        }

        // Si no hay puesto asignado
        return response()->json(['success' => false, 'message' => 'No hay puesto asignado para este colaborador']);
    }
}
