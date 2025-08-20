@extends('home', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Áreas de Auditoría')])

@section('contentJunzi')
<style>
/* Animaciones personalizadas */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

.slide-in {
    animation: slideIn 0.6s ease-out;
}

/* Estados de focus y hover mejorados */
button:focus,
a:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    ring-opacity: 50%;
}

/* Efectos para botones */
button, a {
    transition: all 0.2s ease-in-out;
}

button:hover:not(:disabled),
a:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

button:active:not(:disabled),
a:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Toggle switch personalizado */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-switch-large {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.toggle-switch-large input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider-large {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.toggle-slider-large:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .toggle-slider-large {
    background-color: #10b981;
}

input:focus + .toggle-slider-large {
    box-shadow: 0 0 1px #10b981;
}

input:checked + .toggle-slider-large:before {
    transform: translateX(26px);
}

input:checked + .toggle-slider {
    background-color: #10b981;
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

/* Toggle switch grande para modales */
.toggle-switch-large {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.toggle-switch-large input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider-large {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 30px;
    border: 2px solid #e5e7eb;
}

.toggle-slider-large:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    border: 1px solid #d1d5db;
}

input:checked + .toggle-slider-large {
    background-color: #10b981;
    border-color: #059669;
}

input:checked + .toggle-slider-large:before {
    transform: translateX(28px);
    border-color: #059669;
}

input:focus + .toggle-slider-large {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Efectos para filas de tabla */
.table-row {
    transition: all 0.2s ease;
}

.table-row:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
}

/* Animaciones de notificación */
.alert-enter {
    animation: slideIn 0.5s ease-out;
}

/* Responsive mejoras */
@media (max-width: 768px) {
    .table-container {
        font-size: 0.875rem;
    }

    .btn-mobile {
        padding: 0.5rem;
    }
}
</style>

<div class="bg-gray-50 min-h-screen py-8 mt-5">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-4">

        <!-- Header principal -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-xl shadow-xl mb-8 fade-in">
            <div class="px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-3xl font-bold text-white">Áreas de Auditoría</h1>
                            <p class="text-white text-lg mt-1">Gestiona las áreas para el sistema de auditorías</p>
                        </div>
                    </div>

                    <!-- Botón Nueva Área -->
                    <div class="hidden sm:block">
                        <button onclick="openCreateModal()"
                           class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 border border-green-400 rounded-lg text-white font-semibold focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nueva Área
                        </button>
                    </div>
                </div>

                <!-- Botón móvil -->
                <div class="sm:hidden mt-4">
                    <button onclick="openCreateModal()"
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-500 hover:bg-green-600 border border-green-400 rounded-lg text-white font-semibold focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nueva Área
                    </button>
                </div>
            </div>
        </div>

        <!-- Alerta de éxito -->
        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-8 rounded-r-lg shadow-md alert-enter">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="inline-flex text-green-400 hover:text-green-600 focus:outline-none focus:text-green-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabla de áreas -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden slide-in">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Lista de Áreas ({{ $areas->count() }} registros)
                    </h2>
                    <div class="text-sm text-gray-500">
                        Total de áreas registradas
                    </div>
                </div>
            </div>

            <div class="table-container overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        ID
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Nombre del Área
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Es Planta
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Trazabilidad
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L4.257 9.257a6 6 0 117.743-7.743L15 5m0 2a2 2 0 012 2m-2-2v2a2 2 0 01-2 2m2-2h2a2 2 0 012 2v2a2 2 0 01-2 2m0 0v2a2 2 0 002 2h2M9 21H7a2 2 0 01-2-2v-2"></path>
                                        </svg>
                                        Clave
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                    <div class="flex items-center justify-end">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                        Acciones
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($areas as $area)
                                <tr class="table-row hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-bold text-blue-600">#{{ $area->id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $area->nombre }}</div>
                                        <div class="text-sm text-gray-500">Área de auditoría</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <label class="toggle-switch">
                                            <input type="checkbox" class="toggle-planta"
                                                data-id="{{ $area->id }}"
                                                {{ $area->es_planta ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <label class="toggle-switch">
                                            <input type="checkbox" class="toggle-trazabilidad"
                                                data-id="{{ $area->id }}"
                                                {{ $area->trazabilidad ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                            {{ $area->clave }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Botón Editar -->
                                            <button onclick="openEditModal({{ $area->id }}, '{{ addslashes($area->nombre) }}', '{{ $area->clave }}', {{ $area->es_planta ? 1 : 0 }}, {{ $area->trazabilidad ? 1 : 0 }})"
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                                               title="Editar área">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button"
                                                onclick="openDeleteModal({{ $area->id }}, '{{ $area->nombre }}', '{{ $area->clave }}', {{ $area->trazabilidad ? 1 : 0 }})"
                                                class="delete-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                                title="Eliminar área">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay áreas registradas</h3>
                                            <p class="text-gray-500 mb-4">Comienza agregando tu primera área de auditoría.</p>
                                            <button onclick="openCreateModal()"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Nueva Área
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Nueva Área -->
<div id="createAreaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Área de Auditoría
                </h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form action="{{ route('areas_auditoria.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Campo Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Nombre del Área
                    </label>
                    <input type="text" id="nombre" name="nombre" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        placeholder="Ej: Recursos Humanos">
                    <div id="nombre-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <!-- Campo Clave -->
                <div>
                    <label for="clave" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L4.257 9.257a6 6 0 117.743-7.743L15 5m0 2a2 2 0 012 2m-2-2v2a2 2 0 01-2 2m2-2h2a2 2 0 012 2v2a2 2 0 01-2 2m0 0v2a2 2 0 002 2h2M9 21H7a2 2 0 01-2-2v-2"></path>
                        </svg>
                        Clave del Área
                    </label>
                    <input type="text" id="clave" name="clave" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        placeholder="Ej: RH-001"
                        maxlength="20">
                    <div id="clave-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <p class="text-xs text-gray-500 mt-1">Código único para identificar el área (máx. 20 caracteres)</p>
                </div>

                <!-- Campo Es Planta -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        ¿Es Planta?
                    </label>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Área de Planta</p>
                                <p class="text-xs text-gray-500">Marcar si el área pertenece a una planta de producción</p>
                            </div>
                        </div>
                        <label class="toggle-switch-large">
                            <input type="checkbox" id="es_planta" name="es_planta" value="1">
                            <span class="toggle-slider-large"></span>
                        </label>
                    </div>
                </div>

                <!-- Campo Trazabilidad -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        ¿Habilitar Trazabilidad?
                    </label>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Trazabilidad</p>
                                <p class="text-xs text-gray-500">Habilitar seguimiento detallado de auditorías</p>
                            </div>
                        </div>
                        <label class="toggle-switch-large">
                            <input type="checkbox" id="trazabilidad" name="trazabilidad" value="1">
                            <span class="toggle-slider-large"></span>
                        </label>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Información:</span> El área será utilizada para clasificar y organizar las auditorías en el sistema.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" id="submitCreateBtn"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-green-600 text-base font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Área -->
<div id="editAreaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Área de Auditoría
                </h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form id="editAreaForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Campo oculto para el ID del área -->
                <input type="hidden" id="edit_area_id" name="area_id" value="">

                <!-- Campo Nombre -->
                <div>
                    <label for="edit_nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Nombre del Área
                    </label>
                    <input type="text" id="edit_nombre" name="nombre" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <div id="edit-nombre-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <!-- Campo Clave -->
                <div>
                    <label for="edit_clave" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L4.257 9.257a6 6 0 117.743-7.743L15 5m0 2a2 2 0 012 2m-2-2v2a2 2 0 01-2 2m2-2h2a2 2 0 012 2v2a2 2 0 01-2 2m0 0v2a2 2 0 002 2h2M9 21H7a2 2 0 01-2-2v-2"></path>
                        </svg>
                        Clave del Área
                    </label>
                    <input type="text" id="edit_clave" name="clave" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        maxlength="20">
                    <div id="edit-clave-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <p class="text-xs text-gray-500 mt-1">Código único para identificar el área (máx. 20 caracteres)</p>
                </div>

                <!-- Campo Es Planta -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        ¿Es Planta?
                    </label>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Área de Planta</p>
                                <p class="text-xs text-gray-500">Marcar si el área pertenece a una planta de producción</p>
                            </div>
                        </div>
                        <label class="toggle-switch-large">
                            <input type="checkbox" id="edit_es_planta" name="es_planta" value="1">
                            <span class="toggle-slider-large"></span>
                        </label>
                    </div>
                </div>

                <!-- Campo Trazabilidad -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        ¿Habilitar Trazabilidad?
                    </label>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Trazabilidad</p>
                                <p class="text-xs text-gray-500">Habilitar seguimiento detallado de auditorías</p>
                            </div>
                        </div>
                        <label class="toggle-switch-large">
                            <input type="checkbox" id="edit_trazabilidad" name="trazabilidad" value="1">
                            <span class="toggle-slider-large"></span>
                        </label>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-medium">Precaución:</span> Los cambios afectarán todas las auditorías asociadas a esta área.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" id="submitEditBtn"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Actualizar Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteAreaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Confirmar Eliminación</h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mb-6">
                <!-- Información del área a eliminar -->
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">Área a eliminar:</h4>
                            <div class="mt-2 text-sm text-red-700">
                                <p><span class="font-semibold">Nombre:</span> <span id="delete-area-nombre"></span></p>
                                <p><span class="font-semibold">Clave:</span> <span id="delete-area-clave" class="bg-red-200 px-2 py-1 rounded text-xs"></span></p>
                                <p><span class="font-semibold">Trazabilidad:</span> <span id="delete-area-trazabilidad" class="px-2 py-1 rounded text-xs"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advertencia -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-medium">¡Advertencia!</span> Esta acción eliminará permanentemente el área y puede afectar:
                            </p>
                            <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                                <li>Todas las auditorías asociadas a esta área</li>
                                <li>Reportes y estadísticas relacionadas</li>
                                <li>Referencias en el sistema</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario oculto para envío -->
            <form id="deleteAreaForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- Botones del modal -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </button>
                <button type="button" id="confirmDeleteBtn" onclick="confirmDelete()"
                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span id="deleteButtonText">Eliminar Área</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let deleteAreaId = null;
let deleteAreaName = null;

document.addEventListener('DOMContentLoaded', function() {
    // Verificar que todos los elementos críticos existen
    const criticalElements = ['edit_es_planta', 'es_planta', 'edit_trazabilidad', 'trazabilidad'];
    criticalElements.forEach(id => {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Elemento crítico no encontrado: ${id}`);
        } else {
            console.log(`Elemento encontrado: ${id}`);
        }
    });

    // Auto-hide success alert después de 5 segundos
    const alert = document.querySelector('.alert-enter');
    if (alert) {
        setTimeout(() => {
            alert.style.transform = 'translateX(100%)';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    }

    // Manejar toggle de es_planta en la tabla
    const togglesPlanta = document.querySelectorAll('.toggle-planta');
    togglesPlanta.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const areaId = this.getAttribute('data-id');
            const isChecked = this.checked;
            
            console.log(`Toggle planta cambiado - Área ${areaId}: ${isChecked}`);
            
            // Deshabilitar temporalmente el toggle
            this.disabled = true;
            
            // Mostrar indicador visual de carga
            const row = this.closest('tr');
            if (row) {
                row.style.opacity = '0.7';
            }
            
            // Realizar petición AJAX para actualizar
            fetch(`{{ route('areas_auditoria.update_planta', '') }}/${areaId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    es_planta: isChecked
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta del servidor (planta):', data);
                
                if (data.success) {
                    // Mostrar notificación de éxito
                    showToast(data.message, 'success');
                } else {
                    // Revertir el toggle si hay error
                    this.checked = !isChecked;
                    showToast(data.message || 'Error al actualizar', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revertir el toggle si hay error
                this.checked = !isChecked;
                showToast('Error de conexión', 'error');
            })
            .finally(() => {
                // Rehabilitar el toggle y restaurar opacidad
                this.disabled = false;
                if (row) {
                    row.style.opacity = '1';
                }
            });
        });
    });

    // Manejar toggle de trazabilidad en la tabla
    const togglesTrazabilidad = document.querySelectorAll('.toggle-trazabilidad');
    togglesTrazabilidad.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const areaId = this.getAttribute('data-id');
            const isChecked = this.checked;
            
            console.log(`Toggle trazabilidad cambiado - Área ${areaId}: ${isChecked}`);
            
            // Deshabilitar temporalmente el toggle
            this.disabled = true;
            
            // Mostrar indicador visual de carga
            const row = this.closest('tr');
            if (row) {
                row.style.opacity = '0.7';
            }
            
            // Realizar petición AJAX para actualizar trazabilidad
            fetch(`{{ route('areas_auditoria.update_trazabilidad', '') }}/${areaId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    trazabilidad: isChecked
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta del servidor (trazabilidad):', data);
                
                if (data.success) {
                    // Mostrar notificación de éxito
                    showToast(data.message, 'success');
                    
                    // Actualizar visualmente el estado
                    updateTrazabilidadVisualState(areaId, isChecked);
                } else {
                    // Revertir el toggle si hay error
                    this.checked = !isChecked;
                    showToast(data.message || 'Error al actualizar trazabilidad', 'error');
                    console.error('Error en la respuesta:', data);
                }
            })
            .catch(error => {
                console.error('Error de red o parsing:', error);
                // Revertir el toggle si hay error
                this.checked = !isChecked;
                showToast('Error de conexión al actualizar trazabilidad', 'error');
            })
            .finally(() => {
                // Rehabilitar el toggle y restaurar opacidad
                this.disabled = false;
                if (row) {
                    row.style.opacity = '1';
                }
            });
        });
    });

    // Efectos de hover mejorados
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
        });

        row.addEventListener('mouseleave', function() {
            this.style.boxShadow = 'none';
        });
    });

    // Animaciones escalonadas para las cards
    const cards = document.querySelectorAll('.slide-in');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Función de inicialización mejorada
    console.log('Inicializando toggles de áreas de auditoría...');
    
    const plantaToggles = document.querySelectorAll('.toggle-planta');
    const trazabilidadToggles = document.querySelectorAll('.toggle-trazabilidad');
    
    console.log(`Encontrados ${plantaToggles.length} toggles de planta`);
    console.log(`Encontrados ${trazabilidadToggles.length} toggles de trazabilidad`);
    
    // Verificar integridad de los toggles
    plantaToggles.forEach((toggle, index) => {
        const areaId = toggle.getAttribute('data-id');
        if (!areaId) {
            console.warn(`Toggle de planta ${index} no tiene data-id`);
        } else {
            console.log(`Toggle planta ${index}: área ${areaId}, estado: ${toggle.checked}`);
        }
    });
    
    trazabilidadToggles.forEach((toggle, index) => {
        const areaId = toggle.getAttribute('data-id');
        if (!areaId) {
            console.warn(`Toggle de trazabilidad ${index} no tiene data-id`);
        } else {
            console.log(`Toggle trazabilidad ${index}: área ${areaId}, estado: ${toggle.checked}`);
        }
    });
});

// Función para mostrar notificaciones toast
function showToast(message, type = 'success') {
    // Crear elemento de notificación
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    
    toast.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animar entrada
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-ocultar después de 3 segundos
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Función auxiliar para convertir valores a boolean
function toBooleanValue(value) {
    if (typeof value === 'boolean') {
        return value;
    }
    if (typeof value === 'string') {
        return value.toLowerCase() === 'true' || value === '1';
    }
    if (typeof value === 'number') {
        return value === 1;
    }
    return Boolean(value);
}

/**
 * Actualiza el estado visual del toggle de trazabilidad
 */
function updateTrazabilidadVisualState(areaId, isEnabled) {
    const toggle = document.querySelector(`.toggle-trazabilidad[data-id="${areaId}"]`);
    if (toggle) {
        const row = toggle.closest('tr');
        if (row) {
            // Efecto de destaque temporal
            row.style.backgroundColor = isEnabled ? '#dcfce7' : '#fef2f2';
            row.style.transition = 'background-color 0.3s ease';
            
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 1500);
        }
        
        console.log(`Estado visual actualizado - Área ${areaId}: ${isEnabled ? 'Habilitada' : 'Deshabilitada'}`);
    }
}

// Funciones del modal de crear
function openCreateModal() {
    const modal = document.getElementById('createAreaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Limpiar formulario
        document.getElementById('nombre').value = '';
        document.getElementById('clave').value = '';
        
        // Asegurarse de que ambos checkboxes estén desmarcados
        const esPlantaCheckbox = document.getElementById('es_planta');
        const trazabilidadCheckbox = document.getElementById('trazabilidad');
        
        esPlantaCheckbox.checked = false;
        esPlantaCheckbox.name = 'es_planta';
        
        if (trazabilidadCheckbox) {
            trazabilidadCheckbox.checked = false;
            trazabilidadCheckbox.name = 'trazabilidad';
        }
        
        // Remover cualquier campo oculto previo
        const form = modal.querySelector('form');
        const existingHiddenPlanta = form.querySelector('input[type="hidden"][name="es_planta"]');
        const existingHiddenTrazabilidad = form.querySelector('input[type="hidden"][name="trazabilidad"]');
        
        if (existingHiddenPlanta) existingHiddenPlanta.remove();
        if (existingHiddenTrazabilidad) existingHiddenTrazabilidad.remove();
        
        clearErrors(['nombre-error', 'clave-error']);

        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Focus en primer campo
        setTimeout(() => {
            document.getElementById('nombre').focus();
        }, 300);
        
        console.log('Modal de crear abierto - checkboxes:', {
            esPlanta: esPlantaCheckbox.checked,
            trazabilidad: trazabilidadCheckbox ? trazabilidadCheckbox.checked : 'No existe'
        });
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createAreaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Funciones del modal de editar
function openEditModal(id, nombre, clave, esPlanta, trazabilidad = false) {
    const modal = document.getElementById('editAreaModal');
    const modalContent = modal.querySelector('.bg-white');
    const form = document.getElementById('editAreaForm');

    if (modal) {
        // Construir URL del formulario
        const baseUrl = "{{ route('areas_auditoria.update', ':id') }}".replace(':id', id);
        form.action = baseUrl;

        // Llenar los campos con los datos actuales
        document.getElementById('edit_area_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_clave').value = clave;
        
        // Manejar el checkbox de es_planta
        const esPlantaCheckbox = document.getElementById('edit_es_planta');
        if (esPlantaCheckbox) {
            esPlantaCheckbox.checked = toBooleanValue(esPlanta);
            console.log('Modal edición - es_planta:', esPlanta, 'checkbox:', esPlantaCheckbox.checked);
        }
        
        // Manejar el checkbox de trazabilidad
        const trazabilidadCheckbox = document.getElementById('edit_trazabilidad');
        if (trazabilidadCheckbox) {
            trazabilidadCheckbox.checked = toBooleanValue(trazabilidad);
            console.log('Modal edición - trazabilidad:', trazabilidad, 'checkbox:', trazabilidadCheckbox.checked);
        }

        // Limpiar errores
        clearErrors(['edit-nombre-error', 'edit-clave-error']);

        // Debug
        console.log('Modal edición - Valores:', {
            id: id,
            nombre: nombre,
            clave: clave,
            esPlanta: esPlanta,
            trazabilidad: trazabilidad
        });

        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Focus en primer campo
        setTimeout(() => {
            const nombreField = document.getElementById('edit_nombre');
            nombreField.focus();
            nombreField.select();
        }, 300);
    } else {
        console.error('Modal de edición no encontrado');
    }
}

function closeEditModal() {
    const modal = document.getElementById('editAreaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Función para limpiar errores
function clearErrors(errorIds) {
    errorIds.forEach(id => {
        const errorElement = document.getElementById(id);
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.textContent = '';
        }
    });
}

// Función para mostrar errores
function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + '-error');
    const field = document.getElementById(fieldId);

    if (errorElement && field) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        field.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
    }
}

// Validaciones en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    // Validación para crear
    const nombreInput = document.getElementById('nombre');
    const claveInput = document.getElementById('clave');

    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
                document.getElementById('nombre-error').classList.add('hidden');
            }
        });
    }

    if (claveInput) {
        claveInput.addEventListener('input', function() {
            // Convertir a mayúsculas y remover espacios
            this.value = this.value.toUpperCase().replace(/\s+/g, '');

            if (this.value.length > 0) {
                this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
                document.getElementById('clave-error').classList.add('hidden');
            }
        });
    }

    // Validación para editar
    const editNombreInput = document.getElementById('edit_nombre');
    const editClaveInput = document.getElementById('edit_clave');

    if (editNombreInput) {
        editNombreInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
                document.getElementById('edit-nombre-error').classList.add('hidden');
            }
        });
    }

    if (editClaveInput) {
        editClaveInput.addEventListener('input', function() {
            // Convertir a mayúsculas y remover espacios
            this.value = this.value.toUpperCase().replace(/\s+/g, '');

            if (this.value.length > 0) {
                this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
                document.getElementById('edit-clave-error').classList.add('hidden');
            }
        });
    }
});

// Manejar envío de formularios
document.addEventListener('DOMContentLoaded', function() {
    // Formulario de crear
    const createForm = document.querySelector('#createAreaModal form');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitCreateBtn');
            const nombre = document.getElementById('nombre').value.trim();
            const clave = document.getElementById('clave').value.trim();
            
            // Manejar checkboxes
            const esPlantaCheckbox = document.getElementById('es_planta');
            const trazabilidadCheckbox = document.getElementById('trazabilidad');
            
            // Crear campos ocultos para ambos valores
            const esPlantaHidden = document.createElement('input');
            esPlantaHidden.type = 'hidden';
            esPlantaHidden.name = 'es_planta';
            esPlantaHidden.value = esPlantaCheckbox.checked ? '1' : '0';

            const trazabilidadHidden = document.createElement('input');
            trazabilidadHidden.type = 'hidden';
            trazabilidadHidden.name = 'trazabilidad';
            trazabilidadHidden.value = trazabilidadCheckbox ? (trazabilidadCheckbox.checked ? '1' : '0') : '0';

            // Remover campos ocultos existentes
            const existingHiddenPlanta = createForm.querySelector('input[type="hidden"][name="es_planta"]');
            const existingHiddenTrazabilidad = createForm.querySelector('input[type="hidden"][name="trazabilidad"]');
            
            if (existingHiddenPlanta) existingHiddenPlanta.remove();
            if (existingHiddenTrazabilidad) existingHiddenTrazabilidad.remove();
            
            // Cambiar nombres de los checkboxes para evitar conflictos
            esPlantaCheckbox.name = 'es_planta_checkbox';
            if (trazabilidadCheckbox) {
                trazabilidadCheckbox.name = 'trazabilidad_checkbox';
            }
            
            // Agregar los campos ocultos
            createForm.appendChild(esPlantaHidden);
            createForm.appendChild(trazabilidadHidden);

            // Validaciones básicas
            let hasErrors = false;

            if (nombre.length < 3) {
                showError('nombre', 'El nombre debe tener al menos 3 caracteres');
                hasErrors = true;
            }

            if (clave.length < 2) {
                showError('clave', 'La clave debe tener al menos 2 caracteres');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault();
                return;
            }

            // Deshabilitar botón y mostrar loading
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creando...
                `;

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }

            console.log('Formulario enviado con valores:', {
                nombre: nombre,
                clave: clave,
                es_planta: esPlantaHidden.value,
                trazabilidad: trazabilidadHidden.value
            });
        });
    }

    // Formulario de editar
    const editForm = document.getElementById('editAreaForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitEditBtn');
            const nombre = document.getElementById('edit_nombre').value.trim();
            const clave = document.getElementById('edit_clave').value.trim();

            // Manejar checkboxes para envío
            const esPlantaCheckbox = document.getElementById('edit_es_planta');
            const trazabilidadCheckbox = document.getElementById('edit_trazabilidad');
            
            // Crear campos ocultos para ambos valores
            const esPlantaHidden = document.createElement('input');
            esPlantaHidden.type = 'hidden';
            esPlantaHidden.name = 'es_planta';
            esPlantaHidden.value = esPlantaCheckbox ? (esPlantaCheckbox.checked ? '1' : '0') : '0';

            const trazabilidadHidden = document.createElement('input');
            trazabilidadHidden.type = 'hidden';
            trazabilidadHidden.name = 'trazabilidad';
            trazabilidadHidden.value = trazabilidadCheckbox ? (trazabilidadCheckbox.checked ? '1' : '0') : '0';

            // Remover campos ocultos existentes
            const existingHiddenPlanta = editForm.querySelector('input[type="hidden"][name="es_planta"]');
            const existingHiddenTrazabilidad = editForm.querySelector('input[type="hidden"][name="trazabilidad"]');
            
            if (existingHiddenPlanta) existingHiddenPlanta.remove();
            if (existingHiddenTrazabilidad) existingHiddenTrazabilidad.remove();
            
            // Cambiar nombres de los checkboxes para evitar conflictos
            if (esPlantaCheckbox) esPlantaCheckbox.name = 'es_planta_checkbox';
            if (trazabilidadCheckbox) trazabilidadCheckbox.name = 'trazabilidad_checkbox';
            
            // Agregar los campos ocultos
            editForm.appendChild(esPlantaHidden);
            editForm.appendChild(trazabilidadHidden);

            // Validaciones básicas
            let hasErrors = false;

            if (nombre.length < 3) {
                showError('edit_nombre', 'El nombre debe tener al menos 3 caracteres');
                hasErrors = true;
            }

            if (clave.length < 2) {
                showError('edit_clave', 'La clave debe tener al menos 2 caracteres');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault();
                return;
            }

            // Deshabilitar botón y mostrar loading
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Actualizando...
                `;

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }

            console.log('Formulario de edición enviado con valores:', {
                nombre: nombre,
                clave: clave,
                es_planta: esPlantaHidden.value,
                trazabilidad: trazabilidadHidden.value
            });
        });
    }
});

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
        closeDeleteModal();
    }
});

// Cerrar modales al hacer clic en el fondo
document.addEventListener('click', function(e) {
    if (e.target.id === 'createAreaModal') {
        closeCreateModal();
    }
    if (e.target.id === 'editAreaModal') {
        closeEditModal();
    }
    if (e.target.id === 'deleteAreaModal') {
        closeDeleteModal();
    }
});

/**
 * Abre el modal de confirmación de eliminación
 */
function openDeleteModal(id, nombre, clave, trazabilidad = false) {
    const modal = document.getElementById('deleteAreaModal');
    const modalContent = modal.querySelector('.bg-white');
    const form = document.getElementById('deleteAreaForm');

    if (modal) {
        // Guardar información del área
        deleteAreaId = id;
        deleteAreaName = nombre;

        // Configurar formulario
        const baseUrl = "{{ route('areas_auditoria.destroy', ':id') }}".replace(':id', id);
        form.action = baseUrl;

        // Mostrar información del área
        document.getElementById('delete-area-nombre').textContent = nombre;
        document.getElementById('delete-area-clave').textContent = clave;
        
        // Mostrar información de trazabilidad
        const trazabilidadInfo = document.getElementById('delete-area-trazabilidad');
        if (trazabilidadInfo) {
            const trazabilidadTexto = toBooleanValue(trazabilidad) ? 'Habilitada' : 'Deshabilitada';
            trazabilidadInfo.textContent = trazabilidadTexto;
            trazabilidadInfo.className = toBooleanValue(trazabilidad)
                ? 'bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-medium' 
                : 'bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-medium';
        }

        console.log('Modal eliminación - Área:', {
            id: id,
            nombre: nombre,
            clave: clave,
            trazabilidad: trazabilidad
        });

        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

/**
 * Cierra el modal de eliminación
 */
function closeDeleteModal() {
    const modal = document.getElementById('deleteAreaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Limpiar datos
            deleteAreaId = null;
            deleteAreaName = null;
        }, 300);
    }
}

/**
 * Confirma y ejecuta la eliminación
 */
function confirmDelete() {
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const form = document.getElementById('deleteAreaForm');

    if (confirmBtn && form) {
        // Mostrar estado de carga
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Eliminando...
        `;

        // Enviar formulario
        form.submit();
    }
}

/**
 * Maneja eventos de teclado para los modales
 */
function handleModalKeyEvents(e) {
    if (e.key === 'Escape') {
        // Cerrar modales si existen las funciones
        if (typeof closeCreateModal === 'function') closeCreateModal();
        if (typeof closeEditModal === 'function') closeEditModal();
        closeDeleteModal();
    }
}

/**
 * Maneja clics en el fondo de los modales
 */
function handleModalBackgroundClick(e) {
    if (e.target.id === 'createAreaModal' && typeof closeCreateModal === 'function') {
        closeCreateModal();
    }
    if (e.target.id === 'editAreaModal' && typeof closeEditModal === 'function') {
        closeEditModal();
    }
    if (e.target.id === 'deleteAreaModal') {
        closeDeleteModal();
    }
}

</script>
@endpush