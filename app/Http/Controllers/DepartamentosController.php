<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;
use App\Models\Companies;
use App\Models\Colaboradores;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Departamentos;
use App\Models\CatalogoDepartamentos;
use DB;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function paso2()
    {
        return view('configuracion.paso2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */




     public function index()
     {



       if (session('company_id')=='Todas' || session('company_id')=='0'  || session('company_id')=='' ) {
         $departamentos = CatalogoDepartamentos::all();
       }else {
         $departamentos = CatalogoDepartamentos::all();
       }

       return view('departamentos.index', ['departamentos' => $departamentos]);
     }

     public function ver($id){

       $departamento = CatalogoDepartamentos::where('id',$id)->first();
       return view('departamentos.ver' , ['departamento'=> $departamento]);
     }


     public function editarOld($id)
     {

       $departamento = Departamentos::where('id' , $id)->first();


       $depas = Departamentos::where('company_id',$departamento->company_id)->get();
       $colaboradores = Colaboradores::where('company_id',$departamento->company_id)->get();

       return view('departamentos.editar', ['departamento' => $departamento , 'depas' => $depas , 'colaboradores' => $colaboradores ]);

     }

     public function editar(Request $request){

       Departamentos::where('id',$request->id)->update([
           'departamento' => $request->departamento
       ]);


       return redirect('/departamentos');
     }

     public function eliminar(Request $request){


       $depa=Departamentos::where('id',$request->id)->first();


       $newdepa=Departamentos::where('company_id',$depa->company_id)->where('id',$request->departamento_cambio)->first();


       Colaboradores::where('departamento_id',$depa->iddepartamento)->update([
           'departamento_id' => $newdepa->iddepartamento
       ]);


       Departamentos::where('id',$request->id)->delete();

       return redirect('/departamentos');


     }


    public function create(Request $request)
    {


        foreach ($request->departamentos as $depa){
            if($depa!=""){
                $create=new Departamentos();
                $create->company_id=session('company_id');
                $create->departamento=$depa;
                $create->save();
            }

        }

        return redirect()->route('colaboradores');
    }


    public function crear(Request $request)
    {
        $ultimoRegistro = Departamentos::latest('iddepartamento')->first();
        $iddepartamento= $ultimoRegistro->iddepartamento+1;
        $numerodepartamento= $ultimoRegistro->numerodepartamento+1;


        $create=new Departamentos();
        $create->company_id='1';
        $create->departamento=$request->departamento;
        $create->iddepartamento=$iddepartamento;
        $create->numerodepartamento=$numerodepartamento;
        $create->presupuesto='0';
        $create->estatus='activo';
        $create->save();


       return redirect('/departamentos');
    }


    public function actualizar (Request $request){

      Departamentos::where('id',$request->departamento_id)->update([
          'presupuesto' => $request->presupuesto
      ]);

      return redirect()->route('departamentos');

    }

    public function nuevo()
    {
        $departamentos=Departamentos::all();

        return view('departamentos.crear' , ['departamentos' => $departamentos]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartamentosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function importarNomipaq2()
    {
        $nom10003=DB::connection('sqlsrv2')->table('nom10003')->get();

        foreach ($nom10003 as $n3){
            $create=new Departamentos();
            $create->company_id=session('company_id');
            $create->departamento=$n3->descripcion;
            $create->save();
        }

        return redirect('/pasonomipaq3');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departamentos  $departamentos
     * @return \Illuminate\Http\Response
     */
    public function show(Departamentos $departamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departamentos  $departamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamentos $departamentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartamentosRequest  $request
     * @param  \App\Models\Departamentos  $departamentos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartamentosRequest $request, Departamentos $departamentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamentos  $departamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamentos $departamentos)
    {
        //
    }
}
