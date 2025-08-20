<?php


namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Vacaciones;
use App\Models\Gratificaciones;
use App\Models\HorasExtra;
use App\Models\Asistencias;
use App\Models\Horarios;
use App\Models\Conexiones;
use App\Models\Colaboradores;
use App\Models\CentrodeCostos;
use App\Models\Ubicacion;
use App\Models\Notificaciones;
use App\Models\Departamentos;
use App\Models\PerfilPuestos;
use App\Models\TiposdeTurnodeTrabajo;
use App\Models\TiposdePeriodo;
use App\Models\RegistroPatronal;
use App\Models\OrganigramaLinealNiveles;
use App\Models\OrganigramaLineal;
use App\Models\OrganigramaMatricial;
use App\Models\Vacantes;
use App\Models\Bajas;
use App\Models\Altas;
use App\Models\User;
use App\Models\Desvinculados;
use App\Models\Agrupadores;
use App\Models\AgrupadoresLista;
use App\Models\Procesos;
use App\Models\Externos;
use App\Models\ProcesoRH;
use App\Models\Proyecto;
use App\Models\Familiares;
use App\Models\Candidatos;
use App\Models\Beneficiarios;
use App\Models\DocumentosColaborador;
use App\Models\DireccionOrganigrama;
use App\Models\Periodo;
use App\Models\Concepto;
use App\Models\PuestosCC;
use App\Models\Motivos;
use App\Models\DepartamentosCC;
use App\Models\DepartamentosColaboradores;
use App\Models\ColaboradoresEmpresa;
use App\Models\PuestosEmpresas;
use App\Models\PuestosColaboradores;
use App\Models\PuestosDepartamentos;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\CatalogoPuestos;
use App\Models\ColaboradoresCC;
use App\Models\CatalogoDepartamentos;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Config;
use DB;

