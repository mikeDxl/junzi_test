<?php

namespace App\Http\Controllers;

use App\Models\TrazabilidadVenta;
use App\Models\Companies;
use App\Models\ConfigHallazgos;
use App\Models\AreasAuditoria;



use Illuminate\Http\Request;
use Carbon\Carbon;

class TrazabilidadVentaController extends Controller
{
    public function index(Request $request)
    {
        // Valores por defecto (año y mes actual)
        $currentYear = date('Y');
        $currentMonth = date('m');

        $areasAuditoria  = AreasAuditoria::select('Id', 'clave')
                                ->where('trazabilidad', true)
                                ->get();

        // Obtener filtros del request o usar valores por defecto
        $selectedYear = $request->input('anio', $currentYear);
        $selectedMonth = $request->input('mes', $currentMonth);

        // Consulta base con filtros
        $query = TrazabilidadVenta::query()
            ->when($selectedYear, fn($query) => $query->where('anio', $selectedYear))
            ->when($selectedMonth, fn($query) => $query->where('mes', $selectedMonth));

        $trazabilidadVentas = $query->get();

        // Preparar datos para la gráfica por empresa
        $empresas = $trazabilidadVentas->unique('empresa')->pluck('empresa');
        $chartDataEmpresas = [
            'empresas' => $empresas,
            'nota_entrega' => $trazabilidadVentas->groupBy('empresa')->map->avg('nota_de_entrega'),
            'factura' => $trazabilidadVentas->groupBy('empresa')->map->avg('factura'),
            'carta_porte' => $trazabilidadVentas->groupBy('empresa')->map->avg('carta_porte'),
            'complemento_carta' => $trazabilidadVentas->groupBy('empresa')->map->avg('complemento_carta')
        ];

        // Preparar datos para la gráfica por área
        $areas = $trazabilidadVentas->unique('planta')->pluck('planta');
        $chartDataAreas = [
            'areas' => $areas,
            'nota_entrega' => $trazabilidadVentas->groupBy('planta')->map->avg('nota_de_entrega'),
            'factura' => $trazabilidadVentas->groupBy('planta')->map->avg('factura'),
            'carta_porte' => $trazabilidadVentas->groupBy('planta')->map->avg('carta_porte'),
            'complemento_carta' => $trazabilidadVentas->groupBy('planta')->map->avg('complemento_carta')
        ];

        // Obtener años disponibles
        $years = TrazabilidadVenta::select('anio')
            ->distinct()
            ->orderBy('anio', 'desc')
            ->pluck('anio');

        // Todos los meses en español
        $allMonths = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];

        return view('trazabilidad_venta.index', compact(
            'areasAuditoria',
            'trazabilidadVentas',
            'years',
            'allMonths',
            'selectedYear',
            'selectedMonth',
            'chartDataEmpresas',
            'chartDataAreas'
        ));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        $empresas = Companies::all();

        $areasUnicas = ConfigHallazgos::select('area')
                    ->distinct()
                    ->orderBy('area')
                    ->get()
                    ->pluck('area');

        return view('trazabilidad_venta.create',compact('empresas','areasUnicas'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|digits:4',
            'mes' => 'required|string|size:1,2',
            'nota_de_entrega' => 'nullable|numeric|min:0|max:100',
            'factura' => 'nullable|numeric|min:0|max:100',
            'carta_porte' => 'nullable|numeric|min:0|max:100',
            'complemento_carta' => 'nullable|numeric|min:0|max:100',
            'planta' => 'required|string',
        ]);

        $planta = $request->input('planta');

        // Separar por guion
        [$empresa, $ubicacion] = array_map('trim', explode('-', $planta, 2));

        TrazabilidadVenta::create([
            'empresa' => $empresa,
            'planta' => $planta,
            'anio' => $request->anio,
            'mes' => $request->mes,
            'nota_de_entrega' => $request->nota_de_entrega,
            'factura' => $request->factura,
            'carta_porte' => $request->carta_porte,
            'complemento_carta' => $request->complemento_carta,
        ]);

        return redirect()->route('trazabilidad_ventas.index')->with('success', 'Registro creado correctamente');
    }

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $trazabilidadVenta = TrazabilidadVenta::findOrFail($id);
        return view('trazabilidad_venta.edit', compact('trazabilidadVenta'));
    }

    // Actualizar un registro en la base de datos
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'anio' => 'required|digits:4',
            'mes' => 'required|string|size:2',
            'nota_de_entrega' => 'nullable|numeric|min:0|max:100',
            'factura' => 'nullable|numeric|min:0|max:100',
            'carta_porte' => 'nullable|numeric|min:0|max:100',
            'complemento_carta' => 'nullable|numeric|min:0|max:100',
        ]);

        $planta = $request->input('planta');

        // Separar por el guion
        [$empresa, $ubicacion] = array_map('trim', explode('-', $planta, 2));

        // Buscar el registro y actualizarlo
        $trazabilidadVenta = TrazabilidadVenta::findOrFail($id);
        $trazabilidadVenta->update([
            'empresa' => $empresa,
            'planta' => $planta,
            'anio' => $request->anio,
            'mes' => $request->mes,
            'nota_de_entrega' => $request->nota_de_entrega,
            'factura' => $request->factura,
            'carta_porte' => $request->carta_porte,
            'complemento_carta' => $request->complemento_carta,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('trazabilidad_ventas.index')->with('success', 'Registro actualizado correctamente');
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $trazabilidadVenta = TrazabilidadVenta::findOrFail($id);
        $trazabilidadVenta->delete();

        return redirect()->route('trazabilidad_ventas.index')->with('success', 'Registro eliminado correctamente');
    }
}
