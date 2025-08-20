<?php

namespace App\Services;

use App\Models\Notificaciones;
use App\Models\User;
use App\Models\Colaboradores;
use App\Models\Hallazgos;
use App\Models\Auditoria;
use Carbon\Carbon;

class NotificacionesAuditoriaService
{
    /**
     * Crear notificación cuando se asigna un hallazgo
     */
    public function notificarAsignacionHallazgo($hallazgo, $responsablesIds)
    {
        $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
        
        foreach ($usuarios as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'warning', // Color amarillo para asignaciones
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Se te ha asignado un hallazgo de auditoría con fecha límite: " . 
                              Carbon::parse($hallazgo->fecha_limite)->format('d/m/Y') . 
                              ". Descripción: " . substr($hallazgo->hallazgo, 0, 50) . "...",
                    'abierto' => '0'
                ]);
            }
        }
    }

    /**
     * Notificar cuando se carga evidencia por parte del usuario auditado
     */
    public function notificarEvidenciaRecibida($hallazgo)
    {
        // Notificar a usuarios de auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'info', // Color azul para información
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Evidencia recibida, pendiente de validación.",
                    'abierto' => '0'
                ]);
            }
        }

        // Confirmar al usuario que envió la evidencia
        $responsablesIds = explode(',', $hallazgo->responsable);
        $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
        
        foreach ($usuarios as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'success', // Color verde para confirmación
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Tu evidencia ha sido enviada al área de Auditoría",
                    'abierto' => '0'               
                    ]);
            }
        }
    }

    /**
     * Notificar cuando se acerca el vencimiento del hallazgo
     */
    public function notificarProximoVencimiento($hallazgo, $diasRestantes)
    {
        $responsablesIds = explode(',', $hallazgo->responsable);
        $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
        
        $tipoNotificacion = $diasRestantes <= 1 ? 'danger' : 'warning';
        
        foreach ($usuarios as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => $tipoNotificacion,
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo aún sin subsanar. " . 
                              ($diasRestantes > 0 ? "Quedan $diasRestantes días" : "Vencido") . 
                              ". Lista de pendientes disponible.",
                    'abierto' => '0'
                ]);
            }
        }

        // Notificar también a auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => $tipoNotificacion,
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo aún sin subsanar en lista de pendientes",
                    'abierto' => '0'
                ]);
            }
        }
    }

    /**
     * Notificar cuando el hallazgo vence sin atención
     */
    public function notificarHallazgoVencido($hallazgo)
    {
        $responsablesIds = explode(',', $hallazgo->responsable);
        $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
        
        foreach ($usuarios as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'danger', // Color rojo para urgente
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo vencido: acción requerida. Posible copia a jefatura",
                    'abierto' => '0'
               ]);
            }
        }

        // Notificar a auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'danger',
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo vencido sin respuesta del área",
                    'abierto' => '0'
                ]);
            }
        }
    }


    /**
     *Notificar cuando se hagan comentarios
    */
    public function notificarComentarioHallazgo($userId, $hallazgo)
    {
        // Notificar a usuarios de un nuevo comentario
        $usuarioAuditoria = User::find($userId);
        //dd($usuariosAuditoria);
        if($usuarioAuditoria->auditoria == 1){
            // Confirmar al usuario que comento
            $responsablesIds = explode(',', $hallazgo->responsable);
            $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
            
            foreach ($usuarios as $usuario) {
                if ($usuario->email) {
                    Notificaciones::create([
                        'email' => $usuario->email,
                        'tipo' => 'success', // Color verde para confirmación
                        'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                        'fecha' => now(),
                        'texto' => 'El usuario ' .$usuarioAuditoria->name. ' ha realizado un comentario.',
                        'abierto' => '0'               
                        ]);
                }
            }
        }else{

        $usuariosAuditoria = User::where('auditoria', 1)->get();

        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
            Notificaciones::create([
                'email' => $usuario->email,
                'tipo' => 'info', // Color azul para información
                'ruta' => 'hallazgo/' . $hallazgo->id. '/edit',
                'fecha' => now(),
                'texto' => 'El usuario ' .$usuarioAuditoria->name. ' ha realizado un comentario.',
                'abierto' => '0'
            ]);
           }
         }
       }
    }

    /**
     * Notificar cuando se valida y cierra el hallazgo
     */
    public function notificarHallazgoValidadoCerrado($hallazgo)
    {
        $responsablesIds = explode(',', $hallazgo->responsable);
        $usuarios = User::whereIn('colaborador_id', $responsablesIds)->get();
        
        foreach ($usuarios as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'success', // Color verde para éxito
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo cerrado exitosamente" . 
                              ($hallazgo->comentarios_colaborador ? " con comentario: " . substr($hallazgo->comentarios_colaborador, 0, 50) . "..." : ""),
                    'abierto' => '0'
                ]);
            }
        }

        // Notificar a auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'success',
                    'ruta' => 'hallazgo/' . $hallazgo->id . '/edit',
                    'fecha' => now(),
                    'texto' => "Hallazgo validado y cerrado",
                    'abierto' => '0'
               ]);
            }
        }
    }

    /**
     * Notificar cuando no se recibe reporte de control periódico
     */
    public function notificarControlPeriodicoNoRecibido($area, $fechaLimite)
    {
        // Obtener colaboradores del área específica
        $colaboradoresArea = Colaboradores::where('area', 'like', "%$area%")
                                         ->where('estatus', 'activo')
                                         ->get();
        
        $usuariosArea = User::whereIn('colaborador_id', $colaboradoresArea->pluck('id'))->get();
        
        foreach ($usuariosArea as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'warning',
                    'ruta' => 'controles-periodicos',
                    'fecha' => now(),
                    'texto' => "Entrega pendiente: [nombre del control] con fecha límite " . 
                              Carbon::parse($fechaLimite)->format('d/m/Y'),
                    'abierto' => '0'
                ]);
            }
        }

        // Notificar a auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'info',
                    'ruta' => 'controles-periodicos',
                    'fecha' => now(),
                    'texto' => "Control no entregado por [$area]",
                    'abierto' => '0'
                ]);
            }
        }
    }

    /**
     * Notificar cuando se recibe reporte de control en tiempo
     */
    public function notificarControlPeriodicoRecibido($area, $nombreDocumento)
    {
        // Notificar a auditoría
        $usuariosAuditoria = User::where('auditoria', 1)->get();
        
        foreach ($usuariosAuditoria as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'success',
                    'ruta' => 'controles-periodicos',
                    'fecha' => now(),
                    'texto' => "Documento recibido para revisión: $nombreDocumento",
                    'abierto' => '0'
               ]);
            }
        }

        // Confirmar al área que envió
        $colaboradoresArea = Colaboradores::where('area', 'like', "%$area%")
                                         ->where('estatus', 'activo')
                                         ->get();
        
        $usuariosArea = User::whereIn('colaborador_id', $colaboradoresArea->pluck('id'))->get();
        
        foreach ($usuariosArea as $usuario) {
            if ($usuario->email) {
                Notificaciones::create([
                    'email' => $usuario->email,
                    'tipo' => 'success',
                    'ruta' => 'controles-periodicos',
                    'fecha' => now(),
                    'texto' => "Tu entrega fue recibida por Auditoría",
                    'abierto' => '0'
                ]);
            }
        }
    }

    /**
     * Programar notificaciones automáticas para hallazgos próximos a vencer
     * Este método se ejecutaría diariamente via cron job
     */
    public function verificarVencimientosProximos()
    {
        $hoy = Carbon::now();
        $hallazgosPendientes = Hallazgos::where('estatus', 'Pendiente')
                                      ->whereNotNull('fecha_limite')
                                      ->get();

        foreach ($hallazgosPendientes as $hallazgo) {
            $fechaLimite = Carbon::parse($hallazgo->fecha_limite);
            $diasRestantes = $hoy->diffInDays($fechaLimite, false);

            // Notificar 3 días antes, 1 día antes y el día del vencimiento
            if (in_array($diasRestantes, [3, 1, 0])) {
                $this->notificarProximoVencimiento($hallazgo, $diasRestantes);
            }

            // Notificar si ya venció
            if ($diasRestantes < 0) {
                $this->notificarHallazgoVencido($hallazgo);
            }
        }
    }

    /**
     * Obtener estadísticas del dashboard
     */
    public function obtenerEstadisticasDashboard()
    {
        $hoy = Carbon::now();
        $inicioMes = $hoy->copy()->startOfMonth();
        $finMes = $hoy->copy()->endOfMonth();

        // Auditorías del mes
        $auditoriasProgramadas = Auditoria::whereBetween('fecha_alta', [$inicioMes, $finMes])->count();
        $auditoriasRealizadas = Auditoria::whereBetween('fecha_alta', [$inicioMes, $finMes])
                                       ->whereHas('hallazgos')->count();

        // Hallazgos activos
        $hallazgosActivos = Hallazgos::where('estatus', 'Pendiente')->count();

        // Hallazgos vencidos sin respuesta
        $hallazgosVencidos = Hallazgos::where('estatus', 'Pendiente')
                                    ->whereDate('fecha_limite', '<', $hoy)
                                    ->count();

        // Hallazgos subsanados (cerrados en el mes)
        $hallazgosSubsanados = Hallazgos::where('estatus', 'Cerrado')
                                      ->whereBetween('fecha_cierre', [$inicioMes, $finMes])
                                      ->count();

        return [
            'auditorias_mes' => [
                'realizadas' => $auditoriasRealizadas,
                'programadas' => $auditoriasProgramadas
            ],
            'hallazgos_activos' => $hallazgosActivos,
            'hallazgos_vencidos' => $hallazgosVencidos,
            'hallazgos_subsanados' => $hallazgosSubsanados
        ];
    }

}

    // Trait para usar en el controlador existente
    trait NotificacionesTrait
    {
        protected $notificacionService;

        public function __construct()
        {
            parent::__construct();
            $this->notificacionService = new NotificacionesAuditoriaService();
        }

        /**
         * Integrar notificaciones en el método crear_hallazgo existente
         */
        protected function enviarNotificacionesCrearHallazgo($hallazgoNew, $responsablesemail)
        {
            // Reemplazar el código existente de notificaciones con:
            $this->notificacionService->notificarAsignacionHallazgo($hallazgoNew, $responsablesemail);
        }

        /**
         * Integrar notificaciones en el método updateHallazgo existente
         */
        protected function enviarNotificacionesUpdateHallazgo($hallazgo, $estatusnoti, $usuarios, $usuarios_auditoria)
        {
            switch ($estatusnoti) {
                case 'cerrado':
                    $this->notificacionService->notificarHallazgoValidadoCerrado($hallazgo);
                    break;
                
                case 'evidencia_recibida':
                    // Si se subió evidencia por parte del auditado
                    $this->notificacionService->notificarEvidenciaRecibida($hallazgo, 'Evidencia adjunta');
                    break;
                    
                default:
                    // Mantener el sistema existente para otros casos
                    if ($usuarios->count() > 0 || $usuarios_auditoria->count() > 0) {
                        event(new HallazgoGuardado($hallazgo, $usuarios, $usuarios_auditoria, $estatusnoti));
                    }
                    break;
            }
        }
    }

    // Comando Artisan para ejecutar verificaciones diarias
    // php artisan make:command VerificarVencimientosHallazgos

    /*
    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use App\Services\NotificacionesAuditoriaService;

    class VerificarVencimientosHallazgos extends Command
    {
        protected $signature = 'hallazgos:verificar-vencimientos';
        protected $description = 'Verificar hallazgos próximos a vencer y enviar notificaciones';

        public function handle()
        {
            $service = new NotificacionesAuditoriaService();
            $service->verificarVencimientosProximos();
            
            $this->info('Verificación de vencimientos completada');
        }
    }
*/