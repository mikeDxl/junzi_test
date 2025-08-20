<?php

namespace App\Http\Controllers;

use App\Models\ConfigHallazgos;
use Illuminate\Http\Request;

class ConfigHallazgosController extends Controller
{
    public function obtenerTitulos(Request $request) {
        // Obtener los títulos filtrados por área
        $titulos = ConfigHallazgos::where('area', $request->area)
                                   ->pluck('titulo')
                                   ->unique()
                                   ->values();

        // Verifica que 'pluck' devuelve un arreglo de títulos
        return response()->json($titulos);  // Esto devuelve un arreglo JSON
    }

    public function obtenerSubTitulos(Request $request) {
    $subtitulos = ConfigHallazgos::where('titulo', $request->area)
                                  ->select('subtitulo', 'obligatorio')
                                  ->distinct()
                                  ->get();

    return response()->json($subtitulos);
}


}
