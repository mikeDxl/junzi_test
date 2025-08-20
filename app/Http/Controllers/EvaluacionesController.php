<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Colaboradores;
use Illuminate\Http\Request;

class EvaluacionesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
      $evaluaciones = Evaluacion::all();
      $colaboradores = Colaboradores::where('estatus','activo')->get();

      return view('evaluaciones.index',compact('evaluaciones','colaboradores'));
    }

    public function evaluar($id_evaluador,$id_colaborador)
    {

      return view('evaluaciones.evaluacion',compact('id_evaluador','id_colaborador'));
    }

    public function ver($id_evaluador,$id_colaborador)
    {
      $evaluacion=Evaluacion::where('id_evaluador',$id_evaluador)->where('id_colaborador',$id_colaborador)->first();
      return view('evaluaciones.ver',compact('id_evaluador','id_colaborador'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_colaborador' => 'required|exists:colaboradores,id',
            'id_evaluador' => 'required|array',
            'id_evaluador.*' => 'exists:colaboradores,id',
        ]);

        $idColaborador = $validatedData['id_colaborador'];
        $evaluadores = $validatedData['id_evaluador'];

        foreach ($evaluadores as $idEvaluador) {
            Evaluacion::create([
                'id_colaborador' => $idColaborador,
                'id_evaluador' => $idEvaluador,
                'pregunta1' => null,
                'pregunta2' => null,
                'pregunta3' => null,
                'pregunta4' => null,
                'pregunta5' => null,
                'pregunta6' => null,
            ]);
        }

        return redirect()->route('evaluaciones')->with('success', 'Evaluaciones creadas correctamente.');
    }

    public function guardarEvaluacion(Request $request)
    {
        $request->validate([
            'id_colaborador' => 'required|exists:colaboradores,id',
            'id_evaluador' => 'required|exists:colaboradores,id',
            'pregunta1' => 'required|string',
            'pregunta2' => 'required|string',
            'pregunta3' => 'required|string',
            'pregunta4' => 'required|string',
            'pregunta5' => 'required|string',
            'pregunta6' => 'required|string',
        ]);

        $evaluacion = Evaluacion::where('id_colaborador', $request->id_colaborador)
                                ->where('id_evaluador', $request->id_evaluador)
                                ->first();

        if ($evaluacion) {
            $evaluacion->update([
                'pregunta1' => $request->pregunta1,
                'pregunta2' => $request->pregunta2,
                'pregunta3' => $request->pregunta3,
                'pregunta4' => $request->pregunta4,
                'pregunta5' => $request->pregunta5,
                'pregunta6' => $request->pregunta6,
            ]);
        } else {
            Evaluacion::create([
                'id_colaborador' => $request->id_colaborador,
                'id_evaluador' => $request->id_evaluador,
                'pregunta1' => $request->pregunta1,
                'pregunta2' => $request->pregunta2,
                'pregunta3' => $request->pregunta3,
                'pregunta4' => $request->pregunta4,
                'pregunta5' => $request->pregunta5,
                'pregunta6' => $request->pregunta6,
            ]);
        }

        return redirect('/evaluaciones')->with('success', 'Evaluación guardada exitosamente.');
    }

}
