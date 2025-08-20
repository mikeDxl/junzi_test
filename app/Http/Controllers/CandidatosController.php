<?php



namespace App\Http\Controllers;
use App\Models\Candidatos;

class CandidatosController extends Controller
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
      $candidatos = Candidatos::all();

      return view('candidatos.index' , ['candidatos' => $candidatos ]);
    }
}
