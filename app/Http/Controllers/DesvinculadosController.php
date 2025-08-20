<?php


namespace App\Http\Controllers;


use App\Models\Desvinculados;
use App\Models\Companies;
use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DesvinculadosController extends Controller
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
      $desvinculados = Desvinculados::where('fecha_baja', '>=', Carbon::now()->subYears(5))->get();
        return view('desvinculados.index' , ['desvinculados' => $desvinculados]);
    }

    public function ver($id)
    {

      $desvinculado=Desvinculados::where('id',$id)->first();

      $companies=Companies::all();

      return view('desvinculados.ver' , ['desvinculado' => $desvinculado ,  'companies' => $companies  ]);

    }




    public function editar(Request $request){

      Colaboradores::where('idempleado',$request->idempleado)->where('company_id',$request->company_id)->update([
          'estatus' => 'activo'
      ]);


      Desvinculados::where('idempleado',$request->idempleado)->where('company_id',$request->company_id)->delete();


      return redirect('/desvinculados');
    }




    public function eliminar(Request $request){

      Desvinculados::where('id',$request->id)->delete();


      return redirect('/ubicaciones');

    }
}
