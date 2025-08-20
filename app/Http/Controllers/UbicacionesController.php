<?php


namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Ubicacion;
use App\Models\Colaboradores;
use Illuminate\Http\Request;
use DB;

class UbicacionesController extends Controller
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
    public function index_old()
    {
        $ubicaciones=Ubicacion::all();
        return view('ubicaciones.index' , ['ubicaciones' => $ubicaciones]);
    }

    public function index()
    {

      $ubicaciones = Ubicacion::where('ubicacion','!=','')->get();


      $colaboradores = Colaboradores::where('estatus', 'activo')
        ->select('id', 'nombre', 'apellido_paterno', 'apellido_materno','ubicaciones','puesto','salario_diario','company_id')
        ->orderBy('apellido_paterno')
        ->get();

        $companies=Companies::all();


        return view('ubicaciones.index',compact('ubicaciones','colaboradores','companies'));

    }

    public function ver($id)
    {

      $ubicacion=Ubicacion::where('id',$id)->first();

      $companies=Companies::all();

      return view('ubicaciones.ver' , ['ubicacion' => $ubicacion ,  'companies' => $companies  ]);

    }

    public function nuevo()
    {
        $companies=Companies::all();

        return view('ubicaciones.crear' , ['companies' => $companies]);
    }


    public function editar(Request $request){


     
      Ubicacion::where('ubicacion',$request->ubicacion_old)->update([
          'ubicacion' => $request->ubicacion_nombre,
          'abreviatura' => $request->ubicacion_abreviatura
      ]);
      

      Colaboradores::where('ubicaciones',$request->ubicacion_old)->update(
        ['ubicaciones' => $request->ubicacion_nombre]
      );
      

      return redirect('/ubicaciones');
    }

    public function crear(Request $request)
    {
      $create=new Ubicacion();
      $create->ubicacion=$request->ubicacion;
      $create->company_id=$request->razon_social;
      $create->direccion=" ";
      $create->save();

      return redirect('/ubicaciones');
    }


    public function eliminar(Request $request){

      Ubicacion::where('ubicacion',$request->ubicacion_old)->delete();

      Colaboradores::where('ubicaciones',$request->ubicacion_old)->update(
        ['ubicaciones' => null]
      );

      return redirect('/ubicaciones');

    }

    public function borrar($id)
    {
        // Encuentra el colaborador por ID
        $colaborador = Colaboradores::findOrFail($id);

        // Elimina la ubicación del colaborador
        $colaborador->ubicaciones = null; // O usa el valor predeterminado que necesites
        $colaborador->save();

        // Redirige de vuelta a la URL deseada con un mensaje de éxito
        return redirect('/ubicaciones')->with('success', 'Colaborador eliminado de ubicación correctamente.');
    }

    public function destroy($id)
    {
        // Encuentra el colaborador por ID
        $colaborador = Colaboradores::findOrFail($id);

        // Elimina la ubicación del colaborador
        $colaborador->ubicaciones = null; // O usa el valor predeterminado que necesites
        $colaborador->save();

        // Redirige de vuelta a la URL deseada con un mensaje de éxito
        return redirect('/ubicaciones')->with('success', 'Ubicación eliminada correctamente.');
    }

    public function agregar(Request $request)
    {
        
          Colaboradores::where('id',$request->colaborador_id)->update(
          ['ubicaciones' => $request->ubicacion_nombre]
        );
        
        
        return redirect('ubicaciones')->with('success', 'Colaborador asigando a ubicación exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ubicacion' => 'required|string|max:255',
            'company_id' => 'required|integer',
        ]);

        Ubicacion::create($request->all());

        return redirect('/ubicaciones')->with('success', 'Ubicación creada exitosamente.');
    }



}
