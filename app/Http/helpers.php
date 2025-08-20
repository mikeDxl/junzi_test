<?php

use App\Models\Departamentos;
use App\Models\Companies;
use App\Models\Vacaciones;
use App\Models\TiposdeSolicitudes;
use App\Models\TiposdeReclutamiento;
use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Entrevistas;
use App\Models\Encuestas;
use App\Models\PerfilPuestos;
use App\Models\User;
use App\Models\Bancos;
use App\Models\DireccionOrganigrama;
use App\Models\OrganigramaMatricial;
use App\Models\Vacantes;
use App\Models\Procesos;
use App\Models\ProcesoRH;
use App\Models\CentrodeCostos;
use App\Models\Reclutamientos;
use App\Models\Agrupadores;
use App\Models\AgrupadoresLista;
use App\Models\VacantesGeneradas;
use App\Models\OrganigramaLineal;
use App\Models\OrganigramaLinealNiveles;
use App\Models\RegistroPatronal;
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
use App\Models\Externos;
use App\Models\Bajas;
use Carbon\Carbon;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\DocumentosColaborador;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\CatalogoDepartamentos;
use App\Models\CatalogoPuestos;
use App\Models\ColaboradoresCC;
use App\Models\DepartamentosCC;
use App\Models\ColaboradoresEmpresa;
use App\Models\DepartamentosColaboradores;
use App\Models\PuestosCC;
use App\Models\PuestosColaboradores;
use App\Models\PuestosDepartamentos;
use App\Models\PuestosEmpresas;
use App\Models\DiasVacaciones;
use App\Models\Gratificaciones;
use App\Models\Permisos;
use App\Models\HorasExtra;
use App\Models\Asistencias;
use App\Models\Incapacidad;
use App\Models\Ubicacion;
use App\Models\UbicacionesColaborador;
use App\Models\VacacionesPendientes;


if (!function_exists('obtener_nombres_jefes_directos')) {
    function obtener_nombres_jefes_directos(string $colaboradores): string
    {
        // Convertir el string de IDs a un array
        $colaboradoresArray = explode(',', $colaboradores);

        // Obtener los jefes directos de los colaboradores
        $jefes = OrganigramaLinealNiveles::whereIn('colaborador_id', $colaboradoresArray)
            ->pluck('jefe_directo_id')
            ->toArray();

        // Convertir los IDs de los jefes a nombres usando la función qcolab
        $nombresJefes = array_map(fn($id) => qcolab($id), $jefes);

        // Convertir el array de nombres a un string separado por comas
        return implode(',', $nombresJefes);
    }
}

function qubi($id) {
    $colaborador = Colaboradores::where('id', $id)->first();

    if (!$colaborador) {
        return null; // Retorna null si el colaborador no existe
    }

    $ubicacion_nomipaq = $colaborador->ubicacion;

    // Buscar la ubicación en UbicacionesColaborador
    $ubicacion_junzi = UbicacionesColaborador::where('id_colaborador', $id)->first();

    // Si existe una ubicación en UbicacionesColaborador, buscar la ubicación real
    if ($ubicacion_junzi && $ubicacion_junzi->id_ubicacion) {
        $ubicacion = Ubicacion::where('id', $ubicacion_junzi->id_ubicacion)->first();
        return $ubicacion->ubicacion ?? $ubicacion_nomipaq; // Retorna la ubicación si existe, de lo contrario, la de nomipaq
    }

    return $ubicacion_nomipaq; // Si no hay ubicación en UbicacionesColaborador, usa la de nomipaq
}


function gestiona($id){
  $cuantos = 0;
  $cuantos= OrganigramaLinealNiveles::where('jefe_directo_id', $id)->count();

  return $cuantos ?? '0';
}


function obtenerSubordinados($colaborador_id, $nivel, $max_nivel = 5) {
    // Si ya hemos alcanzado el nivel máximo, no hacemos más consultas
    if ($nivel > $max_nivel) {
        return collect(); // No más niveles
    }

    // Obtenemos todos los subordinados de este colaborador en el nivel actual
    $subordinados = OrganigramaLinealNiveles::where('jefe_directo_id', $colaborador_id)
        ->orderBy('nivel', 'asc')
        ->get();

    // Inicializamos una colección para los resultados
    $resultados = collect($subordinados);

    // Llamada recursiva para obtener subordinados de los subordinados
    foreach ($subordinados as $subordinado) {
        $resultados = $resultados->merge(obtenerSubordinados($subordinado->colaborador_id, $nivel + 1));
    }

    return $resultados;
}
function queEmail($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->email;
}

function quePerfil($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->perfil;
}

function rolReclutamiento($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->reclutamiento;
}

function rolRH($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->nomina;
}

function rolAuditoria($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->auditoria;
}

function rolJefatura($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->jefatura;
}

function rolColaborador($idcolab) {
    return optional(User::where('colaborador_id', $idcolab)->first())->perfil;
}


function vacacionesActuales($idcolab){
    $vac=VacacionesPendientes::where('colaborador_id',$idcolab)->first();

    return $vac->actuales ?? '0';
}

function vacacionesPendientes($idcolab){
  $vac=VacacionesPendientes::where('colaborador_id',$idcolab)->first();

  return $vac->anteriores ?? '0';
}


