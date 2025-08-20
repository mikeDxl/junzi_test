<?php


namespace App\Http\Controllers;
use App\Models\OrganigramaLineal;
use App\Models\PerfilPuestos;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\CatalogoPuestos;
use App\Models\CatalogoDepartamentos;
use App\Models\PuestosDepartamentos;
use App\Models\PuestosEmpresas;
use App\Models\PuestosColaboradores;

class PuestosController extends Controller
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
        //$puestos = PerfilPuestos::where('estatus','activo')->get();
        $puestos = CatalogoPuestos::all();

        return view('puestos.index' , ['puestos' => $puestos]);
    }

    public function ver($id)
    {
        $puesto = CatalogoPuestos::where('id',$id)->first();
        return view('puestos.ver' , ['puesto' => $puesto]);
    }


    public function subirperfil(Request $request)
    {

      $perfil = $request->input('perfil');
      $puesto_id = $request->input('puesto_id');
      $puesto = $request->input('puesto');
      $tipo = $request->input('tipo');
      $perfilpuesto="";

      if ($request->hasFile('perfil')) {
        // Crear la ruta de almacenamiento
        $ruta = "perfildepuestos/{$puesto_id}/";

        // Verificar si la carpeta ya existe, si no, crearla
        if (!Storage::exists($ruta)) {
            Storage::makeDirectory($ruta);
        }

        // Subir el archivo al directorio de almacenamiento
        $archivo = $request->file('perfil');
        $nombreArchivo = $archivo->getClientOriginalName(); // Nombre original del archivo
        $archivo->storeAs($ruta, $nombreArchivo, 'public');

        $perfilpuesto=$ruta.$nombreArchivo;
      }



        CatalogoPuestos::where('id',$puesto_id)->update([
            'perfil' =>  $perfilpuesto,
            'tipo' => $tipo ,
            'puesto' => $puesto ,

        ]);
          /*
          PerfilPuestos::where('id',$puesto_id)->update([
              'perfil' =>  $perfilpuesto,
              'departamento_id' => $departamento ,
              'puesto' => $puesto ,
              'codigo' => $codigo

          ]);

          $puesto = PerfilPuestos::where('id',$puesto_id)->first();
          */

        $puesto = PerfilPuestos::where('id',$puesto_id)->first();

        return redirect('/puestos');
    }
}
