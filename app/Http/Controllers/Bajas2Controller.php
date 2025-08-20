<?php


namespace App\Http\Controllers;
use App\Models\PerfilPuestos;
use App\Models\Bajas;
use App\Models\Desvinculados;
use App\Models\Colaboradores;
use App\Models\TablaISR;
use App\Models\DatosBaja;
use App\Models\VacacionesPendientes;
use App\Models\OrganigramaLinealNiveles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf as PDF;



class BajasController extends Controller
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

      $bajas = Bajas::where('estatus','Pendiente')
      ->when(session('company_active_id') && session('company_active_id') != "0", function ($query) {
        return $query->where('company_id', session('company_active_id'));
    })->get();
      return view('bajas.index' , ['bajas' => $bajas]);
    }


    public function solicitar(){
      $miinfo=Colaboradores::where('id',auth()->user()->colaborador_id)->first();
      $colaboradores=OrganigramaLinealNiveles::where('jefe_directo_id',auth()->user()->colaborador_id)->get();
      return view('bajas.solicitar' , ['colaboradores' => $colaboradores]);
    }

    public function tramitar_pend(Request $request)
    {
        // Procesar los valores para remover signos de pesos, comas y formatearlos con dos decimales
        $salario_diario_normal = round(floatval(str_replace([',', '$'], '', $request->salario_diario_normal)), 2);
        $salario_diario_integral = round(floatval(str_replace([',', '$'], '', $request->salario_diario_integral)), 2);
        $salario_diario_nuevo = round(floatval(str_replace([',', '$'], '', $request->salario_diario_nuevo)), 2);

        // Usar updateOrInsert para guardar los datos en la base de datos
        DatosBaja::updateOrInsert(
            ['baja_id' => $request->id_baja], // Criterio para encontrar el registro
            [   'colaborador_id' => $request->colaborador_id,
                'fecha_baja' => $request->fecha_baja,
                'motivo_baja' => $request->motivo_baja,
                'salario_radio' => $request->salario_seleccionado,
                'salario_diario' => $salario_diario_normal,
                'salario_diario_integral' => $salario_diario_integral,
                'salario_nuevo' => $salario_diario_nuevo,
            ]
        );

        // Redirigir con éxito
        return redirect('/baja/' . $request->id_baja)->with('success', 'Operación realizada con éxito.');
    }


    public function tramitar(Request $request){

      // Función auxiliar para limpiar campos numéricos
      function cleanNumber($value) {
          // Elimina símbolos de dólar y comas
          return str_replace(['$', ','], '', $value);
      }
  
      $colaborador = Colaboradores::where('id', $request->colaborador_id)->first();
  
      $primerDiaDelAnio = Carbon::now()->firstOfYear();
      $dias = $primerDiaDelAnio->diffInDays($request->fechabajad);
      $dias = $dias + 2;
  
      $diasapagar = cleanNumber($request->diaspagaraguinaldo);
      $diasaguinaldo = ($dias * $diasapagar) / 365;
  
      $sd = cleanNumber($request->salario_diario);
      
      // Limpiamos todos los campos numéricos de deducciones
      $deducciones = cleanNumber($request->isr) 
                   + cleanNumber($request->imss) 
                   + cleanNumber($request->isr_finiquito) 
                   + cleanNumber($request->deudores);
  
      // Operaciones con salario diario limpio
      $salario_normal = cleanNumber($request->dias) * $colaborador->salario_diario;
      $aguinaldo = $diasaguinaldo * $colaborador->salario_diario;
      $vacaciones = cleanNumber($request->dias_vacaciones) * $colaborador->salario_diario;
      $prima_vacacional = $colaborador->salario_diario * (cleanNumber($request->monto_prima_vacacional) / 100);
      $incentivo = (cleanNumber($request->diasaguinaldo) * $colaborador->salario_diario) * (cleanNumber($request->monto_incentivo) / 100);
      $prima_de_antiguedad = (cleanNumber($request->monto_prima_de_antiguedad) * cleanNumber($request->salario_diario)) * cleanNumber($request->anio);
      $gratificacion = cleanNumber($request->monto_gratificacion) * cleanNumber($request->salario_diario);
      $veinte_dias = (cleanNumber($request->monto_veinte_dias) * cleanNumber($request->salario_diario)) * cleanNumber($request->anio);
      $despensa = 0; // Asumes que este valor es siempre cero o fijo
  
      $vacacionespendientes = VacacionesPendientes::where('colaborador_id', $request->colaborador_id)->first();
      $vacaciones_pendientes = $vacacionespendientes->anteriores;
  
      $percepciones = $salario_normal + $aguinaldo + $vacaciones + $prima_vacacional + $incentivo + $prima_de_antiguedad + $gratificacion + $veinte_dias + $despensa;
  
      try {
          $datosbaja = DatosBaja::updateOrCreate(
              ['baja_id' => $request->id_baja], 
              [
                  'salario_diario' => cleanNumber($request->salario_diario),
                  'colaborador_id' => $request->colaborador_id,
                  'fecha_baja' => $request->fechabajad,
                  'motivo_baja' => $request->motivo,
                  'd_salario_normal' => cleanNumber($request->dias),
                  'salario_normal' => $salario_normal,
                  'd_aguinaldo' => cleanNumber($request->diaspagaraguinaldo),
                  'd2_aguinaldo' => number_format($diasaguinaldo, 2),
                  'aguinaldo' => $aguinaldo,
                  'd_vacaciones' => cleanNumber($request->dias_vacaciones),
                  'vacaciones' => $vacaciones,
                  'd_primavacacional' => cleanNumber($request->monto_prima_vacacional),
                  'prima_vacacional' => $prima_vacacional,
                  'd_incentivo' => cleanNumber($request->monto_incentivo),
                  'incentivo' => $incentivo,
                  'd_prima_de_antiguedad' => cleanNumber($request->monto_prima_de_antiguedad),
                  'prima_de_antiguedad' => $prima_de_antiguedad,
                  'd_gratificacion' => cleanNumber($request->monto_gratificacion),
                  'gratificacion' => $gratificacion,
                  'd_veinte_dias' => cleanNumber($request->monto_veinte_dias),
                  'veinte_dias' => $veinte_dias,
                  'd_despensa' => cleanNumber($request->monto_despensa),
                  'despensa' => $despensa,
                  'isr' => cleanNumber($request->isr),
                  'imss' => cleanNumber($request->imss),
                  'deudores' => cleanNumber($request->deudores),
                  'isr_finiquito' => cleanNumber($request->isr_finiquito),
                  'percepciones' => $percepciones,
                  'deducciones' => $deducciones,
                  'total' => $percepciones - $deducciones,
                  'fecha_elaboracion' => $request->fecha_elaboracion,
                  'vacaciones_pendientes' => $vacaciones_pendientes
              ]
          );
  
          Bajas::where('id', $request->id_baja)->update([
              'fecha_baja' => $request->fechabajad,
              'motivo' => $request->motivo,
              'monto' => $percepciones - $deducciones,
          ]);
  
          return redirect('/baja/' . $request->id_baja)->with('success', 'Operación realizada con éxito.');
      } catch (\Exception $e) {
          return back()->with('error', $e->getMessage());
      }
  }
  




    public function ver($id)
    {

      $datosbaja = DatosBaja::where('baja_id',$id)->first();
      $baja = Bajas::where('id',$id)->first();
      $colaborador = Colaboradores::where('id',$baja->colaborador_id)->first();

      $fechaFormateada = str_replace(':', ':', str_replace(':AM', '', $baja->fecha_baja));
      $fechaCarbon = Carbon::parse($fechaFormateada);
      $fbaja = $fechaCarbon->format('d / m / Y');
      $fbajaJ = $fechaCarbon->format('j');

      $fechaFormateada2 = str_replace(':', ':', str_replace(':AM', '', $colaborador->fecha_alta));
      $fechaCarbon2 = Carbon::parse($fechaFormateada2);
      $falta = $fechaCarbon2->format('d / m / Y');

      // Convierte las fechas en objetos Carbon
      $fechaBaja = Carbon::createFromFormat('d / m / Y', $fbaja);
      $fechaAlta = Carbon::createFromFormat('d / m / Y', $falta);



      // Calcula la diferencia en días
      //$diasDiferencia = $fechaAlta->diffInDays($fechaBaja);

      $primerDiaDelAnio = Carbon::now()->firstOfYear();
      //$primerDiaDelAnio = Carbon::createFromDate(2024, 1, 1);
      $dias = $primerDiaDelAnio->diffInDays($fechaBaja);
      $dias=$dias+2;

      $diastodos = $fechaAlta->diffInDays($fechaBaja);

      $fechaAltaNow = $fechaAlta->setYear(Carbon::now()->year);
      $fechaAltaNow = $fechaAlta->setYear(2023);
      $diasanivhoy=$fechaAltaNow->diffInDays($fechaBaja);


      function calcularDiferenciaDias($fbajaJ) {
            // Fecha actual
            $hoy = $fbajaJ;

            // Día actual del mes
            $diaActual = $fbajaJ;

            // Día límite para la quincena
            $diaQuincena = 15;

            // Si es después del día de la quincena, restamos los días hasta el final del mes
            if ($diaActual > $diaQuincena) {
                $diferenciaDias = $diaActual - $diaQuincena;
            } else {
                $diferenciaDias = $diaActual;
            }

            return $diferenciaDias;
        }

      /*


      monto a pagar aguinaldo = 10,972.3068

      los dias trabajados 71
      por los dias que le tocan 18
      entre 365
      */

      $diasapagar=15;
      $diasaguinaldo=($dias*$diasapagar)/365;

      $aldiadehoy=calcularDiferenciaDias($fbajaJ);

      $aniostrabajados=calcularAniosDesdeDias($diastodos);

      $dias_vacaciones=calcularDiasDeVacaciones(calcularAniosDesdeDias($diastodos));

      $dias_vacaciones=($diasanivhoy*18)/365;

      
      $vacacionespendientes=VacacionesPendientes::where('colaborador_id',$colaborador->id)->first();
      $vacaciones_pendientes=$vacacionespendientes->anteriores;
      //$dias_vacaciones=3.50;
      $primaTotal=calcularPrimaTotal(calcularAniosDesdeDias($diastodos), $colaborador->salario_diario);
      $prima_de_antiguedad=calcularPrimaDeAntiguedad(calcularAniosDesdeDias($diastodos), $colaborador->salario_diario);
      //$prima_de_antiguedad=36;
      /* 207.44*2 igual o menor el salario */

    //  $prima_de_antiguedad=84;
      $monto_dias=$colaborador->salario_diario*$dias;
      $monto_aguinaldo=$colaborador->salario_diario*$diasaguinaldo;
      $monto_vacaciones=$colaborador->salario_diario*$dias_vacaciones;
      $monto_prima_vacacional=$colaborador->salario_diario*$dias_vacaciones;
      $monto_incentivo=($colaborador->salario_diario*$dias)*0.20;
      $monto_prima_de_antiguedad=$prima_de_antiguedad;
      $monto_gratificacion=90*$colaborador->salario_diario;
      $monto_veinte_dias=(calcularAniosDesdeDias($diastodos)*20)*$colaborador->salario_diario;
      $monto_prima_de_antiguedad=14935.68;
      /* DESPENSA
      QUINCENA= UMA (103.74)*15


       */


      $totalPercepciones = $monto_dias + $monto_aguinaldo + $monto_vacaciones + $monto_prima_vacacional + $monto_incentivo + $monto_prima_de_antiguedad + $monto_gratificacion + $monto_veinte_dias;

      $isr1=$monto_dias;
      $isr2=($monto_aguinaldo)-(30*103.74);
      $isr3=$monto_vacaciones;
      $isr4=$monto_prima_vacacional-(103.74*15);
      $isr5=$monto_incentivo;

      $base_gravable=$isr1+$isr2+$isr3+$isr4+$isr5;

      $anio=2024;
      $periodo='mensual';

      $limiteInferior = TablaISR::buscarLimiteInferior($base_gravable, $anio , $periodo);

      $bglimite=$base_gravable-$limiteInferior;

      $porcentaje = TablaISR::buscarPorcentaje($base_gravable, $anio , $periodo);

      $resultado = ($porcentaje / 100) * $bglimite;

      $cuota_fija= TablaISR::buscarCuotaFija($base_gravable, $anio , $periodo);

      $isr=$resultado+$cuota_fija;

      $imss=116.31;

      $isr_finiquito1=$monto_prima_de_antiguedad+$monto_gratificacion+$monto_veinte_dias;
      $isr_finiquito2=(103.74*90)*20;
      $isr_finiquito3=$isr_finiquito1-$isr_finiquito2;

      $isr_mes1=1319.57*30;
      $isr_mes2=$isr_mes1*0.2;
      $isr_mes3=$isr_mes1+$isr_mes2;
      $isr_mes4=42537.59;
      $isr_mes5=$isr_mes3-$isr_mes4;
      $isr_mes6=0.3;
      $isr_mes7=$isr_mes5*$isr_mes6;
      $isr_mes8=7980.73;
      $isr_mes9=$isr_mes7+$isr_mes8;
      $isr_mes10=$isr_mes9/$isr_mes3;
      $isr_mes11=$isr_mes10*100;

      $isr_finiquito4=$isr_mes11;

      $isr_finiquito=$isr_finiquito3*($isr_finiquito4/100);


      $imss=$datosbaja->imss ?? '0';
      $isr_finiquito=$datosbaja->isr_finiquito ?? '0';
      $deudores=$datosbaja->deudores ?? '0';
      $totalDeducciones=$isr+$imss+$isr_finiquito+$deudores;


      $total=$totalPercepciones-$totalDeducciones;



            return view('bajas.ver' ,
            [
              'baja' => $baja ,
              'colaborador' => $colaborador ,
              'falta' => $falta ,
              'fbaja' => $fbaja ,
              'dias' => $dias ,
              'diasaguinaldo' => $diasaguinaldo ,
              'diastodos' => $diastodos ,
              'dias_vacaciones' => $dias_vacaciones ,
              'prima_de_antiguedad' => $prima_de_antiguedad ,
              'primaTotal' => $primaTotal ,
              'isr' => $isr ,
              'imss' => $imss ,
              'isr_finiquito' => $isr_finiquito ,
              'totalPercepciones' => $totalPercepciones ,
              'totalDeducciones' => $totalDeducciones ,
              'total' => $totalPercepciones+$totalDeducciones ,
              'salario_diario' => $colaborador->salario_diario ,
              'salario_diario_integrado' => $colaborador->sueldointegrado ,
              'aldiadehoy' => $aldiadehoy ,
              'aniostrabajados' => $aniostrabajados,
              'vacaciones_pendientes' => $vacaciones_pendientes ,
              'diasanivhoy' => $diasanivhoy ,
              'datosbaja' => $datosbaja ,
              'diasapagar' => $diasapagar ,
              'primerDiaDelAnio' => $primerDiaDelAnio ,

            ]);
    }



    public function desvincular(Request $request){

      Bajas::where('id',$request->baja_id)->update(['estatus'=>'Desvinculado']);
      Colaboradores::where('id',$request->colaborador_id)->update(['estatus'=>'inactivo' , 'fecha_baja' => $request->fecha_baja." 00:00:00"]);
      $colabinfo=Colaboradores::where('id',$request->colaborador_id)->first();
      $datosbaja = Desvinculados::updateOrCreate(
          ['curp' => $colabinfo->curp], // Claves de búsqueda
          [
              'company_id' => $colabinfo->company_id,
              'idempleado' => $colabinfo->numero_de_empleado,
              'fecha_baja' => $request->fecha_baja." 00:00:00",
              'curp' => $colabinfo->curp,
              'causabaja' => $request->motivo,
          ]
      );
      return redirect('/bajas');
    }


    public function tramitar_new(Request $request)
{
    $colaborador = Colaboradores::where('id', $request->colaborador_id)->first();

    // Obtener datos básicos
    $primerDiaDelAnio = Carbon::now()->firstOfYear();
    $dias = $primerDiaDelAnio->diffInDays($request->fechabajad) + 2;

    // Cálculos separados
    $salario_normal = $this->calcularSalarioNormal($request->dias, $colaborador->salario_diario);
    $aguinaldo = $this->calcularAguinaldo($dias, $request->diaspagaraguinaldo, $colaborador->salario_diario);
    $vacaciones = $this->calcularVacaciones($request->dias_vacaciones, $colaborador->salario_diario);
    $prima_vacacional = $this->calcularPrimaVacacional($colaborador->salario_diario, $request->monto_prima_vacacional);
    $incentivo = $this->calcularIncentivo($request->diasaguinaldo, $colaborador->salario_diario, $request->monto_incentivo);
    $prima_de_antiguedad = $this->calcularPrimaAntiguedad($request->monto_prima_de_antiguedad, $request->salario_diario, $request->anio);
    $gratificacion = $this->calcularGratificacion($request->monto_gratificacion, $request->salario_diario);
    $veinte_dias = $this->calcularVeinteDiasPorAnio($request->monto_veinte_dias, $request->salario_diario, $request->anio);
    $despensa = $this->calcularDespensa();
    $deducciones = $this->calcularDeducciones($request->isr, $request->imss, $request->isr_finiquito, $request->deudores);

    $vacaciones_pendientes = $this->obtenerVacacionesPendientes($request->colaborador_id);

    $percepciones = $salario_normal + $aguinaldo + $vacaciones + $prima_vacacional + $incentivo + $prima_de_antiguedad + $gratificacion + $veinte_dias + $despensa;

    try {
        $datosbaja = DatosBaja::updateOrCreate(
            ['baja_id' => $request->id_baja], // Claves de búsqueda
            [
                'salario_diario' => $request->salario_diario,
                'colaborador_id' => $request->colaborador_id,
                'fecha_baja' => $request->fechabajad,
                'motivo_baja' => $request->motivo,
                'd_salario_normal' => $request->dias,
                'salario_normal' => $salario_normal,
                'd_aguinaldo' => $request->diaspagaraguinaldo,
                'd2_aguinaldo' => number_format($aguinaldo / $colaborador->salario_diario, 2),
                'aguinaldo' => $aguinaldo,
                'd_vacaciones' => $request->dias_vacaciones,
                'vacaciones' => $vacaciones,
                'd_primavacacional' => $request->monto_prima_vacacional,
                'prima_vacacional' => $prima_vacacional,
                'd_incentivo' => $request->monto_incentivo,
                'incentivo' => $incentivo,
                'd_prima_de_antiguedad' => $request->monto_prima_de_antiguedad,
                'prima_de_antiguedad' => $prima_de_antiguedad,
                'd_gratificacion' => $request->monto_gratificacion,
                'gratificacion' => $gratificacion,
                'd_veinte_dias' => $request->monto_veinte_dias,
                'veinte_dias' => $veinte_dias,
                'd_despensa' => $request->monto_despensa,
                'despensa' => $despensa,
                'isr' => str_replace(',', '', $request->isr),
                'imss' => str_replace(',', '', $request->imss),
                'deudores' => str_replace(',', '', $request->deudores),
                'isr_finiquito' => str_replace(',', '', $request->isr_finiquito),
                'percepciones' => $percepciones,
                'deducciones' => $deducciones,
                'total' => $percepciones - $deducciones,
                'fecha_elaboracion' => $request->fecha_elaboracion,
                'vacaciones_pendientes' => $vacaciones_pendientes,
            ]
        );

        Bajas::where('id', $request->id_baja)->update([
            'fecha_baja' => $request->fechabajad,
            'motivo' => $request->motivo,
            'monto' => $percepciones - $deducciones,
        ]);

        return redirect('/baja/' . $request->id_baja)->with('success', 'Operación realizada con éxito.');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}


    public function calcularSalarioNormal($dias, $salario_diario)
    {
        return $dias * $salario_diario;
    }

    public function calcularAguinaldo($dias, $dias_pagar_aguinaldo, $salario_diario)
    {
        $dias_aguinaldo = ($dias * $dias_pagar_aguinaldo) / 365;
        return $dias_aguinaldo * $salario_diario;
    }
    
    public function calcularVacaciones($dias_vacaciones, $salario_diario)
    {
        return $dias_vacaciones * $salario_diario;
    }

    public function obtenerVacacionesPendientes($colaborador_id)
    {
        $vacaciones_pendientes = VacacionesPendientes::where('colaborador_id', $colaborador_id)->first();
        return $vacaciones_pendientes ? $vacaciones_pendientes->anteriores : 0;
    }

    public function calcularIncentivo($dias_aguinaldo, $salario_diario, $monto_incentivo)
    {
        return ($dias_aguinaldo * $salario_diario) * ($monto_incentivo / 100);
    }

    public function calcularGratificacion($monto_gratificacion, $salario_diario)
    {
        return $monto_gratificacion * $salario_diario;
    }

    public function calcularVeinteDiasPorAnio($monto_veinte_dias, $salario_diario, $anio)
    {
        return ($monto_veinte_dias * $salario_diario) * $anio;
    }

    public function calcularPrimaAntiguedad($monto_prima_de_antiguedad, $salario_diario, $anio)
    {
        return ($monto_prima_de_antiguedad * $salario_diario) * $anio;
    }


    public function calcularDespensa()
    {
        // Asignas 0 porque no se realiza ningún cálculo
        return 0;
    }

    public function calcularDeducciones($isr, $imss, $isr_finiquito, $deudores)
  {
      return str_replace(',', '', $isr) + str_replace(',', '', $imss) + str_replace(',', '', $isr_finiquito) + str_replace(',', '', $deudores);
  }




public function comprobante_pago(Request $request){
    try {
        $ruta = "bajas/".$request->baja_id."/";

        if ($request->hasFile('comprobante')) {
            if (!Storage::exists($ruta)) {
                Storage::makeDirectory($ruta);
            }

            $archivo = $request->file('comprobante');
            $nombreOriginal = $archivo->getClientOriginalName();
            $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_'); // Normaliza el nombre sin acentos
            $extension = $archivo->getClientOriginalExtension(); // Obtiene la extensión original del archivo
            $nombreArchivo = $nombreSinAcentos . '.' . $extension; // Agrega la extensión al nombre normalizado

            $archivo->storeAs($ruta, $nombreArchivo, 'public');
        }

        Bajas::where('id',$request->baja_id)->update(['comprobante'=>$ruta.$nombreArchivo]);
        $bajas = Bajas::all();
        // Mensaje de éxito
        return view('bajas.index', ['bajas' => $bajas, 'mensaje' => 'El comprobante de pago se ha guardado con éxito.']);
    } catch (\Exception $e) {
        // Aquí se captura cualquier excepción que ocurra dentro del bloque try
        // Puedes optar por regresar a una vista con un mensaje de error
        // Asegúrate de tener una vista que pueda manejar este mensaje de error
        return back()->withErrors(['error' => 'Ha ocurrido un error al guardar el comprobante de pago.'])->withInput();
    }
}
}
