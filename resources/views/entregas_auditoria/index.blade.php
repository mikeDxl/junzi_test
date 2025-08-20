@extends('home', ['activePage' => 'Reportes de Control', 'menuParent' => 'forms', 'titlePage' => __('Reportes de Control')])

@section('contentJunzi')
    <style>
        .option-item:hover {
            background-color: #eff6ff;
        }

        .option-item.selected {
            background-color: #dbeafe;
            border-left: 3px solid #3b82f6;
        }

        /* Animación del dropdown */
        #modal_responsable_dropdown {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar personalizado */
        #modal_responsable_dropdown::-webkit-scrollbar {
            width: 6px;
        }

        #modal_responsable_dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        #modal_responsable_dropdown::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        #modal_responsable_dropdown::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        /* Estilos adicionales para mejorar la experiencia */
        .tab-button.active {
            border-bottom-color: #3b82f6 !important;
            color: #3b82f6 !important;
        }
        
        .tab-content {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Hover effects para botones */
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        /* Mejoras de accesibilidad */
        .tab-button:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .tab-button {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
            }
            
            /* Ajuste para pantallas pequeñas */
            .flex.space-x-8 {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .tab-button span {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
        
        /* Animaciones suaves para las transiciones de estado */
        .transition-colors {
            transition-property: color, background-color, border-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Efecto de loading para formularios */
        .loading {
            pointer-events: none;
            opacity: 0.6;
        }
        
        .loading button {
            cursor: not-allowed;
        }

        /* Mejoras visuales para estados de entrega */
        .estado-vencido {
            animation: pulseRed 2s infinite;
        }

        @keyframes pulseRed {
            0%, 100% { 
                background-color: rgba(254, 226, 226, 1);
            }
            50% { 
                background-color: rgba(252, 165, 165, 1);
            }
        }

        /* Efectos de hover más suaves */
        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: translateX(2px);
            transition: all 0.2s ease-in-out;
        }

        /* Indicadores de estado más visibles */
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-error {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        /* Estilos para el modal */
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 mt-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Listado de Reporte de Control de Auditoría</h2>
            <p class="text-gray-600">Gestión y seguimiento de reportes de control de auditoría</p>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" class="inline-flex text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.remove()">
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
                        <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header con botones de acción -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <!-- Botón para abrir modal -->
                <button id="btnAbrirModal" type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Programar Entregable
                </button>
            </div>
            
            @if(auth()->user()->auditoria=="1")
            <div>
                <a href="/config-entregas-auditoria" 
                   class="inline-flex items-center px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configuración
                </a>
            </div>
            @endif
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none active" 
                            data-tab="pendientes">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                            Pendientes
                            <span class="ml-2 py-0.5 px-2 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ count($entregas_pendientes) }}</span>
                        </span>
                    </button>
                    <button class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none" 
                            data-tab="enviadas">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                            Enviadas
                            <span class="ml-2 py-0.5 px-2 text-xs bg-blue-100 text-blue-800 rounded-full">{{ count($entregas_enviadas) }}</span>
                        </span>
                    </button>
                    <button class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none" 
                            data-tab="completadas">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Completadas
                            <span class="ml-2 py-0.5 px-2 text-xs bg-green-100 text-green-800 rounded-full">{{ isset($entregas_completadas) ? count($entregas_completadas) : 0 }}</span>
                        </span>
                    </button>
                    <button class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none" 
                            data-tab="detenidas">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                            Detenidas
                            <span class="ml-2 py-0.5 px-2 text-xs bg-red-100 text-red-800 rounded-full">{{ isset($entregas_detenidas) ? count($entregas_detenidas) : 0 }}</span>
                        </span>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Tab Pendientes -->
                <div id="pendientes-content" class="tab-content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe Directo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($entregas_pendientes))
                                    @forelse($entregas_pendientes as $entrega)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->responsable) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->jefe_directo) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                                    $hoy = \Carbon\Carbon::now();
                                                    $diferencia = $hoy->diffInDays($fechaEntrega, false);
                                                @endphp

                                                @if ($diferencia >= 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ $diferencia }} días restantes
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ abs($diferencia) }} días de retraso
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                    <form action="{{ route('entregas_auditoria.detenido') }}" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                        <button type="submit" 
                                                                class="text-yellow-600 hover:text-yellow-900 transition-colors duration-150"
                                                                title="Pausar entrega">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('entregas_auditoria.eliminar') }}" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                                title="Eliminar entrega"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta entrega?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay entregas pendientes</h3>
                                                    <p class="text-gray-500">Todas las entregas están al día.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Variable no definida</h3>
                                                <p class="text-gray-500">$entregas_pendientes no está disponible.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Enviadas -->
                <div id="enviadas-content" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe Directo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($entregas_enviadas))
                                    @forelse($entregas_enviadas as $entrega)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->responsable) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->jefe_directo) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                                   download
                                                   class="inline-flex items-center text-blue-600 hover:text-blue-900 transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Descargar
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                    <form action="{{ route('entregas_auditoria.completar') }}" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900 transition-colors duration-150"
                                                                title="Marcar como completada">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('entregas_auditoria.eliminar') }}" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                                title="Rechazar entrega"
                                                                onclick="return confirm('¿Estás seguro de que deseas rechazar esta entrega?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                    </svg>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay entregas enviadas</h3>
                                                    <p class="text-gray-500">Las entregas enviadas aparecerán aquí.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Variable no definida</h3>
                                                <p class="text-gray-500">$entregas_enviadas no está disponible.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Completadas -->
                <div id="completadas-content" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe Directo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Completada</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($entregas_completadas))
                                    @forelse($entregas_completadas as $entrega)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->responsable) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->jefe_directo) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $entrega->fecha_completada ?? 'No disponible' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($entrega->archivo_adjunto)
                                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                                       download
                                                       class="inline-flex items-center text-blue-600 hover:text-blue-900 transition-colors duration-150">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        Descargar
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-sm">Sin archivo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay entregas completadas</h3>
                                                    <p class="text-gray-500">Las entregas completadas aparecerán aquí.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Variable no definida</h3>
                                                <p class="text-gray-500">$entregas_completadas no está disponible.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Detenidas -->
                <div id="detenidas-content" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe Directo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Completada</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($entregas_detenidas))
                                    @forelse($entregas_detenidas as $entrega)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->responsable) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ qcolab($entrega->jefe_directo) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $entrega->fecha_completada ?? 'No disponible' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($entrega->archivo_adjunto)
                                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                                       download
                                                       class="inline-flex items-center text-blue-600 hover:text-blue-900 transition-colors duration-150">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        Descargar
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-sm">Sin archivo</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('entregas_auditoria.activar') }}" method="post" class="inline">
                                                    @csrf
                                                    <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-md transition-colors duration-150"
                                                            title="Activar entrega">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Activar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay entregas detenidas</h3>
                                                    <p class="text-gray-500">Las entregas pausadas aparecerán aquí.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Variable no definida</h3>
                                                <p class="text-gray-500">$entregas_detenidas no está disponible.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal para Programar Entregable -->
        <div id="modalProgramarEntregable" class="fixed inset-0 bg-gray-900 bg-opacity-50 modal-backdrop overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-4 mx-auto p-3 border w-11/12 sm:w-1/2 md:w-2/5 lg:w-1/3 xl:w-1/4 shadow-2xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-2xl bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Programar Entregable para Auditoría</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure un nuevo entregable para auditoría</p>
                    </div>
                </div>
                <button id="btnCerrarModal" type="button" class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-lg p-2 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6">
                <!-- Contenedor para mensajes -->
                <div id="modalMessages" class="mb-4"></div>

                <!-- Formulario (inicialmente oculto hasta cargar datos) -->
                <div id="formularioContainer" class="hidden">
                    <form id="formProgramarEntregable" action="{{ route('entregas_auditoria.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Selección de Reporte v1 -->
                        {{-- <div class="space-y-2">
                            <label for="modal_id_reporte" class="block text-sm font-semibold text-gray-700">
                                Reporte <span class="text-red-500">*</span>
                            </label>
                            <select name="id_reporte" id="modal_id_reporte" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                                <option value="">Seleccione un reporte</option>
                                <!-- Opciones cargadas vía AJAX -->
                            </select>
                        </div> --}}

                        <!-- Selección de Reporte v2 -->
                        <div class="space-y-2">
                            <label for="modal_id_reporte" class="block text-sm font-semibold text-gray-700">
                                Reporte <span class="text-red-500">*</span>
                            </label>
                            <!-- Container del select personalizado -->
                            <div class="relative">
                                <!-- Input de búsqueda -->
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="modal_id_reporte_search" 
                                        placeholder="Buscar tipo de reporte..."
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                        autocomplete="off"
                                    >
                                    <!-- Icono de búsqueda -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <!-- Flecha dropdown -->
                                    <div class="absolute inset-y-0 right-8 flex items-center pr-2 pointer-events-none">
                                        <svg id="reportes-dropdown-arrow" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <!-- Dropdown de opciones -->
                                <div id="modal_id_reporte_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                    <!-- Lista de opciones se llena dinámicamente -->
                                    <div id="modal_id_reporte_options" class="py-1">
                                        <div class="px-4 py-2 text-sm text-gray-500 text-center">
                                            Escriba para buscar...
                                        </div>
                                    </div>
                                    <!-- Mensaje cuando no hay resultados -->
                                    <div id="reportes-no-results" class="px-4 py-3 text-sm text-gray-500 text-center hidden">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        No se encontraron tipos de reporte
                                    </div>
                                </div>
                                <!-- Input hidden para el valor real -->
                                <input type="hidden" name="id_reporte" id="modal_id_reporte" required>
                            </div>
                            <!-- Texto del elemento seleccionado con indicador de período -->
                            <div id="reporte-selected-text" class="text-xs text-gray-500 hidden">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium">Seleccionado:</span> 
                                    <span id="reporte-selected-name"></span>
                                    <span id="reporte-selected-periodo" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Campo para reportes semanales -->
                        <div id="modal_fecha_semanal" class="space-y-2 hidden">
                            <label for="modal_dia_semanal" class="block text-sm font-semibold text-gray-700">
                                Día de la Semana <span class="text-red-500">*</span>
                            </label>
                            <select name="dia_semanal" id="modal_dia_semanal"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                                <option value="">Seleccione un día</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>

                        <!-- Campo para reportes mensuales -->
                        <div id="modal_fecha_mensual" class="space-y-2 hidden">
                            <label for="modal_dia_mensual" class="block text-sm font-semibold text-gray-700">
                                Día del Mes <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="dia_mensual" id="modal_dia_mensual" min="1" max="31"
                                placeholder="Ingrese el día del mes (1-31)"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                        </div>

                        <!-- Campo para otros tipos de reportes -->
                        <div id="modal_fecha_de_entrega_group" class="space-y-2 hidden">
                            <label for="modal_fecha_entrega" class="block text-sm font-semibold text-gray-700">
                                Fecha de Entrega <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_entrega" id="modal_fecha_entrega"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm">
                        </div>


                        <!-- Responsable v1 -->
                        {{-- <div class="space-y-2">
                            <label for="modal_responsable" class="block text-sm font-semibold text-gray-700">
                                Responsable <span class="text-red-500">*</span>
                            </label>
                            <select name="responsable" id="modal_responsable" required
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Seleccione un Responsable</option>
                                <!-- Opciones cargadas vía AJAX -->
                            </select>
                        </div> --}}

                        <!-- Responsable v2 -->
                        <div class="space-y-2">
                            <label for="modal_responsable" class="block text-sm font-semibold text-gray-700">
                                Responsable <span class="text-red-500">*</span>
                            </label>
                            <!-- Container del select personalizado -->
                            <div class="relative">
                                <!-- Input de búsqueda -->
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="modal_responsable_search" 
                                        placeholder="Buscar responsable..."
                                        class="block w-full px-4 py-3 pr-10 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        autocomplete="off"
                                    >
                                    <!-- Icono de búsqueda -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <!-- Flecha dropdown -->
                                    <div class="absolute inset-y-0 right-8 flex items-center pr-2 pointer-events-none">
                                        <svg id="dropdown-arrow" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <!-- Dropdown de opciones -->
                                <div id="modal_responsable_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                    <!-- Lista de opciones se llena dinámicamente -->
                                    <div id="modal_responsable_options" class="py-1">
                                        <div class="px-4 py-2 text-sm text-gray-500 text-center">
                                            Escriba para buscar...
                                        </div>
                                    </div>
                                    <!-- Mensaje cuando no hay resultados -->
                                    <div id="no-results" class="px-4 py-3 text-sm text-gray-500 text-center hidden">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        No se encontraron resultados
                                    </div>
                                </div>
                                <!-- Input hidden para el valor real -->
                                <input type="hidden" name="responsable" id="modal_responsable" required>
                            </div>
                            <!-- Texto del elemento seleccionado -->
                            <div id="selected-text" class="text-xs text-gray-500 hidden">
                                <span class="font-medium">Seleccionado:</span> <span id="selected-name"></span>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        {{-- <div class="space-y-2">
                            <label for="modal_observaciones" class="block text-sm font-semibold text-gray-700">
                                Observaciones
                            </label>
                            <textarea name="observaciones" id="modal_observaciones" rows="3"
                                    placeholder="Observaciones adicionales (opcional)"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out resize-none shadow-sm"></textarea>
                        </div> --}}
                    </form>
                </div>

                <!-- Estado de carga inicial -->
                <div id="loadingContainer" class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <svg class="animate-spin w-8 h-8 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                            <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600">Cargando datos del formulario...</p>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div id="modalFooter" class="flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl space-x-3 hidden">
                <button id="btnCancelarModal" type="button"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition duration-150 ease-in-out shadow-sm">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </span>
                </button>
                <button id="btnGuardarEntregable" type="submit" form="formProgramarEntregable"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition duration-150 ease-in-out transform hover:scale-105 shadow-lg">
                    <span class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Crear Entregable</span>
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
    document.addEventListener('DOMContentLoaded', function() {

        let colaboradoresData = []; // Datos de colaboradores
        let isDropdownOpen = false;
        let reportesData = []; // Datos de reportes
        let isReportesDropdownOpen = false;
    
        // Referencias DOM
        const searchInput = document.getElementById('modal_responsable_search');
        const dropdown = document.getElementById('modal_responsable_dropdown');
        const optionsContainer = document.getElementById('modal_responsable_options');
        const hiddenInput = document.getElementById('modal_responsable');
        const noResults = document.getElementById('no-results');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const selectedText = document.getElementById('selected-text');
        const selectedName = document.getElementById('selected-name');
        
        // Abrir/cerrar dropdown
        searchInput.addEventListener('focus', function() {
            openDropdown();
        });
        
        searchInput.addEventListener('click', function() {
            openDropdown();
        });
        
        // Búsqueda en tiempo real
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterOptions(searchTerm);
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#modal_responsable_search') && 
                !event.target.closest('#modal_responsable_dropdown')) {
                closeDropdown();
            }
        });
        
        // Función para abrir dropdown
        function openDropdown() {
            isDropdownOpen = true;
            dropdown.classList.remove('hidden');
            dropdownArrow.style.transform = 'rotate(180deg)';
            
            if (colaboradoresData.length === 0) {
                loadColaboradores();
            } else {
                renderOptions(colaboradoresData);
            }
        }
        
        // Función para cerrar dropdown
        function closeDropdown() {
            isDropdownOpen = false;
            dropdown.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
        
        // Cargar colaboradores (integrar con tu AJAX existente)
        function loadColaboradores() {
            optionsContainer.innerHTML = `
                <div class="px-4 py-3 text-center">
                    <svg class="animate-spin w-5 h-5 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div class="text-sm text-gray-500 mt-2">Cargando...</div>
                </div>
            `;
            
            // Aquí conectar con tu AJAX existente
            $.ajax({
                url: '{{ route('entregas_auditoria.create') }}',
                method: 'GET',
                success: function(response) {
                    if (response.success && response.colaboradores) {
                        colaboradoresData = response.colaboradores;
                        renderOptions(colaboradoresData);
                    } else {
                        showError('Error al cargar colaboradores');
                    }
                },
                error: function() {
                    showError('Error de conexión');
                }
            });
        }
        
        // Renderizar opciones
        function renderOptions(colaboradores) {
            console.log('Renderizando colaboradores:', colaboradores);
            
            if (colaboradores.length === 0) {
                optionsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-center">No hay colaboradores disponibles</div>';
                return;
            }
            
            const optionsHTML = colaboradores.map((colaborador, index) => {
                console.log(`Colaborador ${index}:`, colaborador);
                
                // Obtener valores de forma segura
                const id = colaborador.id || colaborador.colaborador_id || colaborador || '';
                const nombre = colaborador.name || colaborador.nombre || colaborador.text || `Usuario ${id}`;
                
                // Validar que tengamos un nombre válido
                if (!nombre || nombre === 'Usuario ') {
                    console.warn('Colaborador sin nombre válido:', colaborador);
                    return ''; // Skip este elemento
                }
                
                // Obtener primera letra de forma segura
                const primeraLetra = String(nombre).charAt(0).toUpperCase() || '?';
                
                return `
                    <div class="option-item px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors duration-150 border-b border-gray-100 last:border-b-0" 
                        data-value="${id}" 
                        data-name="${nombre}">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">
                                    ${primeraLetra}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">
                                    ${nombre}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).filter(html => html !== '').join(''); // Filtrar elementos vacíos
            
            if (optionsHTML === '') {
                optionsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-center">No hay colaboradores válidos</div>';
                return;
            }
            
            optionsContainer.innerHTML = optionsHTML;
            
            // Agregar event listeners a las opciones
            const optionItems = optionsContainer.querySelectorAll('.option-item');
            optionItems.forEach(item => {
                item.addEventListener('click', function() {
                    selectOption(this.dataset.value, this.dataset.name);
                });
            });
        }
        
        // Filtrar opciones
        function filterOptions(searchTerm) {
            if (!isDropdownOpen) openDropdown();
            
            if (searchTerm === '') {
                renderOptions(colaboradoresData);
                noResults.classList.add('hidden');
                return;
            }
            
            const filteredData = colaboradoresData.filter(colaborador => {
                // Obtener valores de forma segura
                const name = String(colaborador.name || colaborador.nombre || colaborador.text || '').toLowerCase();
                const id = String(colaborador.id || colaborador.colaborador_id || colaborador || '').toLowerCase();
                
                return name.includes(searchTerm) || id.includes(searchTerm);
            });
            
            if (filteredData.length === 0) {
                optionsContainer.innerHTML = '';
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
                renderOptions(filteredData);
            }
        }
        
        // Seleccionar opción
        function selectOption(value, name) {
            hiddenInput.value = value;
            searchInput.value = name;
            selectedName.textContent = name;
            selectedText.classList.remove('hidden');
            closeDropdown();
            
            // Trigger change event
            hiddenInput.dispatchEvent(new Event('change'));
            
            // Mostrar feedback visual
            searchInput.classList.add('border-green-300', 'bg-green-50');
            setTimeout(() => {
                searchInput.classList.remove('border-green-300', 'bg-green-50');
            }, 2000);
        }
        
        // Mostrar error
        function showError(message) {
            optionsContainer.innerHTML = `
                <div class="px-4 py-3 text-center">
                    <svg class="w-6 h-6 mx-auto mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-red-600">${message}</div>
                </div>
            `;
        }
        
        // Limpiar selección
        function clearSelection() {
            hiddenInput.value = '';
            searchInput.value = '';
            selectedText.classList.add('hidden');
            closeDropdown();
        }
        
        // Función global para llenar desde AJAX externo
        window.llenarSelectConBuscador = function(colaboradores) {
            colaboradoresData = colaboradores;
            if (isDropdownOpen) {
                renderOptions(colaboradoresData);
            }
        };
        
        // Función global para limpiar
        window.limpiarSelectConBuscador = function() {
            clearSelection();
            colaboradoresData = [];
        };
        
        // Navegación con teclado (opcional)
        let currentIndex = -1;
        
        searchInput.addEventListener('keydown', function(e) {
            const options = optionsContainer.querySelectorAll('.option-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentIndex = Math.min(currentIndex + 1, options.length - 1);
                highlightOption(options, currentIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentIndex = Math.max(currentIndex - 1, -1);
                highlightOption(options, currentIndex);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentIndex >= 0 && options[currentIndex]) {
                    const option = options[currentIndex];
                    selectOption(option.dataset.value, option.dataset.name);
                }
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });
        
        function highlightOption(options, index) {
            options.forEach((option, i) => {
                if (i === index) {
                    option.classList.add('bg-blue-100');
                } else {
                    option.classList.remove('bg-blue-100');
                }
            });
        }

        // Referencias DOM
    const reportesSearchInput = document.getElementById('modal_id_reporte_search');
    const reportesDropdown = document.getElementById('modal_id_reporte_dropdown');
    const reportesOptionsContainer = document.getElementById('modal_id_reporte_options');
    const reportesHiddenInput = document.getElementById('modal_id_reporte');
    const reportesNoResults = document.getElementById('reportes-no-results');
    const reportesDropdownArrow = document.getElementById('reportes-dropdown-arrow');
    const reporteSelectedText = document.getElementById('reporte-selected-text');
    const reporteSelectedName = document.getElementById('reporte-selected-name');
    const reporteSelectedPeriodo = document.getElementById('reporte-selected-periodo');
    
    // Abrir/cerrar dropdown
    reportesSearchInput.addEventListener('focus', function() {
        openReportesDropdown();
    });
    
    reportesSearchInput.addEventListener('click', function() {
        openReportesDropdown();
    });
    
    // Búsqueda en tiempo real
    reportesSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterReportesOptions(searchTerm);
    });
    
    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#modal_id_reporte_search') && 
            !event.target.closest('#modal_id_reporte_dropdown')) {
            closeReportesDropdown();
        }
    });
    
    // Función para abrir dropdown
    function openReportesDropdown() {
        isReportesDropdownOpen = true;
        reportesDropdown.classList.remove('hidden');
        reportesDropdownArrow.style.transform = 'rotate(180deg)';
        
        if (reportesData.length === 0) {
            loadReportes();
        } else {
            renderReportesOptions(reportesData);
        }
    }
    
    // Función para cerrar dropdown
    function closeReportesDropdown() {
        isReportesDropdownOpen = false;
        reportesDropdown.classList.add('hidden');
        reportesDropdownArrow.style.transform = 'rotate(0deg)';
    }
    
    // Cargar reportes (integrar con tu AJAX existente)
    function loadReportes() {
        reportesOptionsContainer.innerHTML = `
            <div class="px-4 py-3 text-center">
                <svg class="animate-spin w-5 h-5 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <div class="text-sm text-gray-500 mt-2">Cargando reportes...</div>
            </div>
        `;
        
        // Aquí conectar con tu AJAX existente
        $.ajax({
            url: '{{ route('entregas_auditoria.create') }}',
            method: 'GET',
            success: function(response) {
                if (response.success && response.configReportes) {
                    reportesData = response.configReportes;
                    renderReportesOptions(reportesData);
                } else {
                    showReportesError('Error al cargar tipos de reportes');
                }
            },
            error: function() {
                showReportesError('Error de conexión');
            }
        });
    }
    
    // Renderizar opciones de reportes
    function renderReportesOptions(reportes) {
        console.log('Renderizando reportes:', reportes);
        
        if (reportes.length === 0) {
            reportesOptionsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-center">No hay tipos de reportes disponibles</div>';
            return;
        }
        
        const optionsHTML = reportes.map((reporte, index) => {
            // Obtener valores de forma segura
            const id = reporte.id || '';
            const nombre = reporte.reporte || reporte.nombre || reporte.name || `Reporte ${id}`;
            const periodo = reporte.periodo || 'No definido';
            
            // Validar que tengamos un nombre válido
            if (!nombre || nombre === 'Reporte ') {
                console.warn('Reporte sin nombre válido:', reporte);
                return '';
            }
            
            // Icono según el período
            let iconoReporte = '';
            let colorPeriodo = '';
            
            switch(periodo.toLowerCase()) {
                case 'diario':
                    iconoReporte = '📅';
                    colorPeriodo = 'bg-green-100 text-green-800';
                    break;
                case 'semanal':
                    iconoReporte = '📊';
                    colorPeriodo = 'bg-blue-100 text-blue-800';
                    break;
                case 'mensual':
                    iconoReporte = '📈';
                    colorPeriodo = 'bg-purple-100 text-purple-800';
                    break;
                case 'anual':
                    iconoReporte = '📋';
                    colorPeriodo = 'bg-yellow-100 text-yellow-800';
                    break;
                default:
                    iconoReporte = '📄';
                    colorPeriodo = 'bg-gray-100 text-gray-800';
            }
            
            return `
                <div class="reporte-option-item px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors duration-150 border-b border-gray-100 last:border-b-0" 
                     data-value="${id}" 
                     data-name="${nombre}"
                     data-periodo="${periodo}">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-lg">
                                ${iconoReporte}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">
                                ${nombre}
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${colorPeriodo}">
                                    ${periodo}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).filter(html => html !== '').join('');
        
        if (optionsHTML === '') {
            reportesOptionsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-center">No hay reportes válidos</div>';
            return;
        }
        
        reportesOptionsContainer.innerHTML = optionsHTML;
        
        // Agregar event listeners a las opciones
        const optionItems = reportesOptionsContainer.querySelectorAll('.reporte-option-item');
        optionItems.forEach(item => {
            item.addEventListener('click', function() {
                selectReporteOption(this.dataset.value, this.dataset.name, this.dataset.periodo);
            });
        });
    }
    
    // Filtrar opciones
    function filterReportesOptions(searchTerm) {
        if (!isReportesDropdownOpen) openReportesDropdown();
        
        if (searchTerm === '') {
            renderReportesOptions(reportesData);
            reportesNoResults.classList.add('hidden');
            return;
        }
        
        const filteredData = reportesData.filter(reporte => {
            const nombre = String(reporte.reporte || reporte.nombre || reporte.name || '').toLowerCase();
            const periodo = String(reporte.periodo || '').toLowerCase();
            const id = String(reporte.id || '').toLowerCase();
            
            return nombre.includes(searchTerm) || periodo.includes(searchTerm) || id.includes(searchTerm);
        });
        
        if (filteredData.length === 0) {
            reportesOptionsContainer.innerHTML = '';
            reportesNoResults.classList.remove('hidden');
        } else {
            reportesNoResults.classList.add('hidden');
            renderReportesOptions(filteredData);
        }
    }
    
    // Seleccionar opción
    function selectReporteOption(value, name, periodo) {
        reportesHiddenInput.value = value;
        reportesSearchInput.value = name;
        reporteSelectedName.textContent = name;
        reporteSelectedPeriodo.textContent = periodo;
        reporteSelectedText.classList.remove('hidden');
        closeReportesDropdown();
        
        // Trigger change event para activar la lógica de campos dinámicos
        const changeEvent = new Event('change', { bubbles: true });
        reportesHiddenInput.dispatchEvent(changeEvent);
        
        // Trigger evento personalizado con datos del período
        const customEvent = new CustomEvent('reporteSelected', {
            detail: { id: value, name: name, periodo: periodo }
        });
        document.dispatchEvent(customEvent);
        
        // Mostrar feedback visual
        reportesSearchInput.classList.add('border-green-300', 'bg-green-50');
        setTimeout(() => {
            reportesSearchInput.classList.remove('border-green-300', 'bg-green-50');
        }, 2000);
    }
    
    // Mostrar error
    function showReportesError(message) {
        reportesOptionsContainer.innerHTML = `
            <div class="px-4 py-3 text-center">
                <svg class="w-6 h-6 mx-auto mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-red-600">${message}</div>
            </div>
        `;
    }
    
    // Limpiar selección
    function clearReportesSelection() {
        reportesHiddenInput.value = '';
        reportesSearchInput.value = '';
        reporteSelectedText.classList.add('hidden');
        closeReportesDropdown();
    }
    
    // Funciones globales para integración externa
    window.llenarSelectReportes = function(reportes) {
        reportesData = reportes;
        if (isReportesDropdownOpen) {
            renderReportesOptions(reportesData);
        }
    };
    
    window.limpiarSelectReportes = function() {
        clearReportesSelection();
        reportesData = [];
    };
    
    // Escuchar el evento de selección de reporte para mostrar campos dinámicos
    document.addEventListener('reporteSelected', function(e) {
        const { periodo } = e.detail;
        console.log('Reporte seleccionado con período:', periodo);
        
        // Aquí puedes agregar la lógica para mostrar/ocultar campos
        // según el período seleccionado
        mostrarCamposPorPeriodo(periodo);
    });
    
    // Función para mostrar campos según período
    function mostrarCamposPorPeriodo(periodo) {
        // Ocultar todos los campos primero
        $('#modal_fecha_semanal').addClass('hidden');
        $('#modal_fecha_mensual').addClass('hidden');
        $('#modal_fecha_de_entrega_group').addClass('hidden');
        
        // Mostrar campo según período
        switch(periodo.toLowerCase()) {
            case 'semanal':
                $('#modal_fecha_semanal').removeClass('hidden');
                break;
            case 'mensual':
                $('#modal_fecha_mensual').removeClass('hidden');
                break;
            default:
                $('#modal_fecha_de_entrega_group').removeClass('hidden');
                break;
        }
    }
    
    // Navegación con teclado
    let currentReportesIndex = -1;
    
    reportesSearchInput.addEventListener('keydown', function(e) {
        const options = reportesOptionsContainer.querySelectorAll('.reporte-option-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentReportesIndex = Math.min(currentReportesIndex + 1, options.length - 1);
            highlightReportesOption(options, currentReportesIndex);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentReportesIndex = Math.max(currentReportesIndex - 1, -1);
            highlightReportesOption(options, currentReportesIndex);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentReportesIndex >= 0 && options[currentReportesIndex]) {
                const option = options[currentReportesIndex];
                selectReporteOption(option.dataset.value, option.dataset.name, option.dataset.periodo);
            }
        } else if (e.key === 'Escape') {
            closeReportesDropdown();
        }
    });
    
    function highlightReportesOption(options, index) {
        options.forEach((option, i) => {
            if (i === index) {
                option.classList.add('bg-blue-100');
            } else {
                option.classList.remove('bg-blue-100');
            }
        });
    }
    });

    $(document).ready(function() {
    // Variables para almacenar datos
        let configReportes = [];
        let colaboradores = [];
        let datosYaCargados = false;

        // Referencias a elementos del modal
        const modal = $('#modalProgramarEntregable');
        const form = $('#formProgramarEntregable');
        const loadingContainer = $('#loadingContainer');
        const formularioContainer = $('#formularioContainer');
        const modalFooter = $('#modalFooter');

        console.log('Modal con carga AJAX inicializado');

        // Abrir modal y cargar datos
        $(document).on('click', '#btnAbrirModal', function(e) {
            e.preventDefault();
            console.log('Abriendo modal...');
            
            // Abrir modal inmediatamente
            modal.removeClass('hidden').addClass('flex');
            $('body').addClass('overflow-hidden');
            
            // Si los datos ya están cargados, mostrar formulario directamente
            if (datosYaCargados) {
                mostrarFormulario();
                return;
            }
            
            // Mostrar estado de carga
            mostrarCarga();
            
            // Cargar datos para el modal
            $.ajax({
                url: '{{ route('entregas_auditoria.create') }}',
                method: 'GET',
                success: function(response) {
                    console.log('Datos cargados:', response);
                    
                    // Guardar datos en variables
                    configReportes = response.configReportes;
                    colaboradores = response.colaboradores;
                    datosYaCargados = true;
                    
                    // Llenar selects
                    //llenarSelectReportes(response.configReportes);
                    //llenarSelectColaboradores(response.colaboradores);
                    
                    // Mostrar formulario
                    mostrarFormulario();
                    
                    // Focus en primer campo
                    setTimeout(() => $('#modal_id_reporte').focus(), 100);
                },
                error: function(xhr, status, error) {
                    console.error('Error cargando datos:', error);
                    mostrarErrorCarga();
                }
            });
        });

        // Función para mostrar estado de carga
        function mostrarCarga() {
            $('#modalMessages').html(`
                <div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                            <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Cargando datos...
                    </div>
                </div>
            `);
            
            loadingContainer.removeClass('hidden');
            formularioContainer.addClass('hidden');
            modalFooter.addClass('hidden');
        }

        // Función para mostrar formulario
        function mostrarFormulario() {
            $('#modalMessages').empty();
            loadingContainer.addClass('hidden');
            formularioContainer.removeClass('hidden');
            modalFooter.removeClass('hidden');
        }

        // Función para mostrar error de carga
        function mostrarErrorCarga() {
            $('#modalMessages').html(`
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Error al cargar los datos. 
                        </div>
                        <button onclick="reintentar()" class="ml-4 px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                            Reintentar
                        </button>
                    </div>
                </div>
            `);
            
            loadingContainer.addClass('hidden');
            formularioContainer.addClass('hidden');
            modalFooter.addClass('hidden');
        }

        // Función global para reintentar
        window.reintentar = function() {
            datosYaCargados = false;
            $('#btnAbrirModal').click();
        };

        // Función para llenar select de reportes
        // function llenarSelectReportes(reportes) {
        //     const select = $('#modal_id_reporte');
        //     select.empty().append('<option value="">Seleccione un reporte</option>');
            
        //     reportes.forEach(function(reporte) {
        //         select.append(
        //             `<option value="${reporte.id}" data-periodo="${reporte.periodo}">
        //                 ${reporte.reporte} (${reporte.periodo})
        //             </option>`
        //         );
        //     });
        // }

        // Función para llenar select de colaboradores  
        // function llenarSelectColaboradores(colaboradores) {
        //     const select = $('#modal_responsable');
        //     select.empty().append('<option value="">Seleccione un Responsable</option>');
            
        //     colaboradores.forEach(function(colaborador) {
        //         select.append(
        //             `<option value="${colaborador.id}">
        //                 ${colaborador.name}
        //             </option>`
        //         );
        //     });
        // }
        

        // Cerrar modal
        $(document).on('click', '#btnCerrarModal, #btnCancelarModal', function() {
            cerrarModal();
        });

        // Cerrar modal al hacer clic fuera
        modal.on('click', function(e) {
            if (e.target === modal[0]) {
                cerrarModal();
            }
        });

        // Función para cerrar modal
        function cerrarModal() {
            modal.addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden');
            limpiarFormulario();
            console.log('Modal cerrado');
        }

        // Función para limpiar formulario
        function limpiarFormulario() {
            if (form.length) {
                form[0].reset();
            }
            $('#modal_fecha_semanal').addClass('hidden');
            $('#modal_fecha_mensual').addClass('hidden');
            $('#modal_fecha_de_entrega_group').addClass('hidden');
            $('#modalMessages').empty();
            
            // Remover clases de validación
            $('select, input').removeClass('border-red-300 border-green-300');
            
            // Volver a mostrar loading para próxima apertura si es necesario
            if (!datosYaCargados) {
                loadingContainer.removeClass('hidden');
                formularioContainer.addClass('hidden');
                modalFooter.addClass('hidden');
            }
        }

        // LÓGICA PRINCIPAL: Mostrar/ocultar campos según el período
        $(document).on('change', '#modal_id_reporte', function() {
            const reporte = $(this).find('option:selected');
            const periodo = reporte.data('periodo');

            console.log('Periodo seleccionado:', periodo);

            // Ocultar todos los campos de fecha
            $('#modal_fecha_semanal').addClass('hidden');
            $('#modal_fecha_mensual').addClass('hidden');
            $('#modal_fecha_de_entrega_group').addClass('hidden');

            // Limpiar valores
            $('#modal_dia_semanal').val('');
            $('#modal_dia_mensual').val('');
            $('#modal_fecha_entrega').val('');

            // Mostrar el campo adecuado según el período
            if (periodo === 'Semanal') {
                $('#modal_fecha_semanal').removeClass('hidden');
                console.log('Mostrando campo semanal');
            } else if (periodo === 'Mensual') {
                $('#modal_fecha_mensual').removeClass('hidden');
                console.log('Mostrando campo mensual');
            } else if (periodo && periodo !== 'Semanal' && periodo !== 'Mensual') {
                $('#modal_fecha_de_entrega_group').removeClass('hidden');
                console.log('Mostrando campo fecha específica');
            }

            // Validación visual
            if ($(this).val()) {
                $(this).removeClass('border-red-300').addClass('border-green-300');
            }
        });

        // Manejar envío del formulario
        $(document).on('submit', '#formProgramarEntregable', function(e) {
            e.preventDefault();
            console.log('Enviando formulario...');
            
            // Validar campos requeridos
            if (!validarFormulario()) {
                return;
            }
            
            const btnGuardar = $('#btnGuardarEntregable');
            
            // Deshabilitar botón y mostrar loading
            btnGuardar.prop('disabled', true).html(`
                <span class="flex items-center space-x-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Guardando...</span>
                </span>
            `);
            
            // Enviar formulario por AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Éxito:', response);
                    mostrarExito('¡Entregable programado exitosamente!');
                    
                    // Cerrar modal y recargar después de 2 segundos
                    setTimeout(function() {
                        cerrarModal();
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    let errorMsg = 'Ha ocurrido un error al guardar el entregable.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = '<ul class="list-disc list-inside space-y-1 mt-2">';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMsg += '<li>' + value[0] + '</li>';
                        });
                        errorMsg += '</ul>';
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
                            <span>Crear Entregable</span>
                        </span>
                    `);
                }
            });
        });

        // Función de validación
        function validarFormulario() {
            let isValid = true;
            
            // Validar reporte
            if (!$('#modal_id_reporte').val()) {
                $('#modal_id_reporte').addClass('border-red-300');
                isValid = false;
            }
            
            // Validar responsable
            if (!$('#modal_responsable').val()) {
                $('#modal_responsable').addClass('border-red-300');
                isValid = false;
            }
            
            // Validar campos de fecha según el período
            const periodo = $('#modal_id_reporte').find('option:selected').data('periodo');
            if (periodo === 'Semanal' && !$('#modal_dia_semanal').val()) {
                $('#modal_dia_semanal').addClass('border-red-300');
                isValid = false;
            } else if (periodo === 'Mensual' && !$('#modal_dia_mensual').val()) {
                $('#modal_dia_mensual').addClass('border-red-300');
                isValid = false;
            } else if (periodo && periodo !== 'Semanal' && periodo !== 'Mensual' && !$('#modal_fecha_entrega').val()) {
                $('#modal_fecha_entrega').addClass('border-red-300');
                isValid = false;
            }
            
            if (!isValid) {
                mostrarError('Por favor complete todos los campos requeridos');
            }
            
            return isValid;
        }

        // Funciones para mostrar mensajes
        function mostrarExito(mensaje) {
            $('#modalMessages').html(`
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
            $('#modalMessages').html(`
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
            document.getElementById('modalMessages').scrollIntoView({ behavior: 'smooth' });
        }

        // Cerrar modal con tecla Escape
        // $(document).on('keydown', function(e) {
        //     if (e.key === 'Escape' && !modal.hasClass('hidden')) {
        //         cerrarModal();
        //     }
        // });

        // Validación en tiempo real
        // $(document).on('change', '#modal_responsable', function() {
        //     if ($(this).val()) {
        //         $(this).removeClass('border-red-300').addClass('border-green-300');
        //     } else {
        //         $(this).removeClass('border-green-300').addClass('border-red-300');
        //     }
        // });

        // Remover clases de error al escribir
        $(document).on('input change', 'input, select, textarea', function() {
            $(this).removeClass('border-red-300');
        });
    });

    // Función global para abrir el modal
    window.abrirModalEntregable = function() {
        $('#btnAbrirModal').click();
    };
    // });

    // Función global para abrir el modal (por si la necesitas llamar desde otro lugar)
    window.abrirModalEntregable = function() {
        $('#modalProgramarEntregable').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
        setTimeout(() => $('#modal_id_reporte').focus(), 100);
    };

        // Sistema de tabs con Tailwind CSS
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            // Función para activar una tab
            function activateTab(targetTab) {
                // Remover clase active de todos los botones
                tabButtons.forEach(button => {
                    button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    button.classList.add('border-transparent', 'text-gray-500');
                });

                // Ocultar todos los contenidos
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    content.classList.add('hidden');
                });

                // Activar el botón seleccionado
                const activeButton = document.querySelector(`[data-tab="${targetTab}"]`);
                if (activeButton) {
                    activeButton.classList.remove('border-transparent', 'text-gray-500');
                    activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
                }

                // Mostrar el contenido seleccionado
                const activeContent = document.getElementById(`${targetTab}-content`);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                    activeContent.classList.add('active');
                }
            }

            // Agregar event listeners a los botones
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    activateTab(targetTab);
                });
            });

            // Inicializar la primera tab como activa
            activateTab('pendientes');

            // Función para confirmar eliminación
            window.confirmarEliminacion = function(mensaje) {
                return confirm(mensaje || '¿Estás seguro de que deseas realizar esta acción?');
            };

            // Animaciones hover para las filas de la tabla
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(2px)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });

        // Función para mostrar notificaciones toast
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColors = {
                'success': 'bg-green-500',
                'error': 'bg-red-500', 
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            };
            
            toast.className = `fixed top-4 right-4 ${bgColors[type]} text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out z-50`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <span class="mr-2">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:bg-white hover:bg-opacity-20 rounded p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto-remove después de 5 segundos
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Integración con sistema de notificaciones Laravel
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if($errors->any())
            showToast('Se encontraron errores en el formulario', 'error');
        @endif

        // Función para actualizar estadísticas en tiempo real (opcional)
        function actualizarEstadisticas() {
            fetch('/api/estadisticas-entregas')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar contadores en las tabs
                        const badges = {
                            pendientes: document.querySelector('[data-tab="pendientes"] .bg-yellow-100'),
                            enviadas: document.querySelector('[data-tab="enviadas"] .bg-blue-100'),
                            completadas: document.querySelector('[data-tab="completadas"] .bg-green-100'),
                            detenidas: document.querySelector('[data-tab="detenidas"] .bg-red-100')
                        };

                        Object.keys(badges).forEach(key => {
                            if (badges[key] && data.estadisticas[key] !== undefined) {
                                badges[key].textContent = data.estadisticas[key];
                            }
                        });
                    }
                })
                .catch(error => console.error('Error actualizando estadísticas:', error));
        }

        // Filtros y búsqueda en tiempo real (opcional)
        function filtrarTabla(input, tablaId) {
            const filtro = input.value.toLowerCase();
            const tabla = document.getElementById(tablaId);
            const filas = tabla.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                const texto = fila.textContent.toLowerCase();
                if (texto.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }

        // Función para exportar datos de la tab activa (opcional)
        function exportarTabActiva() {
            const tabActiva = document.querySelector('.tab-content.active');
            if (!tabActiva) return;

            const tabla = tabActiva.querySelector('table');
            if (!tabla) return;

            console.log('Exportando datos de la tabla activa...');
        }
    </script>
@endpush