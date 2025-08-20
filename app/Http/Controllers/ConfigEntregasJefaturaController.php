<?php

namespace App\Http\Controllers;

use App\Models\ConfigEntregasJefatura;
use Illuminate\Http\Request;

class ConfigEntregasJefaturaController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        $configEntregas = ConfigEntregasJefatura::all();
        return view('config-entregas-jefatura.index', compact('configEntregas'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        return view('config-entregas-jefatura.create');
    }

    // Guardar un nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'reporte' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
        ]);

        ConfigEntregasJefatura::create($request->all());

        return redirect()->route('config-entregas-jefatura.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $configEntrega = ConfigEntregasJefatura::findOrFail($id);
        return view('config-entregas-jefatura.edit', compact('configEntrega'));
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'reporte' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
        ]);

        $configEntrega = ConfigEntregasJefatura::findOrFail($id);
        $configEntrega->update($request->all());

        return redirect()->route('config-entregas-jefatura.index')
            ->with('success', 'Registro actualizado exitosamente.');
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $configEntrega = ConfigEntregasJefatura::findOrFail($id);
        $configEntrega->delete();

        return redirect()->route('config-entregas-jefatura.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}
