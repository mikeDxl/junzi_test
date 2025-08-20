@extends('home', ['activePage' => 'Hallazgos', 'menuParent' => 'auditoria', 'titlePage' => __('Editar Hallazgo')])

@section('contentJunzi')
<style>
/* CSS optimizado - solo estilos críticos */
.chat-message { animation: slideIn 0.3s ease-out; }
@keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

/* Estados de focus simplificados */
input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Estilos específicos para el campo criticidad en edición */
#criticidad {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Opciones del select criticidad con colores */
#criticidad option[value="baja"] {
    background-color: #f0fdf4;
    color: #15803d;
}

#criticidad option[value="media"] {
    background-color: #fefce8;
    color: #a16207;
}

#criticidad option[value="alta"] {
    background-color: #fef2f2;
    color: #dc2626;
}

/* Indicador visual para el campo criticidad cuando está seleccionado */
#criticidad[data-selected="baja"] {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

#criticidad[data-selected="media"] {
    border-color: #eab308;
    box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.1);
}

#criticidad[data-selected="alta"] {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Animación suave para transiciones */
#criticidad {
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

/* Estilos para el indicador de criticidad actual */
#criticidad-info {
    transition: all 0.3s ease-in-out;
}

/* Estilos dinámicos que se aplicarán con JavaScript */
.criticidad-updated {
    animation: criticidicadPulse 0.6s ease-out;
}

@keyframes criticidicadPulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.02);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Efectos de botones simplificados */
button { transition: all 0.2s ease; }
button:hover:not(:disabled) { transform: translateY(-1px); }

/* Scrollbar minimalista */
.overflow-y-auto::-webkit-scrollbar { width: 4px; }
.overflow-y-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }

/* Notificaciones optimizadas */
.notification-enter { animation: slideInNotif 0.3s ease; }
@keyframes slideInNotif { from { transform: translateX(100%); } to { transform: translateX(0); } }

