@extends('home', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('contentJunzi')
<div class="bg-gray-50 py-5">
    <div class="max-w-4xl mx-auto px-3 mt-5 sm:px-4 lg:px-6">
        
        <!-- Main Card -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h1 class="text-2xl font-bold text-white">
                            Auditorías
                            <span class="ml-2 px-2 py-1 bg-blue-500 bg-opacity-50 rounded-full text-sm font-medium">
                                {{ count($auditorias) }}
                            </span>
                        </h1>
                    </div>
                    
                    <!-- Header Section -->
                    @if(auth()->user()->auditoria=='1')
                    <div class="mb-6 py-4 flex justify-end">
                        <div class="flex space-x-3">
                            <a href="/export/auditorias" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar
                            </a>
                            <a href="{{ route('auditorias.nueva') }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear auditoría
                            </a>
                            <a href="{{ route('areas_auditoria.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Áreas
                            </a>

                            <a href="{{ route('config.hallazgos') }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Config Hallazgos
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                
                <!-- Custom Tabs -->
                <div class="w-full">
                    <!-- Tab Buttons -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button class="tab-button py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap focus:outline-none focus:text-blue-600 focus:border-blue-500 transition duration-150 ease-in-out"
                                    data-target="#tab-pendientes">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Sin cerrar
                                    <span class="ml-2 px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full">
                                        {{ count($auditoriasPendientes) }}
                                    </span>
                                </div>
                            </button>
                            <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                                    data-target="#tab-completadas">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Cerradas
                                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        {{ count($auditoriasCerradas) }}
                                    </span>
                                </div>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Tab Pendientes -->
                        <div id="tab-pendientes" class="tab-pane active">
                            @if(count($auditoriasPendientes) > 0)
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                        </svg>
                                                        {{ __('Auditorías') }}
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('Hallazgos') }}
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    {{ __('Opciones') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($auditoriasPendientes as $auditoria)
                                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                                    <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $auditoria->tipo.'-'.$auditoria->area.'-'.$auditoria->anio.'-'.$auditoria->folio }}
                                                                </div>
                                                                {{-- <div class="text-sm text-gray-500">
                                                                    ID: {{ $auditoria->id }}
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $auditoriaDetallePendientes = \App\Models\Auditoria::withCount([
                                                            'hallazgos'
                                                        ])->find($auditoria->id);
                                                    @endphp
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($auditoriaDetallePendientes->hallazgos_count ) && $auditoriaDetallePendientes->hallazgos_count  > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                            {{ $auditoriaDetallePendientes->hallazgos_count ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <a href="/auditoria/{{ $auditoria->id }}" 
                                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-sm">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay auditorías pendientes</h3>
                                    <p class="mt-1 text-sm text-gray-500">Todas las auditorías han sido cerradas.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tab Completadas -->
                        <div id="tab-completadas" class="tab-pane hidden">
                            @if(count($auditoriasCerradas) > 0)
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                        </svg>
                                                        {{ __('Auditorías') }}
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('Hallazgos') }}
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    {{ __('Opciones') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($auditoriasCerradas as $auditoria)
                                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $auditoria->tipo.'-'.$auditoria->area.'-'.$auditoria->ubicacion.'-'.$auditoria->anio.'-'.$auditoria->folio }}
                                                                </div>
                                                                {{-- <div class="text-sm text-gray-500">
                                                                    ID: {{ $auditoria->id }}
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $auditoriaDetalleCerrados = \App\Models\Auditoria::withCount([
                                                            'hallazgos'
                                                        ])->find($auditoria->id);
                                                    @endphp
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($auditoriaDetalleCerrados->hallazgos_count ) && $auditoriaDetalleCerrados->hallazgos_count  > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                            {{ $auditoriaDetalleCerrados->hallazgos_count ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <a href="/auditoria/{{ $auditoria->id }}" 
                                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-sm">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay auditorías cerradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Aún no se han cerrado auditorías.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    //console.log('🚀 Inicializando sistema de tabs...');
    
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    //console.log('📋 Botones encontrados:', tabButtons.length);
    //console.log('📄 Paneles encontrados:', tabPanes.length);
    
    // Listar todos los botones y sus targets
    tabButtons.forEach((btn, index) => {
        const target = btn.getAttribute('data-target');
        //console.log(`🔘 Botón ${index + 1}: target = "${target}"`);
    });
    
    // Listar todos los paneles
    tabPanes.forEach((pane, index) => {
        //console.log(`📝 Panel ${index + 1}: id = "${pane.id}"`);
    });
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Obtener el target (sin # si ya lo tiene)
            let target = this.getAttribute('data-target');
            //console.log('🎯 Target original:', target);
            
            // Limpiar el target - remover # si existe y luego agregarlo
            if (target.startsWith('#')) {
                target = target.substring(1);
            }
            //console.log('🎯 Target limpio:', target);
            
            // Remover clases activas de todos los botones
            tabButtons.forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-500');
                btn.classList.add('text-gray-500', 'border-transparent');
            });
            
            // Ocultar todos los tab panes
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });
            
            // Activar el botón clickeado
            this.classList.remove('text-gray-500', 'border-transparent');
            this.classList.add('text-blue-600', 'border-blue-500');
            
            // Mostrar el tab pane correspondiente
            const targetPane = document.getElementById(target);
            //console.log('🎯 Panel objetivo:', targetPane);
            
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
                //console.log('✅ Tab activado:', target);
            } else {
                console.error('❌ No se encontró el panel:', target);
            }
        });
    });
    
    // Asegurar que el primer tab esté activo al cargar
    const firstTab = document.querySelector('.tab-button');
    const firstPane = document.getElementById('tab-pendientes');
    
    //console.log('🔄 Inicializando primer tab...');
    //console.log('🔘 Primer botón:', firstTab);
    //console.log('📄 Primer panel:', firstPane);
    
    if (firstTab && firstPane) {
        // Resetear todos primero
        tabButtons.forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-500');
            btn.classList.add('text-gray-500', 'border-transparent');
        });
        
        tabPanes.forEach(pane => {
            pane.classList.add('hidden');
            pane.classList.remove('active');
        });
        
        // Activar el primer tab
        firstTab.classList.remove('text-gray-500', 'border-transparent');
        firstTab.classList.add('text-blue-600', 'border-blue-500');
        firstPane.classList.remove('hidden');
        firstPane.classList.add('active');
        
        //console.log('✅ Primer tab inicializado correctamente');
    } else {
        console.error('❌ Error al inicializar primer tab');
    }
    
    // Validación de archivos en formularios
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const maxSize = 60 * 1024 * 1024; // 60MB
                if (file.size > maxSize) {
                    alert('El archivo es demasiado grande. Tamaño máximo: 60MB');
                    e.target.value = '';
                    return false;
                }
                
                // Mostrar información del archivo
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                let fileInfo = document.getElementById('file-info-' + input.id);
                if (!fileInfo) {
                    fileInfo = document.createElement('div');
                    fileInfo.id = 'file-info-' + input.id;
                    fileInfo.className = 'mt-2 text-sm text-gray-600';
                    input.parentNode.appendChild(fileInfo);
                }
                fileInfo.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>${fileName} (${fileSize} MB)</span>
                    </div>
                `;
            }
        });
    });
    
    // Mostrar progreso de subida
    const forms = document.querySelectorAll('form[enctype="multipart/form-data"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Subiendo...
                `;
            }
        });
    });
    
    //console.log('🎉 Sistema de tabs inicializado completamente');
});
</script>
@endpush
