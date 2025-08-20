<?php
namespace App\Http\Controllers;

use App\Models\Valor;
use Illuminate\Http\Request;

class ValorController extends Controller
{
    public function create()
    {
        $datos = Valor::orderBy('created_at', 'desc')->get();

        return view('valores.create',compact('datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'anio' => 'required|integer',
            'valor' => 'required|numeric',
        ]);

        Valor::create($request->all());

        return redirect()->route('valores.create')->with('success', 'Valor guardado con éxito.');
    }
}
