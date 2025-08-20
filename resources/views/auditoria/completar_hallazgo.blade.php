@extends('home', ['activePage' => 'Hallazgos', 'menuParent' => 'auditoria', 'titlePage' => __('Completar Hallazgo')])

@section('contentJunzi')
<style>
/* Animaciones personalizadas */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.chat-message {
    animation: slideIn 0.3s ease-out;
}

.card-enter {
    animation: fadeIn 0.5s ease-out;
}

/* Estados de focus mejorados */
input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

/* Efectos para botones */
button {
    transition: all 0.2s ease-in-out;
}

button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

button:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Scrollbar personalizado */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Efectos de hover para las cards de archivos */
.file-card {
    transition: all 0.3s ease;
}

.file-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Animaciones de notificación */
.notification-enter {
    animation: notificationSlideIn 0.5s ease-out;
}

.notification-exit {
    animation: notificationSlideOut 0.3s ease-in;
}

@keyframes notificationSlideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes notificationSlideOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .chat-message {
        max-width: 85%;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 mt-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Header con información del hallazgo -->
        <div class="bg-gradient-to-r from-teal-600 via-teal-700 to-cyan-700 rounded-t-xl shadow-xl mb-8">
            <div class="px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-3xl font-bold text-white">Completar Hallazgo</h1>
                            <p class="text-white text-lg mt-1">
                                ID: {{ $hallazgo->id }} | Estado: 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $hallazgo->estatus }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-right">
                            <p class="text-white text-sm opacity-80">Auditoría</p>
                            <p class="text-white font-semibold">{{ $auditoria->tipo }}-{{ $auditoria->area }}-{{ $auditoria->anio }}-{{ $auditoria->folio }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor principal -->
        <div class="bg-white rounded-b-xl shadow-xl overflow-hidden">
            <!-- Información del hallazgo -->
            <div class="px-6 py-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Información del Hallazgo
                </h2>

                <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/4">
                                        👤 Jefe Responsable
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium" colspan="3">
                                        {{ qcolab($hallazgo->jefe) }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ⚠️ Hallazgo
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                            {!! nl2br(e($hallazgo->hallazgo)) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        💡 Sugerencia
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                            {!! nl2br(e($hallazgo->sugerencia)) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        📋 Plan de Acción
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                            {!! nl2br(e($hallazgo->plan_de_accion)) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        📅 Fecha Presentación
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ \Carbon\Carbon::parse($hallazgo->fecha_presentacion)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        🎯 Fecha Compromiso
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ \Carbon\Carbon::parse($hallazgo->fecha_compromiso)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        🔍 Fecha Identificación
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ \Carbon\Carbon::parse($hallazgo->fecha_identificacion)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                       📄 Respuesta
                                    </th>
                                    @if(!empty($hallazgo->respuesta))
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' 
                                        : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $hallazgo->respuesta }}
                                        </span>
                                    </td>
                                    @else
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' 
                                        : 'bg-yellow-100 text-yellow-800' }}">
                                            Sin respuesta
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        🏷️ Tipo
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $hallazgo->tipo == 'Operativo' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $hallazgo->tipo }}
                                        </span>
                                    </td>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        📊 Estatus
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $hallazgo->estatus }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    🎯 Criticidad
                                </th>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    @php
                                        $criticidicadInfo = match(strtolower($hallazgo->criticidad ?? '')) {
                                            'baja' => [
                                                'class' => 'bg-green-100 text-green-800 border-green-300',
                                                'icon' => '🟢',
                                                'text' => 'Baja',
                                                'desc' => 'Impacto mínimo en las operaciones'
                                            ],
                                            'media' => [
                                                'class' => 'bg-yellow-100 text-yellow-800 border-yellow-300', 
                                                'icon' => '🟡',
                                                'text' => 'Media',
                                                'desc' => 'Impacto moderado, requiere atención'
                                            ],
                                            'alta' => [
                                                'class' => 'bg-red-100 text-red-800 border-red-300',
                                                'icon' => '🔴', 
                                                'text' => 'Alta',
                                                'desc' => 'Impacto severo, requiere acción inmediata'
                                            ],
                                            default => [
                                                'class' => 'bg-gray-100 text-gray-800 border-gray-300',
                                                'icon' => '⚪',
                                                'text' => 'No definida',
                                                'desc' => 'Sin nivel de criticidad asignado'
                                            ]
                                        };
                                    @endphp
                                    
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $criticidicadInfo['class'] }}">
                                            {{ $criticidicadInfo['icon'] }} {{ $criticidicadInfo['text'] }}
                                        </span>
                                        
                                    </div>
                                </td>
                                
                                <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    📊 Prioridad
                                </th>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    @php
                                        $prioridadInfo = match(strtolower($hallazgo->criticidad ?? '')) {
                                            'alta' => [
                                                'class' => 'bg-red-50 text-red-700 border-red-200',
                                                'icon' => '🔥',
                                                'text' => 'Urgente'
                                            ],
                                            'media' => [
                                                'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'icon' => '⏰',
                                                'text' => 'Importante'
                                            ],
                                            'baja' => [
                                                'class' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'icon' => '📝',
                                                'text' => 'Normal'
                                            ],
                                            default => [
                                                'class' => 'bg-gray-50 text-gray-700 border-gray-200',
                                                'icon' => '❓',
                                                'text' => 'Sin definir'
                                            ]
                                        };
                                    @endphp
                                    
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $prioridadInfo['class'] }}">
                                        {{ $prioridadInfo['icon'] }} {{ $prioridadInfo['text'] }}
                                    </span>
                                </td>
                            </tr>
                                <!-- Comentarios de Auditoría -->
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        💬 Comentarios Auditoría
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">
                                        <div class="bg-blue-50 rounded-lg p-4 max-h-64 overflow-y-auto">
                                            <div class="space-y-3">
                                                @foreach ($comentarios as $comentario)
                                                    @if($comentario->id_user != auth()->user()->id)
                                                        <div class="chat-message flex justify-start">
                                                            <div class="max-w-[80%] bg-white border border-blue-200 rounded-2xl rounded-bl-none px-4 py-3 shadow-sm">
                                                                <div class="flex items-center mb-2">
                                                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                                        <span class="text-xs font-bold text-white">
                                                                            {{ substr($comentario->usuario->name, 0, 2) }}
                                                                        </span>
                                                                    </div>
                                                                    <strong class="text-blue-700 text-sm">{{ $comentario->usuario->name }}</strong>
                                                                </div>
                                                                <p class="text-gray-700 text-sm break-words">
                                                                    {!! nl2br(e($comentario->comentario)) !!}
                                                                </p>
                                                                <div class="text-xs text-gray-500 mt-2">
                                                                    {{ $comentario->created_at->format('d/m/Y H:i') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($comentarios->where('id_user', '!=', auth()->user()->id)->count() == 0)
                                                    <div class="text-center py-4">
                                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                        <p class="text-gray-500 text-sm mt-2">Sin comentarios de auditoría</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Comentarios del Usuario -->
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        📝 Mis Comentarios
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">
                                        <div class="bg-green-50 rounded-lg p-4 max-h-64 overflow-y-auto">
                                            <div class="space-y-3">
                                                @foreach ($comentarios as $comentario)
                                                    @if($comentario->id_user == auth()->user()->id)
                                                        <div class="chat-message flex justify-end">
                                                            <div class="max-w-[80%] bg-green-500 text-white rounded-2xl rounded-br-none px-4 py-3 shadow-sm">
                                                                <div class="flex items-center mb-2 justify-end">
                                                                    <strong class="text-green-100 text-sm">{{ $comentario->usuario->name }}</strong>
                                                                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center ml-2">
                                                                        <span class="text-xs font-bold text-white">
                                                                            {{ substr($comentario->usuario->name, 0, 2) }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <p class="text-white text-sm break-words text-right">
                                                                    {!! nl2br(e($comentario->comentario)) !!}
                                                                </p>
                                                                <div class="text-xs text-green-200 mt-2 text-right">
                                                                    {{ $comentario->created_at->format('d/m/Y H:i') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($comentarios->where('id_user', auth()->user()->id)->count() == 0)
                                                    <div class="text-center py-4">
                                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                        <p class="text-gray-500 text-sm mt-2">Aún no has agregado comentarios</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulario de respuesta -->
            <form action="{{ route('hallazgo.update', $hallazgo->id) }}" method="post" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Sección: Agregar comentario -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Agregar Comentario
                    </h2>

                    <div>
                        <label for="comentarios" class="block text-sm font-semibold text-gray-700 mb-2">
                            💬 Tu Respuesta
                        </label>
                        <textarea id="comentarios" name="comentarios_colaborador" rows="5" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 resize-none"
                            placeholder="Escribe tu comentario o respuesta al hallazgo..."></textarea>
                        <p class="mt-2 text-sm text-gray-500">Describe las acciones tomadas o proporciona una respuesta al hallazgo identificado.</p>
                    </div>
                </div>

                <!-- Sección: Evidencias -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Gestión de Evidencias
                    </h2>

                    <!-- Evidencias de Auditoría -->
                    @if($archivos && $archivos->where('id_user', '!=', auth()->user()->id)->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Evidencias de Auditoría ({{ $archivos->where('id_user', '!=', auth()->user()->id)->count() }})
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($archivos->where('id_user', '!=', auth()->user()->id) as $archivo)
                                <div class="file-card bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200 hover:shadow-lg transition-all duration-200">
                                    <!-- Header con ícono de tipo de archivo -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            @php
                                                $extension = pathinfo($archivo->comentario, PATHINFO_EXTENSION);
                                                $iconColor = match(strtolower($extension)) {
                                                    'pdf' => 'text-red-500',
                                                    'doc', 'docx' => 'text-blue-500',
                                                    'xls', 'xlsx' => 'text-green-500',
                                                    'jpg', 'jpeg', 'png' => 'text-purple-500',
                                                    default => 'text-gray-500'
                                                };
                                            @endphp
                                            <svg class="w-8 h-8 {{ $iconColor }} mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                                {{ strtoupper($extension ?: 'archivo') }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Auditoría
                                        </span>
                                    </div>

                                    <!-- Nombre del archivo con manejo de overflow -->
                                    <div class="mb-4">
                                        <a href="{{ asset('storage/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank" 
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm leading-tight block group"
                                        title="{{ $archivo->comentario }}">
                                            <span class="line-clamp-2 break-words group-hover:underline">
                                                {{ $archivo->comentario }}
                                            </span>
                                        </a>
                                        <p class="text-xs text-blue-500 mt-2">Subido por auditoría</p>
                                    </div>

                                    <!-- Información de fecha y hora -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-blue-100">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $archivo->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $archivo->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Botón de descarga -->
                                    <div class="mt-4">
                                        <a href="{{ asset('storage/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-blue-300 rounded-lg shadow-sm bg-white text-sm font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Ver/Descargar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Mis evidencias existentes -->
                    @if($archivos && $archivos->where('id_user', auth()->user()->id)->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mis Evidencias ({{ $archivos->where('id_user', auth()->user()->id)->count() }})
                        </h3>
                        <div id="existing-files" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($archivos->where('id_user', auth()->user()->id) as $archivo)
                                <div class="file-card bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200 hover:shadow-lg transition-all duration-200" id="archivo-{{ $archivo->id }}">
                                    <!-- Header con ícono de tipo de archivo -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            @php
                                                $extension = pathinfo($archivo->comentario, PATHINFO_EXTENSION);
                                                $iconColor = match(strtolower($extension)) {
                                                    'pdf' => 'text-red-500',
                                                    'doc', 'docx' => 'text-blue-500',
                                                    'xls', 'xlsx' => 'text-green-500',
                                                    'jpg', 'jpeg', 'png' => 'text-purple-500',
                                                    default => 'text-gray-500'
                                                };
                                            @endphp
                                            <svg class="w-8 h-8 {{ $iconColor }} mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                                {{ strtoupper($extension ?: 'archivo') }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Mi archivo
                                        </span>
                                    </div>

                                    <!-- Nombre del archivo con manejo de overflow -->
                                    <div class="mb-4">
                                        <a href="{{ asset('storage/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank" 
                                        class="text-green-600 hover:text-green-800 font-medium text-sm leading-tight block group"
                                        title="{{ $archivo->comentario }}">
                                            <span class="line-clamp-2 break-words group-hover:underline">
                                                {{ $archivo->comentario }}
                                            </span>
                                        </a>
                                        <p class="text-xs text-green-500 mt-2">📁 Subido por mí</p>
                                    </div>

                                    <!-- Información de fecha y hora -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-green-100">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $archivo->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $archivo->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Botón de descarga -->
                                    <div class="mt-4">
                                        <a href="{{ asset('storage/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank"
                                        download="{{ $archivo->comentario }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 rounded-lg shadow-sm bg-white text-sm font-medium text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Ver/Descargar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Subir nuevas evidencias -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Subir Nueva Evidencia
                        </h3>
                        
                        <div id="file-inputs" class="space-y-4">
                            <div class="file-input-container">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="evidencia_colaborador[]" 
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    <button type="button" id="add-file" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Agregar Archivo
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-blue-800">Información sobre archivos</h4>
                                    <ul class="mt-1 text-sm text-blue-700 list-disc list-inside">
                                        <li>Tamaño máximo por archivo: 60MB</li>
                                        {{-- <li>Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG</li> --}}
                                        <li>Puedes subir múltiples archivos como evidencia</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de actualización -->
                <div class="px-6 py-8">
                    <div class="flex justify-center">
                        <button type="submit" id="submit-btn"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Actualizar Hallazgo
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contenedor para notificaciones -->
        <div id="notification-container" class="fixed top-4 right-4 z-50 max-w-sm space-y-2">
            <!-- Las notificaciones se insertarán aquí dinámicamente -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Variables globales
    let fileCounter = 1;
    let hasUnsavedChanges = false;

    // Configurar validación de archivos
    function setupFileValidation(input) {
        input.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const maxSize = 60 * 1024 * 1024; // 60MB

            let hasErrors = false;
            files.forEach(file => {
                if (file.size > maxSize) {
                    showNotification(`El archivo "${file.name}" es demasiado grande. Máximo: 60MB`, 'error');
                    hasErrors = true;
                }
            });

            if (hasErrors) {
                this.value = '';
            } else if (files.length > 0) {
                showNotification(`Archivo "${files[0].name}" seleccionado correctamente.`, 'success');
                hasUnsavedChanges = true;
            }
        });
    }

    // Aplicar validación a inputs existentes
    document.querySelectorAll('input[type="file"]').forEach(setupFileValidation);

    // Manejar botón de agregar archivo
    const addFileBtn = document.getElementById('add-file');
    if (addFileBtn) {
        addFileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón agregar archivo clickeado');
            
            const fileInputs = document.getElementById('file-inputs');
            if (!fileInputs) {
                console.error('No se encontró el contenedor file-inputs');
                return;
            }

            fileCounter++;
            const newFileContainer = document.createElement('div');
            newFileContainer.className = 'file-input-container';
            newFileContainer.innerHTML = `
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex-1">
                        <input type="file" name="evidencia_colaborador[]" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <button type="button" class="remove-file inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar
                    </button>
                </div>
            `;
            
            fileInputs.appendChild(newFileContainer);
            
            // Agregar evento al botón de eliminar
            const removeBtn = newFileContainer.querySelector('.remove-file');
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    newFileContainer.remove();
                    showNotification('Campo de archivo eliminado', 'info');
                });
            }
            
            // Agregar validación al nuevo input
            const newFileInput = newFileContainer.querySelector('input[type="file"]');
            if (newFileInput) {
                setupFileValidation(newFileInput);
            }
            
            showNotification('Nuevo campo de archivo agregado', 'success');
        });
    }

    // Manejar envío del formulario
    const submitBtn = document.getElementById('submit-btn');
    const form = submitBtn?.closest('form');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Deshabilitar botón y mostrar loading
            submitBtn.disabled = true;
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Actualizando...
            `;
            
            // Marcar como guardado
            hasUnsavedChanges = false;
            
            // Reactivar después de 10 segundos por seguridad
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
            }, 10000);
        });
    }

    // Validación del textarea
    const textarea = document.getElementById('comentarios');
    if (textarea) {
        textarea.addEventListener('input', function() {
            const charCount = this.value.length;
            hasUnsavedChanges = true;
            
            if (charCount > 1000) {
                showNotification('El comentario es muy largo. Máximo 1000 caracteres.', 'error');
            }
        });
    }

    // Detectar cambios en inputs
    document.querySelectorAll('input, textarea, select').forEach(element => {
        element.addEventListener('input', () => {
            hasUnsavedChanges = true;
        });
    });

    // Confirmación antes de salir si hay cambios sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Auto-scroll al final del chat si hay mensajes
    const chatContainers = document.querySelectorAll('.overflow-y-auto');
    chatContainers.forEach(container => {
        if (container.children.length > 0) {
            container.scrollTop = container.scrollHeight;
        }
    });

    // Animaciones de entrada para las cards
    const cards = document.querySelectorAll('.file-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Función para mostrar notificaciones
function showNotification(message, type = 'success') {
    const container = document.getElementById('notification-container');
    if (!container) {
        console.error('Contenedor de notificaciones no encontrado');
        return;
    }

    const notification = document.createElement('div');
    
    // Configurar clases según el tipo
    let bgColor, textColor, iconPath;
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            textColor = 'text-white';
            iconPath = 'M5 13l4 4L19 7';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            textColor = 'text-white';
            iconPath = 'M6 18L18 6M6 6l12 12';
            break;
        case 'info':
            bgColor = 'bg-blue-500';
            textColor = 'text-white';
            iconPath = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
            break;
        default:
            bgColor = 'bg-gray-500';
            textColor = 'text-white';
            iconPath = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    }
    
    notification.className = `${bgColor} ${textColor} p-4 rounded-lg shadow-lg notification-enter`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path>
            </svg>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove después de 5 segundos
    setTimeout(() => {
        notification.classList.add('notification-exit');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}
</script>

@endpush