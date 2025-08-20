<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests\StoreOrganigramaRequest;
use App\Http\Requests\UpdateOrganigramaRequest;
use App\Models\DireccionOrganigrama;
use App\Models\Organigrama;
use App\Models\OrganigramaLineal;
use App\Models\OrganigramaLinealNiveles;
use App\Models\OrganigramaColaboradores;
use App\Models\Agrupadores;
use App\Models\AgrupadoresLista;
use App\Models\Companies;
use App\Models\Colaboradores;
use App\Models\Departamentos;
use App\Models\PerfilPuestos;
use App\Models\CentrodeCostos;
use App\Models\Vacantes;
use App\Models\Notificaciones;
use App\Models\Externos;
use App\Models\Bajas;
use App\Models\DatosBaja;
use App\Models\OrganigramaMatricial;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\CatalogoDepartamentos;
use App\Models\CatalogoPuestos;
use App\Models\ColaboradoresCC;
use App\Models\DepartamentosCC;
use App\Models\ColaboradoresEmpresa;
use App\Models\DepartamentosColaboradores;
use App\Models\PuestosCC;
use App\Models\Ubicacion;
use App\Models\PuestosColaboradores;
use App\Models\PuestosDepartamentos;
use App\Models\PuestosEmpresas;
use App\Models\UbicacionesColaborador;





class OrganigramaController extends Controller
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

    public function crear()
    {
        // Obtener los IDs de los colaboradores que ya están en OrganigramaLinealNiveles
        $colaboradoresEnOrganigrama = OrganigramaLinealNiveles::pluck('colaborador_id');

        $jefesEnOrganigrama = OrganigramaLinealNiveles::pluck('jefe_directo_id');

        $catalogo_puestos = CatalogoPuestos::all();

        // Obtener solo los colaboradores activos que no estén en la lista anterior
        $colaboradores = Colaboradores::where('estatus', 'activo')
                            ->whereNotIn('id', $colaboradoresEnOrganigrama)
                            ->where('organigrama','!=','CONSEJO')
                            ->get();

         $jefesEnOrganigrama = OrganigramaLinealNiveles::selectRaw('jefe_directo_id, MIN(codigo) as codigo')
                            ->where('jefe_directo_id', '!=', 0) // Excluir los que tienen 0 en esta consulta
                            ->groupBy('jefe_directo_id') // Solo agrupamos por jefe_directo_id
                            ->union(
                                OrganigramaLinealNiveles::select('jefe_directo_id', 'codigo')
                                    ->where('jefe_directo_id', 0) // Mantiene todos los que tienen 0
                            )
                            ->get();

          $jefes = Colaboradores::where('estatus', 'activo')
                            ->whereIn('id', $colaboradoresEnOrganigrama)
                            ->get();


          $vacantes = OrganigramaLinealNiveles::where('colaborador_id','0')->where('nivel','>',1)->get();



        $organigrama=OrganigramaLinealNiveles::all();

        $last = OrganigramaLinealNiveles::latest('id')->first() ?? null;

        $niveles = $this->getOrganigramaEstructurado();

        $ubicaciones = Ubicacion::all();

        $colabbuscar = OrganigramaLinealNiveles::where('colaborador_id','!=','0')->get();





        return view('organigrama.create', compact('colaboradores','jefes','organigrama','last','catalogo_puestos','vacantes','niveles','colabbuscar'));
    }

    private function getOrganigramaEstructurado()
    {
        $nivel1 = OrganigramaLinealNiveles::where('nivel', 1)->get();

        $estructura = [];

        foreach ($nivel1 as $n1) {
            $estructura[] = $n1;
            $this->agregarSubniveles($estructura, $n1->codigo, 2);
        }

        return $estructura;
    }


    private function agregarSubniveles(&$estructura, $codigoJefe, $nivel)
    {
        if ($nivel > 10) {
            return;
        }

        //$subniveles = OrganigramaLinealNiveles::where('jefe_directo_codigo', $codigoJefe)->where('nivel', $nivel)->get();
        $subniveles = OrganigramaLinealNiveles::where('jefe_directo_codigo', $codigoJefe)
        ->where('nivel', $nivel)
        ->orderBy('jerarquia', 'asc') // Ordenar de menor a mayor
        ->get();


        foreach ($subniveles as $sub) {
            $estructura[] = $sub;
            $this->agregarSubniveles($estructura, $sub->codigo, $nivel + 1);
        }
    }


    public function store(Request $request){

        $jefe_directo_codigo='0';
        $puesto='0';
        $codigo='0';
        $company_id='0';
        $cc='0';
        $nivel=0;

        $colab=Colaboradores::where('id',$request->colaborador_id)->first();

        if($request->colaborador_id!='0'){

            $centro=ColaboradoresCC::where('colaborador_id',$request->colaborador_id)->first();

            $puestos=PuestosColaboradores::where('id_colaborador',$request->colaborador_id)->first();
            $puesto=$puestos->id_catalogo_puesto_id;

        }else{
            $centro=PuestosCC::where('id_catalogo_puestos_id',$request->id_puesto)->first();
            $puesto=$request->id_puesto;
        }

        $catcc=CatalogoCentrosdeCostos::where('id',$centro->id_catalogo_centro_de_costos_id)->first();




        if($request->jefe_directo_id!='0'){
            $jefe=Colaboradores::where('id',$request->jefe_directo_id)->first();
            $orgjf=OrganigramaLinealNiveles::where('colaborador_id',$request->jefe_directo_id)->first();
            $jefe_directo_codigo=$orgjf->codigo;
            $nivel=$orgjf->nivel+1;
        }

        $cuantoscc=OrganigramaLinealNiveles::where('cc',$centro->id_catalogo_centro_de_costos_id)->count();
        $cuantoscc=$cuantoscc+1;
        $codigo=$nivel.'-'.$puesto.'-'.$cuantoscc;

        OrganigramaLinealNiveles::create([
            'organigrama_id' => '1',
            'nivel' => $nivel,
            'jerarquia' => $nivel,
            'colaborador_id' => $request->colaborador_id,
            'jefe_directo_id' => $request->jefe_directo_id,
            'jefe_directo_codigo' => $jefe_directo_codigo,
            'puesto' => $puesto,
            'cc' => $centro->id_catalogo_centro_de_costos_id,
            'codigo' => $codigo,
            'company_id' => $colab->company_id ?? '0',
        ]);




        if($request->colaborador_id == '0'){

            $datosjdf=Colaboradores::where('id',$request->jefe_directo_id)->first();

            $jfdepto=DepartamentosColaboradores::where('colaborador_id',$request->jefe_directo_id)->first();

            $depto=CatalogoDepartamentos::where('id',$jfdepto->id_catalogo_departamento_id)->first();

            $colabcc=ColaboradoresCC::where('colaborador_id',$request->jefe_directo_id)->first();

            $create_v=new Vacantes();
            $create_v->area_id=$colabcc->id_catalogo_centro_de_costos_id;
            $create_v->company_id=$datosjdf->company_id;
            $create_v->departamento_id=$jfdepto->id_catalogo_departamento_id;
            $create_v->puesto_id=$puesto;
            $create_v->fecha=date('Y-m-d');
            $create_v->area=$request->area;
            $create_v->jefe=$request->jefe_directo_id;
            $create_v->estatus='pendiente';
            $create_v->prioridad='Baja';
            $create_v->codigo=$codigo;
            $create_v->solicitadas="1";
            $create_v->completadas="0";
            $create_v->save();
            $idv=$create_v->id;

        }


        return redirect('/organigrama-create');
    }

    public function organigrama_old()
    {
        $direcciones=DireccionOrganigrama::all();


        return view('organigrama.index',[
            'direcciones' => $direcciones
        ]);
    }

    public function centros()
    {

        $colab=ColaboradoresCC::where('colaborador_id',auth()->user()->colaborador_id)->first();
        $colcc=$colab->id_catalogo_centro_de_costos_id;

        if(auth()->user()->perfil=='Jefatura'){
            $centrosDeCosto = CatalogoCentrosdeCostos::where('id',$colcc)->get();
        }
        else{
            $centrosDeCosto = CatalogoCentrosdeCostos::all();
        }
        return view('organigrama.centros', compact('centrosDeCosto'));
    }

    public function obtenerPuestos($idCentroDeCosto)
    {
        // Verificar si el centro de costo existe
        $centroDeCosto = CatalogoCentrosdeCostos::find($idCentroDeCosto);
        if (!$centroDeCosto) {
            return response()->json(['message' => 'Centro de costo no encontrado'], 404);
        }

        // Obtener los puestos de forma única, sin duplicados
        $puestos = PuestosCC::where('id_catalogo_centro_de_costos_id', $idCentroDeCosto)
            ->select('id_catalogo_puestos_id') // Seleccionamos solo el id del puesto para eliminar duplicados
            ->distinct() // Eliminamos los duplicados basados en el id_catalogo_puestos_id
            ->with('catalogoPuesto') // Traemos la relación con el catálogo de puestos
            ->get();

        // Verificar si hay puestos disponibles
        if ($puestos->isEmpty()) {
            return response()->json(['message' => 'No hay puestos disponibles para este centro de costo'], 404);
        }

        return response()->json($puestos);
    }



