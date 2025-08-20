<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Colaboradores;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::all(); // Obtener todos los grupos
        return view('grupos.index', compact('grupos')); // Pasar los grupos a la vista
    }

    public function create()
    {
        return view('grupos.create'); // Mostrar formulario para crear grupo
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Grupo::create($request->all()); // Crear un nuevo grupo

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function show(Grupo $grupo)
    {
        return view('grupos.show', compact('grupo')); // Mostrar detalles del grupo
    }

    public function edit(Grupo $grupo)
    {
        $colaboradores_full = Colaboradores::select('id', 'nombre', 'apellido_paterno', 'apellido_materno')->get();

        // Eliminar duplicados por nombre y apellidos
        $colaboradoresUnicos = $colaboradores_full->unique(function ($colaborador) {
            return $colaborador->nombre . $colaborador->apellido_paterno . $colaborador->apellido_materno;
        });

        // Reindexar la colección (opcional)
        $colaboradores = $colaboradoresUnicos->values();

        return view('grupos.edit', compact('grupo', 'colaboradores')); // Pasar el grupo y los colaboradores a la vista
    }


    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'colaboradores' => 'array', // Aceptar un array de colaboradores
        ]);

        $grupo->update($request->all()); // Actualizar grupo existente
        $grupo->colaboradores()->sync($request->colaboradores); // Sincronizar colaboradores

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
    }


    public function destroy(Grupo $grupo)
    {
        $grupo->delete(); // Eliminar grupo

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente.');
    }
}
