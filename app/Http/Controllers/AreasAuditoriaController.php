<?php

namespace App\Http\Controllers;

use App\Models\AreasAuditoria;
use Illuminate\Http\Request;

class AreasAuditoriaController extends Controller
{
    // Mostrar la lista de todas las áreas de auditoría
    public function index()
    {
        $areas = AreasAuditoria::all();
        return view('areas_auditoria.index', compact('areas'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('areas_auditoria.create');
    }

    // Almacenar una nueva área de auditoría
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:255|unique:areas_auditoria',
            'es_planta' => 'boolean',
            'trazabilidad' => 'boolean',
        ]);

        AreasAuditoria::create($request->all());

        return redirect()->route('areas_auditoria.index')->with('success', 'Área de auditoría creada exitosamente.');
    }

    // Mostrar el formulario de edición
    public function edit($id)
    {
        $area = AreasAuditoria::findOrFail($id);
        return view('areas_auditoria.edit', compact('area'));
    }

    // Actualizar una área de auditoría existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:255|unique:areas_auditoria,clave,' . $id,
            'es_planta' => 'boolean',
            'trazabilidad' => 'boolean',
        ]);

        $area = AreasAuditoria::findOrFail($id);
        $area->update($request->all());

        return redirect()->route('areas_auditoria.index')->with('success', 'Área de auditoría actualizada exitosamente.');
    }

    // Eliminar una área de auditoría
    public function destroy($id)
    {
        $area = AreasAuditoria::findOrFail($id);
        $area->delete();

        return redirect()->route('areas_auditoria.index')->with('success', 'Área de auditoría eliminada exitosamente.');
    }

    public function updatePlanta(Request $request, $id)
    {

        // Validar la entrada
        $request->validate([
            'es_planta' => 'required|boolean'
        ]);

        // Buscar el área
        $area = AreasAuditoria::findOrFail($id);
        
        // Actualizar el campo es_planta
        $area->es_planta = $request->es_planta;
        $area->save();

        // Devolver respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => $request->es_planta 
                ? 'Área marcada como planta exitosamente' 
                : 'Área desmarcada como planta exitosamente',
            'data' => [
                'id' => $area->id,
                'es_planta' => $area->es_planta
            ]
        ]);
    }


    public function updateTrazabilidad(Request $request, $id)
    {

        // Validar la entrada
        $request->validate([
            'trazabilidad' => 'required|boolean'
        ]);

        // Buscar el área
        $area = AreasAuditoria::findOrFail($id);
        
        // Actualizar el campo trazabilidad
        $area->trazabilidad = $request->trazabilidad;
        $area->save();

        // Devolver respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => $request->trazabilidad
                ? 'Área marcada con trazabilidad exitosamente' 
                : 'Área desmarcada con trazabilidad exitosamente',
            'data' => [
                'id' => $area->id,
                'trazabilidad' => $area->trazabilidad
            ]
        ]);
    }

}