function sumarSalariosDiariosPorCentro($centroId)
    {
        // Obtener el centro de costo con los colaboradores activos
        $centro = \App\Models\CatalogoCentrosdeCostos::with(['colaboradores' => function($query) {
            $query->where('estatus', 'activo');  // Filtrar por colaboradores activos
        }])->find($centroId);

        if (!$centro) {
            return 0; // Si el centro de costo no existe, retornar 0
        }

        // Sumar los salarios diarios de los colaboradores activos
        $sumatoriaSalariosDiarios = $centro->colaboradores->sum('salario_diario');

        return $sumatoriaSalariosDiarios*30;
    }

    function edadPromedioPorCentro($centroId)
    {
        // Obtener el centro de costo con los colaboradores activos
        $centro = \App\Models\CatalogoCentrosdeCostos::with(['colaboradores' => function($query) {
            $query->where('estatus', 'activo');  // Filtrar por colaboradores activos
        }])->find($centroId);

        if (!$centro) {
            return 0; // Si el centro de costo no existe, retornar 0
        }

        // Calcular la edad de cada colaborador y obtener la edad promedio
        $edades = $centro->colaboradores->map(function($colaborador) {
            return \Carbon\Carbon::parse($colaborador->fecha_nacimiento)->age; // Calcular la edad
        });

        if ($edades->isEmpty()) {
            return 0; // Si no hay colaboradores activos, retornar 0
        }

        // Calcular el promedio de las edades
        $edadPromedio = $edades->average();

        return round($edadPromedio, 2); // Redondear el promedio a 2 decimales
    }

    function cantidadColaboradoresActivosPorCentro($centroId)
    {
        // Obtener el centro de costo con los colaboradores activos
        $centro = CatalogoCentrosdeCostos::with(['colaboradores' => function($query) {
            $query->where('estatus', 'activo');  // Filtrar por colaboradores activos
        }])->find($centroId);

        // Si el centro de costo no existe o no tiene colaboradores, retornar 0
        if (!$centro || $centro->colaboradores->isEmpty()) {
            return 0;
        }

        // Contar los colaboradores activos
        $cantidadColaboradores = $centro->colaboradores->count();

        return $cantidadColaboradores; // Retornar la cantidad de colaboradores activos
    }

    function antiguedadPromedioPorCentro($centroId)
    {
        // Obtener el centro de costo con los colaboradores activos
        $centro = \App\Models\CatalogoCentrosdeCostos::with(['colaboradores' => function($query) {
            $query->where('estatus', 'activo');  // Filtrar por colaboradores activos
        }])->find($centroId);

        if (!$centro) {
            return 0; // Si el centro de costo no existe, retornar 0
        }

        // Calcular la antigüedad de cada colaborador y obtener la antigüedad promedio
        $antiguedades = $centro->colaboradores->map(function($colaborador) {
            return \Carbon\Carbon::parse($colaborador->fecha_alta)->diffInYears(now()); // Calcular la antigüedad en años
        });

        if ($antiguedades->isEmpty()) {
            return 0; // Si no hay colaboradores activos, retornar 0
        }

        // Calcular el promedio de las antigüedades
        $antiguedadPromedio = $antiguedades->average();

        return round($antiguedadPromedio, 2); // Redondear el promedio a 2 decimales
    }


    function sumarSalariosPorUbicacion($ubicacionId)
    {
        // Obtener la ubicación por ID
        $ubicacion = Ubicacion::find($ubicacionId);

        // Si no se encuentra la ubicación, retornar 0
        if (!$ubicacion) {
            return 0;
        }

        // Sumar los salarios diarios de todos los colaboradores
        $totalSalario = $ubicacion->colaboradores->sum('salario_diario');

        return $totalSalario;
    }

    function promedioEdadPorUbicacion($ubicacionId)
    {
        // Obtener la ubicación por ID
        $ubicacion = Ubicacion::find($ubicacionId);

        // Si no se encuentra la ubicación, retornar 0
        if (!$ubicacion) {
            return 0;
        }

        // Obtener todos los colaboradores de la ubicación
        $colaboradores = $ubicacion->colaboradores;

        // Verificar si la ubicación tiene colaboradores
        if ($colaboradores->isEmpty()) {
            return 0;
        }

        // Calcular el total de edades
        $totalEdad = $colaboradores->reduce(function ($carry, $colaborador) {
            // Calcular la edad a partir de la fecha de nacimiento
            $edad = Carbon::parse($colaborador->fecha_nacimiento)->age;
            return $carry + $edad;
        }, 0);

        // Calcular el promedio de edad
        $promedioEdad = $totalEdad / $colaboradores->count();

        return round($promedioEdad, 2);  // Redondear a dos decimales
    }


function calcularFechaFin($fechaInicio, $diasIncapacidad) {
    $fechaInicio = Carbon::parse($fechaInicio);
    $diasSumados = 0;

    while ($diasSumados < $diasIncapacidad) {
        // Avanzar un día
        $fechaInicio->addDay();

        // Si no es domingo, incrementar el contador de días sumados
        if ($fechaInicio->dayOfWeek !== Carbon::SUNDAY) {
            $diasSumados++;
        }
    }

    return $fechaInicio->toDateString();
}

function promedioAntiguedadPorUbicacion($ubicacionId)
    {
        // Obtener la ubicación por ID
        $ubicacion = Ubicacion::find($ubicacionId);

        // Si no se encuentra la ubicación, retornar 0
        if (!$ubicacion) {
            return 0;
        }

        // Obtener todos los colaboradores de la ubicación
        $colaboradores = $ubicacion->colaboradores;

        // Verificar si la ubicación tiene colaboradores
        if ($colaboradores->isEmpty()) {
            return 0;
        }

        // Calcular el total de antigüedades
        $totalAntiguedad = $colaboradores->reduce(function ($carry, $colaborador) {
            // Calcular la antigüedad a partir de la fecha de alta
            $antiguedad = Carbon::parse($colaborador->fecha_alta)->diffInYears(Carbon::now());
            return $carry + $antiguedad;
        }, 0);

        // Calcular el promedio de antigüedad
        $promedioAntiguedad = $totalAntiguedad / $colaboradores->count();

        return round($promedioAntiguedad, 2);  // Redondear a dos decimales
    }

    function cantidadColaboradoresPorUbicacion($ubicacionId)
    {
        // Obtener la ubicación por ID
        $ubicacion = Ubicacion::find($ubicacionId);

        // Si no se encuentra la ubicación, retornar 0
        if (!$ubicacion) {
            return 0;
        }

        // Obtener la cantidad de colaboradores de la ubicación
        $cantidadColaboradores = $ubicacion->colaboradores()->count();

        return $cantidadColaboradores;
    }