class RazonesSocialesController extends Controller
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
    public function index()
    {
        $companies = Companies::all();
        return view('razones_sociales.index' , ['companies' => $companies]);
    }

    public function fijar_rs(Request $request){

      session(['company_active_id' => $request->company_id]);
      if ($request->company_id=='0') {
        session(['company_active_name' => 'Todas las razones sociales']);
      }else {
        $companies = Companies::where('id',$request->company_id)->first();
        session(['company_active_name' => $companies->razon_social]);
      }

      //echo session('company_active_name');
      return redirect('/');
    }

    public function ver($id)
    {
        $company = Companies::where('id',$id)->first();
        return view('razones_sociales.ver' , ['company' => $company]);
    }

    public function borrado(){

      OrganigramaMatricial::truncate();
      Agrupadores::truncate();
      AgrupadoresLista::truncate();
      DireccionOrganigrama::where('id','1')->update([ 'horizontal' => NULL  , 'vertical' => NULL  , 'esquina' => NULL ]);
      OrganigramaLinealNiveles::truncate();
      OrganigramaLineal::truncate();
      Vacantes::truncate();
      Bajas::truncate();
      Altas::truncate();

      return redirect('/organigrama');
    }

    public function eliminar(Request $request)
    {

        Conexiones::where('company_id',$request->id)->update( [ 'company_id' => '0', ] );
        Companies::where('id',$request->id)->delete();
        Colaboradores::where('company_id',$request->id)->delete();
        Departamentos::where('company_id',$request->id)->delete();
        PerfilPuestos::truncate();
        TiposdeTurnodeTrabajo::where('company_id',$request->id)->delete();
        TiposdePeriodo::where('company_id',$request->id)->delete();
        RegistroPatronal::where('company_id',$request->id)->delete();
        CentroDeCostos::where('company_id',$request->id)->delete();
        Ubicacion::where('company_id',$request->id)->delete();
        OrganigramaLinealNiveles::truncate();
        OrganigramaLineal::truncate();
        Vacantes::truncate();
        Bajas::where('company_id',$request->id)->delete();
        Familiares::where('company_id',$request->id)->delete();
        Beneficiarios::where('company_id',$request->id)->delete();
        Agrupadores::truncate();
        AgrupadoresLista::truncate();
        Procesos::truncate();
        Desvinculados::truncate();
        Notificaciones::truncate();
        Externos::truncate();
        Desvinculados::where('company_id',$request->id)->delete();
        User::where('id', '>=' , 10)->delete();
        ProcesoRH::truncate();
        Proyecto::where('company_id',$request->id)->delete();
        OrganigramaMatricial::truncate();
        DireccionOrganigrama::where('id','1')->update([ 'horizontal' => NULL  , 'vertical' => NULL  , 'esquina' => NULL ]);

        DocumentosColaborador::truncate();
        Colaboradores::truncate();
        CentroDeCostos::truncate();
        Desvinculados::truncate();
        Departamentos::truncate();


        Vacaciones::truncate();
        Gratificaciones::truncate();
        HorasExtra::truncate();
        Asistencias::truncate();
        Horarios::truncate();
        Candidatos::truncate();

        Motivos::truncate();

        PuestosCC::truncate();
        DepartamentosCC::truncate();
        DepartamentosColaboradores::truncate();
        ColaboradoresEmpresa::truncate();
        PuestosEmpresas::truncate();
        PuestosColaboradores::truncate();
        PuestosDepartamentos::truncate();
        CatalogoCentrosdeCostos::truncate();
        CatalogoPuestos::truncate();
        CatalogoDepartamentos::truncate();
        ColaboradoresCC::truncate();


        User::where('id', '!=' ,'1')->delete();

        return redirect ('/razones_sociales');
    }

    public function nuevo()
    {
        $conexiones = Conexiones::where('company_id',0)->get();

            /*$create=new Conexiones();
            $create->company_id='0';
            $create->name='Corporativo';
            $create->host=Crypt::encryptString('104.131.96.200');
            $create->user=Crypt::encryptString('codea');
            $create->password=Crypt::encryptString('coDea1205');
            $create->port=Crypt::encryptString('1433');
            $create->database=Crypt::encryptString('corporativo');
            $create->file="";
            $create->save();

            $create2=new Conexiones();
            $create2->company_id='0';
            $create2->name='Constructora';
            $create2->host=Crypt::encryptString('104.131.96.200');
            $create2->user=Crypt::encryptString('codea');
            $create2->password=Crypt::encryptString('coDea1205');
            $create2->port=Crypt::encryptString('1433');
            $create2->database=Crypt::encryptString('constructora');
            $create2->file="";
            $create2->save();

            $create3=new Conexiones();
            $create3->company_id='0';
            $create3->name='Baeza';
            $create3->host=Crypt::encryptString('104.131.96.200');
            $create3->user=Crypt::encryptString('codea');
            $create3->password=Crypt::encryptString('coDea1205');
            $create3->port=Crypt::encryptString('1433');
            $create3->database=Crypt::encryptString('baeza');
            $create3->file="";
            $create3->save();
            */


        return view('razones_sociales.crear' , ['conexiones'=> $conexiones]);
    }


    public function meterdesvinculados(){

      Candidatos::truncate();
      Vacantes::truncate();
      Altas::truncate();
      Bajas::truncate();
      Motivos::truncate();
      Notificaciones::truncate();
      ProcesoRH::truncate();

    }




    public function crear(Request $request){



      $conexion=Conexiones::where('id',$request->idconexion)->first();

      $host=$conexion->host;
      $port=$conexion->port;
      $database=$conexion->database;
      $username=$conexion->user;
      $password=$conexion->password;
      $driver=$conexion->driver;

      Config::offsetUnset('database.connections.'.$database);


      Config::set('database.connections.'.$database, [
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

      DB::purge($database);
      DB::reconnect($database);


      if (DB::connection($database)->getDatabaseName()) {

            $sqlsrv=$database;

            $nom10000=DB::connection($sqlsrv)->table('nom10000')->first();
            $fechaconstitucion=$nom10000->fechaconstitucion;

            $ano = substr($fechaconstitucion, 2, 2);
            $mes = substr($fechaconstitucion, 5, 2);
            $dia = substr($fechaconstitucion, 8, 2);

            $rfc=$nom10000->rfc.$ano.$mes.$dia.$nom10000->homoclave;

            $create=new Companies();
            $create->user_id='1';
            $create->nombre=$database;
            $create->rfc=$rfc;
            $create->razon_social=$nom10000->nombrecorto;
            $create->calle=$nom10000->direccion;
            $create->colonia=" ";
            $create->codigo_postal=" ";
            $create->municipio=" ";
            $create->ciudad=" ";
            $create->estado=" ";
            $create->imss=$nom10000->registroimss;

            $create->save();

            $numerodecompany=$create->id;

            Conexiones::where('name',$database)->update(['company_id' => $numerodecompany ]);


          //  $nom10001=DB::connection($sqlsrv)->table('nom10001')->where('estadoempleado' , '!=' , 'B')->get();
            $nom10001=DB::connection($sqlsrv)->table('nom10001')->get();
            foreach ($nom10001 as $n1){
                $fecha=trim(str_replace('00:00:00' , '' , $n1->fechanacimiento));
                $fecha=trim(str_replace(' .000' , '' , $fecha));
                $fecha2=trim(str_replace('-' , '' , $fecha));
                $fecha2=trim(substr($fecha2, 2));



                $sexo="";
                if($n1->sexo=='M'){ $sexo='Masculino'; }
                if($n1->sexo=='F'){ $sexo='Femenino'; }

                $estatus="activo";

                if ($n1->estadoempleado=='B') {
                  $estatus="inactivo";
                }

                $estadocivil="";
                if($n1->estadocivil=='S'){ $estadocivil="Soltero"; }
                if($n1->estadocivil=='C'){ $estadocivil="Casado"; }
                if($n1->estadocivil=='V'){ $estadocivil="Viudo"; }
                if($n1->estadocivil=='D'){ $estadocivil="Divorciado"; }
                if($n1->estadocivil=='U'){ $estadocivil="Union Libre"; }

                $edonac=$n1->EntidadFederativa;

                if ($edonac == 'AS') {
                    $edonac = "Aguascalientes";
                } else if ($edonac == 'BC') {
                    $edonac = "Baja California";
                } else if ($edonac == 'BS') {
                    $edonac = "Baja California Sur";
                } else if ($edonac == 'CM') {
                    $edonac = "Campeche";
                } else if ($edonac == 'CS') {
                    $edonac = "Chiapas";
                } else if ($edonac == 'CH') {
                    $edonac = "Chihuahua";
                } else if ($edonac == 'CO') {
                    $edonac = "Coahuila"; // Asumiendo que se usa 'CO' para Coahuila de Zaragoza
                } else if ($edonac == 'CL') {
                    $edonac = "Colima";
                } else if ($edonac == 'CX') {
                    $edonac = "Ciudad de México"; // Usando 'CX' como ejemplo, aunque puede necesitar ajuste
                } else if ($edonac == 'DG') {
                    $edonac = "Durango";
                } else if ($edonac == 'GT') {
                    $edonac = "Guanajuato";
                } else if ($edonac == 'GR') {
                    $edonac = "Guerrero";
                } else if ($edonac == 'HG') {
                    $edonac = "Hidalgo";
                } else if ($edonac == 'JC') {
                    $edonac = "Jalisco";
                } else if ($edonac == 'MC') {
                    $edonac = "Estado de México";
                } else if ($edonac == 'MI') {
                    $edonac = "Michoacán";
                } else if ($edonac == 'MO') {
                    $edonac = "Morelos";
                } else if ($edonac == 'NA') {
                    $edonac = "Nayarit";
                } else if ($edonac == 'NL') {
                    $edonac = "Nuevo León";
                } else if ($edonac == 'OA') {
                    $edonac = "Oaxaca";
                } else if ($edonac == 'PU') {
                    $edonac = "Puebla";
                } else if ($edonac == 'QT') {
                    $edonac = "Querétaro";
                } else if ($edonac == 'QR') {
                    $edonac = "Quintana Roo";
                } else if ($edonac == 'SL') {
                    $edonac = "San Luis Potosí";
                } else if ($edonac == 'SI') {
                    $edonac = "Sinaloa";
                } else if ($edonac == 'SO') {
                    $edonac = "Sonora";
                } else if ($edonac == 'TB') {
                    $edonac = "Tabasco";
                } else if ($edonac == 'TM') {
                    $edonac = "Tamaulipas";
                } else if ($edonac == 'TL') {
                    $edonac = "Tlaxcala";
                } else if ($edonac == 'VE') {
                    $edonac = "Veracruz";
                } else if ($edonac == 'YU') {
                    $edonac = "Yucatán";
                } else if ($edonac == 'ZA') {
                    $edonac = "Zacatecas";
                }
                // No hay necesidad de un "else" final para cambiar $edonac, se mantendrá como está si no entra en ninguno de los anteriores.

                $curp = $n1->curpi . $fecha2 . $n1->curpf;



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
                  $create1->sueldovariable=$n1->sueldovariable;
                  $create1->sueldointegrado=$n1->sueldointegrado;
                  $create1->csueldomixto=$n1->csueldomixto;
                  $create1->turno_de_trabajo_id=$n1->idturno;
                  $create1->periodo_id=$n1->idtipoperiodo;
                  $create1->fecha_alta=$n1->fechaalta;
                  $create1->fecha_baja=$n1->fechabaja;
                  $create1->causabaja=$n1->causabaja;
                  $create1->estadoempleado=$n1->estadoempleado;
                  $create1->tipo_de_contrato_id=$n1->tipocontrato;
                  $create1->telefono=trim($n1->telefono);
                  $create1->codigopostal=trim($n1->codigopostal);
                  $create1->direccion=trim($n1->direccion);
                  $create1->poblacion=trim($n1->poblacion);
                  $create1->estado=trim($n1->estado);
                  $create1->ubicaciones=trim($n1->campoextra3);
                  $create1->proyectos=trim($n1->campoextra2);
                  $create1->organigrama=trim($n1->campoextra1);
                  $create1->estatus=$estatus;
                  $create1->estado_civil_id=$estadocivil;
                  $create1->umf=trim($n1->umf);
                  $create1->base_de_pago_id=trim($n1->basepago);
                  $create1->metodo_de_pago_id=trim($n1->formapago);
                  $create1->zona_de_salario_id=trim($n1->zonasalario);
                  $create1->afore=trim($n1->numeroafore);
                  $create1->fonacot=trim($n1->NumeroFonacot);
                  $create1->email=trim($n1->CorreoElectronico);
                  $create1->regimen_id=trim($n1->TipoRegimen);
                  $create1->clabe_interbancaria=trim($n1->ClabeInterbancaria);
                  $create1->prestacion_id=trim($n1->TipoPrestacion);
                  $create1->estado_nacimiento=$edonac;
                  $create1->registro_patronal_id=trim($n1->cidregistropatronal);
                  $create1->banco=trim($n1->bancopagoelectronico);
                  $create1->cuenta_cheques=trim($n1->cuentapagoelectronico);
                  $create1->banco=trim($n1->bancopagoelectronico);
                  $create1->save();

                  $createrel=new ColaboradoresEmpresa();
                  $createrel->colaborador_id=$create1->id;
                  $createrel->company_id=$numerodecompany;
                  $createrel->save();

                  if($n1->nombrepadre){
                    $create1fam=new Familiares();
                    $create1fam->company_id=$numerodecompany;
                    $create1fam->colaborador_id=$create1->id;
                    $create1fam->nombre=trim($n1->nombrepadre);
                    $create1fam->relacion='Padre';
                    $create1fam->save();
                  }


                  if($n1->nombremadre){
                    $create1fam=new Familiares();
                    $create1fam->company_id=$numerodecompany;
                    $create1fam->colaborador_id=$create1->id;
                    $create1fam->nombre=trim($n1->nombremadre);
                    $create1fam->relacion='Madre';
                    $create1fam->save();
                  }


                    /*
                    $nombreUsuario = generarNombreUsuario($n1->nombre, $n1->apellidopaterno, $n1->apellidomaterno);


                    $createuser = new User();
                    $createuser->name = $nombreUsuario;
                    $createuser->email = $nombreUsuario . '@gonie.com';
                    $createuser->password = bcrypt('Gonie2024++');
                    $createuser->colaborador_id = $create1->id;
                    $createuser->rol = 'Colaborador';
                    $createuser->role_id = '2';
                    $createuser->save();
                    */


            }


            $nom10002=DB::connection($sqlsrv)->table('nom10002')->get();


            foreach ($nom10002 as $n2){
              $create2 = new Periodo();
              $create2->company_id=$numerodecompany;
              $create2->idperiodo = $n2->idperiodo;
              $create2->idtipoperiodo = $n2->idtipoperiodo;
              $create2->numeroperiodo = $n2->numeroperiodo;
              $create2->ejercicio = $n2->ejercicio;
              $create2->mes = $n2->mes;
              $create2->diasdepago = $n2->diasdepago;
              $create2->septimos = $n2->septimos;
              $create2->interfazcheqpaqw = $n2->interfazcheqpaqw;
              $create2->modificacionneto = $n2->modificacionneto;
              $create2->calculado = $n2->calculado;
              $create2->afectado = $n2->afectado;
              $create2->fechainicio = $n2->fechainicio;
              $create2->fechafin = $n2->fechafin;
              $create2->inicioejercicio = $n2->inicioejercicio;
              $create2->iniciomes = $n2->iniciomes;
              $create2->finmes = $n2->finmes;
              $create2->finejercicio = $n2->finejercicio;
              $create2->cfinbimestreimss = $n2->cfinbimestreimss;
              $create2->ciniciobimestreimss = $n2->ciniciobimestreimss;
              $create2->fechaPago = $n2->fechaPago;
              $create2->save();
            }





            $nom10003=DB::connection($sqlsrv)->table('nom10003')->get();
            $estatusdepa='activo';

            foreach ($nom10003 as $n3){

              $existingDepartment = CatalogoDepartamentos::where('departamento', $n3->descripcion)->first();

              if (!$existingDepartment) {
                  // Si no existe, crea un nuevo registro en CatalogoDepartamentos
                  $catalogoDepartamento = new CatalogoDepartamentos();
                  $catalogoDepartamento->departamento = $n3->descripcion;
                  $catalogoDepartamento->save();
              }

              $cc = Colaboradores::where('departamento_id',$n3->iddepartamento)->first();


                $create3=new Departamentos();
                $create3->iddepartamento=$n3->iddepartamento;
                $create3->numerodepartamento=$n3->numerodepartamento;
                $create3->company_id=$numerodecompany;
                $create3->departamento=$n3->descripcion;
                $create3->estatus=$estatusdepa;
                $create3->padre=$cc->centro_de_costos ?? '';
                $create3->save();
            }


            $nom10004=DB::connection($sqlsrv)->table('nom10004')->get();


            foreach ($nom10004 as $n4){
               $create4 = new Concepto();
               $create4->company_id = $numerodecompany;
               $create4->idconcepto = $n4->idconcepto;
               $create4->numeroconcepto = $n4->numeroconcepto;
               $create4->tipoconcepto = $n4->tipoconcepto;
               $create4->descripcion = $n4->descripcion;
               $create4->especie = $n4->especie;
               $create4->automaticoglobal = $n4->automaticoglobal;
               $create4->automaticoliquidacion = $n4->automaticoliquidacion;
               $create4->imprimir = $n4->imprimir;
               $create4->articulo86 = $n4->articulo86;
               $create4->leyendaimporte1 = $n4->leyendaimporte1;
               $create4->leyendaimporte2 = $n4->leyendaimporte2;
               $create4->leyendaimporte3 = $n4->leyendaimporte3;
               $create4->leyendaimporte4 = $n4->leyendaimporte4;
               $create4->cuentacw = $n4->cuentacw;
               $create4->tipomovtocw = $n4->tipomovtocw;
               $create4->contracuentacw = $n4->contracuentacw;
               $create4->contabcuentacw = $n4->contabcuentacw;
               $create4->contabcontracuentacw = $n4->contabcontracuentacw;
               $create4->leyendavalor = $n4->leyendavalor;
               $create4->formulaimportetotal = $n4->formulaimportetotal;
               $create4->formulaimporte1 = $n4->formulaimporte1;
               $create4->formulaimporte2 = $n4->formulaimporte2;
               $create4->formulaimporte3 = $n4->formulaimporte3;
               $create4->formulaimporte4 = $n4->formulaimporte4;
               $create4->FormulaValor = $n4->FormulaValor;
               $create4->CuentaGravado = $n4->CuentaGravado;
               $create4->CuentaExentoDeduc = $n4->CuentaExentoDeduc;
               $create4->CuentaExentoNoDeduc = $n4->CuentaExentoNoDeduc;
               $create4->ClaveAgrupadoraSAT = $n4->ClaveAgrupadoraSAT;
               $create4->MetodoDePago = $n4->MetodoDePago;
               $create4->TipoClaveSAT = $n4->TipoClaveSAT;
               $create4->TipoHoras = $n4->TipoHoras;
               $create4->save();
            }



            $nom10006=DB::connection($sqlsrv)->table('nom10006')->get();

            $estatuspsto='activo';

            foreach ($nom10006 as $n6){

              //$estatuspsto=puestoactivo($n6->idpuesto);

              $existingPuesto = CatalogoPuestos::where('puesto', $n6->descripcion)->first();

              if (!$existingPuesto) {
                  // Si no existe, crea un nuevo registro en CatalogoDepartamentos
                  $catalogoPuesto = new CatalogoPuestos();
                  $catalogoPuesto->puesto = $n6->descripcion;
                  $catalogoPuesto->save();
              }

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
                $create35->cidregistropatronal=$n35->cidregistropatronal;
                $create35->registro_patronal=$n35->cregistroimss;
                $create35->save();
            }


            $centrosDeCostos = Colaboradores::where('estatus', 'activo') ->where('company_id', $numerodecompany) ->select('organigrama') ->distinct() ->get();
            $ubicaciones = Colaboradores::where('estatus', 'activo') ->where('company_id', $numerodecompany) ->select('ubicaciones') ->distinct() ->get();
            $proyectos = Colaboradores::where('estatus', 'activo') ->where('company_id', $numerodecompany) ->select('proyectos') ->distinct() ->get();
            $c=0;
            foreach ($centrosDeCostos as $centroDeCosto) {

              $existingCC = CatalogoCentrosdeCostos::where('centro_de_costo', $centroDeCosto->organigrama)->first();

              if (!$existingCC) {
                  // Si no existe, crea un nuevo registro en CatalogoDepartamentos
                  $catalogoCC = new CatalogoCentrosdeCostos();
                  $catalogoCC->centro_de_costo = $centroDeCosto->organigrama;
                  $catalogoCC->save();
              }

                $c++;
                CentroDeCostos::updateOrCreate(
                    ['centro_de_costos' => $centroDeCosto->organigrama, 'company_id' => $numerodecompany , 'numeracion' => $c]
                );
            }
            foreach ($ubicaciones as $ubicacion) {
                Ubicacion::updateOrCreate(
                    ['ubicacion' => $ubicacion->ubicaciones, 'company_id' => $numerodecompany]
                );
            }
            foreach ($proyectos as $proyecto) {
                Proyecto::updateOrCreate(
                    ['proyecto' => $proyecto->proyectos, 'company_id' => $numerodecompany , 'presupuesto' => '0.00']
                );
            }
            $todosloscolaboradores=Colaboradores::where('company_id',$numerodecompany)->get();
            foreach ($todosloscolaboradores as $todos) {

              $infocatcc = CatalogoCentrosdeCostos::where('centro_de_costo', $todos->organigrama)->first();
              if ($infocatcc) {
                  $colab1 = new ColaboradoresCC();
                  $colab1->colaborador_id = $todos->id;
                  $colab1->id_catalogo_centro_de_costos_id = $infocatcc->id;
                  $colab1->save();
              }
              $infodepas=Departamentos::where('iddepartamento',$todos->departamento_id , )->where('company_id',$numerodecompany)->first();
              $infocatdep=CatalogoDepartamentos::where('departamento',$infodepas->departamento)->first();
              if ($infocatdep) {
                $colab2 = new DepartamentosColaboradores();
                $colab2->colaborador_id = $todos->id;
                $colab2->id_catalogo_departamento_id = $infocatdep->id;
                $colab2->save();
              }
              $infopuestos=PerfilPuestos::where('idpuesto',$todos->puesto)->where('company_id',$numerodecompany)->first();
              $infocatpuesto=CatalogoPuestos::where('puesto',$infopuestos->puesto)->first();
              if ($infocatpuesto) {
                $colab3 = new PuestosColaboradores();
                $colab3->id_colaborador = $todos->id;
                $colab3->id_catalogo_puesto_id = $infocatpuesto->id;
                $colab3->save();
              }

              if ($todos->estatus=='inactivo') {
                $createdes=new Desvinculados();
                $createdes->company_id=$numerodecompany;
                $createdes->idempleado=$todos->id;
                $createdes->fecha_baja=$todos->fecha_baja;
                $createdes->causabaja=$todos->causabaja;
                $createdes->curp=$todos->curp;
                $createdes->save();
              }

              if ($infocatpuesto && $infocatcc) {
                $colab4 = new PuestosCC();
                $colab4->id_catalogo_puestos_id = $infocatpuesto->id;
                $colab4->id_catalogo_centro_de_costos_id = $infocatcc->id;
                $colab4->save();
              }
              if ($infocatdep && $infocatcc) {
                $colab5 = new DepartamentosCC();
                $colab5->id_catalogo_departamento_id = $infocatdep->id;
                $colab5->id_catalogo_centro_de_costos_id = $infocatcc->id;
                $colab5->save();
              }
              if ($infocatdep && $infocatpuesto) {
                $colab6 = new PuestosDepartamentos();
                $colab6->id_catalogo_puesto_id = $infocatpuesto->id;
                $colab6->id_catalogo_departamento_id = $infocatdep->id;
                $colab6->save();
              }
              if ($infocatpuesto) {
              $colab7 = new PuestosEmpresas();
              $colab7->id_catalogo_puesto_id = $infocatpuesto->id;
              $colab7->company_id = $todos->company_id;
              $colab7->save();
            }
           }



           return redirect ('/razones_sociales');


      }else {
        echo "Error al conectarse a ".$database;
      }

    }

    public function update(Request $request, $id)
    {
      $company = Companies::findOrFail($id);

        $company->update([
          'razon_social' => $request->razon_social,
          'rfc' => $request->rfc,
          'calle' => $request->calle,
          'colonia' => $request->colonia ?? ' ',
          'codigo_postal' => $request->codigo_postal ?? ' ',
          'municipio' => $request->municipio ?? ' ',
          'ciudad' => $request->ciudad ?? ' ',
          'estado' => $request->estado ?? ' ',
          'pais' => 'Mexico',
          'abreviatura' => $request->abreviatura ?? ' ',
        ]);

        return redirect('/razones_sociales')->with('success', 'Compañía actualizada con éxito');
    }



}
