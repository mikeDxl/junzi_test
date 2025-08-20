<?php
namespace App\Http\Controllers;

use App\Models\DiasVacaciones;
use Illuminate\Http\Request;

class DiasVacacionesController extends Controller
{
    public function create()
    {
        $datos = DiasVacaciones::all()->groupBy('anio');
        return view('dias_vacaciones.create',compact('datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer',
            'dias_vacaciones.*' => 'nullable|integer',
        ]);

        $anio = $request->input('anio');

        // Guardar los datos para los años laborados del 1 al 35
        foreach ($request->input('dias_vacaciones') as $anio_laborado => $dias_vacaciones) {
            if ($dias_vacaciones !== null) {
                DiasVacaciones::create([
                    'anio' => $anio,
                    'anio_laborado' => $anio_laborado + 1,  // +1 porque el índice comienza en 0
                    'dias_vacaciones' => $dias_vacaciones,
                ]);
            }
        }

        return redirect()->route('dias-vacaciones.create')->with('success', 'Registros creados con éxito.');
    }
}
