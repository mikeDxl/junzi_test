<?php

namespace App\Http\Controllers;

use App\Models\TablaISR;
use Illuminate\Http\Request;

class TablaISRController extends Controller
{
    public function create()
    {
        $datos = TablaISR::all()->groupBy('anio');
        return view('tabla_isr.create',compact('datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer',
            'periodo' => 'required|string|max:50',
            'limite_inferior.*' => 'nullable|numeric',
            'limite_superior.*' => 'nullable|numeric',
            'cuota_fija.*' => 'nullable|numeric',
            'porcentaje.*' => 'nullable|numeric',
        ]);

        $anio = $request->input('anio');
        $periodo = $request->input('periodo');

        // Recorre las filas y guarda las que tengan datos
        foreach ($request->input('limite_inferior') as $index => $limite_inferior) {
            if ($limite_inferior !== null ||
                $request->input('limite_superior')[$index] !== null ||
                $request->input('cuota_fija')[$index] !== null ||
                $request->input('porcentaje')[$index] !== null) {

                TablaISR::create([
                    'limite_inferior' => $limite_inferior,
                    'limite_superior' => $request->input('limite_superior')[$index],
                    'cuota_fija' => $request->input('cuota_fija')[$index],
                    'porcentaje' => $request->input('porcentaje')[$index],
                    'anio' => $anio,
                    'periodo' => $periodo,
                ]);
            }
        }

        return redirect()->route('tabla-isr.create')->with('success', 'Registros creados con éxito.');
    }
}

