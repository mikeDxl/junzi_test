<?php


namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Notificaciones;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
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


    public function notificaciones()
    {

        $notificaciones = Notificaciones::where('email', auth()->user()->email)->orderBy('id', 'DESC')->get();

        return view('notificaciones.index', compact('notificaciones'));

    }

    public function navbar(Request $request)
    {

        $notificaciones = Notificaciones::where('email', auth()->user()->email)
            ->where('abierto', '!=', '2')
            ->where('visto', 0)
            ->where('archivado', 0)
            ->orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json($notificaciones);
    }


    public function show(Request $request)
    {
        $notificaciones = Notificaciones::where('email', auth()->user()->email)
            ->where('abierto', '0')
            ->get();

        $notificacionesArray = [];

        foreach ($notificaciones as $notificacion) {
            $notificacionesArray[] = [
                'texto' => $notificacion->texto,
                'url' => $notificacion->ruta,
                'tipo' => $notificacion->tipo,
            ];
        }

        Notificaciones::where('email', auth()->user()->email)->update(['abierto' => '1']);

        return response()->json($notificacionesArray);
    }

    public function archivadas(Request $request)
    {
        $notificaciones = Notificaciones::where('email', auth()->user()->email)
            ->where('archivado', 1)
            ->orderByDesc('created_at')
            ->get();

        $notificacionesArray = [];

        foreach ($notificaciones as $notificacion) {
            $notificacionesArray[] = [
                'id' => $notificacion->id,
                'texto' => $notificacion->texto,
                'ruta' => $notificacion->ruta,
                'tipo' => $notificacion->tipo,
            ];
        }

        return response()->json($notificacionesArray);
    }

    public function archivar(Request $request)
    {
        $notificacion = Notificaciones::find($request->id);
        if ($notificacion) {
            $notificacion->archivado = 1;
            $notificacion->save();
            return response()->json(['ok' => true]);
        }
        return response()->json(['error' => 'No encontrada'], 404);
    }

    public function eliminar(Request $request)
    {
        $notificacion = Notificaciones::find($request->id);
        if ($notificacion) {
            $notificacion->visto = 1;
            $notificacion->save();
            return response()->json(['ok' => true]);
        }
        return response()->json(['error' => 'No encontrada'], 404);
    }

    
        // =============================================================================
        // ADAPTACIÓN PARA TOAST
        // =============================================================================

        /**
         * obtener notificaciones toast en tiempo real
         */
        public function obtenerToast(Request $request)
        {
            try {
                $lastId = $request->input('last_id', 0);
                $userEmail = auth()->user()->email;

                
                $notificaciones = Notificaciones::where('email', $userEmail)
                    ->where('id', '>', $lastId)
                    ->where('abierto', '0') // No leídas
                    ->orderBy('fecha', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(function($notificacion) {
                        return [
                            'id' => $notificacion->id,
                            'texto' => $notificacion->texto,
                            'descripcion' => '', 
                            'ruta' => $notificacion->ruta,
                            'tipo' => $notificacion->tipo,
                            'created_at' => $notificacion->fecha,
                            'user_id' => auth()->id()
                        ];
                    });

                return response()->json($notificaciones);

            } catch (Exception $e) {
                Log::error('Error al obtener notificaciones toast: ' . $e->getMessage());
                return response()->json([], 500);
            }
        }

        /**
         * Marcar notificación como leída para toast
         */
        public function marcarLeida(Request $request)
        {
            try {
                $notificacionId = $request->input('id');
                $userEmail = auth()->user()->email;

                $notificacion = Notificaciones::where('id', $notificacionId)
                    ->where('email', $userEmail)
                    ->first();

                if ($notificacion) {
                    $notificacion->update(['abierto' => '1']); // Marcar como leída
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Notificación marcada como leída'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Notificación no encontrada'
                ], 404);

            } catch (Exception $e) {
                Log::error('Error al marcar notificación como leída: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }
        }

        /**
         * Archivar notificación 
         */
        public function archivarToast(Request $request)
        {
            try {
                $notificacionId = $request->input('id');
                $userEmail = auth()->user()->email;

                $notificacion = Notificaciones::where('id', $notificacionId)
                    ->where('email', $userEmail)
                    ->first();

                if ($notificacion) {
                    //
                    $notificacion->update(['abierto' => '2']); // 2 = archivada
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Notificación archivada'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Notificación no encontrada'
                ], 404);

            } catch (Exception $e) {
                Log::error('Error al archivar notificación: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }
        }

        // =============================================================================
        // MEJORAR TOAST
        // =============================================================================


        /**
         * Crear notificación mejorada para toast con más información
         */
        private function crearNotificacionMejorada($email, $tipo, $ruta, $texto, $contexto = [])
        {
            $textoMejorado = $this->mejorarTextoNotificacion($texto, $tipo, $contexto);
            
            return Notificaciones::create([
                'email' => $email,
                'tipo' => $tipo,
                'ruta' => $ruta,
                'fecha' => now(),
                'texto' => $textoMejorado,
                'abierto' => '0'
            ]);
        }

        /**
         * Mejorar el texto de las notificaciones
         */
        private function mejorarTextoNotificacion($texto, $tipo, $contexto)
        {
            $prefijos = [
                'success' => '✅ ',
                'warning' => '⚠️ ',
                'danger' => '🚨 ',
                'info' => 'ℹ️ '
            ];

            $prefijo = $prefijos[$tipo] ?? '';
            
            // Si el texto ya tiene emoji, no agregar prefijo
            if (preg_match('/[\x{1F600}-\x{1F6FF}]/u', $texto)) {
                return $texto;
            }
            
            return $prefijo . $texto;
        }

        /**
         * Versiones mejoradas de los métodos existentes para mejor experiencia toast
         */
        public function notificarAsignacionHallazgoMejorado($hallazgo, $responsablesIds)
        {
            $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
            
            foreach ($usuarios as $usuario) {
                if ($usuario->email) {
                    $contexto = [
                        'hallazgo_id' => $hallazgo->id,
                        'fecha_limite' => $hallazgo->fecha_limite,
                        'dias_restantes' => Carbon::parse($hallazgo->fecha_limite)->diffInDays(now())
                    ];
                    
                    $texto = "Nuevo hallazgo asignado - Fecha límite: " . 
                            Carbon::parse($hallazgo->fecha_limite)->format('d/m/Y');
                    
                    $this->crearNotificacionMejorada(
                        $usuario->email,
                        'warning',
                        'hallazgo/' . $hallazgo->id . '/edit',
                        $texto,
                        $contexto
                    );
                }
            }
        }

        public function notificarEvidenciaRecibidaMejorada($hallazgo)
        {
            // Notificar a auditoría
            $usuariosAuditoria = User::where('auditoria', 1)->get();
            
            foreach ($usuariosAuditoria as $usuario) {
                if ($usuario->email) {
                    $this->crearNotificacionMejorada(
                        $usuario->email,
                        'info',
                        'hallazgo/' . $hallazgo->id . '/edit',
                        "Nueva evidencia recibida - Hallazgo #{$hallazgo->id}"
                    );
                }
            }

            // Confirmar al responsable
            $responsablesIds = explode(',', $hallazgo->responsable);
            $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
            
            foreach ($usuarios as $usuario) {
                if ($usuario->email) {
                    $this->crearNotificacionMejorada(
                        $usuario->email,
                        'success',
                        'hallazgo/' . $hallazgo->id . '/edit',
                        "Evidencia enviada correctamente a Auditoría"
                    );
                }
            }
        }

        public function notificarProximoVencimientoMejorado($hallazgo, $diasRestantes)
        {
            $responsablesIds = explode(',', $hallazgo->responsable);
            $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
            
            $tipo = $diasRestantes <= 1 ? 'danger' : 'warning';
            $urgencia = $diasRestantes <= 0 ? 'VENCIDO' : 
                    ($diasRestantes == 1 ? 'ÚLTIMO DÍA' : "$diasRestantes días restantes");
            
            foreach ($usuarios as $usuario) {
                if ($usuario->email) {
                    $texto = "Hallazgo próximo a vencer - $urgencia";
                    
                    $this->crearNotificacionMejorada(
                        $usuario->email,
                        $tipo,
                        'hallazgo/' . $hallazgo->id . '/edit',
                        $texto
                    );
                }
            }
        }

        public function notificarComentarioHallazgoMejorado($userId, $hallazgo)
        {
            $usuarioAuditoria = User::find($userId);
            
            if ($usuarioAuditoria->auditoria == 1) {
                // Notificar a responsables
                $responsablesIds = explode(',', $hallazgo->responsable);
                $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
                
                foreach ($usuarios as $usuario) {
                    if ($usuario->email) {
                        $this->crearNotificacionMejorada(
                            $usuario->email,
                            'info',
                            'hallazgo/' . $hallazgo->id . '/edit',
                            "Nuevo comentario de {$usuarioAuditoria->name} en hallazgo"
                        );
                    }
                }
            } else {
                // Notificar a auditoría
                $usuariosAuditoria = User::where('auditoria', 1)->get();
                
                foreach ($usuariosAuditoria as $usuario) {
                    if ($usuario->email) {
                        $this->crearNotificacionMejorada(
                            $usuario->email,
                            'info',
                            'hallazgo/' . $hallazgo->id . '/edit',
                            "Nuevo comentario de {$usuarioAuditoria->name} en hallazgo"
                        );
                    }
                }
            }
        }

        // =============================================================================
        // MÉTODOS PARA ESTADÍSTICAS DE NOTIFICACIONES
        // =============================================================================

        /**
         * Obtener resumen de notificaciones para dashboard
         */
        public function obtenerResumenNotificaciones($userEmail)
        {
            $hoy = Carbon::now();
            $inicioSemana = $hoy->copy()->startOfWeek();
            
            return [
                'no_leidas' => Notificaciones::where('email', $userEmail)
                                        ->where('abierto', '0')
                                        ->count(),
                'esta_semana' => Notificaciones::where('email', $userEmail)
                                            ->where('fecha', '>=', $inicioSemana)
                                            ->count(),
                'urgentes' => Notificaciones::where('email', $userEmail)
                                        ->where('abierto', '0')
                                        ->where('tipo', 'danger')
                                        ->count()
            ];
        }

        /**
         * Limpiar notificaciones antiguas (ejecutar periódicamente)
         */
        public function limpiarNotificacionesAntiguas($diasAntiguedad = 30)
        {
            $fechaLimite = Carbon::now()->subDays($diasAntiguedad);
            
            return Notificaciones::where('fecha', '<', $fechaLimite)
                                ->where('abierto', '1') // Solo las ya leídas
                                ->delete();
        }


    // public function marcarTodasLeidas(Request $request)
    // {
    //     try {
    //         $userId = Notificaciones::find($request->id);

    //         // Usando modelo Eloquent
    //         $updated = Notificaciones::where('id', $userId)
    //             ->whereNull('visto') // o where('visto', false)
    //             ->update(['visto' => 1]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => "Se marcaron {$updated} notificaciones como leídas",
    //             'updated_count' => $updated
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al marcar las notificaciones como leídas',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


}
