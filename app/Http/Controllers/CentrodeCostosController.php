<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Colaboradores;
use App\Models\CentrodeCostos;
use App\Models\HistoricosPresupuestos;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\PuestosCC;
use App\Models\CatalogoPuestos;


class CentrodeCostosController extends Controller
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
        $centro_de_costos=CatalogoCentrosdeCostos::all();
        return view('centro_de_costos.index' , ['centrodecostos' => $centro_de_costos]);
    }

    public function nuevo()
    {

      return view('centro_de_costos.crear');
    }

    public function crear(Request $request)
    {
      $create=new CatalogoCentrosdeCostos();
      $create->centro_de_costos=$request->centro_de_costos;
      $create->presupuesto=$request->presupuesto;
      $create->company_id='1';
      $create->save();

      return redirect('/centro_de_costos');
    }

    public function eliminar(Request $request){

      CatalogoCentrosdeCostos::where('id',$request->id)->delete();


      return redirect('/centro_de_costos');

    }

    public function ver($id)
    {
        $cc=CatalogoCentrosdeCostos::where('id',$id)->first();

        $puestoscc=PuestosCC::where('id_catalogo_centro_de_costos_id',$id)->get();
        $puestosIds = $puestoscc->pluck('id_catalogo_puestos_id')->toArray();
        $puestos=CatalogoPuestos::whereIn('id', $puestosIds)->orderBy('puesto','ASC')->get();


        return view('centro_de_costos.ver' , ['cc' => $cc , 'puestos' => $puestos]);



    }

    public function eliminar_hp(Request $request){

      if ($request->anio==date("Y")) {
        CentrodeCostos::where('id',$request->cc_id)->update([
            'presupuesto' => '0.00'
        ]);
      }
      HistoricosPresupuestos::where('id',$request->idhp)->delete();

      return redirect('/centro_de_costos');
    }

    public function editar(Request $request){

      CentrodeCostos::where('id',$request->cc_id)->update([
          'presupuesto' => $request->presupuesto ,
          'centro_de_costos' => $request->centro_de_costos
      ]);


      /*
      Colaboradores::where('organigrama',$request->centro_de_costos)->update([
          'organigrama' => $request->presupuesto
      ]);
      */


      HistoricosPresupuestos::updateOrInsert(
        ['anio' => $request->anio, 'tipo' => 'Centro de costos', 'id_concepto' => $request->cc_id],
        ['presupuesto' => $request->presupuesto]
      );


      return redirect('/centro_de_costos');
    }
}
