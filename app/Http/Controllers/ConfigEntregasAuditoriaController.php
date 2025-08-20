<?php

namespace App\Http\Controllers;

use App\Models\ConfigEntregasAuditoria;
use Illuminate\Http\Request;

class ConfigEntregasAuditoriaController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        $configEntregas = ConfigEntregasAuditoria::all();
        return view('config-entregas-auditoria.index', compact('configEntregas'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        return view('config-entregas-auditoria.create');
    }

    // Guardar un nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'reporte' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
        ]);

        ConfigEntregasAuditoria::create($request->all());

        return redirect()->route('config-entregas-auditoria.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $configEntrega = ConfigEntregasAuditoria::findOrFail($id);
        return view('config-entregas-auditoria.edit', compact('configEntrega'));
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'reporte' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
        ]);

        $configEntrega = ConfigEntregasAuditoria::findOrFail($id);
        $configEntrega->update($request->all());

        return redirect()->route('config-entregas-auditoria.index')
            ->with('success', 'Registro actualizado exitosamente.');
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $configEntrega = ConfigEntregasAuditoria::findOrFail($id);
        $configEntrega->delete();

        return redirect()->route('config-entregas-auditoria.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}
