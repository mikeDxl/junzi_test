<?php


namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Proyecto;
use App\Models\Colaboradores;
use Illuminate\Http\Request;
use DB;

class ProyectosController extends Controller
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
      $proyectos = Proyecto::all();
  

       $companies=Companies::all();

         $colaboradores = Colaboradores::where('estatus', 'activo')->get();$colaboradores = Colaboradores::where('estatus', 'activo')
           ->select('id', 'nombre', 'apellido_paterno', 'apellido_materno','proyectos','salario_diario','puesto','company_id')
           ->orderBy('apellido_paterno')
           ->get();

         return view('proyectos.index',compact('proyectos','colaboradores','companies'));

     }

    public function ver($id)
    {

      $proyecto=Proyecto::where('id',$id)->first();

      $companies=Companies::all();

      return view('proyectos.ver' , ['proyecto' => $proyecto ,  'companies' => $companies  ]);

    }

    public function nuevo()
    {
        $companies=Companies::all();

        return view('proyectos.crear' , ['companies' => $companies]);
    }


    public function editar(Request $request){

      
      
      Proyecto::where('proyecto',$request->proyecto_old)->update([
          'proyecto' => $request->proyecto_nombre
      ]);
      

      Colaboradores::where('proyectos',$request->proyecto_old)->update(
        ['proyectos' => $request->proyecto_nombre]
      );
      

      return redirect('/proyectos');
    }

    public function agregar(Request $request)
    {
        
          Colaboradores::where('id',$request->colaborador_id)->update(
          ['proyectos' => $request->proyecto_nombre]
        );
        
          echo "hola";
        //return redirect('proyectos')->with('success', 'Colaborador asigando a proyecto exitosamente.');
    }

    public function crear(Request $request)
    {
      $create=new Proyecto();
      $create->proyecto=$request->proyecto;
      $create->company_id=$request->razon_social;
      $create->save();

      return redirect('/proyectos');
    }


    public function eliminar(Request $request){

      Proyecto::where('id',$request->id)->delete();


      return redirect('/proyectos');

    }

    public function destroy($id)
    {
        // Encuentra el colaborador por ID
        $colaborador = Colaboradores::findOrFail($id);

        // Elimina la ubicación del colaborador
        $colaborador->proyectos = null; // O usa el valor predeterminado que necesites
        $colaborador->save();

        // Redirige de vuelta a la URL deseada con un mensaje de éxito
        return redirect('/proyectos')->with('success', 'Colaborador eliminado correctamente del proyecto.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'proyecto' => 'required|string|max:255',
            'company_id' => 'required|integer',
        ]);

        Proyecto::create($request->all());

        return redirect('/proyectos')->with('success', 'Proyecto creado exitosamente.');
    }
}