public function getColaboradores($puestoId)
{
    // Obtener todos los colaboradores asociados al puesto
    $puestosColaboradores = PuestosColaboradores::with('colaborador:id,nombre,apellido_paterno,apellido_materno,fecha_nacimiento,fecha_alta,salario_diario')
    ->where('id_catalogo_puesto_id', $puestoId)
    ->get();

    if ($puestosColaboradores->isEmpty()) {
        return response()->json(['message' => 'No hay colaboradores para este puesto'], 404);
    }

    // Mapear los colaboradores con los datos que necesitamos
    $colaboradores = $puestosColaboradores->map(function ($puestoColaborador) {
        $colaborador = $puestoColaborador->colaborador; // Accedemos al colaborador desde la relación

        return [
            'nombre' => $colaborador->nombre.' '.$colaborador->apellido_paterno.' '.$colaborador->apellido_materno,
            'salario_mensual' => '$'.number_format($colaborador->salario_diario*30,2),
            'salario_anual' => '$'.number_format($colaborador->salario_diario*30*12,2),
            'edad' => edad($colaborador->fecha_nacimiento),
            'antiguedad' => antiguedad_anio($colaborador->fecha_alta),
        ];
    });

    return response()->json($colaboradores);
}





    public function ubicaciones()
    {
        if(auth()->user()->perfil=='Jefatura'){
            $colb=Colaboradores::where('id',auth()->user()->colaborador_id)->first();

            $ubicacionesall = Ubicacion::where('ubicacion',$colb->ubicaciones)->get();
        }else{
            $ubicacionesall = Ubicacion::all();
        }

        $ubicaciones = $ubicacionesall->groupBy('ubicacion');


        // Pasar las ubicaciones a la vista
        return view('organigrama.ubicaciones', compact('ubicaciones'));
    }


    public function getColaboradores2($ubicacion_id)
    {
        // Obtener la ubicación por ID
        $ubicacion = Ubicacion::find($ubicacion_id);

        // Si no se encuentra la ubicación, devolver error o vacío
        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        // Obtener los colaboradores relacionados con esta ubicación
        $colaboradores = $ubicacion->colaboradores;

        // Preparar la respuesta
        $colaboradores_data = $colaboradores->map(function ($colaborador) {
            return [
                'nombre' => $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno,
                'salario_mensual' => '$' . number_format($colaborador->salario_diario * 30, 2),
                'salario_anual' => '$' . number_format($colaborador->salario_diario * 30 * 12, 2),
                'edad' => edad($colaborador->fecha_nacimiento),
                'antiguedad' => antiguedad_anio($colaborador->fecha_alta),
            ];
        });

        return response()->json(['colaboradores' => $colaboradores_data]);
    }


    // Función para calcular la edad
    private function edad($fecha_nacimiento)
    {
        $fecha_nacimiento = new \DateTime($fecha_nacimiento);
        $hoy = new \DateTime();
        $edad = $hoy->diff($fecha_nacimiento);
        return $edad->y;
    }

    // Función para calcular la antigüedad
    private function antiguedad_anio($fecha_alta)
    {
        $fecha_alta = new \DateTime($fecha_alta);
        $hoy = new \DateTime();
        $antiguedad = $hoy->diff($fecha_alta);
        return $antiguedad->y;
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ver($departamentomatricial)
    {


       if(session('company_id')==0){

         $colaboradores=Colaboradores::where('organigrama' , $departamentomatricial)->where('estatus','activo')->get();

         $resultados = Colaboradores::select('puesto', DB::raw('MAX(company_id) as company_id'))
                              ->where('organigrama', $departamentomatricial)
                              ->where('estatus', 'activo')
                              ->groupBy('puesto')
                              ->pluck('company_id', 'puesto');

       }else {
         $colaboradores=Colaboradores::where('organigrama' , $departamentomatricial)->where('company_id',session('company_id'))->where('estatus','activo')->get();

         $resultados = Colaboradores::select('puesto', DB::raw('MAX(company_id) as company_id'))
                              ->where('organigrama', $departamentomatricial)
                              ->where('estatus', 'activo')
                              ->where('company_id',session('company_id'))
                              ->groupBy('puesto')
                              ->pluck('company_id', 'puesto');
       }

       $externos=Externos::where('area',$departamentomatricial)->get();

       return view('organigrama.organigrama' , ['departamentomatricial' => $departamentomatricial , 'colaboradores' => $colaboradores , 'resultados' => $resultados , 'externos' => $externos ]);


    }

    public function showOrganigramaCustom($id)
    {
        $niveles = $this->getOrganigramaUsuarioCustom($id);
        $colaborador=OrganigramaLinealNiveles::where('colaborador_id', $id)->first();
        $colaboradores = Colaboradores::where('estatus','activo')->get();

        $ubicaciones = Ubicacion::all();

        return view('organigrama.custom', compact('niveles','colaborador','colaboradores','ubicaciones'));
    }



    public function showOrganigramaEditar($id)
    {
        $colaboradores = Colaboradores::where('estatus','activo')->get();

        $colaborador=OrganigramaLinealNiveles::where('colaborador_id', $id)->first();

        return view('organigrama.editar', compact('colaborador','colaboradores'));
    }

    public function showOrganigramaUpdate(Request $request)
    {

        $colaborador_id = $request->colaborador_id;
        $jefe_directo_id = $request->jefe_directo_id;
        $nivel = $request->nivel;
        $jerarquia = $request->nivel;
        $jerarquia_hijo = $jerarquia+1;
        $elemento_id = $request->elemento_id;


        $data_colab=OrganigramaLinealNiveles::where('colaborador_id', $request->colaborador_id)->first();
        $codigo_colab=$data_colab->codigo;

        $data_jefe=OrganigramaLinealNiveles::where('colaborador_id', $request->jefe_directo_id)->first();
        $codigo_jefe=$data_jefe->codigo;
        $nivel_jefe=$data_jefe->nivel+1;

        $partes_codigo=explode('-',$codigo_colab);
        $nuevo_codigo=$nivel_jefe.'-'.$partes_codigo[1].'-'.$partes_codigo[2];

        $gente_colab=OrganigramaLinealNiveles::where('jefe_directo_id', $request->colaborador_id)->get();

        $nivel_hijo=$nivel_jefe+1;

        //echo $nivel_jefe;



        if($colaborador_id!=1){
            OrganigramaLinealNiveles::where('colaborador_id', $colaborador_id)->update([
                'jefe_directo_codigo' => $codigo_jefe,
                'codigo' => $nuevo_codigo,
                'jefe_directo_id' => $jefe_directo_id,
                'nivel' => $nivel_jefe,
                'jerarquia' => $jerarquia,
            ]);
        }

        foreach($gente_colab as $info){

            $partes_codigo_hijo=explode('-',$info->codigo);
            $nuevo_codigo_hijo=$nivel_hijo.'-'.$partes_codigo_hijo[1].'-'.$partes_codigo_hijo[2];

            if($info->id!=1){
                OrganigramaLinealNiveles::where('id', $info->id)->update([
                    'jefe_directo_codigo' => $nuevo_codigo,
                    'jefe_directo_id' => $colaborador_id,
                    'codigo' => $nuevo_codigo_hijo,
                    'nivel' => $nivel_hijo,
                    'jerarquia' => $jerarquia_hijo,
                ]);
            }

            //echo "<br><br>-----<br><br>".qcolab($info->colaborador_id).
            // "<br>JFC".$info->jefe_directo_codigo." JFCN:".$nuevo_codigo."
            // <br>COD:".$info->codigo." CODN:".$nuevo_codigo_hijo."
            // <br>N:".$info->nivel." NN:".$nivel_hijo."
            // <br>E:".$info->id;
        }

        return redirect('organigrama-editar/'.$colaborador_id);




    }


    private function getOrganigramaUsuarioCustom($colaboradorId)
    {
        $estructura = [];

        // Obtener los colaboradores que tienen como jefe directo al usuario autenticado
        //$nivelesInmediatos = OrganigramaLinealNiveles::where('jefe_directo_id', $colaboradorId)->get();
        $nivelesInmediatos = OrganigramaLinealNiveles::where('jefe_directo_id', $colaboradorId)->orderBy('jerarquia', 'asc')->get();
        foreach ($nivelesInmediatos as $colaborador) {
            $estructura[] = $colaborador;
            //$this->agregarSubnivelesUsuario($estructura, $colaborador->colaborador_id);
        }

        return $estructura;
    }


    public function showOrganigrama()
    {
        $colaboradorId = auth()->user()->colaborador_id;

        // Obtener la estructura del organigrama filtrada por usuario
        $niveles = $this->getOrganigramaUsuario($colaboradorId);

        return view('organigrama.index', compact('niveles'));
    }

    private function getOrganigramaUsuario($colaboradorId)
    {
        $estructura = [];

        // Obtener los colaboradores que tienen como jefe directo al usuario autenticado
        //$nivelesInmediatos = OrganigramaLinealNiveles::where('jefe_directo_id', $colaboradorId)->get();
        $nivelesInmediatos = OrganigramaLinealNiveles::where('jefe_directo_id', $colaboradorId)->orderBy('jerarquia', 'asc')->get();
        foreach ($nivelesInmediatos as $colaborador) {
            $estructura[] = $colaborador;
            $this->agregarSubnivelesUsuario($estructura, $colaborador->colaborador_id);
        }

        return $estructura;
    }

    private function agregarSubnivelesUsuario($estructura, $jefeDirectoId)
    {
        //$subniveles = OrganigramaLinealNiveles::where('jefe_directo_id', $jefeDirectoId)->get();
        //dato duro 
        //$codigoJefe = "1-280-1";

        $subniveles = OrganigramaLinealNiveles::where('jefe_directo_codigo', $jefeDirectoId)->orderBy('jerarquia', 'asc')->get();
        //dd($subniveles);

        foreach ($subniveles as $sub) {
            $estructura[] = $sub;
            $this->agregarSubnivelesUsuario($estructura, $sub->colaborador_id);
        }
    }


    public function buscar(Request $request)
    {

    }


    public function matricialh(Request $request){
      DireccionOrganigrama::where('id','1')->update([
          'horizontal' => $request->cc
      ]);

      $create3=new OrganigramaMatricial();
      $create3->direccion_organigrama_id='1';
      $create3->orientacion='matricial';
      $create3->nombre=nombrecc($request->cc);
      $create3->agrupador_id=$request->cc;
      $create3->clave="1";
      $create3->save();

      return redirect('/organigrama');
    }

    public function matricialv(Request $request){
      DireccionOrganigrama::where('id','1')->update([
          'vertical' => $request->cc
      ]);

      $create3=new OrganigramaMatricial();
      $create3->direccion_organigrama_id='1';
      $create3->orientacion='matricial';
      $create3->nombre=nombrecc($request->cc);
      $create3->agrupador_id=$request->cc;
      $create3->clave="1";
      $create3->save();

      return redirect('/organigrama');
    }

    public function matriciale(Request $request){
      DireccionOrganigrama::where('id','1')->update([
          'esquina' => $request->cc
      ]);

      $create3=new OrganigramaMatricial();
      $create3->direccion_organigrama_id='1';
      $create3->orientacion='matricial';
      $create3->nombre=nombrecc($request->cc);
      $create3->agrupador_id=$request->cc;
      $create3->clave="1";
      $create3->save();

      return redirect('/organigrama');
    }


    public function index()
    {


        $matricial=DireccionOrganigrama::where('id','1')->first();



        $count_h=OrganigramaMatricial::where('direccion_organigrama_id','1')->where('orientacion','horizontal')->count();
        $agrupadores_h=OrganigramaMatricial::where('direccion_organigrama_id','1')->where('orientacion','horizontal')->get();

        $count_v=OrganigramaMatricial::where('direccion_organigrama_id','1')->where('orientacion','vertical')->count();
        $agrupadores_v=OrganigramaMatricial::where('direccion_organigrama_id','1')->where('orientacion','vertical')->get();



        $organigramaall = OrganigramaMatricial::where('direccion_organigrama_id', '1')
            ->groupBy('agrupador_id')
            ->pluck('agrupador_id')
            ->toArray();

        $exclusiones = array_merge($organigramaall, [$matricial->horizontal, $matricial->vertical, $matricial->esquina ]);

        $centros_de_costos = CatalogoCentrosdeCostos::whereNotIn('id', $exclusiones)->orderBy('centro_de_costo', 'asc')->get();

        $centros_de_costos = $centros_de_costos->unique('centro_de_costo');


        return view('organigrama.index' , [
          'centros_de_costos' => $centros_de_costos,
          'matricial' => $matricial ,
          'count_h' => $count_h ,
          'agrupadores_h' => $agrupadores_h ,
          'count_v' => $count_v ,
          'agrupadores_v' => $agrupadores_v ,
        ]);
    }

    public function limpiar(Request $request){

      $matricial=DireccionOrganigrama::where('company_id',session('company_id'))->first();

      Agrupadores::where('company_id', session('company_id'))->delete();
      AgrupadoresLista::where('company_id', session('company_id'))->delete();

      OrganigramaMatricial::where('direccion_organigrama_id',$matricial->id)->delete();

      $direcciones=DireccionOrganigrama::all();


      return view('organigrama.index',[
          'direcciones' => $direcciones
      ]);

    }


    public function matricial(Request $request)
    {

          $create3=new OrganigramaMatricial();
          $create3->direccion_organigrama_id='1';
          $create3->orientacion=$request->orientacion;
          $create3->nombre=nombrecc($request->cc);
          $create3->agrupador_id=$request->cc;
          $create3->clave="1";
          $create3->save();


        return redirect('/organigrama');
    }


    public function crearMatricial()
    {

      $company_id = session('company_id');

        if ($company_id == null) {
            return redirect()->back()->with('error', 'Error: Selecciona primero una empresa.');
        }

      $cont=DireccionOrganigrama::where('company_id',session('company_id'))->count();
      if ($cont==0) {
        $create=new DireccionOrganigrama();
        $create->company_id=session('company_id');
        $create->horizontal='Dirección A';
        $create->vertical='Dirección B';
        $create->save();
      }

      return redirect('/alta-organigrama');


    }


    public function organigrama_lineal($id){


      $cc=CatalogoCentrosdeCostos::where('id',$id)->first();

      $cc_old=CentrodeCostos::where('centro_de_costos',$cc->centro_de_costo)->first();


      $hay=OrganigramaLineal::where('area_id',$id)->count();

      $matricial=OrganigramaMatricial::where('agrupador_id',$id)->first();

      $direccion=DireccionOrganigrama::where('id','1')->first();
      $or=$matricial->orientacion;
      $ccraiz=$direccion->$or;

      $datosRaiz=OrganigramaLinealNiveles::where('nivel','1')->where('cc',$ccraiz)->first();

      $listado_empresas=Companies::all();
        /*
        $puestos = DB::table('puestos')
          ->join('colaboradores', 'puestos.idpuesto', '=', 'colaboradores.puesto')
          ->where('colaboradores.organigrama',$cc->centro_de_costo)
          ->where('colaboradores.estatus','activo')
          ->select('puestos.*')
          ->orderBy('puestos.puesto')
          ->get();
        */

        $puestos_x_cc=PuestosCC::where('id_catalogo_centro_de_costos_id',$id)->get();

        $puestosIds = $puestos_x_cc->pluck('id_catalogo_puestos_id')->toArray();

        // Luego, puedes usar estos IDs en la consulta para obtener los puestos del catálogo
        $puestos = CatalogoPuestos::whereIn('id', $puestosIds)->orderBy('puesto','ASC')->get();

        $puestosUnicos = $puestos->unique('puesto');

        if ($hay==0) {
          $create=new OrganigramaLineal();
          $create->company_id=$cc_old->company_id;
          $create->area=$cc->centro_de_costo;
          $create->area_id=$id;
          $create->jefe_directo='0';
          $create->niveles='2';
          $create->save();
        }

        $lineal=OrganigramaLineal::where('area_id',$id)->first();

        $asignados=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->orderBy('nivel', 'asc')->get();


        $jsonData = $asignados->toJson();
       //echo $asignados->toJson();

       $organigrama = [];
         $primera_iteracion = true;

         // Itera sobre los empleados
         foreach ($asignados as $empleado) {
             // Obtiene los valores del empleado
             $colab = qcolabv($empleado['colaborador_id']);
             $jefe = qcolabv($empleado['jefe_directo_id']);
             $puesto= catalogopuesto($empleado['puesto']);
             $motrar=$colab."<br>".$puesto;
             // Define las propiedades adicionales de estilo y texto para cada empleado
             $style = ''; // Puedes definir el estilo aquí si es necesario
             $tooltip = ''; // Puedes definir el tooltip aquí si es necesario

             // Si es la primera iteración, agrega solo el colaborador sin jefe
             if ($primera_iteracion) {
                 $organigrama[] = ["$colab", "$colab", ""];
                 // Cambia el valor de la variable booleana para indicar que ya no es la primera iteración
                 $primera_iteracion = false;
             } else {
                 // De lo contrario, agrega el colaborador con jefe
                 $organigrama[] = ["$colab", "$jefe", ""];
             }
         }


          // Convertir el array a formato JSON
          $organigrama_json = json_encode($organigrama);

          // Imprimir el JSON
        //  echo $organigrama_json;


        return view('organigrama.lineal' ,[
         'listado_empresas' => $listado_empresas,
         'area_id' => $id ,
         'lineal' => $lineal ,
         'asignados' => $asignados ,
         'organigrama_json' => $organigrama_json ,
         'puestos' => $puestos ,
         'area' => $cc->centro_de_costo ,
         'matricial' => $matricial ,
         'ccraiz' => $ccraiz ,
         'datosRaiz' => $datosRaiz ,
         'cc' => $id ,
         'orientacion' => $or
        ] );








    }

    public function buscarColaborador(Request $request){

      //$datos=explode('-',$request->puesto);

      $puesto=$request->puesto;


      $colaboradores_organigrama=OrganigramaLinealNiveles::groupBy('colaborador_id')
      ->pluck('colaborador_id')
      ->toArray();

      $colaboradores_x_puesto=PuestosColaboradores::where('id_catalogo_puesto_id',$puesto)->get();

      $colabsIds = $colaboradores_x_puesto->pluck('id_colaborador')->toArray();


      $colaboradores = Colaboradores::whereIn('id', $colabsIds)
      ->where('estatus', 'activo')
      ->whereNotIn('id', $colaboradores_organigrama)
      ->get();


      /*
      $colaboradores = Colaboradores::where('puesto', $puesto)
      ->where('estatus', 'activo')
      ->whereNotIn('id', $colaboradores_organigrama)
      ->get();
      */

      $respuesta='<option value="">Selecciona una opción:</option>';

      foreach ($colaboradores as $colab) {
            $respuesta.= '<option value="' . $colab->id . '">' . $colab->nombre .' '. $colab->apellido_paterno.' '. $colab->apellido_materno.'</option>';
      }

      return $respuesta;
    }


    public function buscarPuestoxEmpresa(Request $request){



      $company_id=$request->company_id;

      $cc_id=$request->cc_id;



      $puestos_x_empresa=PuestosEmpresas::where('company_id' , $company_id)->get();

      $puestosIds = $puestos_x_empresa->pluck('id_catalogo_puesto_id')->toArray();

      $puestos_x_cc=PuestosCC::where('id_catalogo_centro_de_costos_id' , $cc_id)->whereIn('id_catalogo_puestos_id', $puestosIds)->get();


      $respuesta='<option value="">Selecciona una opción:</option>';

      foreach ($puestos_x_cc as $puesto) {
            $respuesta.= '<option value="' . $puesto->id . '">' . $puesto->puesto .'</option>';
      }

      return $respuesta;
    }


    public function agregarnivel(Request $request){


      $niveles=$request->nivelactual+1;


      $cuantoshay=OrganigramaLineal::where('id',$request->id)->first();



      $max=$cuantoshay->niveles+1;




      $existe=OrganigramaLinealNiveles::where('organigrama_id',$request->id)->where('nivel',$request->nivelactual)->count();

      OrganigramaLineal::where('id',$request->id)->update([ 'niveles' => $max ]);

      if ($cuantoshay->niveles>$request->nivelactual) {


        for ($i=$max-1; $i>$request->nivelactual; $i--) {
          $j=$i+1;

        OrganigramaLinealNiveles::where('organigrama_id',$request->id)
        ->where('nivel',$i)
        ->update([ 'nivel' => $j ]);

        }




      }


     return redirect('/organigrama-lineal/'.$request->iddepartamento);

    }

    public function eliminardelorganigrama(Request $request){
      $idorganigrama=$request->idorganigrama;
      $nivel=$request->nivel;
      $iddepartamento=$request->iddepartamento;
      $idcolab=$request->idcolab;

      $jefatura=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->where('nivel','1')->first();

      $company_id=CentrodeCostos::where('id',$request->iddepartamento)->first();



      if($request->nuevo_jefe!=""){

        OrganigramaLinealNiveles::where('jefe_directo_id', $idcolab)
        ->update(['jefe_directo_id' => $request->nuevo_jefe]);
      }

      if ($request->tipo_de_eliminacion=='3') {

          /* Eliminar del organigrama */

          OrganigramaLinealNiveles::where('codigo',$request->id_codigo)->delete();

        if($idcolab!='0'){
            User::where('colaborador_id',$idcolab)->delete();
        }


      } elseif ($request->tipo_de_eliminacion=='2') {

          /* Dar de baja al colaborador y crear vacante */


          if($idcolab!='0'){
              User::where('colaborador_id',$idcolab)->delete();
          }

          $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();
          $infocentro=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->where('nivel','1')->first();

          $sol=Vacantes::where('departamento_id',$request->iddepartamento)
          ->where('puesto_id',$request->puestoidvac)->where('company_id',$numcc->company_id)
          ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->count();

          $solinfo=Vacantes::where('departamento_id',$request->iddepartamento)
          ->where('puesto_id',$request->puestoidvac)->where('company_id',$numcc->company_id)
          ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->first();


          if ($sol>0) {
            $sol=$sol+1;
            Vacantes::where('departamento_id',$request->iddepartamento)
            ->where('puesto_id',$request->puestoidvac)->where('company_id',$numcc->company_id)
            ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->update([
              'solicitadas' => $sol
                ]);

            $idv=$solinfo->id;

          }else {
            $create_v=new Vacantes();
            $create_v->area_id=$request->iddepartamento;
            $create_v->company_id=$company_id->company_id;
            $create_v->departamento_id=$iddepartamento;
            $create_v->puesto_id=buscarPuestoCatid($idcolab);
            $create_v->fecha=date('Y-m-d');
            $create_v->area=$request->area;
            $create_v->jefe=$jefatura->colaborador_id;
            $create_v->estatus='pendiente';
            $create_v->prioridad='Baja';
            $create_v->codigo=$request->id_codigo;
            $create_v->solicitadas="1";
            $create_v->completadas="0";
            $create_v->save();
            $idv=$create_v->id;
          }

          if (emailreclutamiento()) {
            Notificaciones::create([
                  'email' => emailreclutamiento(),
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$create_v->id,
                  'fecha' => now(),
                  'texto' => 'Nueva Vacante para '.$request->area.'. Puesto '.npuesto(qpuesto($idcolab)),
                  'abierto' => '0',
                ]);
          }


          if (emailnomina()) {
            Notificaciones::create([
                  'email' => emailnomina(),
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$create_v->id,
                  'fecha' => now(),
                  'texto' => 'Nueva Vacante para '.$request->area.'. Puesto '.npuesto(qpuesto($idcolab)),
                  'abierto' => '0',
                ]);
          }

          $infojefe=User::where('id',$jefatura->colaborador_id)->first();

          if($infojefe){
            Notificaciones::create([
                  'email' => $infojefe->email,
                  'tipo' => 'success',
                  'ruta' => '/proceso_vacante/'.$create_v->id,
                  'fecha' => now(),
                  'texto' => 'Nueva Vacante para '.$request->area.'. Puesto '.npuesto(qpuesto($idcolab)),
                  'abierto' => '0',
                ]);
          }

          $createbaja=new Bajas();
          $createbaja->company_id=$company_id->company_id;
          $createbaja->colaborador_id=$idcolab;
          $createbaja->area=$request->area;
          $createbaja->departamento_id=$iddepartamento;
          $createbaja->puesto_id=buscarPuestoCatid($idcolab);
          $createbaja->fecha_baja=$request->fecha_baja;
          $createbaja->motivo=$request->tipobaja;
          $createbaja->vacante='Si';
          $createbaja->generada_por=auth()->user()->id;
          $createbaja->save();





          if (emailnomina()) {
            Notificaciones::create([
                  'email' => emailnomina(),
                  'tipo' => 'success',
                  'ruta' => '/baja/'.$createbaja->id,
                  'fecha' => now(),
                  'texto' => 'Solicitud de baja de colaborador: '.qcolab($idcolab),
                  'abierto' => '0',
                ]);
          }

          if($request->tipobaja=='Baja inmediata'){

            if($idcolab!='0'){
                User::where('colaborador_id',$idcolab)->delete();
            }

            OrganigramaLinealNiveles::where('codigo',$request->id_codigo)->delete();

          }

      }

      elseif ($request->tipo_de_eliminacion=='1') {

        /* Dar de baja al colaborador */
        $idcolab=$request->idcolab;

        $datacolab=Colaboradores::where('id',$idcolab)->first();
        if($idcolab!='0'){
            User::where('colaborador_id',$idcolab)->delete();
        }


          $create2=new Bajas();
          $create2->company_id=$datacolab->company_id;
          $create2->colaborador_id=$datacolab->id;
          $create2->area=$datacolab->organigrama;
          $create2->departamento_id=$datacolab->departamento_id;
          $create2->puesto_id=$datacolab->puesto;
          $create2->fecha_baja=$request->fecha_baja;
          $create2->motivo=$request->tipobaja;
          $create2->vacante='Si';
          $create2->generada_por=auth()->user()->id;
          $create2->save();


        if (emailnomina()) {
          Notificaciones::create([
                'email' => emailnomina(),
                'tipo' => 'success',
                'ruta' => '/baja/'.$create2->id,
                'fecha' => now(),
                'texto' => 'Solicitud de baja de colaborador '.qcolab($datacolab->id),
                'abierto' => '0',
              ]);
        }

      }



      return redirect('/organigrama-lineal/'.$request->iddepartamento);


    }


    public function unoarriba(Request $request){

      $idorganigrama=$request->idorganigrama;
      $nivel=$request->nivel;
      $iddepartamento=$request->iddepartamento;
      $idcolab=$request->idcolab;
      $nuevo_colabid=$request->nuevo_colabid;
      $codigo_colab=$request->id_codigo;
      $puesto_nuevo=$request->puestoid;



      $subs=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
      ->where('jefe_directo_id',$idcolab)->get();

      $masinfo=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)->where('colaborador_id',$idcolab)->first();
      $masinfo->jefe_directo_id;


      $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

      $cuantaspos=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->count();
      $pos=$cuantaspos+1;

      $infocentro=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->where('nivel','1')->first();



      $nivelmas=$nivel+1;



     if ($request->tipo_asignar_abajo=='colaborador') {

       $codigo=$numcc->numeracion.'-'.$puesto_nuevo.'-'.$pos;

       OrganigramaLinealNiveles::where('jefe_directo_id', $idcolab)->update([
           'nivel' => \DB::raw('nivel + 1') // Incrementa el valor de nivel en 1
       ]);


        OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
        ->where('colaborador_id',$idcolab)
        ->update([ 'jefe_directo_id' => $nuevo_colabid ,
        'jefe_directo_codigo' => $codigo ,
        'nivel' => $nivelmas ]);

        $datacolab=Colaboradores::where('id',$idcolab)->first();

        $create=new OrganigramaLinealNiveles();
        $create->organigrama_id=$idorganigrama;
        $create->nivel=$request->nivel;
        $create->colaborador_id=$nuevo_colabid;
        $create->jefe_directo_id=$masinfo->jefe_directo_id;
        $create->jefe_directo_codigo=$masinfo->jefe_directo_codigo;
        $create->puesto=$puesto_nuevo;
        $create->codigo=$codigo;
        $create->cc=$request->iddepartamento;
        $create->company_id=$datacolab->company_id;
        $create->save();

     }elseif ($request->tipo_asignar_abajo=='vacante') {

       $codigo=$numcc->numeracion.'-'.$request->puestoidvac.'-'.$pos;


       OrganigramaLinealNiveles::where('jefe_directo_id', $idcolab)->update([
           'nivel' => \DB::raw('nivel + 1') // Incrementa el valor de nivel en 1
       ]);


        OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
        ->where('colaborador_id',$idcolab)
        ->update([ 'jefe_directo_id' => '0' ,
        'jefe_directo_codigo' => $codigo ,
        'nivel' => $nivelmas ]);

        $create=new OrganigramaLinealNiveles();
        $create->organigrama_id=$idorganigrama;
        $create->nivel=$request->nivel;
        $create->colaborador_id='0';
        $create->jefe_directo_id=$masinfo->jefe_directo_id;
        $create->jefe_directo_codigo=$masinfo->jefe_directo_codigo;
        $create->puesto=$request->puestoidvac;
        $create->codigo=$codigo;
        $create->cc=$request->iddepartamento;
        $create->company_id=$datacolab->company_id;
        $create->save();

     }




     return redirect('/organigrama-lineal/'.$request->iddepartamento);


    }


    public function unoabajo(Request $request){

      $idorganigrama=$request->idorganigrama;
      $nivel=$request->nivel+1;
      $iddepartamento=$request->iddepartamento;
      $idcolab=$request->idcolab;
      $nuevo_colabid=$request->nuevo_colabid;


      $datacolab=Colaboradores::where('id',$nuevo_colabid)->first();


      $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

      $cuantaspos=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->count();
      $pos=$cuantaspos+1;

      $infocentro=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->where('nivel','1')->first();



      if($request->tipo_asignar_abajo=='colaborador'){
        $codigo=$numcc->numeracion.'-'.$request->puestoid.'-'.$pos;


        $create=new OrganigramaLinealNiveles();
        $create->organigrama_id=$idorganigrama;
        $create->nivel=$nivel;
        $create->colaborador_id=$nuevo_colabid;
        $create->cc=$request->iddepartamento;
        $create->jefe_directo_id=$idcolab;
        $create->jefe_directo_codigo=$request->id_codigo;
        $create->puesto=ipuestocolab($nuevo_colabid);
        $create->codigo=$codigo;
        $create->company_id=$datacolab->company_id;
        $create->save();


      }

      if($request->tipo_asignar_abajo=='espacio'){

        $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

        $cuantaspos=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->count();
        $pos=$cuantaspos+1;
        $codigo=$numcc->numeracion.'-0-'.$pos;


        $codigo=$numcc->numeracion.'-'.$request->puestoid.'-'.$pos;


        $codigo=$numcc->numeracion.'-'.$request->puestoidvac.'-'.$pos;
        $datacolab=Colaboradores::where('id',$idcolab)->first();
        $create=new OrganigramaLinealNiveles();
        $create->organigrama_id=$idorganigrama;
        $create->nivel=$nivel;
        $create->colaborador_id='Vacio';
        $create->cc=$request->iddepartamento;
        $create->jefe_directo_id=$idcolab;
        $create->jefe_directo_codigo=$request->id_codigo;
        $create->puesto='0';
        $create->codigo=$codigo;
        $create->company_id=$request->company_id;
        $create->save();


      }

      if($request->tipo_asignar_abajo=='vacante'){


        $codigo=$numcc->numeracion.'-'.$request->puestoidvac.'-'.$pos;
        $datacolab=Colaboradores::where('id',$idcolab)->first();
        $create=new OrganigramaLinealNiveles();
        $create->organigrama_id=$idorganigrama;
        $create->nivel=$nivel;
        $create->colaborador_id='0';
        $create->cc=$request->iddepartamento;
        $create->jefe_directo_id=$idcolab;
        $create->jefe_directo_codigo=$request->id_codigo;
        $create->puesto=$request->puestoidvac;
        $create->codigo=$codigo;
        $create->company_id=$request->company_id;
        $create->save();

        $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

        $sol=Vacantes::where('departamento_id',$request->iddepartamento)
        ->where('puesto_id',$request->puestoidvac)->where('company_id',$request->company_id)
        ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->count();

        $solinfo=Vacantes::where('departamento_id',$request->iddepartamento)
        ->where('puesto_id',$request->puestoidvac)->where('company_id',$request->company_id)
        ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->first();

        if ($sol>0) {
          $sol=$sol+1;
          Vacantes::where('departamento_id',$request->iddepartamento)
          ->where('puesto_id',$request->puestoidvac)->where('company_id',$request->company_id)
          ->where('area_id',$request->iddepartamento)->where('jefe' , $infocentro->colaborador_id)->update([
            'solicitadas' => $sol
              ]);

          $idv=$solinfo->id;

        }else {
          $create_v=new Vacantes();
          $create_v->area_id=$request->iddepartamento;
          $create_v->company_id=$request->company_id;
          $create_v->departamento_id=$request->iddepartamento;
          $create_v->puesto_id=$request->puestoidvac;
          $create_v->fecha=date('Y-m-d');
          $create_v->area=$request->area;
          $create_v->jefe=$infocentro->colaborador_id;
          $create_v->estatus='pendiente';
          $create_v->prioridad='Baja';
          $create_v->codigo=$codigo;
          $create_v->solicitadas="1";
          $create_v->completadas="0";
          $create_v->save();

          $idv=$create_v->id;
        }


        $infonuevo=User::where('colaborador_id',$infocentro->colaborador_id)->first();

        if ($infonuevo->email) {
          Notificaciones::create([
                'email' => $infonuevo->email,
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$idv,
                'fecha' => now(),
                'texto' => 'Nueva Vacante para '.$request->area.'. Puesto '.npuesto($request->puestoidvac),
                'abierto' => '0',
              ]);
        }

        if (emailreclutamiento()) {
          Notificaciones::create([
                'email' => emailreclutamiento(),
                'tipo' => 'success',
                'ruta' => '/proceso_vacante/'.$idv,
                'fecha' => now(),
                'texto' => 'Nueva Vacante para '.$request->area.'. Puesto '.npuesto($request->puestoidvac),
                'abierto' => '0',
              ]);
        }



      }

     return redirect('/organigrama-lineal/'.$request->iddepartamento);


    }

    public function asignarnivel1(Request $request)
    {
      $idorganigrama=$request->idorganigrama;
      $nivel=1;
      $iddepartamento=$request->iddepartamento;
      $nuevo_colabid=$request->nuevo_colabid;
      $datacolab=Colaboradores::where('id',$nuevo_colabid)->first();
      $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

      $cuantaspos=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->count();
      $pos=$cuantaspos+1;
      $codigo=$numcc->numeracion.'-'.qpuesto($request->nuevo_colabid).'-'.$pos;

      $create=new OrganigramaLinealNiveles();
      $create->organigrama_id=$idorganigrama;
      $create->nivel='1';
      $create->colaborador_id=$request->nuevo_colabid;
      $create->jefe_directo_id='0';
      $create->jefe_directo_codigo='0';
      $create->codigo=$codigo;
      $create->cc=$request->iddepartamento;
      $create->puesto=ipuestocolab($nuevo_colabid);
      $create->company_id=$datacolab->company_id;
      $create->save();

      $user = new User();
      $user->email = $request->usuario;
      $user->name = $request->nombre;
      $user->perfil = $request->perfil;
      $user->colaborador_id = $request->nuevo_colabid;
      $user->device_key = '0';
      $user->role_id = '1';
      $user->rol = $request->permisos;

      // Hashea la contraseña antes de guardarla en la base de datos
      $user->password = Hash::make($request->password);

      // Guarda el usuario en la base de datos
      $user->save();

      return redirect('/organigrama-lineal/'.$request->iddepartamento);
    }


    public function moverposicion(Request $request){

      $origen=str_replace('colab','',$request->origen);
      $destino=str_replace('colab','',$request->destino);



      $datosOrigen=OrganigramaLinealNiveles::where('id',$origen)->first();
      $datosDestino=OrganigramaLinealNiveles::where('id',$destino)->first();





      $nuevonivel=$datosDestino->nivel+1;

      $idorganigrama=$datosOrigen->organigrama_id;
      $idcolab=$datosOrigen->colaborador_id;

      $subs=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
      ->where('jefe_directo_id',$idcolab)->get();

      $masinfo=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)->where('colaborador_id',$idcolab)->first();
      //$masinfo->jefe_directo_id;

    //  echo "<br> jefe directo:".$masinfo->jefe_directo_id."<br>";

      $colaboradores=array();

      $colaboradores[] = [
          'colaborador_id' => $datosOrigen->colaborador_id,
          'nivel' => $datosOrigen->nivel
      ];

      if ($subs) {
        foreach ($subs as $key) {
          $colaboradores[] = [
              'colaborador_id' => $key->colaborador_id,
              'nivel' => $key->nivel
          ];

          $subs2=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
          ->where('jefe_directo_id',$key->colaborador_id)->get();
            if ($subs2) {
              foreach ($subs2 as $key2) {


                $colaboradores[] = [
                    'colaborador_id' => $key2->colaborador_id,
                    'nivel' => $key2->nivel
                ];

                  $subs3=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
                  ->where('jefe_directo_id',$key2->colaborador_id)->get();
                    if ($subs3) {
                        foreach ($subs3 as $key3) {
                          $colaboradores[] = [
                              'colaborador_id' => $key3->colaborador_id,
                              'nivel' => $key3->nivel
                          ];

                            $subs4=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
                            ->where('jefe_directo_id',$key3->colaborador_id)->get();

                            if ($subs4) {

                                foreach ($subs4 as $key4) {

                                  $colaboradores[] = [
                                      'colaborador_id' => $key4->colaborador_id,
                                      'nivel' => $key4->nivel
                                  ];
                                }
                            }

                        }
                    }
              }
            }
        }
      }

      if ($datosOrigen->nivel==$datosDestino->nivel) {

         $dif=$datosOrigen->nivel-$datosDestino->nivel;

         return $dif;


      }elseif ($datosOrigen->nivel>$datosDestino->nivel) {
        //aqui sube de nivel
         $dif= $datosOrigen->nivel-$datosDestino->nivel;

         $numeroASumar=$dif;
         $colaboradoresActualizados = collect($colaboradores)->map(function ($colaborador) use ($numeroASumar) {
             $colaborador['nivel'] -= $numeroASumar;
             return $colaborador;
         });


         collect($colaboradores)->each(function ($colaborador) {
             // Actualizar el registro correspondiente en la base de datos

           //    echo "<br>".$colaborador['colaborador_id']."-".$colaborador['nivel'];
           //  OrganigramaLinealNiveles::where('colaborador_id', $colaborador['colaborador_id'])
               //  ->update(['nivel' => $colaborador['nivel']]);
         });

         collect($colaboradoresActualizados)->each(function ($colaborador) {
             // Actualizar el registro correspondiente en la base de datos

             //  echo "<br>".$colaborador['colaborador_id']."-".$colaborador['nivel'];
             OrganigramaLinealNiveles::where('colaborador_id', $colaborador['colaborador_id'])
                 ->update(['nivel' => $colaborador['nivel']]);
         });



         OrganigramaLinealNiveles::where('id',$origen)
         ->update([ 'jefe_directo_id' => $datosDestino->colaborador_id ,
                     'nivel' => $nuevonivel ]);

      }elseif ($datosOrigen->nivel<$datosDestino->nivel) {
          // aqui baja de nivel
         $dif=$datosDestino->nivel-$datosOrigen->nivel;
         //return $dif;
         $numeroASumar=$dif;
         $colaboradoresActualizados = collect($colaboradores)->map(function ($colaborador) use ($numeroASumar) {
             $colaborador['nivel'] += $numeroASumar;
             return $colaborador;
         });


         collect($colaboradores)->each(function ($colaborador) {
             // Actualizar el registro correspondiente en la base de datos

           //    echo "<br>".$colaborador['colaborador_id']."-".$colaborador['nivel'];
           //  OrganigramaLinealNiveles::where('colaborador_id', $colaborador['colaborador_id'])
               //  ->update(['nivel' => $colaborador['nivel']]);
         });

         collect($colaboradoresActualizados)->each(function ($colaborador) {
             // Actualizar el registro correspondiente en la base de datos

             //  echo "<br>".$colaborador['colaborador_id']."-".$colaborador['nivel'];
             OrganigramaLinealNiveles::where('colaborador_id', $colaborador['colaborador_id'])
                 ->update(['nivel' => $colaborador['nivel']]);
         });



         OrganigramaLinealNiveles::where('id',$origen)
         ->update([ 'jefe_directo_id' => $datosDestino->colaborador_id ,
                     'nivel' => $nuevonivel ]);

      }







    }

    public function reemplazar(Request $request){

      $idorganigrama=$request->idorganigrama;
      $nivel=$request->nivel;
      $iddepartamento=$request->iddepartamento;
      $idcolab=$request->idcolab;
      $nuevo_colabid=$request->nuevo_colabid;
      $puesto=$request->puestoid;

      $pos=$request->pos;

      $puesto_old_text=$request->puesto_old_text;
      $puesto_old=$request->puesto_old;


      $numcc=CentrodeCostos::where('id',$request->iddepartamento)->first();

      $cuantaspos=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->count();
      $pos=$cuantaspos+1;

      $infocentro=OrganigramaLinealNiveles::where('cc',$request->iddepartamento)->where('nivel','1')->first();





        $info=OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
        ->where('colaborador_id',$idcolab)->first();

        $info2=Colaboradores::where('id',$idcolab)->first();

        $infonuevo=Colaboradores::where('id',$nuevo_colabid)->first();


        if ($request->forzar_cambio=='Si') {

          //$codigo=$numcc->numeracion.'-'.$request->puesto_old.'-'.$pos;

          OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
          ->where('id',$pos)
          ->update([ 'colaborador_id' => $nuevo_colabid ]);

          Colaboradores::where('id',$idcolab)
          ->update([ 'puesto' => $puesto_old ]);

          OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
          ->where('jefe_directo_id',$idcolab)
          ->update([ 'jefe_directo_id' => $nuevo_colabid , 'jefe_directo_codigo' => $infonuevo->codigo ]);


        }else {

          $codigo=$numcc->numeracion.'-'.$info2->puesto.'-'.$pos;

          OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
          ->where('id',$pos)
          ->update([ 'colaborador_id' => $nuevo_colabid ]);

          OrganigramaLinealNiveles::where('organigrama_id',$idorganigrama)
          ->where('jefe_directo_id',$idcolab)
          ->update([ 'jefe_directo_id' => $nuevo_colabid , 'jefe_directo_codigo' => $codigo ]);

        }




     return redirect('/organigrama-lineal/'.$request->iddepartamento);

    }

    public function asignarjefe(Request $request){


      $existe=OrganigramaLinealNiveles::where('organigrama_id',$request->id)->where('nivel',$request->nivelactual)->count();

      /* El código se genera por: company_id iddepartamento organigrama_id nivel $existe+1 */
      $datacolab=Colaboradores::where('id',$request->colaborador_id)->first();
      $ex=$existe+1;
      $codigo=$datacolab->company_id.$request->iddepartamento.$request->id.$request->nivelactual.$ex;

      if ($request->nivelactual=='1') {

        OrganigramaLineal::where('id',$request->id)
        ->update([
          'jefe_directo' => $request->colaborador_id
         ]);

         OrganigramaLinealNiveles::where('nivel','2')
         ->update([
           'jefe_directo_id' => $request->colaborador_id
          ]);


        if($existe==0){

          $create=new OrganigramaLinealNiveles();
          $create->organigrama_id=$request->id;
          $create->nivel=$request->nivelactual;
          $create->colaborador_id=$request->colaborador_id;
          $create->jefe_directo_id='0';
          $create->codigo='0';
          $create->puesto=qpuesto($request->colaborador_id);
          $create->company_id=$datacolab->company_id;
          $create->save();

        }else {
          OrganigramaLinealNiveles::where('nivel',$request->nivelactual)
          ->update([
            'colaborador_id' => $request->colaborador_id ,
            'jefe_directo_id' => '0'
           ]);



        }

      }else {

          if ($request->nivelactual==2) {
            $create=new OrganigramaLinealNiveles();
            $create->organigrama_id=$request->id;
            $create->nivel=$request->nivelactual;
            $create->colaborador_id=$request->colaborador_id;
            $create->jefe_directo_id=$request->jefe_directo_id;
            $create->jefe_directo_codigo=$request->id_codigo;
            $create->codigo='0';
            $create->puesto=qpuesto($request->colaborador_id);
            $create->company_id=$datacolab->company_id;
            $create->save();


            $create2=new OrganigramaColaboradores();
            $create2->colaborador_id=$request->colaborador_id;
            $create2->codigo=$codigo;
            $create2->save();
          }else {
            $create=new OrganigramaLinealNiveles();
            $create->organigrama_id=$request->id;
            $create->nivel=$request->nivelactual;
            $create->colaborador_id=$request->colaborador_id;
            $create->jefe_directo_id=$request->jefe_directo_id;
            $create->codigo='0';
            $create->puesto=qpuesto($request->colaborador_id);
            $create->company_id=$datacolab->company_id;
            $create->save();


            $create2=new OrganigramaColaboradores();
            $create2->colaborador_id=$request->colaborador_id;
            $create2->codigo='0';
            $create2->save();
          }


      }
      return redirect('/organigrama-lineal'.'/'.$request->iddepartamento);
    }



    public function moverUbicacion(Request $request)
    {
        $colaboradoresSeleccionados = $request->input('colab_selec', []);

        $ubicacion_lista = $request->input('ubicacion');
        $nuevaUbicacion = $request->input('nueva_ubicacion');

        if($nuevaUbicacion){
            $create=new Ubicacion();
            $create->ubicacion=$nuevaUbicacion;
            $create->company_id='0';
            $create->abreviatura='0';
            $create->save();
            $ubicacion_lista = $create->id;
        }

        // Asignar la nueva ubicación a cada colaborador seleccionado
        foreach ($colaboradoresSeleccionados as $colaborador_id) {
            UbicacionesColaborador::updateOrCreate(
                ['id_colaborador' => $colaborador_id], // Condición para buscar
                ['id_ubicacion' => $ubicacion_lista]  // Datos a actualizar/crear
            );
        }

        return back()->with('success', 'Ubicación actualizada correctamente');

    }
}
