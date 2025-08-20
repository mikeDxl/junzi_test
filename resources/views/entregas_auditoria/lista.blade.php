@extends('home', ['activePage' => 'Entregables', 'menuParent' => 'forms', 'titlePage' => __('Entregas de Auditoría')])

@section('contentJunzi')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mt-5">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Listado de Entregas de Auditoría</h2>

        @if(session('success'))
            <div id="successAlert" class="alert-success relative bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-md transform transition-all duration-500 ease-in-out opacity-100 translate-x-0">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="closeAlert('successAlert')" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600 transition-colors duration-200">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Barra de progreso -->
                <div class="mt-2">
                    <div class="bg-green-200 rounded-full h-1">
                        <div id="progressBar" class="bg-green-500 h-1 rounded-full transition-all duration-75 ease-linear" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div id="errorAlert" class="alert-error relative bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-md transform transition-all duration-500 ease-in-out opacity-100 translate-x-0">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-red-800 mb-2">
                            Se encontraron los siguientes errores:
                        </h3>
                        <div class="text-sm text-red-700">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-center">
                                        <svg class="h-3 w-3 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="2"/>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="closeAlert('errorAlert')" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 transition-colors duration-200">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-1" aria-label="Tabs">
                <button class="tab-button border-b-2 border-blue-500 py-2 px-4 text-sm font-medium text-blue-600 whitespace-nowrap" 
                        data-tab="pendientes">
                    Pendientes
                </button>
                <button class="tab-button border-b-2 border-transparent py-2 px-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap" 
                        data-tab="enviadas">
                    Enviadas
                </button>
                <button class="tab-button border-b-2 border-transparent py-2 px-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap" 
                        data-tab="completadas">
                    Completadas
                </button>
            </nav>
        </div>

        <div class="tab-content">
            <!-- Tab Pendientes -->
            <div class="tab-pane" id="pendientes">
                <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Completada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Días de Retraso</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subir archivo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entregas_pendientes as $entrega)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                            $hoy = \Carbon\Carbon::now();
                                            $diferencia = $hoy->diffInDays($fechaEntrega, false);
                                        @endphp

                                        @if ($diferencia >= 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $diferencia }} días restantes
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ abs($diferencia) }} días de retraso
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <form id="uploadForm" action="{{ route('entregas_auditoria.upload', ['id' => $entrega->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="file" class="sr-only" id="archivo_adjunto" name="archivo_adjunto" required>
                                            </div>

                                            <label for="archivo_adjunto" id="fileLabel" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                Cargar archivo
                                            </label>

                                            <span id="fileName" class="text-sm text-gray-600 ml-2" style="display:none;"></span>

                                            <button type="submit" id="submitBtn" class="ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-blue-500 transition-colors duration-200" style="display:none;">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                                Enviar
                                            </button>
                                        </form>
                                        @if($entrega->archivo_adjunto)
                                        <div class="mt-2">
                                            <a href="/storage/app/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                               download 
                                               class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Descargar
                                            </a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Enviadas -->
            <div class="tab-pane" id="enviadas" style="display: none;">
                <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Completada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Días de Retraso</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo Adjunto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entregas_enviadas as $entrega)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                            $fechaCompletada = \Carbon\Carbon::parse($entrega->fecha_completada);
                                            $diferencia = $fechaEntrega->diffInDays($fechaCompletada, false);
                                        @endphp

                                        @if ($diferencia >= 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sin retraso
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ abs($diferencia) }} días de retraso
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($entrega->archivo_adjunto)
                                        <a href="/storage/app/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                           download 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Descargar
                                        </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('entregas_auditoria.pendiente') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                <button class="inline-flex items-center p-2 border border-transparent rounded-md text-green-600 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('entregas_auditoria.completar') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                                <button class="inline-flex items-center p-2 border border-transparent rounded-md text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Completadas -->
            <div class="tab-pane" id="completadas" style="display: none;">
                <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporte</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Completada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Días de Retraso</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo Adjunto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entregas_completadas as $entrega)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entrega->configReporte->reporte ?? 'No especificado' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                            $fechaCompletada = \Carbon\Carbon::parse($entrega->fecha_completada);
                                            $diferencia = $fechaEntrega->diffInDays($fechaCompletada, false);
                                        @endphp

                                        @if ($diferencia >= 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sin retraso
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ abs($diferencia) }} días de retraso
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($entrega->archivo_adjunto)
                                        <a href="/storage/app/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" 
                                           download 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Descargar
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="modalSubirArchivo">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Subir Archivo Adjunto
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="closeModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form id="uploadFormModal" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="archivo_adjunto_modal" class="block text-sm font-medium text-gray-700 mb-2">
                            Archivo Adjunto:
                        </label>
                        <input type="file" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                               id="archivo_adjunto_modal" 
                               name="archivo_adjunto" 
                               required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" 
                                onclick="closeModal()" 
                                class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Subir Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Funciones para alertas dinámicas
    function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.transform = 'translateX(-100%)';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }

    function autoCloseAlerts() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        // Auto cerrar alerta de éxito después de 5 segundos
        if (successAlert) {
            const progressBar = document.getElementById('progressBar');
            let width = 100;
            const interval = setInterval(() => {
                width -= 2;
                if (progressBar) {
                    progressBar.style.width = width + '%';
                }
                if (width <= 0) {
                    clearInterval(interval);
                    closeAlert('successAlert');
                }
            }, 100); // 5 segundos total (50 * 100ms)
        }
        
        // Auto cerrar alerta de error después de 10 segundos
        if (errorAlert) {
            setTimeout(() => {
                closeAlert('errorAlert');
            }, 10000);
        }
    }

    // Función para mostrar alertas dinámicamente
    function showAlert(message, type = 'success') {
        const alertsContainer = document.querySelector('.max-w-7xl');
        const alertId = 'dynamic-alert-' + Date.now();
        
        const alertHTML = type === 'success' ? `
            <div id="${alertId}" class="alert-success relative bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-md transform transition-all duration-500 ease-in-out opacity-0 -translate-x-full">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" onclick="closeAlert('${alertId}')" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600 transition-colors duration-200">
                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        ` : `
            <div id="${alertId}" class="alert-error relative bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-md transform transition-all duration-500 ease-in-out opacity-0 -translate-x-full">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" onclick="closeAlert('${alertId}')" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 transition-colors duration-200">
                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        alertsContainer.insertAdjacentHTML('afterbegin', alertHTML);
        
        // Animar entrada
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '1';
                alert.style.transform = 'translateX(0)';
            }
        }, 100);
        
        // Auto cerrar después de 5 segundos
        setTimeout(() => {
            closeAlert(alertId);
        }, 5000);
    }

    // Funcionalidad de tabs
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar auto-close de alertas
        autoCloseAlerts();
        
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');

        // Mostrar el primer tab por defecto
        if (tabPanes.length > 0) {
            tabPanes[0].style.display = 'block';
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remover clases activas de todos los botones
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Agregar clases activas al botón clickeado
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-blue-500', 'text-blue-600');
                
                // Ocultar todos los paneles
                tabPanes.forEach(pane => {
                    pane.style.display = 'none';
                });
                
                // Mostrar el panel objetivo
                const targetPane = document.getElementById(targetTab);
                if (targetPane) {
                    targetPane.style.display = 'block';
                }
            });
        });
    });

    // Funcionalidad del archivo (mejorada con alertas)
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(fileInput => {
            const form = fileInput.closest('form');
            if (!form) return;
            
            const fileLabel = form.querySelector('#fileLabel');
            const fileName = form.querySelector('#fileName');
            const submitBtn = form.querySelector('#submitBtn');

            if (fileInput && fileLabel && fileName && submitBtn) {
                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) {
                        const selectedFile = fileInput.files[0];
                        
                        // Validar tamaño de archivo (máximo 10MB)
                        const maxSize = 10 * 1024 * 1024; // 10MB
                        if (selectedFile.size > maxSize) {
                            showAlert('El archivo es demasiado grande. Máximo 10MB permitido.', 'error');
                            fileInput.value = '';
                            return;
                        }
                        
                        fileName.style.display = 'inline';
                        fileName.textContent = selectedFile.name;
                        submitBtn.style.display = 'inline';
                        fileLabel.style.display = 'none';
                    } else {
                        fileName.style.display = 'none';
                        submitBtn.style.display = 'none';
                        fileLabel.style.display = 'inline';
                    }
                });
                
                // Manejar envío del formulario
                form.addEventListener('submit', function(e) {
                    if (fileInput.files.length > 0) {
                        showAlert('Subiendo archivo...', 'success');
                    }
                });
            }
        });
    });

    // Funciones del modal
    function closeModal() {
        const modal = document.getElementById('modalSubirArchivo');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function openModal() {
        const modal = document.getElementById('modalSubirArchivo');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    // Cerrar modal al hacer click fuera de él
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('modalSubirArchivo');
        if (modal && event.target === modal) {
            closeModal();
        }
    });
</script>
@endpush