<?php


namespace App\Http\Controllers;

use App\Models\ComentarioHallazgos;
use App\Models\HallazgoArchivos;
use App\Models\Hallazgos;
use App\Models\User;
use App\Models\Auditoria;
use App\Models\Companies;
use App\Models\Colaboradores;
use App\Models\AreasAuditoria;
use App\Models\CentrodeCostos;
use App\Models\CatalogoCentrosdeCostos;
use App\Models\Ubicacion;
use App\Models\ConfigHallazgos;
use App\Models\Notificaciones;
use App\Events\HallazgoGuardado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\AuditoriasExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionesAuditoriaService;



class AuditoriaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->notificacionService = new NotificacionesAuditoriaService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
     public function index()
    {
        $idcolab = auth()->user()->colaborador_id;

            $colabinfo=Colaboradores::where('id',$idcolab)->first();

        if(auth()->user()->auditoria=='1'){
            
            $auditorias = Auditoria::withCount('hallazgos')->get();

            //$auditoriasPendientes = Auditoria::where('estatus', 'Pendiente')->get();

            //$auditoriasCerradas = Auditoria::where('estatus', 'Cerrado')->get();

            // Obtener auditorías abiertas (con al menos un hallazgo pendiente)
            $auditoriasPendientes = Auditoria::whereHas('hallazgosPendientes')->get();

            // Obtener auditorías cerradas (todas sus hallazgos están cerrados)
            $auditoriasCerradas = Auditoria::whereDoesntHave('hallazgosPendientes')->get();


            /*

            $auditoriasPendientes = Auditoria::whereHas('hallazgos', function ($query) {
                $query->where('estatus', 'Pendiente');
            })->get();

            $auditoriasCerradas = Auditoria::whereDoesntHave('hallazgos', function ($query) {
                $query->where('estatus', 'Cerrado');
            })->get();

            */
        }else{
            $auditorias = Auditoria::whereHas('hallazgos', function($query) use ($idcolab) {
                $idcolabString = (string)$idcolab;
                $query->where(function($query) use ($idcolabString) {
                    $query->where('responsable', 'LIKE', "%,$idcolabString,%") // ID en medio de la cadena
                        ->orWhere('responsable', 'LIKE', "$idcolabString,%")  // ID al inicio de la cadena
                        ->orWhere('responsable', 'LIKE', "%,$idcolabString")  // ID al final de la cadena
                        ->orWhere('responsable', '=', $idcolabString);        // ID es el único valor
                });
            })->get();

            $auditoriasPendientes = Auditoria::whereHas('hallazgos', function ($query) use ($idcolab) {
                $query->where('estatus', 'Pendiente')
                    ->whereRaw("INSTR(responsable, ?) > 0", [$idcolab]);
            })->get();


            $auditoriasCerradas = Auditoria::whereHas('hallazgos', function ($query) use ($idcolab) {
                $query->where('estatus', 'Cerrado')
                    ->whereRaw("INSTR(responsable, ?) > 0", [$idcolab]);
            })->get();
        }


        return view('auditoria.index', ['auditorias' => $auditorias, 'auditoriasPendientes' => $auditoriasPendientes , 'auditoriasCerradas' => $auditoriasCerradas]);
    }


    public function exportAuditorias()
    {
        return Excel::download(new AuditoriasExport, 'auditorias.xlsx');
    }

    public function nueva()
    {
        $claves=AreasAuditoria::all();
        $auditorias=Auditoria::all();
        $companies=Companies::all();
        $ubicaciones=Ubicacion::all();

        return view('auditoria.crear' , ['auditorias' => $auditorias , 'ubicaciones' => $ubicaciones , 'companies' => $companies , 'claves' => $claves ]);
    }

    public function crear(Request $request)
    {


      $folio=Auditoria::where('anio',date('Y'))
      ->where('tipo',strtoupper(substr($request->tipo, 0, 3)),)
      ->where('area',strtoupper(substr($request->area, 0, 7)),)
      ->count();

      $folio=$folio+1;

      $partes = explode('-', $request->area);
      $ubicacion = end($partes); // Esto ya funciona sin error

      $auditoria=Auditoria::create([
            'tipo' => strtoupper(substr($request->tipo, 0, 3)),
            'area' => $request->area,
            'ubicacion' => $ubicacion,
            'anio' => date('Y'),
            'folio' => str_pad($folio, 2, '0', STR_PAD_LEFT),
            'fecha_alta' =>  date('Y-m-d'),
            'estatus' => 'Pendiente',
            'cc' => $request->area,
          ]);

        return redirect('/auditoria/'.$auditoria->id);
    }

    public function crear_hallazgo(Request $request)
    {
        //dd($request->criticidad);
        // Validar los datos entrantes
        $request->validate([
            'colaborador_id' => 'required|array',
            'evidencia' => 'nullable|file|max:61440', // 60MB = 61440KB
        ], [
            'colaborador_id.required' => 'Falta seleccionar el colaborador.',
            'evidencia.max' => 'El archivo no puede ser mayor a 60MB.',
        ]);

        $nombreArchivo = null;

        if ($request->hasFile('evidencia')) {

            $archivo = $request->file('evidencia');
            $nombreOriginal = $archivo->getClientOriginalName();
            $nombreSinAcentos = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME), '_');
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = $nombreSinAcentos . '.' . $extension;
        }


        try {
            // Convertir el array de IDs de colaboradores a una cadena separada por comas
            $responsables = implode(',', $request->colaborador_id);

            // Obtener configuración del hallazgo
            $hallazgo = ConfigHallazgos::where('subtitulo', $request->hallazgo)->first();

            if (!$hallazgo) {
                return back()->withErrors(['hallazgo' => 'Hallazgo no encontrado.']);
            }

            $quefefe = 2994;
            if ($hallazgo->tipo == 'Operativo' || $hallazgo->tipo == 'OPERATIVO') {
                $quefefe = 2994;
            } else {
                $quefefe = 2994;
            }

            $hallazgoNew=Hallazgos::create([
                'auditoria_id' => $request->auditoria_id,
                'responsable' => $responsables,
                'fecha_presentacion' => $request->fecha_presentacion,
                'fecha_limite' => $request->fecha_limite,
                'fecha_identificacion' => $request->fecha_identificacion,
                'hallazgo' => $hallazgo->subtitulo,
                'sugerencia' => $request->sugerencia,
                'estatus' => 'Pendiente',
                'evidencia' => $nombreArchivo,
                'comentarios' => $request->comentarios,
                'fecha_cierre' => $request->fecha_cierre,
                'fecha_compromiso' => $request->fecha_compromiso,
                'tipo' => $hallazgo->tipo,
                'criticidad' => $request->criticidad,
                'plan_de_accion' => $request->plan_de_accion,
                'jefe' => $quefefe,
                'titulo' => $hallazgo->id,
            ]);

            // Manejar archivo de evidencia si existe

            $auditoriaId = $hallazgoNew->auditoria_id;
            $hallazgoId = $hallazgoNew->id;

            if ($request->hasFile('evidencia')) {
                $this->procesarArchivoEvidenciaCrear($request->file('evidencia'), $auditoriaId,  $hallazgoId);
            }

            // Enviar notificaciones
            $responsablesemail = $request->colaborador_id;
            $usuarios = User::whereIn('colaborador_id', $responsablesemail)->get();

            // foreach ($usuarios as $usuario) {
            //     if ($usuario->email) {
            //         Notificaciones::create([
            //             'email' => $usuario->email,
            //             'tipo' => 'success',
            //             'ruta' => 'auditoria/'.$request->auditoria_id,
            //             'fecha' => now(),
            //             'texto' => 'Nuevo hallazgo asignado',
            //             'abierto' => '0',
            //         ]);
            //     }
            // }

            $this->notificacionService->notificarAsignacionHallazgo($hallazgoNew, $request->colaborador_id);


            return redirect('/auditoria'.'/'.$request->auditoria_id);

        } catch (\Exception $e) {
            //DB::rollback();
            \Log::error('Error al crear hallazgo: ' . $e->getMessage());

            // Si falló la creación del hallazgo, eliminar el archivo si se subió
            // if (isset($nombreArchivo) && $nombreArchivo) {
            //     $this->limpiarArchivoError($request, $nombreArchivo);
            // }

            return back()->withErrors(['general' => 'Error al crear el hallazgo: ' . $e->getMessage()]);
        }
    }

    /**
     * Procesar archivo de evidencia para crear hallazgo
     */
    private function procesarArchivoEvidenciaCrear($files, $auditoriaId, $hallazgoId)
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
        try {
            // Validar archivo
            if (!$file->isValid()) {
                \Log::error("Archivo inválido: " . $file->getErrorMessage());
                continue;
            }

            // Generar nombre único y seguro
            $nombreOriginal = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $nombreLimpio = $this->limpiarNombreArchivo($nombreOriginal);
            $nombreArchivo = time() . '_' . uniqid() . '_' . $nombreLimpio . '.' . $extension;

            // Crear registro en la base de datos PRIMERO

            $archivo=HallazgoArchivos::create([
                'id_auditoria' => $auditoriaId,
                'id_hallazgo' => $hallazgoId,
                'id_user' => auth()->user()->id,
                'comentario' => $nombreArchivo,
            ]);

            $auditoria = Auditoria::find($auditoriaId);

            $ruta = "auditorias/{$auditoria->tipo}/{$auditoria->area}/{$auditoria->anio}/{$auditoria->folio}/{$hallazgoId}/{$archivo->id}/";

            // Guardar archivo físicamente
            $rutaCompleta = $this->guardarArchivoSeguro($file, $ruta, $nombreArchivo);

            // Actualizar registro con ruta final
            // $archivo->ruta_archivo = $ruta . $filename;
            // $archivo->estado = 'guardado';
            // $archivo->save();

            \Log::info("Archivo guardado exitosamente: {$rutaCompleta}");

        } catch (\Exception $e) {
            \Log::error('Error procesando archivo de evidencia: ' . $e->getMessage());
            throw $e;
        }
      }
    }

    public function ver($id)
    {
        // Obteniendo la auditoría por su ID
        $auditoria = Auditoria::where('id', $id)->first();

        // Obteniendo los hallazgos relacionados a la auditoría
        $hallazgos = Hallazgos::where('auditoria_id', $id)->get();

        $areash = ConfigHallazgos::distinct()->pluck('area');
        $titulos = ConfigHallazgos::distinct()->pluck('titulo');

        $subtitulos = ConfigHallazgos::all();

        // Obteniendo todos los colaboradores con estatus 'activo'
        $colaboradores = Colaboradores::where('estatus', 'activo')
          ->select('id', 'nombre', 'apellido_paterno', 'apellido_materno')
          ->orderBy('apellido_paterno')
          ->get();

        // Obteniendo los IDs de los colaboradores responsables (suponiendo que se encuentran en los hallazgos)
        $responsablesIds = $hallazgos->flatMap(function ($hallazgo) {
            return explode(',', $hallazgo->responsable);
        })->unique()->toArray(); // Convertir la colección a un array
        $centro_de_costos=CatalogoCentrosdeCostos::all();
        $ubicaciones=Ubicacion::all();

        $claves=AreasAuditoria::all();
        $auditorias=Auditoria::all();
        $companies=Companies::all();
        // Retornando la vista con los datos necesarios
        return view('auditoria.ver', compact('areash','titulos','subtitulos','auditoria', 'hallazgos', 'colaboradores', 'responsablesIds','centro_de_costos','ubicaciones','claves','auditoria','companies'));
    }

    public function update(Request $request, $id)
    {
        $auditoria = Auditoria::findOrFail($id);

        // Obtener ubicación desde el área
        $partes = explode('-', $request->area);
        $ubicacion = end($partes);

        // Actualizar datos
        $auditoria->update([
            'tipo' => strtoupper(substr($request->tipo, 0, 3)),
            'area' => $request->area,
            'ubicacion' => $ubicacion,
            'cc' => $request->area,
        ]);

        return redirect('/auditoria'.'/'.$id)->with('success', 'Auditoría actualizada con éxito.');
    }

    // Método para crear un hallazgo
    public function storeHallazgo(Request $request, $id)
    {
        $auditoria = Auditoria::findOrFail($id);

        $hallazgo = new Hallazgos();
        $hallazgo->auditoria_id = $auditoria->id;
        $hallazgo->fill($request->all());
        $hallazgo->save();

        $usuarios = User::whereIn('colaborador_id', $request->colaborador_id)->get();
        $usuarios_auditoria = User::where('auditoria', 1)->get();

        // Disparar el evento para crear notificaciones
        event(new HallazgoGuardado($hallazgo, $usuarios, $usuarios_auditoria, 'creado'));

        return redirect()->route('auditoria.edit', $id)->with('success', 'Hallazgo creado con éxito.');
    }

    public function editHallazgo($id)
    {
        // Obtener el hallazgo por ID
        $hallazgo = Hallazgos::findOrFail($id);

        $auditoria = Auditoria::findOrFail($hallazgo->auditoria_id);
        // Obtener la lista de colaboradores
        $colaboradores = Colaboradores::all();

        $titulos = ConfigHallazgos::all();

        $comentarios=ComentarioHallazgos::where('id_hallazgo',$id)->with('usuario')->get();

        // Obtener los datos adicionales necesarios (si los hay)

        // ...
        $archivos=HallazgoArchivos::where('id_hallazgo',$id)->get();
        $idcolab=auth()->user()->colaborador_id;

        if(auth()->user()->auditoria=='1'){
            // Pasar los datos a la vista de edición
        return view('auditoria.editar_hallazgo', compact('hallazgo', 'colaboradores','auditoria','titulos','comentarios','archivos'));
        }else{
            // Pasar los datos a la vista de edición
        return view('auditoria.completar_hallazgo', compact('hallazgo', 'colaboradores','auditoria','titulos','comentarios','archivos'));
        }


    }

    public function updateHallazgo(Request $request, $id)
    {
        // Validaciones iniciales
        $request->validate([
            'evidencia.*' => 'nullable|file|max:61440',
            'evidencia_colaborador.*' => 'nullable|file|max:61440',
        ], [
            'evidencia.*.max' => 'Cada archivo no puede ser mayor a 60MB.',
            'evidencia_colaborador.*.max' => 'Cada archivo no puede ser mayor a 60MB.',
        ]);

        // Obtener el hallazgo por ID
        $hallazgo = Hallazgos::findOrFail($id);
        $auditoria = Auditoria::find($hallazgo->auditoria_id);

        if (!$auditoria) {
            return back()->withErrors(['error' => 'Auditoría no encontrada.']);
        }

        // DB::beginTransaction();

        try {
            // Variables para notificaciones
            //$estatusAnterior = $hallazgo->estatus;
            $usuarios = collect();
            $usuarios_auditoria = User::where('auditoria', 1)->get();
            //$estatusnoti = 'actualizado';

            if (auth()->user()->auditoria == '1') {
                // ========== SECCIÓN AUDITOR ==========
                $this->actualizarHallazgoAuditor($request, $hallazgo, $id, $auditoria);

                // Obtener usuarios responsables para notificaciones (solo si se actualizaron)
                if ($request->has('colaborador_id') && is_array($request->colaborador_id)) {
                    $usuarios = User::whereIn('colaborador_id', $request->colaborador_id)->get();
                }

            } else {
                // ========== SECCIÓN AUDITADO ==========
                $this->actualizarHallazgoAuditado($request, $hallazgo, $id, $auditoria);

                // Para auditados, notificar solo a usuarios de auditoría
                //$usuarios = collect(); // No notificar a otros colaboradores desde vista de auditado
                    if ($request->hasFile('evidencia_colaborador')) {
                        $this->notificacionService->notificarEvidenciaRecibida($hallazgo);
                    }
            }

            // Refrescar el modelo para obtener el estado actual
            $hallazgo->refresh();

            // Determinar estatus para la notificación basado en el estado actual
            $estatusnoti = $hallazgo->estatus == 'Cerrado' ? 'cerrado' : 'actualizado';

            // DB::commit();

            // Lanzar el evento UNA SOLA VEZ
            // if ($usuarios->count() > 0 || $usuarios_auditoria->count() > 0) {
            //     event(new HallazgoGuardado($hallazgo, $usuarios, $usuarios_auditoria, $estatusnoti));
            // }

            // Actualización normal - usar sistema existente
            if ($usuarios->count() > 0 || $usuarios_auditoria->count() > 0) {
                event(new HallazgoGuardado($hallazgo, $usuarios, $usuarios_auditoria, 'actualizado'));
            }

            // Redirigir según el tipo de usuario
            if (auth()->user()->auditoria == '1') {
                return redirect('/hallazgo/' . $id . '/edit')->with('success', 'Hallazgo actualizado correctamente.');
            } else {
                return redirect('/auditoria/' . $hallazgo->auditoria_id)->with('success', 'Hallazgo actualizado correctamente.');
            }

        } catch (\Exception $e) {
            // DB::rollback();
            \Log::error('Error en updateHallazgo: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al actualizar hallazgo: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualizar hallazgo desde perspectiva del auditor
     */
    private function actualizarHallazgoAuditor($request, $hallazgo, $id, $auditoria)
    {
        // Actualizar campos del auditor
        $hallazgo->responsable = implode(',', $request->input('colaborador_id', []));
        $hallazgo->jefe = $request->input('jefe');
        $hallazgo->hallazgo = $request->input('hallazgo');
        $hallazgo->fecha_presentacion = $request->input('fecha_presentacion');
        $hallazgo->fecha_compromiso = $request->input('fecha_compromiso');
        $hallazgo->fecha_identificacion = $request->input('fecha_identificacion');
        $hallazgo->tipo = $request->input('tipo');
        $hallazgo->sugerencia = $request->input('sugerencia');
        $hallazgo->plan_de_accion = $request->input('plan_de_accion');
        $hallazgo->estatus = $request->input('estatus', 'Pendiente');
        $hallazgo->respuestaid = auth()->user()->id;
        $hallazgo->respuesta = $request->input('respuesta');
        $hallazgo->titulo = $request->input('titulo');
        $hallazgo->criticidad = $request->input('criticidad');

        // Manejar fecha de cierre
        if ($request->input('estatus') == 'Cerrado') {
            $hallazgo->fecha_cierre = $request->input('fecha_cierre') ?: now();
        }

        // Agregar comentario si existe
        if ($request->filled('comentarios')) {
            $this->agregarComentario($request->input('comentarios'), $id, $hallazgo);
        }

        // Manejar archivos de evidencia del auditor
        if ($request->hasFile('evidencia')) {
            $this->procesarArchivosEvidencia($request->file('evidencia'), $auditoria, $id);
        }

        $hallazgo->save();
    }

    /**
     * Actualizar hallazgo desde perspectiva del auditado
     */
    private function actualizarHallazgoAuditado($request, $hallazgo, $id, $auditoria)
    {
        // Actualizar campos del auditado
        $hallazgo->estatus = 'Pendiente';
        //$hallazgo->respuestaid = auth()->user()->id;
        //$hallazgo->respuesta = 'Respuesta Auditado';

        // Agregar comentario del colaborador si existe
        if ($request->filled('comentarios_colaborador')) {
            $this->agregarComentario($request->input('comentarios_colaborador'), $id, $hallazgo);
        }

        // Manejar eliminación de evidencias
        // if ($request->has('eliminar_evidencias')) {
        //     $this->eliminarEvidencias($request->eliminar_evidencias, $hallazgo);
        // }

        // Manejar archivos de evidencia del colaborador
        if ($request->hasFile('evidencia_colaborador')) {
            $this->procesarArchivosEvidencia($request->file('evidencia_colaborador'), $auditoria, $id);
        }

        $hallazgo->save();
    }

    /**
     * Agregar comentario al hallazgo
     */
    private function agregarComentario($comentario, $hallazgoId, $hallazgo)
    {
        ComentarioHallazgos::create([
            'comentario' => $comentario,
            'id_hallazgo' => $hallazgoId,
            'id_user' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->notificacionService->notificarComentarioHallazgo(auth()->user()->id, $hallazgo);
    }

    /**
     * Procesar archivos de evidencia con validación robusta
     */
    private function procesarArchivosEvidencia($files, $auditoria, $hallazgoId)
    {
        // Asegurar que $files sea un array
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            try {
                // Validar archivo
                if (!$file->isValid()) {
                    \Log::error("Archivo inválido: " . $file->getErrorMessage());
                    continue;
                }

                // Validaciones adicionales
                // $validacion = $this->validarArchivoEvidencia($file);
                // if (!$validacion['valido']) {
                //     \Log::error("Validación fallida: " . $validacion['error']);
                //     continue;
                // }

                // Generar nombre único y seguro
                $nombreOriginal = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $nombreLimpio = $this->limpiarNombreArchivo($nombreOriginal);
                $filename = time() . '_' . uniqid() . '_' . $nombreLimpio . '.' . $extension;

                // Crear registro en la base de datos
                $archivo = new HallazgoArchivos();
                $archivo->id_auditoria = $auditoria->id;
                $archivo->id_hallazgo = $hallazgoId;
                $archivo->id_user = auth()->user()->id;
                $archivo->comentario = $filename;
                $archivo->save();

                // Construir ruta única usando el ID del archivo
                $ruta = "auditorias/{$auditoria->tipo}/{$auditoria->area}/{$auditoria->anio}/{$auditoria->folio}/{$hallazgoId}/{$archivo->id}/";

                // Guardar archivo físicamente
                $rutaCompleta = $this->guardarArchivoSeguro($file, $ruta, $filename);

                // Actualizar registro con ruta final
                // $archivo->ruta_archivo = $ruta . $filename;
                // $archivo->estado = 'guardado';
                // $archivo->save();

                \Log::info("Archivo guardado exitosamente: {$rutaCompleta}");

            } catch (\Exception $e) {
                \Log::error("Error procesando archivo: " . $e->getMessage());

            }
        }
    }

    /**
     * Validar archivo de evidencia
     */
    // private function validarArchivoEvidencia($file)
    // {
    //     $maxSize = 60 * 1024 * 1024; // 60MB
    //     $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
    //     $mimesPermitidos = [
    //         'application/pdf',
    //         'application/msword',
    //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    //         'application/vnd.ms-excel',
    //         'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         'image/jpeg',
    //         'image/png'
    //     ];

    //     if ($file->getSize() > $maxSize) {
    //         return ['valido' => false, 'error' => 'Archivo muy grande. Máximo: 60MB'];
    //     }

    //     $extension = strtolower($file->getClientOriginalExtension());
    //     if (!in_array($extension, $extensionesPermitidas)) {
    //         return ['valido' => false, 'error' => 'Extensión no permitida: ' . $extension];
    //     }

    //     $mimeType = $file->getMimeType();
    //     if (!in_array($mimeType, $mimesPermitidos)) {
    //         return ['valido' => false, 'error' => 'Tipo MIME no válido: ' . $mimeType];
    //     }

    //     return ['valido' => true];
    // }

    /**
     * Limpiar nombre de archivo
     */
    private function limpiarNombreArchivo($nombre)
    {
        $nombreSinExtension = pathinfo($nombre, PATHINFO_FILENAME);
        $nombreLimpio = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $nombreSinExtension);
        return Str::slug($nombreLimpio, '_');
    }


    private function guardarArchivoSeguro($file, $ruta, $filename)
    {
        $rutaCompleta = storage_path('app/' . $ruta);

        // Crear directorio con permisos adecuados
        if (!File::exists($rutaCompleta)) {
            if (!File::makeDirectory($rutaCompleta, 0755, true, true)) {
                throw new \Exception("No se pudo crear directorio: {$rutaCompleta}");
            }
        }

        // permisos de escritura
        if (!is_writable($rutaCompleta)) {
            throw new \Exception("Sin permisos de escritura en: {$rutaCompleta}");
        }

        // Evitar sobrescribir archivos existentes
        $contador = 1;
        $nombreBase = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $archivoFinal = $filename;

        while (File::exists($rutaCompleta . $archivoFinal)) {
            $archivoFinal = $nombreBase . '_' . $contador . '.' . $extension;
            $contador++;
        }

        try {
            if ($file->move($rutaCompleta, $archivoFinal))
            {
                chmod($rutaCompleta . $archivoFinal, 0755);
                return $rutaCompleta . $archivoFinal;
            }
        } catch (\Exception $e) {
            \Log::warning("Error, intentando Storage: " . $e->getMessage());
        }
        throw new \Exception("No se pudo guardar el archivo por ningún método");
    }


    /*Revisar*/
    public function eliminarEvidencia(Request $request, $id)
    {
        try {
            $hallazgo = Hallazgos::findOrFail($id);
            $auditoria = Auditoria::findOrFail($hallazgo->auditoria_id);

            // Obtener el archivo a eliminar
            $archivoAEliminar = $request->input('archivo');

            // Eliminar el archivo del almacenamiento
            $ruta = "auditorias/{$auditoria->tipo}/{$auditoria->area}/{$auditoria->anio}/{$auditoria->folio}/{$archivoAEliminar}";
            if (Storage::disk('public')->exists($ruta)) {
                Storage::disk('public')->delete($ruta);
            }

            // Actualizar la lista de evidencias en la base de datos
            $evidencias = explode(',', $hallazgo->evidencia);
            $evidencias = array_filter($evidencias, fn($evidencia) => $evidencia !== $archivoAEliminar); // Eliminar el archivo de la lista
            $hallazgo->evidencia = implode(',', $evidencias);
            $hallazgo->save();

            return response()->json(['success' => true, 'message' => 'Evidencia eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
    }

    public function reportesAuditoria(Request $request)
    {
        $areasQuery = AreasAuditoria::query();

        // Filtrar por área si se selecciona una específica
        if ($request->filled('area_id') && $request->area_id !== 'all') {
            $areasQuery->where('id', $request->area_id);
        }

        $areas = $areasQuery->get();

        // Fechas por defecto: inicio y fin del mes actual
        $fechaDesde = $request->input('fecha_desde') ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $fechaHasta = $request->input('fecha_hasta') ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');

        $data = $areas->map(function ($area) use ($fechaDesde, $fechaHasta) {
            // Obtener los hallazgos del área con fecha_compromiso en el rango
            $hallazgos = Hallazgos::whereHas('auditoria', function($query) use ($area) {
                    $query->where('area', $area->clave);
                })
                ->whereNotNull('fecha_compromiso')
                ->whereBetween('fecha_compromiso', [$fechaDesde, $fechaHasta])
                ->get();

            // Calcular suma de días de retraso
            $sumaRetraso = 0;

            foreach ($hallazgos as $hallazgo) {
                $fechaCompromiso = \Carbon\Carbon::parse($hallazgo->fecha_compromiso);
                $fechaCierre = $hallazgo->fecha_cierre ? \Carbon\Carbon::parse($hallazgo->fecha_cierre) : \Carbon\Carbon::now();

                $diasRetraso = $fechaCompromiso->diffInDays($fechaCierre, false);

                // Solo contamos si hay retraso (días positivos)
                $sumaRetraso += max(0, $diasRetraso);
            }

            $cantidadHallazgos = $hallazgos->count();
            $promedioRetraso = $cantidadHallazgos > 0 ? $sumaRetraso / $cantidadHallazgos : 0;

            return [
                'nombre' => $area->nombre,
                'clave' => $area->clave,
                'hallazgos_compromiso' => $cantidadHallazgos,
                'suma_dias_retraso' => $sumaRetraso,
                'promedio_retraso' => round($promedioRetraso, 2) // Redondeamos a 2 decimales
            ];
        });

        // Obtener todas las áreas para el select
        $todasAreas = AreasAuditoria::all();

        return view('auditoria.reporte', compact('data', 'todasAreas', 'fechaDesde', 'fechaHasta'));
    }


    public function reporteHallazgos(Request $request)
    {
        // Obtener valores de filtros desde el request
        $area = $request->input('area', 'todas');
        $responsableId = $request->input('responsable', 'todos');
        $jefeId = $request->input('jefe', 'todos');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        // Construir la consulta base
        $hallazgos = Hallazgos::with(['area']); // Solo cargamos la relación 'area'

        // Aplicar filtro por área si es necesario
        if ($area !== 'todas') {
            $hallazgos->whereHas('area', function ($query) use ($area) {
                $query->where('clave', $area);
            });
        }

        // Aplicar filtro por responsable si es necesario
        if ($responsableId !== 'todos') {
            $hallazgos->where(function($query) use ($responsableId) {
                $query->whereRaw("FIND_IN_SET(?, responsable)", [$responsableId]);
            });
        }

        // Aplicar filtro por jefe si es necesario
        if ($jefeId !== 'todos') {
            $hallazgos->where(function($query) use ($jefeId) {
                $query->whereRaw("FIND_IN_SET(?, jefe)", [$jefeId]);
            });
        }

        // Aplicar filtro por fechas si es necesario
        if ($desde) {
            $hallazgos->whereDate('fecha_presentacion', '>=', $desde);
        }

        if ($hasta) {
            $hallazgos->whereDate('fecha_presentacion', '<=', $hasta);
        }

        // Obtener los hallazgos filtrados
        $hallazgosFiltrados = $hallazgos->get();

        // Obtener los IDs de responsables y jefes únicos desde los hallazgos filtrados
        $responsablesIds = $hallazgosFiltrados->flatMap(function ($hallazgo) {
            return explode(',', $hallazgo->responsable);
        })->unique();

        $jefesIds = $hallazgosFiltrados->flatMap(function ($hallazgo) {
            return explode(',', $hallazgo->jefe);
        })->unique();

        // Obtener los colaboradores que coinciden con los IDs extraídos
        $responsables = Colaboradores::whereIn('id', $responsablesIds)->get();
        $jefes = Colaboradores::whereIn('id', $jefesIds)->get();

        // Obtener los datos de los hallazgos filtrados y mapear los resultados
        $data = $hallazgosFiltrados->map(function ($hallazgo) {
            // Obtener nombre del área
            $area = optional($hallazgo->area)->nombre ?? 'Sin área asignada';

            // Obtener clave del área
            $areaClave = optional($hallazgo->area)->clave ?? 'Sin clave asignada';

            // Obtener responsables
            $responsables = $hallazgo->responsables()->map(function ($colaborador) {
                return $colaborador->nombre . ' ' . $colaborador->apellido_paterno;
            })->join(', ');

            // Obtener jefes
            $jefes = $hallazgo->jefes()->map(function ($colaborador) {
                return $colaborador->nombre . ' ' . $colaborador->apellido_paterno;
            })->join(', ');

            // Calcular tiempo abierto
            $fechaPresentacion = Carbon::parse($hallazgo->fecha_presentacion);
            $fechaCierre = $hallazgo->fecha_cierre ? Carbon::parse($hallazgo->fecha_cierre) : Carbon::now();
            $tiempoAbierto = $fechaPresentacion->diffInDays($fechaCierre);

            return [
                'area' => $area,
                'area_clave' => $areaClave,  // Agregamos la clave del área
                'responsables' => $responsables ?: 'Sin responsables',
                'jefes' => $jefes ?: 'Sin jefes',
                'estatus' => $hallazgo->estatus,
                'tiempo_abierto' => $tiempoAbierto . ' días',
            ];
        });

        // Obtener áreas para los selects
        $areas = AreasAuditoria::all();

        return view('auditoria.reportes_hallazgos', compact('data', 'areas', 'responsables', 'jefes'));
    }


    public function configHallazgos()
    {
        // Obtener los hallazgos y las áreas/títulos distintos
        $hallazgos = ConfigHallazgos::orderBy('area')
        ->orderBy('titulo')
        ->orderBy('subtitulo')
        ->get();

        $areas = ConfigHallazgos::distinct()->pluck('area');
        $titulos = ConfigHallazgos::distinct()->pluck('titulo');

        // Pasar los datos a la vista
        return view('auditoria.config-hallazgos', compact('hallazgos', 'areas', 'titulos'));
    }


    public function cerrarHallazgo(Request $request, $id)
    {
        $hallazgo = Hallazgos::findOrFail($id);
        $hallazgo->estatus = 'Cerrado';
        $hallazgo->fecha_cierre = $request->fecha_cierre;
        $hallazgo->save();

        // Hallazgo fue cerrado
        $this->notificacionService->notificarHallazgoValidadoCerrado($hallazgo);

        return redirect()->back()->with('success', 'Hallazgo cerrado con éxito.');
    }


    public function configHallazgosObligatorio(Request $request, $id){
        $hallazgo = ConfigHallazgos::findOrFail($id);
        $hallazgo->obligatorio = $request->input('obligatorio');
        $hallazgo->save();

        return response()->json(['success' => true, 'obligatorio' => $hallazgo->obligatorio]);
    }


    public function getTitulos($areaId)
    {
        $titulos = ConfigHallazgos::where('area_id', $areaId)->get();
        return response()->json($titulos);
    }

    public function storeConfigHallazgo(Request $request)
    {
        // Validar si el área y el título están presentes
        $area = $request->area ?? $request->area_nueva;
        $titulo = $request->titulo ?? $request->titulo_nuevo;
        $tipo = $request->tipo ?? $request->tipo;

        // Usar updateOrCreate para evitar duplicados
        ConfigHallazgos::updateOrCreate(
            [
                'area' => $area, // Condición para buscar el registro
                'titulo' => $titulo, // Condición para buscar el registro
                'subtitulo' => $request->subtitulo, // Condición para buscar el registro
                'tipo' => $request->tipo // Condición para buscar el registro
            ],
            [
                'subtitulo' => $request->subtitulo, // Si no existe, este será el valor para el subtitulo
                'area' => $area, // Si no existe, se inserta también el área
                'titulo' => $titulo, // Si no existe, se inserta también el título
                'tipo' => $tipo // Si no existe, se inserta también el título
            ]);

        // Redirigir a la URL con un mensaje de éxito
        return redirect()->to('/config-hallazgos')
            ->with('success', 'Registro creado o actualizado correctamente.');
    }


    public function updateConfigHallazgo(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
        ]);

        $hallazgo = ConfigHallazgos::findOrFail($id);
        $hallazgo->update($request->only('titulo', 'subtitulo'));

        return response()->json(['success' => true, 'message' => 'Registro actualizado correctamente.']);
    }

    public function destroyConfigHallazgo($id)
    {
        ConfigHallazgos::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Registro eliminado correctamente.']);
    }

    public function reporteFiltrado(Request $request)
    {
        $areas = AreasAuditoria::all();
        $responsables = Hallazgos::with('responsables')
            ->get()
            ->flatMap(fn($hallazgo) => $hallazgo->responsables())
            ->unique('id');

        $jefes = Hallazgos::with('jefes')
            ->get()
            ->flatMap(fn($hallazgo) => $hallazgo->jefes())
            ->unique('id');

        $query = Hallazgos::with(['auditoria.areaAuditoria']);

        // Filtros dinámicos
        if ($request->area && $request->area !== 'todas') {
            $query->whereHas('auditoria.areaAuditoria', fn($q) => $q->where('clave', $request->area));
        }

        if ($request->responsable && $request->responsable !== 'todos') {
            $query->whereRaw("FIND_IN_SET(?, responsable)", [$request->responsable]);
        }

        if ($request->jefe && $request->jefe !== 'todos') {
            $query->whereRaw("FIND_IN_SET(?, jefe)", [$request->jefe]);
        }

        if ($request->desde) {
            $query->where('fecha_presentacion', '>=', $request->desde);
        }

        if ($request->hasta) {
            $query->where('fecha_presentacion', '<=', $request->hasta);
        }

        $hallazgos = $query->get();

        $data = $hallazgos->map(function ($hallazgo) {
            $area = optional($hallazgo->auditoria->areaAuditoria)->nombre ?? 'Sin área asignada';
            $responsables = collect($hallazgo->responsables())
                ->map(fn($colaborador) => $colaborador->nombre . ' ' . $colaborador->apellido_paterno)
                ->join(', ');

            $jefes = collect($hallazgo->jefes())
                ->map(fn($colaborador) => $colaborador->nombre . ' ' . $colaborador->apellido_paterno)
                ->join(', ');

            $fechaPresentacion = Carbon::parse($hallazgo->fecha_presentacion);
            $fechaCierre = $hallazgo->fecha_cierre ? Carbon::parse($hallazgo->fecha_cierre) : Carbon::now();
            $tiempoAbierto = $fechaPresentacion->diffInDays($fechaCierre);

            return [
                'area' => $area,
                'responsables' => $responsables ?: 'Sin responsables',
                'jefes' => $jefes ?: 'Sin jefes',
                'estatus' => $hallazgo->estatus,
                'tiempo_abierto' => $tiempoAbierto . ' días',
            ];
        });

        return view('auditoria.reportes_hallazgos', compact('data', 'areas', 'responsables', 'jefes'));
    }

    public function eliminar_auditoria(Request $request){
        Auditoria::where('id', $request->auditoria_id)->delete();

        return redirect('/auditorias')->with('success', 'La auditoría se eliminó de manera correcta.');
    }

    public function eliminar_hallazgo(Request $request){
        $hallazgo = Hallazgos::where('id', $request->hallazgo_id)->first();
        Hallazgos::where('id', $request->hallazgo_id)->delete();

        return redirect('/auditoria'.'/'.$hallazgo->auditoria_id)
                    ->with('success', 'El hallazgo se eliminó de manera correcta.');
    }

    public function generarReporteDuplicado(Request $request)
    {
        // Obtener filtros del request
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $colaborador_id = $request->input('colaborador_id');

        // Query base para hallazgos
        $query = Hallazgos::query();

        // Filtrar por rango de fecha_presentacion si existe
        if ($fecha_inicio && $fecha_fin) {
            $query->whereBetween('fecha_presentacion', [$fecha_inicio, $fecha_fin]);
        } elseif ($fecha_inicio) {
            $query->where('fecha_presentacion', '>=', $fecha_inicio);
        } elseif ($fecha_fin) {
            $query->where('fecha_presentacion', '<=', $fecha_fin);
        }

        $hallazgos = $query->get();

        $resultado = [];

        foreach ($hallazgos as $hallazgo) {
            $ids = array_filter(array_map('trim', explode(',', $hallazgo->responsable)));

            // Si hay filtro por colaborador, solo procesar ese ID
            if ($colaborador_id) {
                $ids = array_filter($ids, fn($id) => $id == $colaborador_id);
            }

            foreach ($ids as $id) {
                $colaborador = Colaboradores::find($id);

                if ($colaborador) {
                    $clave = $colaborador->id . '||' . $hallazgo->hallazgo;

                    if (!isset($resultado[$clave])) {
                        $resultado[$clave] = [
                            'colaborador' => $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno,
                            'hallazgo' => $hallazgo->hallazgo,
                            'conteo' => 0
                        ];
                    }

                    $resultado[$clave]['conteo'] += 1;
                }
            }
        }

        // Convertir a array indexado
        $datos = array_values($resultado);

        // Ordenar por conteo descendente
        usort($datos, function($a, $b) {
            return $b['conteo'] <=> $a['conteo'];
        });

        // Obtener IDs únicos de colaboradores para el select
        $ids_colaboradores = [];
        foreach ($hallazgos as $hallazgo) {
            $ids = array_filter(array_map('trim', explode(',', $hallazgo->responsable)));
            $ids_colaboradores = array_merge($ids_colaboradores, $ids);
        }
        $ids_colaboradores = array_unique($ids_colaboradores);

        // Obtener colaboradores sólo con esos IDs para el select
        $colaboradores = Colaboradores::whereIn('id', $ids_colaboradores)->orderBy('nombre')->get();

        return view('auditoria.reportes_hallazgos_duplicados', compact('datos', 'colaboradores', 'fecha_inicio', 'fecha_fin', 'colaborador_id'));
    }


}



