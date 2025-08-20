@extends('home', ['activePage' => 'TrazabilidadVentas', 'menuParent' => 'ventas', 'titlePage' => __('Trazabilidad Ventas')])

@section('contentJunzi')

<div class="p-6">
    <div class="max-w-7xl mx-auto py-8 mt-5">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Lista de Trazabilidad Ventas</h2>

        <button onclick="openCreateModal()" 
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors duration-200 mb-6">
            Crear Nuevo Registro
        </button>

        @if(session('success'))
            @php
                $isDelete = str_contains(strtolower(session('success')), 'eliminad') || 
                           str_contains(strtolower(session('success')), 'borrad') || 
                           str_contains(strtolower(session('success')), 'delete');
            @endphp
            <div id="alertMessage" 
                 class="{{ $isDelete ? 'bg-red-100 border border-red-400 text-red-700' : 'bg-green-100 border border-green-400 text-green-700' }} px-4 py-3 rounded mb-6 flex items-center justify-between transition-all duration-500 ease-in-out" 
                 role="alert">
                <div class="flex items-center">
                    @if($isDelete)
                        <svg class="h-5 w-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg class="h-5 w-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="closeAlert()" class="ml-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-medium text-gray-900">Filtrar por</h4>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('trazabilidad_ventas.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="anio" class="block text-sm font-medium text-gray-700 mb-2">Año</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    id="anio" name="anio">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="mes" class="block text-sm font-medium text-gray-700 mb-2">Mes</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    id="mes" name="mes">
                                @foreach($allMonths as $monthValue => $monthName)
                                    <option value="{{ $monthValue }}" {{ $monthValue == $selectedMonth ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                                Filtrar
                            </button>
                            <a href="{{ route('trazabilidad_ventas.index') }}" 
                               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-md transition-colors duration-200">
                                Resetear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de datos -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Planta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nota de Entrega</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carta Porte</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complemento Carta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($trazabilidadVentas as $trazabilidadVenta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->empresa }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->planta }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->nota_de_entrega }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->factura }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->carta_porte }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trazabilidadVenta->complemento_carta }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button onclick="openEditModal({{ $trazabilidadVenta->id }}, '{{ $trazabilidadVenta->planta }}', {{ $trazabilidadVenta->anio }}, '{{ str_pad($trazabilidadVenta->mes, 2, '0', STR_PAD_LEFT) }}', {{ $trazabilidadVenta->nota_de_entrega }}, {{ $trazabilidadVenta->factura }}, {{ $trazabilidadVenta->carta_porte }}, {{ $trazabilidadVenta->complemento_carta }})" 
                                            class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors duration-200">
                                        Editar
                                    </button>
                                    <button onclick="openDeleteModal({{ $trazabilidadVenta->id }}, '{{ $trazabilidadVenta->empresa }}', '{{ $trazabilidadVenta->planta }}', '{{ $trazabilidadVenta->nota_de_entrega }}', '{{ $trazabilidadVenta->factura }}', '{{ $trazabilidadVenta->carta_porte }}', '{{ $trazabilidadVenta->complemento_carta }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition-colors duration-200">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gráfica: Por Documento -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-medium text-gray-900">Estadísticas por Documento</h4>
            </div>
            <div class="p-6">
                <div class="relative" style="height: 400px;">
                    <canvas id="ventasPorDocumentoChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfica por Área -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-medium text-gray-900">Estadísticas de Ventas por Planta</h4>
            </div>
            <div class="p-6">
                <div class="relative" style="height: 400px;">
                    <canvas id="ventasAreaChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Eliminación -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-25 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 xl:w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="mt-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Detalles del registro a eliminar:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Empresa:</span>
                            <span id="delete_empresa_display" class="text-gray-900 ml-1"></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Planta:</span>
                            <span id="delete_planta_display" class="text-gray-900 ml-1"></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Nota de Entrega:</span>
                            <span id="delete_nota_display" class="text-gray-900 ml-1"></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Factura:</span>
                            <span id="delete_factura_display" class="text-gray-900 ml-1"></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Carta Porte:</span>
                            <span id="delete_carta_display" class="text-gray-900 ml-1"></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Complemento Carta:</span>
                            <span id="delete_complemento_display" class="text-gray-900 ml-1"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">¡Atención!</h3>
                            <p class="mt-1 text-sm text-red-700">
                                Una vez eliminado este registro, no podrás recuperarlo. Todos los datos asociados se perderán permanentemente.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones del Modal -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md transition-colors duration-200">
                        Cancelar
                    </button>
                    <form id="deleteForm" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Sí, Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Registro -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-25 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Editar Trazabilidad Venta</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="mt-6">
                <form id="editForm" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Ubicación -->
                    <div>
                        <label for="edit_planta" class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                        <select id="edit_planta" name="planta" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Selecciona:</option>
                            @foreach($areasAuditoria as $area)
                                <option value="{{ $area->clave }}">{{ $area->clave }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grid para Año y Mes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Año -->
                        <div>
                            <label for="edit_anio" class="block text-sm font-medium text-gray-700 mb-2">Año</label>
                            <select id="edit_anio" name="anio" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                @for($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Mes -->
                        <div>
                            <label for="edit_mes" class="block text-sm font-medium text-gray-700 mb-2">Mes</label>
                            <select id="edit_mes" name="mes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid para los campos numéricos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nota de Entrega -->
                        <div>
                            <label for="edit_nota_de_entrega" class="block text-sm font-medium text-gray-700 mb-2">Nota de Entrega</label>
                            <input type="number" id="edit_nota_de_entrega" name="nota_de_entrega" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Factura -->
                        <div>
                            <label for="edit_factura" class="block text-sm font-medium text-gray-700 mb-2">Factura</label>
                            <input type="number" id="edit_factura" name="factura" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Carta Porte -->
                        <div>
                            <label for="edit_carta_porte" class="block text-sm font-medium text-gray-700 mb-2">Carta Porte</label>
                            <input type="number" id="edit_carta_porte" name="carta_porte" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Complemento Carta -->
                        <div>
                            <label for="edit_complemento_carta" class="block text-sm font-medium text-gray-700 mb-2">Complemento Carta</label>
                            <input type="number" id="edit_complemento_carta" name="complemento_carta" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Botones del Modal -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                            Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Nuevo Registro -->
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-25 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Crear Trazabilidad Venta</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="mt-6">
                <form action="{{ route('trazabilidad_ventas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Ubicación -->
                    <div>
                        <label for="planta" class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                        <select id="planta" name="planta" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Selecciona:</option>
                            @foreach($areasAuditoria as $area)
                                <option value="{{ $area->clave }}">{{ $area->clave }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grid para los campos numéricos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nota de Entrega -->
                        <div>
                            <label for="nota_de_entrega" class="block text-sm font-medium text-gray-700 mb-2">Nota de Entrega</label>
                            <input type="number" id="nota_de_entrega" name="nota_de_entrega" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Factura -->
                        <div>
                            <label for="factura" class="block text-sm font-medium text-gray-700 mb-2">Factura</label>
                            <input type="number" id="factura" name="factura" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Carta Porte -->
                        <div>
                            <label for="carta_porte" class="block text-sm font-medium text-gray-700 mb-2">Carta Porte</label>
                            <input type="number" id="carta_porte" name="carta_porte" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Complemento Carta -->
                        <div>
                            <label for="complemento_carta" class="block text-sm font-medium text-gray-700 mb-2">Complemento Carta</label>
                            <input type="number" id="complemento_carta" name="complemento_carta" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Grid para Año y Mes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Año -->
                        <div>
                            <label for="anio" class="block text-sm font-medium text-gray-700 mb-2">Año</label>
                            <input type="number" id="anio" name="anio" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ date('Y') }}" required>
                        </div>

                        <!-- Mes -->
                        <div>
                            <label for="mes" class="block text-sm font-medium text-gray-700 mb-2">Mes</label>
                            <select id="mes" name="mes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>Enero</option>
                                <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>Febrero</option>
                                <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>Marzo</option>
                                <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>Abril</option>
                                <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>Mayo</option>
                                <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>Junio</option>
                                <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>Julio</option>
                                <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>Agosto</option>
                                <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>Septiembre</option>
                                <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>Octubre</option>
                                <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>Noviembre</option>
                                <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>Diciembre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones del Modal -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors duration-200">
                            Crear Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Función para cerrar alerta manualmente
function closeAlert() {
    const alert = document.getElementById('alertMessage');
    if (alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

// Auto-cerrar alertas después de 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alertMessage');
    if (alert) {
        // Agregar animación de entrada
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        
        // Animar entrada
        setTimeout(() => {
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 100);
        
        // Auto-cerrar después de 5 segundos
        setTimeout(() => {
            if (document.getElementById('alertMessage')) {
                closeAlert();
            }
        }, 5000);
    }
});

// Funciones para el modal de eliminación
function openDeleteModal(id, empresa, planta, notaEntrega, factura, cartaPorte, complementoCarta) {
    // Establecer la action del formulario de eliminación
    document.getElementById('deleteForm').action = `/trazabilidad_ventas/${id}`;
    
    // Llenar los datos a mostrar en el modal
    document.getElementById('delete_empresa_display').textContent = empresa;
    document.getElementById('delete_planta_display').textContent = planta;
    document.getElementById('delete_nota_display').textContent = notaEntrega || 'N/A';
    document.getElementById('delete_factura_display').textContent = factura || 'N/A';
    document.getElementById('delete_carta_display').textContent = cartaPorte || 'N/A';
    document.getElementById('delete_complemento_display').textContent = complementoCarta || 'N/A';
    
    // Mostrar el modal
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones para el modal de creación
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.querySelector('#createModal form').reset();
    document.getElementById('anio').value = {{ date('Y') }};
    document.getElementById('mes').value = {{ date('n') }};
}

// Funciones para el modal de edición - CORREGIDA
function openEditModal(id, planta, anio, mes, notaEntrega, factura, cartaPorte, complementoCarta) {
    // Establecer la action del formulario
    document.getElementById('editForm').action = `/trazabilidad_ventas/${id}`;
    
    // Llenar los campos con los datos actuales
    document.getElementById('edit_planta').value = planta;
    document.getElementById('edit_anio').value = anio;
    document.getElementById('edit_mes').value = mes;
    document.getElementById('edit_nota_de_entrega').value = notaEntrega;
    document.getElementById('edit_factura').value = factura;
    document.getElementById('edit_carta_porte').value = cartaPorte;
    document.getElementById('edit_complemento_carta').value = complementoCarta;
    
    // Mostrar el modal
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cerrar modales con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
        closeDeleteModal();
    }
});