/* Responsive básico */
@media (max-width: 768px) { .chat-message { max-width: 90%; } }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 mt-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Header simplificado -->
        <div class="bg-gradient-to-r from-teal-600 to-cyan-700 rounded-xl shadow-lg mb-6">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-3xl font-bold text-white">Editar Hallazgo</h1>
                            <p class="text-white text-lg mt-1">
                                {{-- ID: {{ $hallazgo->id }} | Estado:  --}}
                                Estado: 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $hallazgo->estatus }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="hidden sm:block text-right">
                        <p class="text-sm  text-white">{{ $auditoria->tipo }}-{{ $auditoria->area }}-{{ $auditoria->anio }}-{{ $auditoria->folio }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas de errores optimizadas -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
            <h3 class="text-red-800 font-medium">Errores encontrados:</h3>
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario principal -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('hallazgo.update', $hallazgo->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Sección 1: Información básica -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Hallazgo
                    </h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Colaboradores -->
                        <div>
                            <label for="colaborador_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Colaboradores Responsables
                            </label>
                            <select id="colaborador_name" name="colaborador_id[]" multiple 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 min-h-[120px]">
                                @foreach($colaboradores as $col)
                                    <option value="{{ $col->id }}" {{ in_array($col->id, explode(',', $hallazgo->responsable)) ? 'selected' : '' }}
                                        class="py-2">
                                        {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- <p class="mt-2 text-sm text-gray-500">Mantén presionado Ctrl (o Cmd en Mac) para seleccionar múltiples colaboradores</p> --}}
                        </div>

                        <!-- Jefatura -->
                        <div>
                            <label for="colaborador_name2" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Jefatura Responsable
                            </label>
                            <select id="colaborador_name2" name="jefe" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Seleccionar jefatura...</option>
                                @foreach($colaboradores as $col)
                                    <option value="{{ $col->id }}" {{ $hallazgo->jefe == $col->id ? 'selected' : '' }}>
                                        {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Título -->
                        <div class="lg:col-span-2">
                             <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Título del Hallazgo
                            </label>
                            <select name="titulo" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                @if(isset($hallazgo->titulo) && $hallazgo->titulo)
                                    <option value="{{ $hallazgo->titulo }}" selected>
                                        {{ $hallazgo->titysubtit->titulo ?? '' }} - {{ $hallazgo->titysubtit->subtitulo ?? '' }}
                                    </option>
                                @endif
                                @foreach($titulos as $titulo)
                                    @if($titulo->id != $hallazgo->titulo)
                                        <option value="{{ $titulo->id }}">{{ $titulo->titulo }} - {{ $titulo->subtitulo }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Tipo de Hallazgo
                            </label>
                            <select name="tipo" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="Operativo" {{ $hallazgo->tipo == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                                <option value="Administrativo" {{ $hallazgo->tipo == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                            </select>
                        </div>

                        <!-- NUEVO CAMPO CRITICIDAD -->
                        <div>
                            <label for="criticidad" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                Nivel de Criticidad
                            </label>
                            <select id="criticidad" name="criticidad" 
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                                required>
                                <option value="">Selecciona el nivel</option>
                                <option value="baja" 
                                    {{ (strtolower($hallazgo->criticidad ?? '') == 'baja') ? 'selected' : '' }}
                                    class="text-green-700">
                                    🟢 Baja
                                </option>
                                <option value="media" 
                                    {{ (strtolower($hallazgo->criticidad ?? '') == 'media') ? 'selected' : '' }}
                                    class="text-yellow-700">
                                    🟡 Media
                                </option>
                                <option value="alta" 
                                    {{ (strtolower($hallazgo->criticidad ?? '') == 'alta') ? 'selected' : '' }}
                                    class="text-red-700">
                                    🔴 Alta
                                </option>
                            </select>
                            
                            <!-- Indicador visual del nivel actual -->
                            @if($hallazgo->criticidad)
                                @php
                                    $criticidicadInfo = match(strtolower($hallazgo->criticidad)) {
                                        'baja' => ['color' => 'text-green-600', 'bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => '🟢', 'desc' => 'Impacto mínimo'],
                                        'media' => ['color' => 'text-yellow-600', 'bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'icon' => '🟡', 'desc' => 'Impacto moderado'],
                                        'alta' => ['color' => 'text-red-600', 'bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => '🔴', 'desc' => 'Impacto severo'],
                                        default => ['color' => 'text-gray-600', 'bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'icon' => '⚪', 'desc' => 'Sin definir']
                                    };
                                @endphp
                                <div id="criticidad-info" class="mt-2 p-2 {{ $criticidicadInfo['bg'] }} {{ $criticidicadInfo['border'] }} border rounded-md">
                                    <p class="text-xs {{ $criticidicadInfo['color'] }} font-medium">
                                        {{ $criticidicadInfo['icon'] }} Nivel actual: {{ ucfirst($hallazgo->criticidad) }} - {{ $criticidicadInfo['desc'] }}
                                    </p>
                                </div>
                            @endif
                            
                            <p class="mt-1 text-xs text-gray-500">
                                Indica el nivel de impacto y urgencia del hallazgo
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Descripción -->
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Descripción y Detalles
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="hallazgo" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Descripción del Hallazgo
                            </label>
                            <textarea name="hallazgo" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 resize-none">{{ $hallazgo->hallazgo }}</textarea>
                        </div>

                        <div>
                            <label for="sugerencia" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Sugerencia de Mejora
                            </label>
                            <textarea name="sugerencia" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 resize-none">{{ $hallazgo->sugerencia }}</textarea>
                        </div>

                        <div>
                            <label for="plan_de_accion" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Plan de Acción
                            </label>
                            <textarea name="plan_de_accion" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 resize-none">{{ $hallazgo->plan_de_accion }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Fechas -->
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Fechas y Plazos
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="fecha_presentacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                📅 Fecha de Presentación
                            </label>
                            <input type="date" name="fecha_presentacion" value="{{ $hallazgo->fecha_presentacion }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="fecha_compromiso" class="block text-sm font-semibold text-gray-700 mb-2">
                                🎯 Fecha de Compromiso
                            </label>
                            <input type="date" name="fecha_compromiso" value="{{ $hallazgo->fecha_compromiso }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="fecha_identificacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                🔍 Fecha de Identificación
                            </label>
                            <input type="date" name="fecha_identificacion" value="{{ $hallazgo->fecha_identificacion }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="fecha_cierre" class="block text-sm font-semibold text-gray-700 mb-2">
                                ✅ Fecha de Cierre
                            </label>
                            <input type="date" name="fecha_cierre" value="{{ $hallazgo->fecha_cierre }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Sección 4: Comentarios -->
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Comentarios de Auditoría
                    </h2>
                    <textarea name="comentarios" rows="3" placeholder="Agregar comentario..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                </div>

                <!-- Sección 5: Evidencias -->
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Evidencias de Auditoría
                    </h2>
                    
                    <!-- Evidencias actuales -->
                    @if($archivos && $archivos->where('id_user', auth()->user()->id)->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Evidencias Actuales ({{ $archivos->where('id_user', auth()->user()->id)->count() }})
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($archivos->where('id_user', auth()->user()->id) as $archivo)
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200 hover:shadow-md transition-shadow duration-200">
                                    <!-- Header con ícono de tipo de archivo -->
                                    <div class="flex items-start justify-between mb-3">
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
                                            <svg class="w-6 h-6 {{ $iconColor }} mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/app/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank" 
                                        class="text-blue-700 hover:text-blue-900 font-medium text-sm leading-tight block group"
                                        title="{{ $archivo->comentario }}">
                                            <span class="line-clamp-2 break-words group-hover:underline">
                                                {{ $archivo->comentario }}
                                            </span>
                                        </a>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-blue-100">
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
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/app/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 border border-blue-300 rounded-md shadow-sm bg-white text-sm font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
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

                    <!-- Subir archivos -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subir Nueva Evidencia</label>
                        <input type="file" name="evidencia[]" multiple class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Máximo 60MB por archivo.</p>
                    </div>
                </div>

                <!-- Sección 6: Información del colaborador -->
                <div class="p-6 border-b bg-gray-50">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información del Colaborador
                    </h2>
                    
                    <!-- Fecha de respuesta -->
                    <div class="mb-4 bg-white p-3 rounded border">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Respuesta</label>
                        <p class="text-gray-800">{{ $hallazgo->fecha_colaborador ?? 'Sin respuesta' }}</p>
                    </div>

                    <!-- Evidencias del colaborador -->
                    @if($archivos && $archivos->where('id_user', '!=', auth()->user()->id)->count() > 0)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Evidencias del Colaborador ({{ $archivos->where('id_user', '!=', auth()->user()->id)->count() }})
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($archivos->where('id_user', '!=', auth()->user()->id) as $archivo)
                                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-lg border border-teal-200 hover:shadow-md transition-shadow duration-200">
                                    <!-- Header con ícono de tipo de archivo -->
                                    <div class="flex items-start justify-between mb-3">
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
                                            <svg class="w-6 h-6 {{ $iconColor }} mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                                {{ strtoupper($extension ?: 'archivo') }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                            Colaborador
                                        </span>
                                    </div>

                                    <!-- Nombre del archivo con manejo de overflow -->
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/app/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank" 
                                        class="text-teal-700 hover:text-teal-900 font-medium text-sm leading-tight block group"
                                        title="{{ $archivo->comentario }}">
                                            <span class="line-clamp-2 break-words group-hover:underline">
                                                {{ $archivo->comentario }}
                                            </span>
                                        </a>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-teal-100">
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
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/app/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}" 
                                        target="_blank"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 border border-teal-300 rounded-md shadow-sm bg-white text-sm font-medium text-teal-700 hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">
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
                </div>

                <!-- Sección 7: Conversación -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Conversación con Colaborador
                    </h2>

                    <div class="bg-gray-50 rounded-lg p-6 min-h-[300px] max-h-[500px] overflow-y-auto space-y-4">
                        @if($comentarios->count() > 0)
                            @foreach ($comentarios as $comentario)
                                @php
                                    $esAuditoria = $comentario->id_user == auth()->user()->id;
                                @endphp
                                <div class="chat-message flex {{ $esAuditoria ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[70%] px-4 py-3 rounded-2xl {{ $esAuditoria ? 'bg-blue-500 text-white rounded-br-none' : 'bg-white border border-gray-200 rounded-bl-none' }} shadow-sm">
                                        <div class="flex items-center mb-2">
                                            <div class="w-8 h-8 {{ $esAuditoria ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center mr-2">
                                                <span class="text-xs font-bold {{ $esAuditoria ? 'text-white' : 'text-gray-600' }}">
                                                    {{ substr($comentario->usuario->name, 0, 2) }}
                                                </span>
                                            </div>
                                            <strong class="{{ $esAuditoria ? 'text-blue-100' : 'text-gray-800' }} text-sm">
                                                {{ $comentario->usuario->name }}
                                            </strong>
                                        </div>
                                        <p class="{{ $esAuditoria ? 'text-white' : 'text-gray-700' }} text-sm break-words">
                                            {!! nl2br(e($comentario->comentario)) !!}
                                        </p>
                                        <div class="{{ $esAuditoria ? 'text-blue-200' : 'text-gray-500' }} text-xs mt-2">
                                            {{ $comentario->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Sin conversaciones</h3>
                                <p class="mt-1 text-sm text-gray-500">Aún no hay comentarios en este hallazgo.</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($comentarios->count() > 0)
                <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-orange-50">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        🏷️ Estado de la Respuesta del Colaborador
                    </h3>
                    
                    <div class="max-w-md mx-auto text-center">
                        <label for="respuesta" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            🏷️ Evaluar respuesta del colaborador
                        </label>
                        <select name="respuesta" id="respuesta" 
                            class="w-full px-4 py-3 border border-yellow-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-white hover:border-yellow-400">
                            <option value="" class="text-gray-500">Selecciona una opción...</option>
                            <option value="respuesta rechazada" class="py-2">
                                🚫 Respuesta rechazada
                            </option>
                            <option value="evidencia incompleta" class="py-2">
                                📄 Evidencia incompleta
                            </option>
                            <option value="requiere confirmación" class="py-2">
                                ❓ Requiere confirmación
                            </option>
                        </select>
                        <p class="mt-2 text-sm text-gray-600 flex items-start justify-center">
                            <svg class="w-4 h-4 mr-1 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selecciona el estado correspondiente según la evaluación de la respuesta del colaborador.
                        </p>
                    </div>
                </div>
                @endif

                <!-- Botones de acción -->
                <div class="px-6 py-8">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button id="submit-btn" type="submit" 
                            class="flex-1 max-w-xs bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Actualizar Hallazgo
                        </button>
                    </div>
                </div>
            </form>

            <!-- Acciones adicionales -->
            <div class="px-6 py-8 bg-gray-50 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 text-center">Acciones Adicionales</h3>
                
                @if($hallazgo->estatus == 'Cerrado')
                    <!-- Solo mostrar eliminar cuando está cerrado -->
                    <div class="flex justify-center">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 p-6 rounded-xl border border-red-200 max-w-md w-full">
                            <h4 class="text-lg font-semibold text-red-800 mb-4 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar Hallazgo
                            </h4>
                            
                            <div class="text-center mb-4">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Hallazgo Cerrado
                                </div>
                                <p class="text-sm text-red-600 mb-2">
                                    ⚠️ Este hallazgo ya está cerrado. Solo puedes eliminarlo si es necesario.
                                </p>
                                <p class="text-xs text-gray-600">
                                    La eliminación es permanente y no se puede deshacer.
                                </p>
                            </div>
                            
                            <form action="{{ route('eliminar_hallazgo') }}" method="post" 
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este hallazgo cerrado? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" value="{{ $hallazgo->id }}" name="hallazgo_id">
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar Hallazgo
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Mostrar ambas acciones cuando NO está cerrado -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        <!-- Cerrar hallazgo (formulario independiente) -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                            <h4 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Cierre de Hallazgo
                            </h4>
                            
                        <form id="form-cierre-hallazgo" action="{{ route('hallazgo.cerrar',$hallazgo->id) }}" method="post" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="fecha_cierre_form" class="block text-sm font-semibold text-gray-700 mb-2">
                                    📅 Fecha de cierre definitiva <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                    id="fecha_cierre_form" 
                                    name="fecha_cierre" 
                                    value="{{ $hallazgo->fecha_cierre }}"
                                    required
                                    class="w-full px-4 py-3 border border-green-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white hover:border-green-400">
                                <div id="error-fecha" class="mt-1 text-sm text-red-600 hidden flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Debe seleccionar una fecha de cierre válida
                                </div>
                            </div>
                            
                            <button type="button" id="btn-cerrar-hallazgo"
                                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Cerrar Hallazgo
                            </button>
                        </form>
                        </div>

                        <!-- Eliminar hallazgo -->
                        <div class="flex justify-center">
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 p-6 rounded-xl border border-red-200 max-w-lg w-full">
                                <h4 class="text-lg font-semibold text-red-800 mb-4 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar Hallazgo
                                </h4>
                                
                                <div class="text-center mb-4">
                                    <p class="text-sm text-red-600 mb-2">
                                        ⚠️ Esta acción eliminará permanentemente el hallazgo y no se puede deshacer.
                                    </p>
                                </div>
                                
                                <form action="{{ route('eliminar_hallazgo') }}" method="post" 
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este hallazgo? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" value="{{ $hallazgo->id }}" name="hallazgo_id">
                                    <button type="submit" 
                                        class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Eliminar Hallazgo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notificaciones -->
        <div id="notification-container" class="fixed top-4 right-4 z-50 max-w-sm"></div>

        <div id="modal-cierre" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95" id="modal-content">
                <div class="p-6">
                    <!-- Header del modal -->
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Confirmar Cierre de Hallazgo</h3>
                    </div>
                    
                    <!-- Contenido del modal -->
                    <div class="mb-6">
                        <p class="text-gray-700 mb-3">¿Estás seguro de que deseas cerrar este hallazgo?</p>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-yellow-800 font-medium">Información importante:</p>
                                    <ul class="text-sm text-yellow-700 mt-1 list-disc list-inside">
                                        <li>El hallazgo será marcado como <strong>cerrado definitivamente</strong></li>
                                        <li>Esta acción <strong>no se puede deshacer</strong></li>
                                        <li>Se registrará la fecha: <span id="fecha-confirmacion" class="font-semibold"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones del modal -->
                    <div class="flex space-x-3">
                        <button type="button" id="cancelar-cierre" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="button" id="confirmar-cierre" 
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Sí, Cerrar Hallazgo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Scripts optimizados -->
<script>
// Variables globales - definir ANTES del DOMContentLoaded
let criticidicadSelect;
let criticidicadInfo;

document.addEventListener('DOMContentLoaded', function() {
    
    // Inicializar variables globales
    criticidicadSelect = document.getElementById('criticidad');
    criticidicadInfo = document.getElementById('criticidad-info');
    
    // Variables locales
    const submitBtn = document.getElementById('submit-btn');
    const form = submitBtn.closest('form');

    if (criticidicadSelect) {
        // Configurar el estado inicial
        const valorInicial = criticidicadSelect.value;
        if (valorInicial) {
            criticidicadSelect.setAttribute('data-selected', valorInicial);
            aplicarEstiloCriticidad(valorInicial);
        }

        // Manejar cambio de criticidad
        criticidicadSelect.addEventListener('change', function() {
            const nuevoValor = this.value;
            
            // Remover clases anteriores
            this.removeAttribute('data-selected');
            this.classList.remove('border-green-500', 'border-yellow-500', 'border-red-500');
            
            // Aplicar nuevo estilo
            if (nuevoValor) {
                this.setAttribute('data-selected', nuevoValor);
                aplicarEstiloCriticidad(nuevoValor);
                actualizarIndicadorCriticidad(nuevoValor);
                
                // Mostrar notificación
                showNotification(`Criticidad actualizada: ${capitalizeFirst(nuevoValor)}`, 'success');
            } else {
                // Si se deselecciona, mostrar el info original
                if (criticidicadInfo) {
                    criticidicadInfo.style.display = 'block';
                }
            }
        });

        // Validación en tiempo real
        criticidicadSelect.addEventListener('blur', function() {
            if (!this.value) {
                showNotification('Debe seleccionar un nivel de criticidad', 'error');
                this.classList.add('border-red-300');
            } else {
                this.classList.remove('border-red-300');
            }
        });
    }
    
    // Envío del formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Actualizando...';
            
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Actualizar Hallazgo';
            }, 5000);
        });
    }

    // Validación de archivos
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const maxSize = 60 * 1024 * 1024; // 60MB
            
            let hasErrors = false;
            files.forEach(file => {
                if (file.size > maxSize) {
                    showNotification(`Archivo "${file.name}" muy grande. Máximo: 60MB`, 'error');
                    hasErrors = true;
                }
            });

            if (hasErrors) {
                this.value = '';
            } else if (files.length > 0) {
                showNotification(`${files.length} archivo(s) seleccionados`, 'success');
            }
        });
    }

    // Multi-select feedback
    const multiSelect = document.querySelector('select[multiple]');
    if (multiSelect) {
        multiSelect.addEventListener('change', function() {
            const count = this.selectedOptions.length;
            if (count > 0) {
                showNotification(`${count} colaborador(es) seleccionados`, 'success');
            }
        });
    }

    // Auto-scroll chat
    const chatContainer = document.querySelector('.overflow-y-auto');
    if (chatContainer && chatContainer.children.length > 0) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // === MODAL DE CIERRE DE HALLAZGO ===
    const btnCerrarHallazgo = document.getElementById('btn-cerrar-hallazgo');
    const formCierreHallazgo = document.getElementById('form-cierre-hallazgo');
    const fechaCierreInput = document.getElementById('fecha_cierre_form');
    const errorFecha = document.getElementById('error-fecha');
    const modal = document.getElementById('modal-cierre');
    const modalContent = document.getElementById('modal-content');
    const btnCancelar = document.getElementById('cancelar-cierre');
    const btnConfirmar = document.getElementById('confirmar-cierre');
    const fechaConfirmacion = document.getElementById('fecha-confirmacion');

    // Validación en tiempo real del campo fecha
    if (fechaCierreInput) {
        fechaCierreInput.addEventListener('change', function() {
            validarFecha();
        });

        fechaCierreInput.addEventListener('blur', function() {
            validarFecha();
        });
    }

    // Función para validar la fecha
    function validarFecha() {
        if (!fechaCierreInput || !errorFecha) return false;
        
        const fechaSeleccionada = fechaCierreInput.value;
        const fechaActual = new Date().toISOString().split('T')[0];
        
        // Limpiar errores previos
        errorFecha.classList.add('hidden');
        fechaCierreInput.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
        fechaCierreInput.classList.add('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');

        // Validar que se haya seleccionado una fecha
        if (!fechaSeleccionada) {
            mostrarError('Debe seleccionar una fecha de cierre');
            return false;
        }

        // Validar que la fecha no sea futura (opcional)
        if (fechaSeleccionada > fechaActual) {
            mostrarError('La fecha de cierre no puede ser futura');
            return false;
        }

        return true;
    }

    // Función para mostrar errores
    function mostrarError(mensaje) {
        if (!errorFecha || !fechaCierreInput) return;
        
        errorFecha.textContent = mensaje;
        errorFecha.classList.remove('hidden');
        fechaCierreInput.classList.remove('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
        fechaCierreInput.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
    }

    // Función para formatear fecha
    function formatearFecha(fecha) {
        const opciones = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            weekday: 'long'
        };
        return new Date(fecha + 'T00:00:00').toLocaleDateString('es-ES', opciones);
    }

    // Manejar clic en "Cerrar Hallazgo"
    if (btnCerrarHallazgo) {
        btnCerrarHallazgo.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validar fecha antes de mostrar modal
            if (!validarFecha()) {
                // Scroll hacia el campo con error
                fechaCierreInput.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                fechaCierreInput.focus();
                
                // Mostrar notificación
                showNotification('Por favor, corrige los errores antes de continuar', 'error');
                return;
            }

            // Actualizar fecha en el modal
            const fechaSeleccionada = fechaCierreInput.value;
            if (fechaConfirmacion) {
                fechaConfirmacion.textContent = formatearFecha(fechaSeleccionada);
            }
            
            // Mostrar modal con animación
            if (modal && modalContent) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);
            }
        });
    }

    // Manejar cancelación
    if (btnCancelar) {
        btnCancelar.addEventListener('click', function() {
            cerrarModal();
        });
    }

    // Manejar confirmación
    if (btnConfirmar) {
        btnConfirmar.addEventListener('click', function() {
            // Deshabilitar botón para evitar doble envío
            btnConfirmar.disabled = true;
            btnConfirmar.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Cerrando...
            `;
            
            // Enviar formulario
            if (formCierreHallazgo) {
                formCierreHallazgo.submit();
            }
        });
    }

    // Cerrar modal al hacer clic fuera
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModal();
            }
        });
    }

    // Función para cerrar modal
    function cerrarModal() {
        if (!modal || !modalContent || !btnConfirmar) return;
        
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            // Reactivar botón si se canceló
            btnConfirmar.disabled = false;
            btnConfirmar.innerHTML = 'Sí, Cerrar Hallazgo';
        }, 200);
    }

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            cerrarModal();
        }
    });

    // Validación inicial al cargar la página
    if (fechaCierreInput && fechaCierreInput.value) {
        validarFecha();
    }

    // Validación adicional antes del envío del formulario principal
    const formPrincipal = document.querySelector('form[action*="hallazgo.update"]');
    if (formPrincipal && criticidicadSelect) {
        formPrincipal.addEventListener('submit', function(e) {
            if (!criticidicadSelect.value) {
                e.preventDefault();
                criticidicadSelect.focus();
                criticidicadSelect.classList.add('border-red-300');
                showNotification('Debe seleccionar un nivel de criticidad antes de guardar', 'error');
                return false;
            }
        });
    }
});

// === FUNCIONES GLOBALES (fuera del DOMContentLoaded) ===

// Función para aplicar estilos según la criticidad
function aplicarEstiloCriticidad(valor) {
    if (!criticidicadSelect) return;
    
    const estilos = {
        'baja': 'border-green-500',
        'media': 'border-yellow-500', 
        'alta': 'border-red-500'
    };
    
    if (estilos[valor]) {
        criticidicadSelect.classList.add(estilos[valor]);
    }
}

// Función para actualizar el indicador de criticidad
function actualizarIndicadorCriticidad(nuevoValor) {
    if (!criticidicadInfo) return;
    
    const infoCriticidad = {
        'baja': {
            color: 'text-green-600',
            bg: 'bg-green-50',
            border: 'border-green-200',
            icon: '🟢',
            desc: 'Impacto mínimo'
        },
        'media': {
            color: 'text-yellow-600',
            bg: 'bg-yellow-50', 
            border: 'border-yellow-200',
            icon: '🟡',
            desc: 'Impacto moderado'
        },
        'alta': {
            color: 'text-red-600',
            bg: 'bg-red-50',
            border: 'border-red-200', 
            icon: '🔴',
            desc: 'Impacto severo'
        }
    };
    
    const info = infoCriticidad[nuevoValor];
    if (info) {
        // Limpiar clases anteriores
        criticidicadInfo.className = 'mt-2 p-2 border rounded-md transition-all duration-300';
        
        // Aplicar nuevas clases
        criticidicadInfo.classList.add(info.bg, info.border);
        
        // Actualizar contenido
        criticidicadInfo.innerHTML = `
            <p class="text-xs ${info.color} font-medium">
                ${info.icon} Nivel seleccionado: ${capitalizeFirst(nuevoValor)} - ${info.desc}
                <span class="ml-2 text-blue-600">(Modificado)</span>
            </p>
        `;
        
        // Animación de actualización
        criticidicadInfo.classList.add('criticidad-updated');
        setTimeout(() => {
            criticidicadInfo.classList.remove('criticidad-updated');
        }, 600);
    }
}

// Función auxiliar para capitalizar primera letra
function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Función de notificaciones simplificada
function showNotification(message, type = 'success') {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
    const notification = document.createElement('div');
    
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    notification.className = `${bgColor} text-white p-3 rounded-lg shadow-lg mb-2 notification-enter`;
    notification.innerHTML = `<span class="text-sm font-medium">${message}</span>`;
    
    container.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 3000);
}
</script>

@endpush