@extends('home', ['activePage' => 'Entregables', 'menuParent' => 'forms', 'titlePage' => __('Entregables')])

@section('contentJunzi')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 mt-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Configuración de Entregas de Auditoría</h1>
                <p class="text-gray-600">Gestiona los tipos de reportes y sus períodos de entrega</p>
            </div>

            <!-- Alertas -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center animate-pulse">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="inline-flex text-green-400 hover:text-green-600 transition-colors duration-200" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Se encontraron los siguientes errores:</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-center">
                                        <span class="w-1 h-1 bg-red-400 rounded-full mr-2"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card Principal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                
                <!-- Header de la tabla -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white">Tipos de Reportes</h2>
                            <p class="text-white text-sm mt-1">Administra los reportes disponibles para auditoría</p>
                        </div>
                        <!-- Botón para abrir modal -->
                        <button id="btnAbrirModalCrear" type="button"
                               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear Nuevo
                        </button>
                    </div>
                </div>


                <!-- Contenido de la tabla -->
                <div class="overflow-x-auto">
                    @if($configEntregas->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Reporte</span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Período</span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                            <span>Acciones</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($configEntregas as $config)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    @php
                                                        $iconoReporte = match(strtolower($config->periodo ?? '')) {
                                                            'diario' => '📅',
                                                            'semanal' => '📊',
                                                            'mensual' => '📈',
                                                            'anual' => '📋',
                                                            default => '📄'
                                                        };
                                                    @endphp
                                                    <span class="text-lg">{{ $iconoReporte }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $config->reporte }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        ID: {{ $config->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colorPeriodo = match(strtolower($config->periodo ?? '')) {
                                                    'diario' => 'bg-green-100 text-green-800',
                                                    'semanal' => 'bg-blue-100 text-blue-800',
                                                    'mensual' => 'bg-purple-100 text-purple-800',
                                                    'anual' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $colorPeriodo }}">
                                                {{ $config->periodo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <!-- Botón Editar -->
                                                <button onclick="editarReporte({{ $config->id }}, '{{ $config->reporte }}', '{{ $config->periodo }}')"
                                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-150"
                                                       title="Editar reporte">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Botón Eliminar -->
                                                {{-- <form action="{{ route('config-entregas-auditoria.destroy', $config->id) }}" 
                                                      method="POST" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar el reporte &quot;{{ $config->reporte }}&quot;?\n\nEsta acción no se puede deshacer.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                            title="Eliminar reporte">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form> --}}
                                            <button onclick="abrirModalEliminar({{ $config->id }}, '{{ $config->reporte }}')"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                title="Eliminar reporte">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <!-- Estado vacío -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No hay reportes configurados</h3>
                            <p class="mt-2 text-sm text-gray-500">Comienza creando tu primer tipo de reporte para auditoría.</p>
                            <div class="mt-6">
                                <button id="btnCrearPrimero" type="button"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Crear Primer Reporte
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer de la tabla -->
                @if($configEntregas->count() > 0)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                <span class="font-medium">{{ $configEntregas->count() }}</span>
                                {{ $configEntregas->count() === 1 ? 'reporte configurado' : 'reportes configurados' }}
                            </div>
                            {{-- <div class="text-xs text-gray-500">
                                Última actualización: {{ now()->format('d/m/Y H:i') }}
                            </div> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para Crear/Editar Reporte -->
    <div id="modalCrearReporte" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-8 mx-auto p-4 border w-11/12 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 shadow-2xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
            
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-xl bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 id="modal-title" class="text-lg font-bold text-gray-900">Crear Nuevo Reporte</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure el tipo de reporte de auditoría</p>
                    </div>
                </div>
                <button id="btnCerrarModalCrear" type="button" class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-lg p-2 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6">
                <!-- Contenedor para mensajes -->
                <div id="modalCrearMessages" class="mb-4"></div>

                <form id="formCrearReporte" action="{{ route('config-entregas-auditoria.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" id="reporte_id" name="id" value="">
                    <input type="hidden" id="form_method" name="_method" value="">

                    <!-- Campo Nombre del Reporte -->
                    <div class="space-y-2">
                        <label for="modal_reporte" class="block text-sm font-semibold text-gray-700">
                            Nombre del Reporte <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="reporte" 
                               id="modal_reporte" 
                               required
                               placeholder="Ej: Reporte de Ventas, Control de Inventario..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                    </div>

                    <!-- Campo Período -->
                    <div class="space-y-2">
                        <label for="modal_periodo" class="block text-sm font-semibold text-gray-700">
                            Período <span class="text-red-500">*</span>
                        </label>
                        <select name="periodo" 
                                id="modal_periodo" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                            <option value="">Seleccione un período</option>
                            <option value="Diario">📅 Diario</option>
                            <option value="Semanal">📊 Semanal</option>
                            <option value="Mensual">📈 Mensual</option>
                            <option value="Trimestral">📋 Trimestral</option>
                            <option value="Semestral">📊 Semestral</option>
                            <option value="Anual">📋 Anual</option>
                        </select>
                    </div>

                    <!-- Información del período seleccionado -->
                    <div id="periodo-info" class="hidden p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-medium mb-1">Información del período:</p>
                                <p id="periodo-descripcion"></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl space-x-3">
                <button id="btnCancelarModalCrear" type="button"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition duration-150 ease-in-out shadow-sm">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </span>
                </button>
                <button id="btnGuardarReporte" type="submit" form="formCrearReporte"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition duration-150 ease-in-out transform hover:scale-105 shadow-lg">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="btn-text">Crear Reporte</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

        <!-- Modal de Confirmación de Eliminación -->
    <div id="modalEliminar" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-4 border w-11/12 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-2xl rounded-xl bg-white">
            
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-xl bg-gradient-to-r from-red-50 to-pink-50">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h3>
                        <p class="text-sm text-gray-600 mt-1">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button id="btnCerrarModalEliminar" type="button" class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-lg p-2 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6">
                <!-- Contenedor para mensajes -->
                <div id="modalEliminarMessages" class="mb-4"></div>

                <!-- Información del reporte a eliminar -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900" id="reporteNombreEliminar"></div>
                            <div class="text-sm text-gray-500">Será eliminado permanentemente</div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de advertencia -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="text-sm text-yellow-700">
                            <p class="font-medium mb-1">⚠️ Advertencia Importante</p>
                            <p>Esta acción eliminará permanentemente el reporte y no se puede deshacer. Todos los datos asociados se perderán.</p>
                        </div>
                    </div>
                </div>

                <!-- Confirmación con checkbox -->
                <div class="mb-6">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" id="confirmarEliminacion" class="mt-1 w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm text-gray-700">
                            Entiendo que esta acción es permanente y no se puede deshacer
                        </span>
                    </label>
                </div>

                <!-- Form oculto para enviar eliminación -->
                <form id="formEliminarReporte" method="POST" style="display: none;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl space-x-3">
                <button id="btnCancelarEliminar" type="button"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition duration-150 ease-in-out shadow-sm">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </span>
                </button>
                <button id="btnConfirmarEliminar" type="button" disabled
                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed font-medium transition duration-150 ease-in-out shadow-lg">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Eliminar Reporte</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <!-- Scripts -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
    
    <script>
        $(document).ready(function() {

            let reporteIdEliminar = null;
            let reporteNombreEliminar = null;
    
            // Referencias del modal
            const modal = $('#modalCrearReporte');
            const form = $('#formCrearReporte');
            const modalTitle = $('#modal-title');
            const btnText = $('#btn-text');

            // Abrir modal para crear
            $('#btnAbrirModalCrear, #btnCrearPrimero').on('click', function() {
                abrirModalCrear();
            });

            // Cerrar modal
            $('#btnCerrarModalCrear, #btnCancelarModalCrear').on('click', function() {
                cerrarModal();
            });

            // Cerrar modal al hacer clic fuera
            modal.on('click', function(e) {
                if (e.target === modal[0]) {
                    cerrarModal();
                }
            });

            // Función para abrir modal (crear)
            function abrirModalCrear() {
                // Configurar para crear
                modalTitle.text('Crear Nuevo Reporte');
                btnText.text('Crear Reporte');
                form.attr('action', '{{ route("config-entregas-auditoria.store") }}');
                $('#reporte_id').val('');
                $('#form_method').val('');
                
                // Limpiar formulario
                limpiarFormulario();
                
                // Mostrar modal
                modal.removeClass('hidden');
                $('body').addClass('overflow-hidden');
                
                // Focus en primer campo
                setTimeout(() => $('#modal_reporte').focus(), 100);
            }

            // Función para editar reporte
            window.editarReporte = function(id, nombre, periodo) {
                // Configurar para editar
                modalTitle.text('Editar Reporte');
                btnText.text('Actualizar Reporte');
                form.attr('action', `/config-entregas-auditoria/${id}`);
                $('#reporte_id').val(id);
                $('#form_method').val('PUT');
                
                // Llenar campos
                $('#modal_reporte').val(nombre);
                $('#modal_periodo').val(periodo);
                
                // Mostrar información del período
                mostrarInfoPeriodo(periodo);
                
                // Mostrar modal
                modal.removeClass('hidden');
                $('body').addClass('overflow-hidden');
                
                // Focus en primer campo
                setTimeout(() => $('#modal_reporte').focus(), 100);
            };

            // Función para cerrar modal
            function cerrarModal() {
                modal.addClass('hidden');
                $('body').removeClass('overflow-hidden');
                limpiarFormulario();
            }

            // Función para limpiar formulario
            function limpiarFormulario() {
                form[0].reset();
                $('#modalCrearMessages').empty();
                $('#periodo-info').addClass('hidden');
                
                // Remover clases de validación
                $('input, select').removeClass('border-red-300 border-green-300');
            }

            // Mostrar información según período seleccionado
            $('#modal_periodo').on('change', function() {
                const periodo = $(this).val();
                mostrarInfoPeriodo(periodo);
                
                // Validación visual
                if (periodo) {
                    $(this).removeClass('border-red-300').addClass('border-green-300');
                }
            });

            function mostrarInfoPeriodo(periodo) {
                const descripciones = {
                    'Diario': 'Los reportes se generarán todos los días. Ideal para seguimiento continuo.',
                    'Semanal': 'Los reportes se generarán cada semana. Perfecto para revisiones regulares.',
                    'Mensual': 'Los reportes se generarán mensualmente. Ideal para análisis periódicos.',
                    'Trimestral': 'Los reportes se generarán cada 3 meses. Para evaluaciones trimestrales.',
                    'Semestral': 'Los reportes se generarán cada 6 meses. Para revisiones semestrales.',
                    'Anual': 'Los reportes se generarán anualmente. Para evaluaciones anuales completas.'
                };

                if (periodo && descripciones[periodo]) {
                    $('#periodo-descripcion').text(descripciones[periodo]);
                    $('#periodo-info').removeClass('hidden');
                } else {
                    $('#periodo-info').addClass('hidden');
                }
            }

            // Manejar envío del formulario
            form.on('submit', function(e) {
                e.preventDefault();
                
                // Validar campos
                if (!validarFormulario()) {
                    return;
                }
                
                const btnGuardar = $('#btnGuardarReporte');
                const isEditing = $('#form_method').val() === 'PUT';
                
                // Deshabilitar botón y mostrar loading
                btnGuardar.prop('disabled', true).html(`
                    <span class="flex items-center space-x-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>${isEditing ? 'Actualizando...' : 'Creando...'}</span>
                    </span>
                `);
                
                // Preparar datos del formulario
                let formData = new FormData(this);
                let url = $(this).attr('action');
                let method = 'POST';
                
                if (isEditing) {
                    formData.append('_method', 'PUT');
                }
                
                // Enviar formulario por AJAX
                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Éxito:', response);
                        mostrarExito(isEditing ? 
                            '¡Reporte actualizado exitosamente!' : 
                            '¡Reporte creado exitosamente!'
                        );
                        
                        // Cerrar modal y recargar después de 2 segundos
                        setTimeout(function() {
                            cerrarModal();
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        let errorMsg = 'Ha ocurrido un error al guardar el reporte.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = '<ul class="list-disc list-inside space-y-1 mt-2">';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMsg += '<li>' + value[0] + '</li>';
                            });
                            errorMsg += '</ul>';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        
                        mostrarError(errorMsg);
                    },
                    complete: function() {
                        // Rehabilitar botón
                        btnGuardar.prop('disabled', false).html(`
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>${isEditing ? 'Actualizar Reporte' : 'Crear Reporte'}</span>
                            </span>
                        `);
                    }
                });
            });

            // Función de validación
            function validarFormulario() {
                let isValid = true;
                
                // Validar nombre de reporte
                const reporte = $('#modal_reporte');
                if (!reporte.val().trim()) {
                    reporte.addClass('border-red-300');
                    isValid = false;
                } else {
                    reporte.removeClass('border-red-300').addClass('border-green-300');
                }
                
                // Validar período
                const periodo = $('#modal_periodo');
                if (!periodo.val()) {
                    periodo.addClass('border-red-300');
                    isValid = false;
                } else {
                    periodo.removeClass('border-red-300').addClass('border-green-300');
                }
                
                if (!isValid) {
                    mostrarError('Por favor complete todos los campos requeridos');
                }
                
                return isValid;
            }

            // Funciones para mostrar mensajes
            function mostrarExito(mensaje) {
                $('#modalCrearMessages').html(`
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            ${mensaje}
                        </div>
                    </div>
                `);
            }

            function mostrarError(mensaje) {
                $('#modalCrearMessages').html(`
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <span class="font-medium">Error:</span>
                                <div>${mensaje}</div>
                            </div>
                        </div>
                    </div>
                `);
                
                // Scroll al mensaje de error
                document.getElementById('modalCrearMessages').scrollIntoView({ behavior: 'smooth' });
            }

            // Cerrar modal con tecla Escape
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && !modal.hasClass('hidden')) {
                    cerrarModal();
                }
            });

            // Validación en tiempo real
            $('#modal_reporte').on('input', function() {
                if ($(this).val().trim()) {
                    $(this).removeClass('border-red-300').addClass('border-green-300');
                } else {
                    $(this).removeClass('border-green-300');
                }
            });

            // Remover clases de error al escribir
            $('input, select').on('input change', function() {
                $(this).removeClass('border-red-300');
            });
        });

        // Auto-hide alerts después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.animate-pulse');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Referencias del modal de eliminación
    const modalEliminar = $('#modalEliminar');
    const formEliminar = $('#formEliminarReporte');
    const btnConfirmar = $('#btnConfirmarEliminar');
    const checkboxConfirmar = $('#confirmarEliminacion');

    // Función para abrir modal de eliminación
    window.abrirModalEliminar = function(id, nombre) {
        reporteIdEliminar = id;
        reporteNombreEliminar = nombre;
        
        // Actualizar información en el modal
        $('#reporteNombreEliminar').text(nombre);
        
        // Configurar form action
        formEliminar.attr('action', `{{ url('config-entregas-auditoria') }}/${id}`);
        
        // Resetear estado del modal
        checkboxConfirmar.prop('checked', false);
        btnConfirmar.prop('disabled', true).removeClass('bg-red-600 hover:bg-red-700').addClass('bg-gray-300');
        $('#modalEliminarMessages').empty();
        
        // Mostrar modal
        modalEliminar.removeClass('hidden');
        $('body').addClass('overflow-hidden');
        
        // Focus en checkbox después de un momento
        setTimeout(() => checkboxConfirmar.focus(), 100);
    };

    // Cerrar modal de eliminación
    $('#btnCerrarModalEliminar, #btnCancelarEliminar').on('click', function() {
        cerrarModalEliminar();
    });

    // Cerrar modal al hacer clic fuera
    modalEliminar.on('click', function(e) {
        if (e.target === modalEliminar[0]) {
            cerrarModalEliminar();
        }
    });

    // Función para cerrar modal de eliminación
    function cerrarModalEliminar() {
        modalEliminar.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        reporteIdEliminar = null;
        reporteNombreEliminar = null;
        checkboxConfirmar.prop('checked', false);
        btnConfirmar.prop('disabled', true);
        $('#modalEliminarMessages').empty();
    }

    // Habilitar/deshabilitar botón según checkbox
    checkboxConfirmar.on('change', function() {
        if ($(this).is(':checked')) {
            btnConfirmar.prop('disabled', false)
                       .removeClass('bg-gray-300')
                       .addClass('bg-red-600 hover:bg-red-700 transform hover:scale-105');
        } else {
            btnConfirmar.prop('disabled', true)
                       .removeClass('bg-red-600 hover:bg-red-700 transform hover:scale-105')
                       .addClass('bg-gray-300');
        }
    });

    // Manejar confirmación de eliminación
    btnConfirmar.on('click', function() {
        if (!checkboxConfirmar.is(':checked')) {
            mostrarErrorEliminar('Debe confirmar que entiende las consecuencias de esta acción');
            return;
        }

        // Deshabilitar botón y mostrar loading
        btnConfirmar.prop('disabled', true).html(`
            <span class="flex items-center space-x-2">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Eliminando...</span>
            </span>
        `);

        // Enviar eliminación por AJAX
        $.ajax({
            url: formEliminar.attr('action'),
            method: 'POST',
            data: formEliminar.serialize(),
            success: function(response) {
                console.log('Éxito:', response);
                mostrarExitoEliminar(`¡El reporte "${reporteNombreEliminar}" ha sido eliminado exitosamente!`);
                
                // Cerrar modal y recargar después de 2 segundos
                setTimeout(function() {
                    cerrarModalEliminar();
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                let errorMsg = 'Ha ocurrido un error al eliminar el reporte.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 404) {
                    errorMsg = 'El reporte no fue encontrado.';
                } else if (xhr.status === 403) {
                    errorMsg = 'No tiene permisos para eliminar este reporte.';
                }
                
                mostrarErrorEliminar(errorMsg);
            },
            complete: function() {
                // Rehabilitar botón
                btnConfirmar.prop('disabled', false).html(`
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Eliminar Reporte</span>
                    </span>
                `);
            }
        });
    });

    // Funciones para mostrar mensajes en modal de eliminación
    function mostrarExitoEliminar(mensaje) {
        $('#modalEliminarMessages').html(`
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    ${mensaje}
                </div>
            </div>
        `);
    }

    function mostrarErrorEliminar(mensaje) {
        $('#modalEliminarMessages').html(`
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium">Error:</span>
                        <div>${mensaje}</div>
                    </div>
                </div>
            </div>
        `);
        
        // Scroll al mensaje de error
        document.getElementById('modalEliminarMessages').scrollIntoView({ behavior: 'smooth' });
    }

    // Cerrar modal con tecla Escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !modalEliminar.hasClass('hidden')) {
            cerrarModalEliminar();
        }
    });

    </script>
@endpush
            