function buscarDiasVacacionesC($id){
  $colaborador_id=$id;

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

function incidencias_aprobadas($company_id,$startOfMonth, $endOfMonth){
  $compensaciones = Gratificaciones::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_gratificacion', 'desc') ->where('estatus', 'Aprobada')->count();
  $permisos = Permisos::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_permiso', 'desc')->where('estatus', 'Aprobada') ->count();
  $horasextra = HorasExtra::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_hora_extra', 'desc')->where('estatus', 'Aprobada') ->count();

  $total=$compensaciones+$permisos+$horasextra;

  return $total;
}

function incidencias_pendientes($company_id,$startOfMonth, $endOfMonth){
  $compensaciones = Gratificaciones::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_gratificacion', 'desc') ->where('estatus', 'Pendiente')->count();
  $permisos = Permisos::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_permiso', 'desc')->where('estatus', 'Pendiente') ->count();
  $horasextra = HorasExtra::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_hora_extra', 'desc')->where('estatus', 'Pendiente') ->count();
  $incapacidades = Incapacidad::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('apartir', 'desc')->where('estatus', 'Pendiente') ->count();
  $vacaciones = Vacaciones::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('desde', 'desc')->where('estatus', 'Pendiente') ->count();
  $total=$compensaciones+$permisos+$horasextra+$incapacidades+$vacaciones;

  return $total;
}

function incidencias_rechazadas($company_id,$startOfMonth, $endOfMonth){
  $compensaciones = Gratificaciones::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_gratificacion', 'desc') ->where('estatus', 'Rechazada')->count();
  $permisos = Permisos::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_permiso', 'desc')->where('estatus', 'Rechazada') ->count();
  $horasextra = HorasExtra::where('company_id',$company_id)->whereBetween('created_at', [$startOfMonth, $endOfMonth]) ->orderBy('fecha_hora_extra', 'desc')->where('estatus', 'Rechazada') ->count();

  $total=$compensaciones+$permisos+$horasextra;

  return $total;
}


function horamenos($hora){
  $horaOriginal = $hora; // Obtener la hora original
    $horaModificada = ''; // Inicializar variable para la hora modificada

    if ($horaOriginal) {
        try {
            // Crear un objeto DateTime a partir de la hora original
            $horaDateTime = new DateTime($horaOriginal);

            // Restar una hora usando DateInterval
            $horaDateTime->sub(new DateInterval('PT1H'));

            // Formatear la hora modificada
            $horaModificada = $horaDateTime->format('H:i');
        } catch (Exception $e) {
            // Manejar posibles excepciones
            $horaModificada = 'Error en la hora';
        }
    }

    return $horaModificada;
}


function generarNombreUsuario($nombre, $apellidoPaterno, $apellidoMaterno) {
    // Tomar la primera letra del nombre y convertirla a minúsculas
    $inicialNombre = strtolower(substr($nombre, 0, 1));

    // Convertir el apellido paterno a minúsculas
    $apellidoPaterno = strtolower($apellidoPaterno);

    // Convertir el apellido materno a minúsculas
    $apellidoMaterno = strtolower($apellidoMaterno);

    // Generar el nombre de usuario sin duplicidades
    $nombreUsuario = $inicialNombre . $apellidoPaterno . substr($apellidoMaterno, 0, 1);

    // Verificar si el nombre de usuario ya existe
    $existingUserCount = User::where('email', $nombreUsuario . '@gonie.com')->count();

    // Si ya existe, agregar la segunda letra del apellido materno para evitar duplicidades
    if ($existingUserCount > 0) {
        $nombreUsuario .= substr($apellidoMaterno, 1, 1);
    }

    // Verificar nuevamente si el nombre de usuario ya existe
    $existingUserCount = User::where('email', $nombreUsuario . '@gonie.com')->count();

    // Si aún así existe, agregar la siguiente letra del apellido materno
    if ($existingUserCount > 0) {
        $nextLetterIndex = strlen($nombreUsuario) - strlen($apellidoMaterno) + 1;
        $nombreUsuario .= substr($apellidoMaterno, $nextLetterIndex, 1);
    }

    return $nombreUsuario;
}

function colab_x_cc($id){

  $count=ColaboradoresCC::where('id_catalogo_centro_de_costos_id',$id)->count();
  return $count;
}

function puestos_x_cc($id){

  $count=PuestosCC::where('id_catalogo_centro_de_costos_id',$id)->count();
  return $count;
}

function colab_x_puesto($id){

  $count=PuestosColaboradores::where('id_catalogo_puesto_id',$id)->count();
  return $count;
}

function namedepa($id){

  $depa=Departamentos::where('numerodepartamento',$id)->first();
  return $depa->departamento;
}

function namedepaid($id){

  $depa=Departamentos::where('numerodepartamento',$id)->first();
  return $depa->iddepartamento;
}

function buscarproceso($id){

  $proceso=ProcesoRH::where('candidato_id',$id)->first();

  $vacante=Vacantes::where('id',$proceso->vacante_id)->first();

  return npuesto($vacante->puesto_id);
}

function buscarprocesolink($id){

  $proceso=ProcesoRH::where('candidato_id',$id)->first();

  $vacante=Vacantes::where('id',$proceso->vacante_id)->first();

  return $vacante->id;
}

function emailnomina(){

  $email=User::where('rol','Nómina')->first();

  return $email->email;
}

function emailreclutamiento(){

  $email=User::where('rol','Reclutamiento')->first();

  return $email->email;
}

function emailauditoria(){

  $email=User::where('rol','Auditoria')->first();

  return $email->email;
}


function docs($tipo , $idColab){

  $info=DocumentosColaborador::where('colaborador_id',$idColab)->where('tipo',$tipo)->first();

  return $info->ruta ?? '';

}


function tipoderegistropatronal($id,$company_id){

    $info=RegistroPatronal::where('cidregistropatronal',$id)->where('company_id',$company_id)->first();

    return $info->registro_patronal ?? '';

}


function qbanco($clave){

  $banco=Bancos::where('clave',$clave)->first();

  return $banco->banco ?? '';
}

function calcularAniosTranscurridos($fecha = null) {
    // Si la fecha es nula, establece la fecha actual como valor predeterminado
    if ($fecha === null) {
        $fecha = date('Y-m-d H:i:s'); // Cambiar al formato deseado si es necesario
    }

    // Convierte la fecha en un timestamp
    $timestamp = strtotime($fecha);

    // Si la conversión falla, devuelve 0
    if ($timestamp === false) {
        return 0;
    }

    // Calcula la diferencia en segundos entre la fecha dada y la fecha actual
    $diferencia = time() - $timestamp;

    // Si la diferencia es menor a un año, calcula los meses
    if ($diferencia < 365 * 24 * 60 * 60) {
        $mesesTranscurridos = floor($diferencia / (30 * 24 * 60 * 60)); // Asumiendo un promedio de 30 días por mes
        if ($mesesTranscurridos === 1) {
            return "1 mes";
        } else {
            return "$mesesTranscurridos meses";
        }
    } else {
        // Si la diferencia es un año o más, calcula los años
        $aniosTranscurridos = floor($diferencia / (365 * 24 * 60 * 60));
        if ($aniosTranscurridos === 1) {
            return "1 año";
        } else {
            return "$aniosTranscurridos años";
        }
    }
}



function anios_laborados($fecha = null) {
    // Si la fecha es nula, establece la fecha actual como valor predeterminado
    if ($fecha === null) {
        $fecha = date('Y-m-d H:i:s'); // Cambiar al formato deseado si es necesario
    }

    // Convierte la fecha en un timestamp
    $timestamp = strtotime($fecha);

    // Si la conversión falla, devuelve 0
    if ($timestamp === false) {
        return 0;
    }

    // Calcula la diferencia en segundos entre la fecha dada y la fecha actual
    $diferencia = time() - $timestamp;

    // Si la diferencia es menor a un año, calcula los meses
    if ($diferencia < 365 * 24 * 60 * 60) {
        $mesesTranscurridos = floor($diferencia / (30 * 24 * 60 * 60)); // Asumiendo un promedio de 30 días por mes
        if ($mesesTranscurridos === 1) {
            return "1";
        } else {
            return "1";
        }
    } else {
        // Si la diferencia es un año o más, calcula los años
        $aniosTranscurridos = floor($diferencia / (365 * 24 * 60 * 60));
        if ($aniosTranscurridos === 1) {
            return "1";
        } else {
            return "$aniosTranscurridos";
        }
    }
}




function progresoColab($id){

$colaboradorId = $id;
$tabla = 'colaboradores'; // Reemplaza con el nombre real de tu tabla

// Obtener la lista de columnas de la tabla
$columnas = Schema::getColumnListing($tabla);

// Crear una expresión SQL dinámica para contar campos en blanco
$expresionSQL = '';
foreach ($columnas as $columna) {
    $expresionSQL .= "CASE WHEN $columna IS NULL OR $columna = '' THEN 1 ELSE 0 END + ";
}

$expresionSQL = rtrim($expresionSQL, '+ '); // Eliminar el último operador +

// Ejecutar la consulta para contar campos en blanco
$camposEnBlanco = DB::table($tabla)
    ->where('id', $colaboradorId)
    ->select(DB::raw($expresionSQL . ' AS campos_en_blanco'))
    ->first();

$cantidadCamposEnBlanco = $camposEnBlanco->campos_en_blanco;

$columnas = Schema::getColumnListing($tabla);

// Obtener el número total de campos
$numeroTotalCampos = count($columnas);

return number_format(((($cantidadCamposEnBlanco*100)/$numeroTotalCampos)-100)*(-1),0) ?? '0';
}



function npuesto($id){
  $puesto=PerfilPuestos::where('idpuesto',$id)->first();

  return $puesto->puesto ?? '';
}


function buscarPuesto($id,$comp){
  $puesto=PerfilPuestos::where('idpuesto',$id)->where('company_id',$comp)->first();

  return $puesto->puesto ?? '';
}



function buscarperfildePuesto($id){

    $puesto=CatalogoPuestos::where('id',$id)->first();
    return $puesto->perfil ?? '';
}

function buscartipodePuesto($id){

    $puesto=CatalogoPuestos::where('id',$id)->first();
    return $puesto->tipo ?? '';
}

function fotoperfil($id){


  $colaborador=Colaboradores::where('id',$id)->first();

  return $colaborador->fotografia ?? auth()->user()->profilePicture();
}

function calcularPrimaDeAntiguedad($aniosServicio, $salarioDiarioPromedio) {
    // La prima de antigüedad inicial es de 30 días por cada año de servicio completo
    $prima = $aniosServicio * 12;

    // Se verifica si hay años adicionales para calcular
    if ($aniosServicio > 15) {
        $aniosAdicionales = $aniosServicio - 15;
        // Se agrega 12 días por cada año completo adicional
        $prima += $aniosAdicionales * 12;
    }

    // Se aplica el salario diario promedio
    $primaTotal = $prima * $salarioDiarioPromedio;

    // Se verifica el tope máximo de 90 días de salario
    if ($primaTotal > 90 * $salarioDiarioPromedio) {
        $primaTotal = 90 * $salarioDiarioPromedio;
    }

    return $primaTotal;
}

function calcularPrimaTotal($aniosServicio, $salarioDiarioPromedio) {
    // La prima de antigüedad inicial es de 30 días por cada año de servicio completo
    $prima = $aniosServicio * 30;

    // Se verifica si hay años adicionales para calcular
    if ($aniosServicio > 15) {
        $aniosAdicionales = $aniosServicio - 15;
        // Se agrega 12 días por cada año completo adicional
        $prima += $aniosAdicionales * 12;
    }

    // Se aplica el salario diario promedio
    $primaTotal = $prima * $salarioDiarioPromedio;



    return $primaTotal;
}

function buscarsiesbaja($id){

$bajas=Bajas::where('colaborador_id',$id)->first();

  if($bajas){
    return "proximabaja ";
  }else {
    return "";
  }
}

function calcularAniosDesdeDias($dias) {
    $diasEnAnioPromedio = 365.25; // Promedio de días en un año, considerando años bisiestos

    // Calcula la cantidad de años equivalentes
    $anios = floor($dias / $diasEnAnioPromedio);

    return $anios;
}

function calcularDiasDeVacaciones($aniosTrabajados) {
    $diasDeVacaciones = 6; // Días de vacaciones para el primer año

    // Sumar un día adicional por cada año adicional de trabajo
    $diasDeVacaciones += min($aniosTrabajados - 1, 5);

    return $diasDeVacaciones;
}


function buscarDirector($id,$or){

  $direccion=DireccionOrganigrama::where('id','1')->first();

  if($or=='horizontal'){
    $director=OrganigramaLinealNiveles::where('cc', $direccion->horizontal)->where('nivel', '1')->first();
    if($director){ return qcolab($director->colaborador_id); } else { return ""; }
  }

  if($or=='vertical'){
    $director=OrganigramaLinealNiveles::where('cc', $direccion->vertical)->where('nivel', '1')->first();
    if($director){ return qcolab($director->colaborador_id); } else { return ""; }
  }




}


function avancecolab($id){

    $colaborador = Colaboradores::where('id', $id)->first();

    $camposEnBlanco = [];

    foreach ((array)$colaborador as $columna => $valor) {
        if ($valor === null || $valor === '') {
            $camposEnBlanco[] = $columna;
        }
    }

    $numeroDeCamposEnBlanco = count($camposEnBlanco);

    // Ahora puedes acceder a los campos en blanco y el número total de campos en blanco
    return $numeroDeCamposEnBlanco;

}


function nombrecc($id){
  $cc=CatalogoCentrosdeCostos::where('id',$id)->first();

  return $cc->centro_de_costo;
}


function colades_nombre($idempleado){
  $colab=Colaboradores::where('id',$idempleado)->first();

  return $colab->nombre;
}

function colades_apaterno($idempleado){
  $colab=Colaboradores::where('id',$idempleado)->first();

  return $colab->apellido_paterno;
}

function colades_amaterno($idempleado){
  $colab=Colaboradores::where('id',$idempleado)->first();

  return $colab->apellido_materno;
}

function cuantos_cc($id){

  $cuantos=CentrodeCostos::where('company_id',$id)->count();

  return $cuantos;
}

function colabs_cc($id){

  $cuantos=Colaboradores::where('company_id',$id)->where('estatus','activo')->count();

  return $cuantos;
}



function cantColaboradoresCC($centrocostos){
  $cuantos=Colaboradores::where('organigrama',$centrocostos)->where('estatus','activo')->count();

  return $cuantos;
}

function cantColaboradoresUb($ubicacion){
  $cuantos=Colaboradores::where('ubicaciones',$ubicacion)->where('estatus','activo')->count();

  return $cuantos;
}

function cantColaboradoresDepto($departamento_id){
  $cuantos=Colaboradores::where('departamento_id',$departamento_id)->where('estatus','activo')->count();

  return $cuantos;
}



function cantPuestossDepto($departamento_id){
  $cuantos=PerfilPuestos::where('departamento_id',$departamento_id)->where('estatus','activo')->count();

  return $cuantos;
}

function externosp($area){

  $suma=Externos::where('area',$area)->sum('presupuesto');

    return $suma;
}

function total_salario($area){
  $suma=Colaboradores::where('estatus' , 'activo')->where('organigrama',$area)->sum('salario_diario');

  $suma=($suma*30)*1;

  return '$'.number_format($suma,2);
}

function total_salario_puesto($area, $puesto){
  $suma=Colaboradores::where('estatus' , 'activo')->where('organigrama',$area)->where('puesto',$puesto)->sum('salario_diario');

  $suma=($suma*30);

  return '$'.number_format($suma,2);
}


function tipodemetododepago($id){

   $tipo=CatalogosdeTiposdeMetododePago::where('id' , $id)->first();

   return $tipo->tipo ?? '' ;
}


function tipodeprestacion($id){

   $tipo=CatalogosdeTiposdePrestacion::where('id' , $id)->first();

   return $tipo->tipo ?? '' ;
}

function tipodezonadesalario($id){

   $tipo=CatalogosdeTiposdeZonadeSalario::where('nomipaq' , $id)->first();

   return $tipo->tipo ?? '' ;
}


function tipodecontrato($id){

    $tipo=CatalogosdeTiposdeContratos::where('nomipaq' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function tipoderegimen($id){

    $tipo=CatalogosdeTiposdeRegimen::where('nomipaq' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function tipodebasedepago($id){

    $tipo=CatalogosdeTiposdeBasedePago::where('nomipaq' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function tipodeperiodo($id){

    $tipo=CatalogosdeTiposdePeriodo::where('id' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function tipodebasedecotizacion($id){

    $tipo=CatalogosdeTiposdeBasedeCotizacion::where('nomipaq' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function turnodetrabajo($id){

    $tipo=CatalogosdeTiposdeTurnodeTrabajo::where('id' , $id)->first();

    return $tipo->tipo ?? '' ;

}

function jornada($id){

    $tipo=CatalogosdeTiposdeJornada::where('nomipaq' , $id)->first();

    return $tipo->tipo ?? '' ;

}


function registropatronal($id){

    $tipo=RegistroPatronal::where('id' , $id)->first();

    return $tipo->registro_patronal;

}



      function notify()
      {
         $options = [
             'cluster' => env('PUSHER_APP_CLUSTER'),
             'useTLS' => true,
         ];

         $pusher = new Pusher(
             env('PUSHER_APP_KEY'),
             env('PUSHER_APP_SECRET'),
             env('PUSHER_APP_ID'),
             $options
         );

         $data = ['message' => '¡Esta es una notificación push de ejemplo!'];

         $pusher->trigger('my-channel', 'my-event', $data);
     }


function vacantesorganigrama($agrupador_id){

    $departamentos=AgrupadoresLista::where('agrupador_id' , $agrupador_id)->pluck('departamento_id');

}

function formatFecha($fecha){
  $fechaOriginal = $fecha;

  //  $fechaFormateada = Carbon::createFromFormat('M d Y h:i:s A', $fechaOriginal)->format('M d Y');

    echo $fecha;
}


function calcularDiferenciaEnDias($fecha)
{
    // Crear objetos DateTime para la fecha dada y la fecha actual
  /*  $fechaDada = DateTime::createFromFormat('M d Y h:i:s A', $fecha);
    $fechaActual = new DateTime();

    // Calcular la diferencia en días
    $diferencia = $fechaActual->diff($fechaDada);
    $diferenciaDias = $diferencia->days;
*/
    return $fecha;
}


function estatusVacante($id){
  $vacante = VacantesGeneradas::where('id_vacante',$id)->first();

  if ($vacante != null) {
    return $vacante->estatus;
  }else {
    return "Pendiente";
  }
}

function qpuetso($id){
  $puesto = PerfilPuestos::where('idpuesto',$id)->first();

  return $puesto->puesto;
}


function puestoVacante($id){
  $vacante = Vacantes::where('id',$id)->first();

  return $vacante->puesto_id;
}

function fechaVacanteCompleada($id){
  $vacante = VacantesGeneradas::where('id_vacante',$id)->first();

  if ($vacante != null) {
    return formatFecha($vacante->fecha);
  }else {
    return "";
  }
}

function calcularDiferenciaEnAnios($fecha)
{
  $fechaActual = Carbon::now();
  $fechaDada = Carbon::parse($fecha);

  $diferencia = $fechaDada->diff($fechaActual);

  $anios = $diferencia->y;
  $meses = $diferencia->m;

  $textoDiferencia = '';

  if ($anios > 0) {
      $textoDiferencia .= $anios . ' año' . ($anios > 1 ? 's' : '');
  }

  if ($meses > 0) {
      if ($textoDiferencia !== '') {
          $textoDiferencia .= ' y ';
      }

      $textoDiferencia .= $meses . ' mes' . ($meses > 1 ? 'es' : '');
  }

  return $textoDiferencia;
}


function depa($id , $company_id)
{
    if($id==0 || $id=='' || $id==null){
        return '';
    }else{
        $depa = Departamentos::where('company_id',$company_id)->where('iddepartamento',$id)->first();
        return $depa->departamento;
    }


}

function depas($id)
{
    if($id==0 || $id=='' || $id==null){
        return '';
    }else{
        $depa = Departamentos::where('id',$id)->first();
        return $depa->departamento ?? '';
    }


}

function depas2($id , $company_id)
{
    if($id==0 || $id=='' || $id==null){
        return 'NINGUNO';
    }else{
        $depa = Departamentos::where('iddepartamento',$id)->where('company_id',$company_id)->first();
        return $depa->departamento ?? '';
    }


}

function calcularAntiguedad($fechaInicio) {
    $fechaActual = new DateTime();
    $fechaInicio = new DateTime($fechaInicio);
    $diferencia = $fechaInicio->diff($fechaActual);

    $anios = $diferencia->y;
    $meses = $diferencia->m;
    $dias = $diferencia->d;

    return "$anios años, $meses meses y $dias días";
}

function antiguedad_anio($fechaInicio) {
  $fechaActual = new DateTime();
  $fechaInicio = new DateTime($fechaInicio);
  $diferencia = $fechaInicio->diff($fechaActual);

  $anios = $diferencia->y;
  $meses = $diferencia->m;
  $dias = $diferencia->d;

  return $anios;
}

function calcularDiasTranscurridos($fecha) {
    // Convertir la fecha proporcionada en un objeto DateTime


    return $fecha;
}



function puestos($id)
{
    if($id==0 || $id=='' || $id==null){
        return '';
    }else{
        $puesto = PerfilPuestos::where('id',$id)->first();
        if ($puesto) {
          return $puesto->puesto;
        }else {
          return "nulo";
        }

    }


}

function puestos2($id)
{
    if($id==0 || $id=='' || $id==null){
        return '';
    }else{
        $puesto = PerfilPuestos::where('idpuesto',$id)->first();
        if ($puesto) {
          return $puesto->puesto;
        }else {
          return "nulo";
        }

    }


}

function puestosid($id , $company_id)
{
    if($id==0 || $id=='' || $id==null){
        return '';
    }else{
        $puesto = PerfilPuestos::where('idpuesto',$id)->where('company_id',$company_id)->first();
        if ($puesto) {
          return $puesto->puesto;
        }else {
          return "nulo";
        }

    }


}
function calcularAntiguedadTabla($fechaAlta)
{
    $fechaAlta = \Carbon\Carbon::parse($fechaAlta);
    $hoy = \Carbon\Carbon::now();
    $antiguedad = $fechaAlta->diffInYears($hoy);

    return $antiguedad;
}

function diasvacaciones($ant,$anio)
{
  if ($anio>2023) {
    $anio='2023';
  }

  $ant=$ant+1;

  if ($ant>35) {
    $ant=35;
  }
  $diasvac=DiasVacaciones::where('anio',$anio)->where('anio_laborado',$ant)->first();

  return $diasvac->dias_vacaciones ?? '0';

}

function nombrepuestoreal($id)
{
    $infocolab=Colaboradores::where('id',$id)->first();
    if ($infocolab) {
      $infopuesto=PerfilPuestos::where('idpuesto',$infocolab->puesto)->where('company_id',$infocolab->company_id)->first();
      return $infopuesto->puesto;
    }else {
      return "";
    }

}

function puestosidvav($id , $company_id){

  $puesto = PerfilPuestos::where('idpuesto',$id)->where('company_id',$company_id)->first();
  if ($puesto) {
    return $puesto->puesto;
  }else {
    return "nulo";
  }

}

function presupuestodepa($id,$company_id){
  $depa = Departamentos::where('company_id',$company_id)->where('iddepartamento',$id)->first();
  return $depa->presupuesto;
}


function empresa($id)
{
    $count= Companies::where('id',$id)->count();
    if ($count>0) {
      $comp = Companies::where('id',$id)->first();

      return $comp->razon_social;
    }else {
      return "Todas";
    }
}

function empresars($id)
{
    $count= Companies::where('id',$id)->count();
    if ($count>0) {
      $comp = Companies::where('id',$id)->first();

      return $comp->razon_social;
    }else {
      return "Todas";
    }
}

function perfiles($email)
{
    $perfil= User::where('email',$email)->first();

    return $perfil->perfil;
}

function nombreSolicitud($id)
{
    $comp = TiposdeSolicitudes::where('id',$id)->first();
    return $comp->nombre;
}

function puesto($id , $company_id)
{
    $comp = PerfilPuestos::where('company_id',$company_id)->where('idpuesto',$id)->first();

    if ($comp) {
      return $comp->puesto;
    }else {
      return "";
    }

}

function depapuesto($idpuesto , $company_id){
  $cont = Colaboradores::where('company_id',$company_id)->where('puesto',$idpuesto)->count();

    if ($cont>0) {
      $comp = Colaboradores::where('company_id',$company_id)->where('puesto',$idpuesto)->first();

      return $comp->departamento_id;
    }else{
      return '0';
    }

}

function nombreColaborador($id)
{
    if($id!=0){
      $comp = Colaboradores::where('id',$id)->first();
      return $comp->nombre.' '.$comp->apellido_paterno.' '.$comp->apellido_materno;
    }else {
      return "";
    }

}

function nombreUsuario($id)
{
    $comp = User::where('id',$id)->first();
    return $comp->name;
}

function buscarcv($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->curriculum;
}

function buscarburo($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->referencia_nombre1;
}

function  buscarresultados($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->examen;
}

function buscarexamen($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->fotoexamen;
}

function buscarcarta($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->referencia_nombre2;
}

function buscarcarta2($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->referencia_telefono2;
}

function buscarestatus($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_entrevista;
}

function buscarperfil($id){
    $perfil = PerfilPuestos::where('id',$id)->first();
    return $perfil->perfil ?? '';

}

function buscarfechas1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->entrevista1_fecha;
}

function buscardesde1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->entrevista1_desde;
}

function buscarhasta1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->entrevista1_hasta;
}

function buscarcomentarios($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentarios;
}


function fechajefatura($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->fecha_jefatura;
}

function fechanomina($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->fecha_nomina;
}

function rechazadopor($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->rechazado_por;
}




function buscarFechaPropuesta($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    $vacinfo=Vacantes::where('id',$vacante)->first();

    if ($rh->entrevista1_fecha=='') {
      return 'En espera de que '.qcolab($vacinfo->jefe).' asigne las fechas para la entrevista.';
    }else {
      return 'Fechas asignadas';
    }

}


function jefedirecto($colaborador_id,$company_id){

  $organigrama=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->where('company_id',$company_id)->first();


  if ($organigrama) {
    if ($organigrama->jefe_directo_id=='0') {
      return 'No tiene Jefe Directo';
    }else {
      return $organigrama->jefe_directo_id;
    }
  }else {
    return 'No tiene Jefe Directo';
  }

}


function jefatura($colaborador_id,$company_id){

  $organigrama=OrganigramaLinealNiveles::where('colaborador_id',$colaborador_id)->where('company_id',$company_id)->first();
  $masinfo=OrganigramaLinealNiveles::where('organigrama_id',organigrama->organigrama_id)->where('nivel','1')->first();

  if ($masinfo) {
    if ($masinfo->jefe_directo_id=='0') {
      return 'No tiene Jefe Directo';
    }else {
      return $masinfo->jefe_directo_id;
    }
  }else {
    return 'No tiene Jefe Directo';
  }

}

function buscarFechaProgramada($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();
    if ($rh->entrevista2_fecha) {
      return "Fechas programadas";
    }else {
      return 'En espera de que Reclutamiento programe fecha para entrevista';
    }

}

function buscarFechaEntrevista($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();
    if ($rh->entrevista2_fecha) {
      return $rh->entrevista2_fecha.' '.$rh->entrevista2_hora;
    }else {
      return 'En espera de que Reclutamiento programe fecha para entrevista';
    }

}


function buscardocumento1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->documento1;
}

function buscardocumento2($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->documento2;
}

function buscardocumento3($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->documento3;
}

function buscardocumento4($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->documento4;
}

function buscardocumento5($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->documento5;
}


function estatusDocumento1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_documento1;
}

function estatusDocumento2($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_documento2;
}

function estatusDocumento3($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_documento3;
}

function estatusDocumento4($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_documento4;
}

function estatusDocumento5($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->estatus_documento5;
}


function comentarioDocumento1($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentariodoc1;
}

function comentarioDocumento2($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentariodoc2;
}

function comentarioDocumento3($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentariodoc3;
}

function comentarioDocumento4($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentariodoc4;
}

function comentarioDocumento5($candidato , $vacante){
    $rh = ProcesoRH::where('candidato_id',$candidato)->where('vacante_id',$vacante)->first();

    return $rh->comentariodoc5;
}



function calcularEdadPorRFC($rfc) {


    $anioNacimiento = substr($rfc, 4, 2);
    $mesNacimiento = substr($rfc, 6, 2);
    $diaNacimiento = substr($rfc, 8, 2);

    $fechaNacimiento = "$anioNacimiento-$mesNacimiento-$diaNacimiento";
    $fechaActual = new DateTime();
    $fechaNac = new DateTime($fechaNacimiento);
    $diferencia = $fechaNac->diff($fechaActual);

    return $diferencia->y; // Devuelve la edad en años
}

function edad($fecha_nacimiento)
{
    $nacimiento = new DateTime($fecha_nacimiento);
    $ahora = new DateTime(date("Y-m-d"));
    $diferencia = $ahora->diff($nacimiento);
    return $diferencia->format("%y");
}

function cantColaboradores($id)
{
    $cant = Colaboradores::where('company_id',$id)->where('estatus','activo')->count();
    return $cant ;
}

function cantColaboradoresxDepartamento($company_id , $departamento_id)
{
    $cant = Colaboradores::where('company_id',$company_id)
        ->where('departamento_id',$departamento_id)
        ->where('estatus', 'activo')
        ->count();
    return $cant ;
}

function cantColaboradoresxPuesto($company_id , $puesto_id)
{
    $cant = Colaboradores::where('company_id',$company_id)
        ->where('puesto',$puesto_id)
        ->where('estatus', 'activo')
        ->count();
    return $cant ;
}

function cantColaboradoresPuesto($id)
{
    $cant = Colaboradores::where('puesto',$id)
        ->where('estatus', 'activo')
        ->count();
    return $cant ;
}

function cantColaboradoresxTurno($company_id , $turno_id)
{
    $cant = Colaboradores::where('company_id',$company_id)
        ->where('turno_de_trabajo_id',$turno_id)
        ->where('estatus', 'activo')
        ->count();
    return $cant ;
}

function cantColaboradoresxRegistro($company_id , $registro_patronal_id)
{
    $cant = Colaboradores::where('company_id',$company_id)
        ->where('registro_patronal_id',$registro_patronal_id)
        ->where('estatus', 'activo')
        ->count();
    return $cant ;
}



function cantDepartamentos($id)
{
    $cant = Departamentos::where('company_id',$id)->where('estatus','activo')->count();
    return $cant ;
}

function cantPuestos($id)
{
    $cant = PerfilPuestos::where('company_id',$id)->where('estatus','activo')->count();
    return $cant;
}


function nominaDepartamento($company_id , $departamento_id)
{
    $sum = Colaboradores::where('company_id',$company_id)
        ->where('departamento_id',$departamento_id)
        ->where('estatus', 'activo')
        ->sum('salario_diario');
    return $sum*30;
}


function nominaPerfil($company_id , $puesto_id)
{
    $sum = Colaboradores::where('company_id',$company_id)
        ->where('puesto',$puesto_id)
        ->where('estatus', 'activo')
        ->sum('salario_diario');
    return $sum*30;
}

function nominaTurno($company_id , $turno_id)
{
    $sum = Colaboradores::where('company_id',$company_id)
        ->where('turno_de_trabajo_id',$turno_id)
        ->where('estatus', 'activo')
        ->sum('salario_diario');
    return $sum*30;
}

function reclutamiento($id)
{
    $tipo = TiposdeReclutamiento::where('id',$id)->first();
    return $tipo->tipo ?? '' ;
}

function candidato($id)
{
    $candidato = Candidatos::where('id',$id)->first();
    $nombre=$candidato->nombre ?? '';
    $apellido_paterno=$candidato->apellido_paterno ?? '';
    $apellido_materno=$candidato->apellido_materno ?? '';
    return $nombre.' '.$apellido_paterno.' '.$apellido_materno;
}

function candidatoiniciales($id)
{
    $candidato = Candidatos::where('id',$id)->first();
    return $candidato->nombre.' '.$candidato->apellido_paterno[0].''.$candidato->apellido_materno[0];
}

function cuantoscandidatos($vacante_id)
{
    $cuantos = Procesos::where('vacante_id',$vacante_id)->count();
    return $cuantos;
}

function qorganigrama($id){

  $qorganigrama = OrganigramaLineal::where('id',$id)->first();

  return $qorganigrama->area;

}



function buscarPuestoCat($id){

  $puestoinfo=PuestosColaboradores::where('id_colaborador',$id)->first();

  $puestodata=CatalogoPuestos::where('id',$puestoinfo->id_catalogo_puesto_id)->first();
  return $puestodata->puesto ?? '';
}

function buscarDeptoCat($id){

  $deptoinfo=DepartamentosColaboradores::where('colaborador_id',$id)->first();

  $deptodata=CatalogoDepartamentos::where('id',$deptoinfo->id_catalogo_departamento_id)->first();
  return $deptodata->departamento ?? '';
}

function buscarPuestoCatid($id){

  $puestoinfo=PuestosColaboradores::where('id_colaborador',$id)->first();

  $puestodata=CatalogoPuestos::where('id',$puestoinfo->id_catalogo_puesto_id)->first();
  return $puestoinfo->id_catalogo_puesto_id ?? '';
}

function catalogopuesto($id){
  if ($id=='0') {
    return '';
  }else {
    $puesto = CatalogoPuestos::where('id',$id)->first();
    return $puesto->puesto ?? $id;
  }
}

function catpuesto($id){
  if ($id=='0') {
    return '';
  }else {
    $puesto = CatalogoPuestos::where('id',$id)->first();
    return $puesto->puesto ?? $id;
  }
}

function catalogopuestodepa($id){
  $puesto = PuestosDepartamentos::where('id_catalogo_puesto_id',$id)->first();

  $depa = CatalogoDepartamentos::where('id',$puesto->id_catalogo_departamento_id)->first();

  return $depa->departamento ?? $id;
}

function catalogopuestodepaid($id){
  $puesto = PuestosDepartamentos::where('id_catalogo_puesto_id',$id)->first();

  $depa = CatalogoDepartamentos::where('id',$puesto->id_catalogo_departamento_id)->first();

  return $depa->id ?? $id;
}

function nombre_depa($id){
  $depa = CatalogoDepartamentos::where('id',$id)->first();

  return $depa->departamento ?? '';
}


function nombre_puesto($id){

  $puesto = CatalogoPuestos::where('id',$id)->first();
  return $puesto->puesto ?? 'no se econtró el puesto';
}

function ipuestocolab($id){

  if ($id=='0') {
    return '';
  }else {
    $info=PuestosColaboradores::where('id_colaborador',$id)->first();
    return $info->id_catalogo_puesto_id ?? '';
  }

}

function qcolabv($id)
{
    if ($id === 0) {
        return 'Vacante';
    } elseif ($id === 'Vacio') {
        return '';
    } else {
        $colaborador = Colaboradores::where('id', $id)->first();
        if ($colaborador) {
            return $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno;
        } else {
            return 'Colaborador no encontrado';
        }
    }
}


function qcolab($id)
{
    if ($id === 0) {
        return 'Vacante';
    } elseif ($id === 'Vacio') {
        return '';
    } else {
        $colaborador = Colaboradores::where('id', $id)->first();
        if ($colaborador) {
            return $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno;
        } else {
            return 'Colaborador no encontrado';
        }
    }
}

function nombre_empresa($id){
  $company=Companies::where('id',$id)->first();

  return $company->razon_social ?? '';
}

function qpuesto($id)
{
    $colaborador = Colaboradores::where('id',$id)->first();

    if ($colaborador) {
      return $colaborador->puesto;
    }else {
      return '';
    }

}

function mailcolab($id){
  $user = User::where('colaborador_id',$id)->first();

  return $user->email;
}

function entrevistador($vacante_id , $reclutamiento_id)
{
    $entrevistador = Entrevistas::where('vacante_id',$vacante_id)
        ->where('reclutamiento_id',$reclutamiento_id)
        ->first();
    return $entrevistador->entrevistador;
}

function encuesta_id($vacante_id , $reclutamiento_id)
{
    $encuesta = Entrevistas::where('vacante_id',$vacante_id)
        ->where('reclutamiento_id',$reclutamiento_id)
        ->first();
    return $encuesta->encuesta_id;
}

function nombre_encuesta($vacante_id , $reclutamiento_id)
{
    $entrevista = Entrevistas::where('vacante_id',$vacante_id)
        ->where('reclutamiento_id',$reclutamiento_id)
        ->first();

    $encuestas = Encuestas::where('id',$entrevista->encuesta_id)
        ->first();
    return $encuestas->nombre;
}

function nombre_encuesta2($id)
{
    $encuestas = Encuestas::where('id',$id)
        ->first();
    return $encuestas->nombre;
}

function nombre_agrupador($id)
{
    $agrupador = Agrupadores::where('id',$id)
        ->first();
    return $agrupador->nombre;
}

function hijos(){
    $data[] = [
        'puesto' => '2',
        'imagen' => 'https://d500.epimg.net/cincodias/imagenes/2016/07/04/lifestyle/1467646262_522853_1467646344_noticia_normal.jpg',
        'nombre' => 'Mau Briseño',
        'hijos'  => '[]'
    ];

    return $data;
}

function nombre_vac($vacante_id )
{
    $vac = Vacantes::where('id',$vacante_id)
        ->first();

    return depa($vac->departamento_id).' / '.puesto($vac->puesto_id);
}

function proceso($vac_id )
{
    $proceso = Reclutamientos::where('vacante_id',$vac_id)
        ->get();
    $res="";
    foreach ($proceso as $p)
    {
        $res.=reclutamiento($p->tipo_reclutamiento)." -> ";
    }

    $res.=' Selección';

    return $res;
}

function depaactivo($iddepa){
  $res='inactivo';
  $contar=Colaboradores::where('departamento_id',$iddepa)->where('fecha_baja','1899-12-30')->count();
  if ($contar>0) {
    $res='activo';
  }

  return $res;
}


function puestoactivo($idpsto){
  $res='inactivo';
  $contar=Colaboradores::where('puesto',$idpsto)->where('fecha_baja','1899-12-30')->count();
  if ($contar>0) {
    $res='activo';
  }

  return $res;
}


function cuadroOrganigrama($o , $n , $jf){

  if ($n==1) {
    $colabs=OrganigramaLinealNiveles::where('organigrama_id',$o)
    ->where('nivel',$n)
    ->get();
  }else {
    $colabs=OrganigramaLinealNiveles::where('organigrama_id',$o)
    ->where('nivel',$n)
    ->where('jefe_directo_id',$jf)
    ->get();
  }
  $res="";
  foreach ($colabs as $as) {
    $res.='
    <div class="col text-center contenedor">
      <div class="colab-org text-center">
        <img src="https://img.freepik.com/vector-premium/icono-circulo-usuario-anonimo-ilustracion-vector-estilo-plano-sombra_520826-1931.jpg" alt="" style="height:60px;">
        <br>
        <span>'.qcolabv($as->colaborador_id).'</span>
        <br><br>
        <b>'.puesto(qpuesto( $as->colaborador_id ) , session('company_id')).'</b>
      </div>
    </div>
    ';
  }

  return $res;

}
