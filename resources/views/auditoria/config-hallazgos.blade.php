@extends('home', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Configuración de Hallazgos')])

@section('contentJunzi')
<style>
/* Animaciones y estilos personalizados */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.fade-in { animation: fadeIn 0.5s ease-out; }
.slide-in { animation: slideIn 0.6s ease-out; }

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

input:checked + .toggle-slider {
    background-color: #10b981;
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

/* Estilos para botones y efectos hover */
.btn-hover {
    transition: all 0.2s ease-in-out;
}

.btn-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.table-row {
    transition: all 0.2s ease;
}

.table-row:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
}

/* Estilos de paginación */
.pagination-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: white;
    color: #374151;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination-btn:hover:not(.disabled):not(.active) {
    background-color: #f3f4f6;
    border-color: #9ca3af;
    color: #1f2937;
}

.pagination-btn.active {
    background-color: #7c3aed;
    border-color: #7c3aed;
    color: white;
    font-weight: 600;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.pagination-ellipsis {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}
</style>

<div class="bg-gray-50 min-h-screen py-8 mt-5">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-4">

        <!-- Header principal -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 rounded-xl shadow-xl mb-8 fade-in">
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
                            <h1 class="text-3xl font-bold text-white">Configuración de Hallazgos</h1>
                            <p class="text-white text-lg mt-1">Gestiona los hallazgos del sistema de auditorías</p>
                        </div>
                    </div>

                    <!-- Botón Nuevo Hallazgo -->
                    <div class="hidden sm:block">
                        <button onclick="openCreateModal()"
                           class="btn-hover inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 border border-green-400 rounded-lg text-white font-semibold focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Hallazgo
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
                        Nuevo Hallazgo
                    </button>
                </div>
            </div>
        </div>

        <!-- Alerta de éxito -->
        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-8 rounded-r-lg shadow-md slide-in">
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

        <!-- Controles de navegación y filtros -->
        <div class="bg-white rounded-xl shadow-lg mb-6 p-6 slide-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                
                <!-- Información y controles izquierda -->
                <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-6">
                    <!-- Información de registros -->
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">
                                @if(method_exists($hallazgos, 'firstItem'))
                                    Mostrando <span class="font-semibold text-purple-600">{{ $hallazgos->firstItem() }}</span> - 
                                    <span class="font-semibold text-purple-600">{{ $hallazgos->lastItem() }}</span> de 
                                    <span class="font-semibold text-purple-600">{{ $hallazgos->total() }}</span> resultados
                                @else
                                    <span class="font-semibold text-purple-600">{{ $hallazgos->count() }}</span> resultado(s)
                                @endif
                            </span>
                        </div>
                        
                        @if(request()->hasAny(['search', 'tipo', 'obligatorio']))
                        <!-- Indicador de filtros activos -->
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                </svg>
                                Filtrado
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Selector de elementos por página -->
                    <div class="flex items-center space-x-2">
                        <label for="items-per-page" class="text-sm font-medium text-gray-700">Por página:</label>
                        <form method="GET" action="{{ request()->url() }}" class="inline">
                            @foreach(request()->except('per_page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="per_page" onchange="this.form.submit()" 
                                class="px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Controles de filtros y búsqueda -->
                <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Formulario de búsqueda y filtros -->
                    <form method="GET" action="{{ request()->url() }}" class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @foreach(request()->except(['search', 'tipo', 'obligatorio', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <!-- Buscador -->
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar hallazgos..." value="{{ request('search') }}"
                                class="pl-10 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors w-64">
                            <div class="absolute left-3 top-2.5">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                            <a href="{{ request()->url() }}?{{ http_build_query(request()->except('search')) }}" 
                               class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            @endif
                        </div>

                        <!-- Filtros -->
                        <select name="tipo" onchange="this.form.submit()"
                            class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Todos los tipos</option>
                            <option value="OPERATIVO" {{ request('tipo') == 'OPERATIVO' ? 'selected' : '' }}>OPERATIVO</option>
                            <option value="ADMINISTRATIVO" {{ request('tipo') == 'ADMINISTRATIVO' ? 'selected' : '' }}>ADMINISTRATIVO</option>
                            <option value="OPERATIVO / ADMINISTRATIVO" {{ request('tipo') == 'OPERATIVO / ADMINISTRATIVO' ? 'selected' : '' }}>OPERATIVO / ADMINISTRATIVO</option>
                            <option value="ADM., OP y RH" {{ request('tipo') == 'ADM., OP y RH' ? 'selected' : '' }}>ADM., OP y RH</option>
                            <option value="CONTABILIDAD" {{ request('tipo') == 'CONTABILIDAD' ? 'selected' : '' }}>CONTABILIDAD</option>
                        </select>

                        <select name="obligatorio" onchange="this.form.submit()"
                            class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Todos</option>
                            <option value="1" {{ request('obligatorio') == '1' ? 'selected' : '' }}>Solo obligatorios</option>
                            <option value="0" {{ request('obligatorio') == '0' ? 'selected' : '' }}>Solo opcionales</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                            Filtrar
                        </button>
                    </form>

                    <!-- Botones de acción -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ request()->url() }}" 
                           class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" 
                           title="Limpiar filtros">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paginación Superior -->
        @if(method_exists($hallazgos, 'hasPages') && $hallazgos->hasPages())
        <div class="bg-white rounded-xl shadow-lg mb-6 p-4">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                <!-- Información de página -->
                <div class="text-sm text-gray-600">
                    Página {{ $hallazgos->currentPage() }} de {{ $hallazgos->lastPage() }}
                </div>

                <!-- Navegación de páginas -->
                <div class="flex items-center space-x-1">
                    {{-- Botón Primera Página --}}
                    @if($hallazgos->currentPage() > 1)
                        <a href="{{ $hallazgos->url(1) }}" class="pagination-btn" title="Primera página">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Botón Página Anterior --}}
                    @if($hallazgos->previousPageUrl())
                        <a href="{{ $hallazgos->previousPageUrl() }}" class="pagination-btn" title="Página anterior">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Números de Página --}}
                    @php
                        $currentPage = $hallazgos->currentPage();
                        $lastPage = $hallazgos->lastPage();
                        $startPage = max(1, $currentPage - 3);
                        $endPage = min($lastPage, $currentPage + 3);
                    @endphp

                    {{-- Primera página si no está en el rango --}}
                    @if($startPage > 1)
                        <a href="{{ $hallazgos->url(1) }}" class="pagination-btn">1</a>
                        @if($startPage > 2)
                            <span class="pagination-ellipsis">...</span>
                        @endif
                    @endif

                    {{-- Páginas en el rango --}}
                    @for($i = $startPage; $i <= $endPage; $i++)
                        @if($i == $currentPage)
                            <span class="pagination-btn active">{{ $i }}</span>
                        @else
                            <a href="{{ $hallazgos->url($i) }}" class="pagination-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Última página si no está en el rango --}}
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span class="pagination-ellipsis">...</span>
                        @endif
                        <a href="{{ $hallazgos->url($lastPage) }}" class="pagination-btn">{{ $lastPage }}</a>
                    @endif

                    {{-- Botón Página Siguiente --}}
                    @if($hallazgos->nextPageUrl())
                        <a href="{{ $hallazgos->nextPageUrl() }}" class="pagination-btn" title="Página siguiente">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Botón Última Página --}}
                    @if($hallazgos->currentPage() < $lastPage)
                        <a href="{{ $hallazgos->url($lastPage) }}" class="pagination-btn" title="Última página">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- Ir a página específica -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Ir a:</span>
                    <form method="GET" action="{{ request()->url() }}" class="inline-flex items-center space-x-2">
                        @foreach(request()->except('page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="number" name="page" min="1" max="{{ $lastPage }}" 
                               placeholder="Página" value="{{ $currentPage }}"
                               class="w-20 px-2 py-1 text-sm text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="submit" class="px-3 py-1 text-sm bg-purple-600 text-white rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Ir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabla de hallazgos -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden slide-in">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Lista de Hallazgos ({{ method_exists($hallazgos, 'total') ? $hallazgos->total() : $hallazgos->count() }} registros)
                    </h2>
                    <div class="text-sm text-gray-500">
                        Total de hallazgos configurados
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Obligatorio</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Área</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Título</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Subtítulo</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($hallazgos as $hallazgo)
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-bold text-purple-600">{{ $loop->iteration }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label class="toggle-switch">
                                        <input type="checkbox" class="toggle-obligatorio"
                                            data-id="{{ $hallazgo->id }}"
                                            {{ $hallazgo->obligatorio ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $hallazgo->area }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate" title="{{ $hallazgo->titulo }}">
                                        {{ $hallazgo->titulo }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @switch($hallazgo->tipo)
                                            @case('OPERATIVO')
                                                bg-green-100 text-green-800
                                                @break
                                            @case('ADMINISTRATIVO')
                                                bg-yellow-100 text-yellow-800
                                                @break
                                            @case('CONTABILIDAD')
                                                bg-purple-100 text-purple-800
                                                @break
                                            @default
                                                bg-gray-100 text-gray-800
                                        @endswitch
                                    ">
                                        {{ $hallazgo->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $hallazgo->subtitulo }}">
                                        {{ $hallazgo->subtitulo ?: '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Botón Editar -->
                                        <button onclick="openEditModal({{ $hallazgo->id }}, '{{ addslashes($hallazgo->area) }}', '{{ addslashes($hallazgo->titulo) }}', '{{ $hallazgo->tipo }}', '{{ addslashes($hallazgo->subtitulo) }}')"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                                           title="Editar hallazgo">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button type="button"
                                                onclick="openDeleteModal({{ $hallazgo->id }}, '{{ addslashes($hallazgo->titulo) }}')"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                                title="Eliminar hallazgo">
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
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay hallazgos configurados</h3>
                                        <p class="text-gray-500 mb-4">Comienza agregando tu primer hallazgo.</p>
                                        <button onclick="openCreateModal()"
                                           class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:border-purple-700 focus:ring ring-purple-200 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Nuevo Hallazgo
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación Inferior -->
        @if(method_exists($hallazgos, 'hasPages') && $hallazgos->hasPages())
        <div class="bg-white rounded-xl shadow-lg mt-6 p-4">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                <!-- Información de registros -->
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $hallazgos->total() }} hallazgo(s) total(es)</span>
                    </div>
                    <div class="hidden md:block text-gray-300">|</div>
                    <div class="hidden md:block">
                        <span>{{ $hallazgos->where('obligatorio', true)->count() }} obligatorio(s)</span>
                    </div>
                    <div class="hidden md:block text-gray-300">|</div>
                    <div class="hidden md:block">
                        <span>Actualizado: {{ now()->format('H:i') }}</span>
                    </div>
                </div>

                <!-- Navegación compacta -->
                <div class="flex items-center space-x-2">
                    {{-- Botón Anterior Compacto --}}
                    @if($hallazgos->previousPageUrl())
                        <a href="{{ $hallazgos->previousPageUrl() }}" 
                           class="p-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors"
                           title="Página anterior">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="p-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Números de página compactos --}}
                    @php
                        $currentPage = $hallazgos->currentPage();
                        $lastPage = $hallazgos->lastPage();
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp

                    @for($i = $startPage; $i <= $endPage; $i++)
                        @if($i == $currentPage)
                            <span class="w-8 h-8 flex items-center justify-center text-xs border rounded-md bg-purple-600 text-white border-purple-600 font-semibold">
                                {{ $i }}
                            </span>
                        @else
                            <a href="{{ $hallazgos->url($i) }}" 
                               class="w-8 h-8 flex items-center justify-center text-xs border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                                {{ $i }}
                            </a>
                        @endif
                    @endfor

                    {{-- Botón Siguiente Compacto --}}
                    @if($hallazgos->nextPageUrl())
                        <a href="{{ $hallazgos->nextPageUrl() }}" 
                           class="p-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors"
                           title="Página siguiente">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="p-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- Botones de exportación y página actual -->
                <div class="flex items-center space-x-4">
                    <span class="text-xs text-gray-500 font-medium">
                        Página {{ $hallazgos->currentPage() }} de {{ $hallazgos->lastPage() }}
                    </span>
                    
                    <!-- Botones de exportación -->
                    <div class="flex items-center space-x-1">
                        <span class="text-xs text-gray-500 font-medium">Exportar:</span>
                        <button onclick="exportData('csv')"
                            class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded hover:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-400 transition-colors"
                            title="Exportar a CSV">CSV</button>
                        <button onclick="exportData('xlsx')"
                            class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded hover:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-400 transition-colors"
                            title="Exportar a Excel">Excel</button>
                        <button onclick="exportData('pdf')"
                            class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded hover:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-400 transition-colors"
                            title="Exportar a PDF">PDF</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Controles flotantes para móvil -->
        @if(method_exists($hallazgos, 'hasPages') && $hallazgos->hasPages())
        <div class="fixed bottom-4 right-4 sm:hidden">
            <div class="bg-white rounded-full shadow-lg border border-gray-200 p-2 flex items-center space-x-2">
                @if($hallazgos->previousPageUrl())
                    <a href="{{ $hallazgos->previousPageUrl() }}" 
                       class="p-2 text-gray-600 hover:text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @else
                    <span class="p-2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                @endif
                
                <span class="text-sm font-medium text-gray-700 px-2">{{ $hallazgos->currentPage() }}/{{ $hallazgos->lastPage() }}</span>
                
                @if($hallazgos->nextPageUrl())
                    <a href="{{ $hallazgos->nextPageUrl() }}" 
                       class="p-2 text-gray-600 hover:text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="p-2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal para Crear Nuevo Hallazgo -->
<div id="createHallazgoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Hallazgo
                </h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form id="createHallazgoForm" action="{{ route('config.hallazgos.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo de selección de área -->
                <div>
                    <label for="area" class="block text-sm font-semibold text-gray-700 mb-2">Área</label>
                    <select name="area" id="area" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <option value="">Selecciona un área</option>
                        @foreach($areas as $area)
                            <option value="{{ $area }}">{{ $area }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="addAreaBtn"
                            class="mt-2 text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                        + Agregar nueva área
                    </button>
                    <input type="text" id="new-area" name="area_nueva"
                           class="hidden mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                           placeholder="Nombre de la nueva área">
                </div>

                <!-- Campo de selección de título -->
                <div>
                    <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">Título</label>
                    <select name="titulo" id="titulo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <option value="">Selecciona un título</option>
                        @foreach($titulos as $titulo)
                            <option value="{{ $titulo }}">{{ $titulo }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="addTituloBtn"
                            class="mt-2 text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                        + Agregar nuevo título
                    </button>
                    <input type="text" id="new-titulo" name="titulo_nuevo"
                           class="hidden mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                           placeholder="Título del nuevo hallazgo">
                </div>

                <!-- Campo Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo</label>
                    <select name="tipo" id="tipo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <option value="">Selecciona un tipo</option>
                        <option value="OPERATIVO">OPERATIVO</option>
                        <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                        <option value="OPERATIVO / ADMINISTRATIVO">OPERATIVO / ADMINISTRATIVO</option>
                        <option value="ADM., OP y RH">ADM., OP y RH</option>
                        <option value="CONTABILIDAD">CONTABILIDAD</option>
                    </select>
                </div>

                <!-- Campo Subtítulo -->
                <div>
                    <label for="subtitulo" class="block text-sm font-semibold text-gray-700 mb-2">Subtítulo (Opcional)</label>
                    <input type="text" name="subtitulo" id="subtitulo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        placeholder="Subtítulo del hallazgo">
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="submitCreateBtn"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-green-600 text-base font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Hallazgo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Hallazgo -->
<div id="editHallazgoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Hallazgo
                </h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form id="editHallazgoForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">

                <!-- Campo Área -->
                <div>
                    <label for="edit-area" class="block text-sm font-semibold text-gray-700 mb-2">Área</label>
                    <input type="text" name="area" id="edit-area" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <!-- Campo Título -->
                <div>
                    <label for="edit-titulo" class="block text-sm font-semibold text-gray-700 mb-2">Título</label>
                    <input type="text" name="titulo" id="edit-titulo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <!-- Campo Tipo -->
                <div>
                    <label for="edit-tipo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo</label>
                    <select name="tipo" id="edit-tipo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Selecciona un tipo</option>
                        <option value="OPERATIVO">OPERATIVO</option>
                        <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                        <option value="OPERATIVO / ADMINISTRATIVO">OPERATIVO / ADMINISTRATIVO</option>
                        <option value="ADM., OP y RH">ADM., OP y RH</option>
                        <option value="CONTABILIDAD">CONTABILIDAD</option>
                    </select>
                </div>

                <!-- Campo Subtítulo -->
                <div>
                    <label for="edit-subtitulo" class="block text-sm font-semibold text-gray-700 mb-2">Subtítulo</label>
                    <input type="text" name="subtitulo" id="edit-subtitulo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="submitEditBtn"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Actualizar Hallazgo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteHallazgoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
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
                <!-- Información del hallazgo a eliminar -->
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">Hallazgo a eliminar:</h4>
                            <div class="mt-2 text-sm text-red-700">
                                <p><span class="font-semibold">Título:</span> <span id="delete-hallazgo-titulo"></span></p>
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
                                <span class="font-medium">¡Advertencia!</span> Esta acción eliminará permanentemente el hallazgo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario oculto para envío -->
            <form id="deleteHallazgoForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- Botones del modal -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="confirmDeleteBtn" onclick="confirmDelete()"
                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span id="deleteButtonText">Eliminar Hallazgo</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables globales
let deleteHallazgoId = null;
let deleteHallazgoTitulo = null;

// Funciones de modales
function openCreateModal() {
    const modal = document.getElementById('createHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        document.getElementById('createHallazgoForm').reset();
        document.getElementById('new-area').classList.add('hidden');
        document.getElementById('new-titulo').classList.add('hidden');
        document.getElementById('addAreaBtn').style.display = 'inline';
        document.getElementById('addTituloBtn').style.display = 'inline';
        document.getElementById('area').setAttribute('required', 'required');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('area').focus();
        }, 300);
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

function openEditModal(id, area, titulo, tipo, subtitulo) {
    const modal = document.getElementById('editHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-area').value = area;
        document.getElementById('edit-titulo').value = titulo;
        document.getElementById('edit-tipo').value = tipo;
        document.getElementById('edit-subtitulo').value = subtitulo || '';

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('edit-area').focus();
        }, 300);
    }
}

function closeEditModal() {
    const modal = document.getElementById('editHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

function openDeleteModal(id, titulo) {
    const modal = document.getElementById('deleteHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');
    const form = document.getElementById('deleteHallazgoForm');

    if (modal) {
        deleteHallazgoId = id;
        deleteHallazgoTitulo = titulo;

        form.action = `/config-hallazgos/destroy/${id}`;
        document.getElementById('delete-hallazgo-titulo').textContent = titulo;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            deleteHallazgoId = null;
            deleteHallazgoTitulo = null;
        }, 300);
    }
}

function confirmDelete() {
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    if (confirmBtn && deleteHallazgoId) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Eliminando...
        `;

        fetch(`/config-hallazgos/destroy/${deleteHallazgoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== false) {
                showNotification('Hallazgo eliminado exitosamente', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Error al eliminar el hallazgo');
            }
        })
        .catch(error => {
            showNotification(error.message || 'Error al eliminar el hallazgo', 'error');
            // Resetear botón
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span id="deleteButtonText">Eliminar Hallazgo</span>
            `;
        });
    }
}

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 
                   type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Función para exportar datos
function exportData(format) {
    showNotification(`Preparando exportación en formato ${format.toUpperCase()}...`, 'info');
    
    setTimeout(() => {
        showNotification(`Exportación en ${format.toUpperCase()} iniciada`, 'success');
    }, 1000);
}

// Manejo de formularios
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de estado obligatorio
    document.querySelectorAll('.toggle-obligatorio').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hallazgoId = this.dataset.id;
            const nuevoEstado = this.checked ? 1 : 0;

            fetch(`/config-hallazgos/obligatorio/${hallazgoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    obligatorio: nuevoEstado
                })
            })
            .then(response => {
                if (!response.ok) throw new Error("Error al actualizar");
                return response.json();
            })
            .then(data => {
                showNotification('Estado actualizado correctamente', 'success');
            })
            .catch(error => {
                this.checked = !this.checked;
                showNotification('Error al actualizar el estado', 'error');
            });
        });
    });

    // Campos dinámicos
    const addAreaBtn = document.getElementById('addAreaBtn');
    const addTituloBtn = document.getElementById('addTituloBtn');
    const newAreaInput = document.getElementById('new-area');
    const newTituloInput = document.getElementById('new-titulo');
    const areaSelect = document.getElementById('area');
    const tituloSelect = document.getElementById('titulo');

    if (addAreaBtn) {
        addAreaBtn.addEventListener('click', () => {
            newAreaInput.classList.remove('hidden');
            addAreaBtn.style.display = 'none';
            if (areaSelect) areaSelect.removeAttribute('required');
            newAreaInput.focus();
        });
    }

    if (addTituloBtn) {
        addTituloBtn.addEventListener('click', () => {
            newTituloInput.classList.remove('hidden');
            addTituloBtn.style.display = 'none';
            if (tituloSelect) tituloSelect.removeAttribute('required');
            newTituloInput.focus();
        });
    }

    // Formulario de creación
    const createForm = document.getElementById('createHallazgoForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const areaValue = areaSelect.value || newAreaInput.value.trim();
            const tituloValue = tituloSelect.value || newTituloInput.value.trim();
            const tipoValue = document.getElementById('tipo').value;

            if (!areaValue) {
                showNotification('Debes seleccionar o agregar un área', 'error');
                return;
            }

            if (!tituloValue) {
                showNotification('Debes seleccionar o agregar un título', 'error');
                return;
            }

            if (!tipoValue) {
                showNotification('Debes seleccionar un tipo', 'error');
                return;
            }

            this.submit();
        });
    }

    // Formulario de edición
    const editForm = document.getElementById('editHallazgoForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const formData = new FormData(this);

            fetch(`/config-hallazgos/update/${id}`, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success !== false) {
                    showNotification('Hallazgo actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    throw new Error(data.message || 'Error al actualizar el hallazgo');
                }
            })
            .catch(error => {
                showNotification(error.message || 'Error al actualizar el hallazgo', 'error');
            });
        });
    }

    // Cerrar modales con Esc
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeDeleteModal();
        }
    });

    // Cerrar modales al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (e.target.id === 'createHallazgoModal') {
            closeCreateModal();
        }
        if (e.target.id === 'editHallazgoModal') {
            closeEditModal();
        }
        if (e.target.id === 'deleteHallazgoModal') {
            closeDeleteModal();
        }
    });

    // Auto-hide success alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.slide-in');
        alerts.forEach(alert => {
            if (alert.classList.contains('bg-green-50')) {
                alert.style.transform = 'translateX(100%)';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);
});
</script>

@endpush