// Cerrar modal de creación al hacer clic fuera de él
document.getElementById('createModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});

// Cerrar modal de edición al hacer clic fuera de él
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Cerrar modal de eliminación al hacer clic fuera de él
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ctxArea = document.getElementById('ventasAreaChart').getContext('2d');
    const chartDataArea = {
        areas: @json($chartDataAreas['areas']),
        nota_entrega: @json($chartDataAreas['nota_entrega']),
        factura: @json($chartDataAreas['factura']),
        carta_porte: @json($chartDataAreas['carta_porte']),
        complemento_carta: @json($chartDataAreas['complemento_carta'])
    };

    const replaceZeroWithNull = (value) => value === 0 ? null : value;

    const datasetsArea = [
        {
            label: 'Nota de Entrega',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.nota_entrega[area] || null)),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Factura',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.factura[area] || null)),
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Carta Porte',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.carta_porte[area] || null)),
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Complemento Carta',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.complemento_carta[area] || null)),
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        }
    ];

    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: chartDataArea.areas,
            datasets: datasetsArea
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    min: 0,
                    title: {
                        display: true,
                        text: 'Porcentaje (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Plantas'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Métricas por planta'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw === null ?
                                `${context.dataset.label}: Sin dato` :
                                `${context.dataset.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });

    const ctxPorDocumento = document.getElementById('ventasPorDocumentoChart').getContext('2d');

    // Transformar los datos para que cada planta sea un dataset
    const documentos = ['Nota de Entrega', 'Factura', 'Carta Porte', 'Complemento Carta'];
    const plantas = chartDataArea.areas;

    const datasetsPorDocumento = plantas.map(planta => {
        return {
            label: planta,
            data: [
                replaceZeroWithNull(chartDataArea.nota_entrega[planta] || null),
                replaceZeroWithNull(chartDataArea.factura[planta] || null),
                replaceZeroWithNull(chartDataArea.carta_porte[planta] || null),
                replaceZeroWithNull(chartDataArea.complemento_carta[planta] || null)
            ],
            borderColor: `hsl(${Math.random() * 360}, 70%, 50%)`,
            backgroundColor: 'rgba(255,255,255,0.2)',
            tension: 0.1,
            spanGaps: true
        };
    });

    new Chart(ctxPorDocumento, {
        type: 'line',
        data: {
            labels: documentos,
            datasets: datasetsPorDocumento
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    min: 0,
                    title: {
                        display: true,
                        text: 'Porcentaje (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tipo de Documento'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Métricas por Documento'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw === null ?
                                `${context.dataset.label}: Sin dato` :
                                `${context.dataset.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });
});
</script>

@endpush