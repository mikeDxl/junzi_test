<?php


namespace App\Http\Controllers;
use App\Models\PerfilPuestos;
use App\Models\Bajas;
use App\Models\Desvinculados;
use App\Models\Colaboradores;
use App\Models\TablaISR;
use App\Models\DatosBaja;
use App\Models\Vacantes;
use App\Models\VacacionesPendientes;
use App\Models\OrganigramaLinealNiveles;

use App\Models\CatalogoCentrosdeCostos;
use App\Models\ColaboradoresCC;

use App\Models\DepartamentosColaboradores;

use App\Models\PuestosColaboradores;



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

      $bajas = Bajas::all();
      return view('bajas.index' , ['bajas' => $bajas]);
    }

    public function cancelarBaja(Request $request)
    {
        try {
            // Intentar eliminar el registro de la tabla bajas
            Bajas::where('id', $request->baja_id)->delete();
            DatosBaja::where('baja_id', $request->baja_id)->delete();

            // Redirigir con mensaje de éxito
            return redirect('/bajas')->with('success', 'Baja cancelada exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, redirigir con mensaje de error
            return redirect('/bajas')->with('error', 'No se pudo cancelar la baja. Inténtalo de nuevo.');
        }
    }

    public function restaurarBaja(Request $request)
    {
        try {
            DatosBaja::where('baja_id', $request->baja_id)->delete();

            // Redirigir con mensaje de éxito
            return redirect('/baja'.'/'.$request->baja_id)->with('success', 'Baja restaurada exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, redirigir con mensaje de error
            return redirect('/baja'.'/'.$request->baja_id)->with('error', 'No se pudo restaur la baja. Inténtalo de nuevo.');
        }
    }


    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'fecha_baja' => 'required|date',
            'motivo' => 'required|string',
            'generar_vacante' => 'nullable|boolean',
        ]);

        $colaborador = Colaboradores::where('id',$request->colaborador_id)->first();

        $cc = ColaboradoresCC::where('colaborador_id',$request->colaborador_id)->first();
        $departamento = DepartamentosColaboradores::where('colaborador_id',$request->colaborador_id)->first();
        $puesto = PuestosColaboradores::where('id_colaborador',$request->colaborador_id)->first();

        // Comprobar si se requiere generar una vacante
        $vacanteId = null;
        if ($request->has('generar_vacante') && $request->generar_vacante) {

            $create_v=new Vacantes();
            $create_v->area_id=$cc->id;
            $create_v->company_id=$colaborador->company_id;
            $create_v->departamento_id=$departamento->id_catalogo_departamento_id;
            $create_v->puesto_id=$puesto->id_catalogo_puesto_id;
            $create_v->fecha=date('Y-m-d');
            $create_v->area=$colaborador->organigrama;
            $create_v->jefe=$colaborador->jefe_directo;
            $create_v->estatus='pendiente';
            $create_v->prioridad='Baja';
            $create_v->codigo='codigo';
            $create_v->solicitadas="1";
            $create_v->completadas="0";
            $create_v->save();

            $vacanteId = $create_v->id;

        }

        // Crear la baja
        $baja = new Bajas();
        $baja->colaborador_id = $request->colaborador_id;
        $baja->area = $colaborador->organigrama;
        $baja->departamento_id = $departamento->id_catalogo_departamento_id;
        $baja->company_id =  $colaborador->company_id;
        $baja->puesto_id = $puesto->id_catalogo_puesto_id;
        $baja->fecha_baja = $request->fecha_baja;
        $baja->motivo = $request->motivo;
        $baja->vacante = $vacanteId; // Si se generó vacante, asignamos el ID, si no es null
        $baja->save();

        // Redirigir con mensaje de éxito
        return redirect('/bajas')->with('success', 'Baja registrada correctamente.');
    }



    public function solicitar(){
        //$colaboradores=OrganigramaLinealNiveles::where('jefe_directo_id',auth()->user()->colaborador_id)->get();
        /*
        $infojefe=ColaboradoresCC::where('colaborador_id',auth()->user()->colaborador_id)->first();
        $colaboradores_cc=ColaboradoresCC::where('id_catalogo_centro_de_costos_id',$infojefe->id_catalogo_centro_de_costos_id)->get();

        $colaboradores_ids = $colaboradores_cc->pluck('id');

        $colaboradores_en_baja = Bajas::pluck('colaborador_id');

        // Filtrar colaboradores activos que no estén en la tabla bajas
        $colaboradores = Colaboradores::whereIn('id', $colaboradores_ids)
        ->where('estatus', 'activo')
        ->whereNotIn('id', $colaboradores_en_baja)
        ->get();
        */

        $colaboradorId = auth()->user()->colaborador_id;

        // Obtener la estructura del organigrama filtrada por usuario
        $colaboradores = $this->getOrganigramaUsuario($colaboradorId);

        return view('bajas.solicitar' , ['colaboradores' => $colaboradores]);
    }

    private function getOrganigramaUsuario($colaboradorId)
    {
        $estructura = [];

        // Obtener los colaboradores que tienen como jefe directo al usuario autenticado
        $nivelesInmediatos = OrganigramaLinealNiveles::where('jefe_directo_id', $colaboradorId)->get();

        foreach ($nivelesInmediatos as $colaborador) {
            $estructura[] = $colaborador;
            $this->agregarSubnivelesUsuario($estructura, $colaborador->colaborador_id);
        }

        return $estructura;
    }

    private function agregarSubnivelesUsuario(&$estructura, $jefeDirectoId)
    {
        $subniveles = OrganigramaLinealNiveles::where('jefe_directo_id', $jefeDirectoId)->get();

        foreach ($subniveles as $sub) {
            $estructura[] = $sub;
            $this->agregarSubnivelesUsuario($estructura, $sub->colaborador_id);
        }
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

    public function obtenerLimiteInferior($baseGravable)
    {
        $anio = date('Y'); // Año actual
        $periodo = 'mensual'; // Periodo fijo como 'mensual'

        // Buscar la cuota fija en la tabla ISR
        $cuotaFija = TablaISR::where('anio', $anio)
            ->where('periodo', $periodo)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('limite_inferior');

        // Retornar la cuota fija o un valor por defecto si no se encuentra
        return response()->json([
            'limite_inferior' => $cuotaFija ?? 0,
        ]);
    }


    public function obtenerLimiteSuperior($baseGravable)
    {
        $anio = date('Y'); // Año actual
        $periodo = 'mensual'; // Periodo fijo como 'mensual'

        // Buscar la cuota fija en la tabla ISR
        $cuotaFija = TablaISR::where('anio', $anio)
            ->where('periodo', $periodo)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('limite_superior');

        // Retornar la cuota fija o un valor por defecto si no se encuentra
        return response()->json([
            'limite_superior' => $cuotaFija ?? 0,
        ]);
    }


    public function obtenerCuotaFija($baseGravable)
    {
        $anio = date('Y'); // Año actual
        $periodo = 'mensual'; // Periodo fijo como 'mensual'

        // Buscar la cuota fija en la tabla ISR
        $cuotaFija = TablaISR::where('anio', $anio)
            ->where('periodo', $periodo)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('cuota_fija');

        // Retornar la cuota fija o un valor por defecto si no se encuentra
        return response()->json([
            'cuota_fija' => $cuotaFija ?? 0,
        ]);
    }




    public function calcularPorcentaje($baseGravable)
    {
        $anio = date('Y'); // Año actual
        $periodo = 'mensual'; // Periodo fijo como 'mensual'

        // Buscar la cuota fija en la tabla ISR
        $cuotaFija = TablaISR::where('anio', $anio)
            ->where('periodo', $periodo)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('porcentaje');

        // Retornar la cuota fija o un valor por defecto si no se encuentra
        return response()->json([
            'porcentaje' => $cuotaFija ?? 0,
        ]);
    }



    public function tramitar(Request $request){

    $idcolaborador=$request->idcolaborador;
    $idbaja=$request->idbaja;
    $falta=$request->falta;
    $fechabajad=$request->fechabajad;
    $motivo=$request->motivo;
    $fecha_elaboracion=$request->fecha_elaboracion;
    $salario_normal=$request->monto_dias;
    $aguinaldo=$request->monto_aguinaldo;
    $vacaciones=$request->monto_vacaciones;
    $vacaciones_pend=$request->monto_vacaciones_pend;
    $prima_vacacional=$request->monto_prima_vacacional;
    $prima_vacacional_pend=$request->monto_prima_vacacional_pend;
    $incentivo=$request->monto_incentivo;
    $prima_de_antiguedad=$request->monto_prima_de_antiguedad;
    $gratificacion=$request->monto_gratificacion;
    $veinte_dias=$request->monto_veinte_dias;
    $despensa=$request->despensa;
    $percepciones=$request->totalPercepciones;

    $isr=$request->isr;
    $imss=$request->imss;
    $deudores=$request->deudores;
    $isr_finiquito=$request->isr_finiquito;
    $deducciones=$request->totalDeducciones;

    $total=$request->total;


    DatosBaja::where('baja_id', $request->id_baja)->update([
        'fecha_elaboracion' => $request->fecha_elaboracion,
        'salario_normal' => $request->monto_dias,
        'aguinaldo' => $request->monto_aguinaldo,
        'vacaciones' => $request->monto_vacaciones,
        'vacaciones_pend' => $request->monto_vacaciones_pend,
        'prima_vacacional' => $request->monto_prima_vacacional,
        'prima_vacacional_pend' => $request->monto_prima_vacacional_pend,
        'incentivo' => $request->monto_incentivo,
        'prima_de_antiguedad' => $request->monto_prima_de_antiguedad,
        'gratificacion' => $request->monto_gratificacion,
        'veinte_dias' => $request->monto_veinte_dias,
        'despensa' => $request->despensa,
        'percepciones' => $request->totalPercepciones,
        'isr' => $request->isr,
        'imss' => $request->imss,
        'deudores' => $request->deudores,
        'isr_finiquito' => $request->isr_finiquito,
        'deducciones' => $request->totalDeducciones,
        'total' => $request->total,
    ]);




    return redirect('/baja/' . $request->id_baja)->with('success', 'Operación realizada con éxito.');

  }


    public function actualizarMotivoBaja(Request $request)
    {
        try {
            // Validación de los datos
            $validated = $request->validate([
                'motivo' => 'required|string',
                'colaborador_id' => 'required|exists:colaboradores,id',
            ]);

            // Actualizar la baja en la tabla Bajas
            $baja = Bajas::where('colaborador_id', $request->colaborador_id)->first();

            if ($baja) {
                // Actualizamos el motivo de la baja en la tabla Bajas
                $baja->motivo = $request->motivo;
                $baja->save();

                // Ahora actualizamos el motivo de la baja en la tabla DatosBaja
                $datosBaja = DatosBaja::where('baja_id', $baja->id)->first();

                if ($datosBaja) {
                    // Actualizamos el motivo de baja en la tabla DatosBaja
                    $datosBaja->motivo_baja = $request->motivo;
                    $datosBaja->save();

                    // Respuesta de éxito
                    return response()->json(['success' => true, 'message' => 'Motivo de baja actualizado correctamente en ambas tablas.']);
                } else {
                    // Si no se encuentra el registro en la tabla DatosBaja
                    return response()->json(['success' => false, 'message' => 'No se encontró el registro en la tabla de DatosBaja.']);
                }
            } else {
                // Si no se encuentra la baja en la tabla Bajas
                return response()->json(['success' => false, 'message' => 'No se encontró la baja en la tabla de Bajas.']);
            }

        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function actualizarFechaBaja(Request $request)
    {
        try {
            // Validación de los datos
            $validated = $request->validate([
                'fecha_baja' => 'required|date',
                'idBaja' => 'required',
            ]);

            // Lógica para actualizar la fecha de baja
            $datosBaja = DatosBaja::where('baja_id', $request->idBaja)->first();

            if ($datosBaja) {
                // Actualizamos la fecha de baja en la tabla DatosBaja
                $datosBaja->fecha_baja = $request->fecha_baja;
                $datosBaja->save();

                // Ahora actualizamos la fecha de baja en la tabla Bajas
                $baja = Bajas::where('colaborador_id', $request->colaborador_id)->first();

                if ($baja) {
                    // Actualizamos la fecha de baja en la tabla Bajas
                    $baja->fecha_baja = $request->fecha_baja;
                    $baja->save();

                    // Respuesta de éxito
                    return response()->json(['success' => true, 'message' => 'Fecha de baja actualizada correctamente en ambas tablas.']);
                } else {
                    // Si no se encuentra el registro en la tabla Bajas
                    return response()->json(['success' => false, 'message' => 'No se encontró el registro en la tabla de Bajas.']);
                }

            } else {
                // Si no se encuentra el registro en la tabla DatosBaja
                return response()->json(['success' => false, 'message' => 'No se encontró la baja para este colaborador.']);
            }

        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function actualizarFechaElaboracion(Request $request)
    {
        // Validar los datos
        $request->validate([
            'fecha_elaboracion' => 'required|date',
            'colaborador_id' => 'required|exists:colaboradores,id',  // Asegúrate de que el colaborador exista
        ]);

        // Obtener el colaborador_id y la fecha de elaboración desde la petición
        $colaboradorId = $request->colaborador_id;
        $fechaElaboracion = $request->fecha_elaboracion;

        // Buscar el registro de la baja correspondiente al colaborador
        $datosBaja = DatosBaja::where('colaborador_id', $colaboradorId)->first();

        if ($datosBaja) {
            // Actualizar la fecha de elaboración
            $datosBaja->fecha_elaboracion = $fechaElaboracion;
            $datosBaja->save();

            // Responder con un mensaje de éxito
            return response()->json([
                'success' => true,
                'message' => 'Fecha de elaboración actualizada correctamente.'
            ]);
        } else {
            // Si no se encuentra el registro
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el colaborador o la baja.'
            ]);
        }
    }

    public function actualizarSalario(Request $request)
    {


        // Buscar la baja
        $baja = DatosBaja::where('baja_id',$request->idbaja)->first();

        // Actualizar los campos en la tabla
        $baja->update([
            'salario_radio' => $request->salario_seleccionado,
            'salario_diario' => number_format($request->salario_diario,2),
            'salario_diario_integrado' => number_format($request->salario_diario_integrado,2),
            'salario_nuevo' => number_format($request->salario_diario_nuevo_valor,2),
        ]);

        // Responder con éxito
        return response()->json([
            'salario_seleccionado' => $baja->salario_radio
        ]);
    }

    public function actualizarDiasdeSalario(Request $request)
    {
        try {
            // Buscar la baja
            $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

            if (!$baja) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro no encontrado.'
                ], 404);
            }

            // Actualizar los campos en la tabla
            $baja->update([
                's_salario_normal' => $request->salario,
                'd_salario_normal' => $request->dias,
                'salario_normal' => $request->monto_dias,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Datos actualizados correctamente.',
                'salario_normal' => $baja->salario_normal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function actualizarAguinaldo(Request $request)
    {
        // Buscar la baja
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        // Calcular el monto del aguinaldo
        $diasAguinaldo = $request->diasaguinaldo;
        $salarioDiario = $request->salario_diario;
        $montoAguinaldo = $diasAguinaldo * $salarioDiario;

        // Actualizar los campos en la tabla
        $baja->update([
            'd_aguinaldo' => $request->diaspagaraguinaldo,
            'd2_aguinaldo' => $diasAguinaldo,
            'aguinaldo' => $montoAguinaldo,
        ]);

        // Responder con éxito
        return response()->json([
            'success' => true,
            'monto_aguinaldo' => number_format($montoAguinaldo, 2),
        ]);
    }

    public function actualizarVacaciones(Request $request)
    {
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        // Obtén los valores del formulario
        $diasVacaciones = $request->dias_vacaciones;
        $salarioDiario = $request->salario_diario;
        $salarioSeleccionado = $request->salarioSeleccionado;

        // Calcula el monto
        $montoVacaciones = $diasVacaciones * $salarioDiario;

        // Actualiza los datos en la base de datos
        $baja->update([
            's_vacaciones' => $salarioSeleccionado,
            'd_vacaciones' => $diasVacaciones,
            'vacaciones' => $montoVacaciones,
        ]);

        return response()->json([
            'success' => true,
            'monto_vacaciones' => number_format($montoVacaciones, 2),
        ]);
    }


    public function actualizarVacacionesPendientes(Request $request)
    {
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        // Obtén los valores del formulario
        $diasVacaciones = $request->dias_vacaciones;
        $salarioDiario = $request->salario_diario;
        $salarioSeleccionado = $request->salarioSeleccionado;

        // Calcula el monto
        $montoVacaciones = $diasVacaciones * $salarioDiario;

        // Actualiza los datos en la base de datos
        $baja->update([
            's_vacaciones_pend' => $salarioSeleccionado,
            'd_vacaciones_pend' => $diasVacaciones,
            'vacaciones_pend' => $montoVacaciones,
        ]);

        return response()->json([
            'success' => true,
            'monto_vacaciones_pend' => number_format($montoVacaciones, 2),
        ]);
    }


    public function actualizarPrimaVacacional(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                'd_primavacacional' => $request->porcentajePrima,
                'prima_vacacional' => number_format($request->montoPrimaVacacional,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }

    public function actualizarPrimaVacacionalPendiente(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                'd_primavacacional_pend' => $request->porcentajePrima,
                'prima_vacacional_pend' => number_format($request->montoPrimaVacacional,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }


    public function actualizarIncentivo(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                's_incentivo' => $request->salario_diario,
                'd_incentivo' => $request->porcentajeIncentivo,
                'incentivo' => number_format($request->incentivo,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }



    public function actualizarGratificacion(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                'd_gratificacion' => $request->d_gratificacion,
                'gratificacion' => number_format($request->gratificacion,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }



    public function actualizarVeinteDias(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                'd_veinte_dias' => $request->anos_trabajados,
                'veinte_dias' => number_format($request->monto_veinte_dias,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }

    public function calcularPrimaDeAntiguedad(Request $request)
    {


        // Buscar el registro correspondiente por ID
        $baja = DatosBaja::where('baja_id', $request->idbaja)->first();

        if ($baja) {

            $baja->update([
                'd_prima_de_antiguedad' => $request->salario_topado,
                'prima_de_antiguedad' => number_format($request->monto_prima,2),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
    }







    public function ver($id)
    {
        $baja = Bajas::where('id',$id)->first();
        $colaborador = Colaboradores::where('id',$baja->colaborador_id)->first();

        $datosbaja = DatosBaja::firstOrCreate(
            ['baja_id' => $id], // Condición de búsqueda
            [
                // Valores por defecto si no se encuentra el registro
                'colaborador_id' => $baja->colaborador_id,
                's_salario_normal' => 'sd',
                's_aguinaldo' => 'sd',
                's_vacaciones' => 'sd',
                's_vacaciones_pend' => 'sd',
                's_incentivo' => 'sd',
                's_prima_de_antiguedad' => 'sd',
                's_gratificacion' => 'sd',
                's_veinte_dias' => 'sd',
                's_despensa' => 'sd',
                // Otros campos que puedas necesitar por defecto
            ]
        );



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
      $vacaciones_pendientes=$vacacionespendientes->anteriores ?? '0';
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
