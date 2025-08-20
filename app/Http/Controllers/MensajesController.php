<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Grupo; // Asegúrate de importar el modelo Grupo
use Illuminate\Http\Request;

class MensajesController extends Controller
{
    public function index()
    {
        $mensajes = Mensaje::with('grupo')->get(); // Obtener todos los mensajes con el grupo asociado
        return view('mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $grupos = Grupo::all(); // Obtener todos los grupos
        return view('mensajes.create', compact('grupos'));
    }

    public function store(Request $request)
    {

        Mensaje::create($request->only('contenido', 'grupo_id', 'fecha_inicio', 'fecha_fin'));

        return redirect()->route('mensajes.index')->with('success', 'Mensaje guardado exitosamente.');
    }

    public function show(Mensaje $mensaje)
    {
        return view('mensajes.show', compact('mensaje'));
    }

    public function edit(Mensaje $mensaje)
    {
        $grupos = Grupo::all(); // Obtener todos los grupos
        return view('mensajes.edit', compact('mensaje', 'grupos'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $request->validate([
            'mensaje' => 'required',
            'grupo_id' => 'required|exists:grupos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $mensaje->update($request->only('mensaje', 'grupo_id', 'fecha_inicio', 'fecha_fin'));

        return redirect()->route('mensajes.index')->with('success', 'Mensaje actualizado exitosamente.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();

        return redirect()->route('mensajes.index')->with('success', 'Mensaje eliminado exitosamente.');
    }

    public function uploadImage(Request $request)
    {
        /*
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('images', 'public'); // Guarda la imagen en la carpeta 'storage/app/public/images'

            return response()->json(['location' => Storage::url($path)]);
        }

        return response()->json(['location' => ''], 400);
        */

        $path = $request->file('file')->store('images'); // Almacena la imagen en el directorio 'storage/app/public/images'

        // Obtén la URL de la imagen almacenada
        $url = asset('storage/app/images/' . substr($path, 7));

        return response()->json(['location' => $url]);
    }


}
