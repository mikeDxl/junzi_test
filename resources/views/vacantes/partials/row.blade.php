<!-- vacantes/partials/row.blade.php -->
@php
    $diasActiva = \Carbon\Carbon::parse($vac->fecha)->diffInDays(\Carbon\Carbon::now());
    $fechaFormateada = str_replace(' 12:00:00 AM', '', $vac->fecha);
    $fechaAlta = $vac->altas()->latest('fecha_alta')->first()->fecha_alta ?? 'No disponible';
    $ultimaModificacion = \Carbon\Carbon::createFromFormat('d/m/Y', \Carbon\Carbon::parse($vac->updated_at)->format('d/m/Y'));
    $diasProceso = $ultimaModificacion->diffInDays(\Carbon\Carbon::now());
    
    // Determinar color del badge de prioridad
    $prioridadColor = match($vac->prioridad) {
        'Alta' => 'bg-red-100 text-red-800',
        'Media' => 'bg-yellow-100 text-yellow-800',
        'Baja' => 'bg-gray-100 text-gray-800',
        default => 'bg-gray-100 text-gray-800'
    };
    
    // Determinar estado del proceso
    $completadasPorcentaje = $vac->solicitadas > 0 ? ($vac->completadas / $vac->solicitadas) * 100 : 0;
    $procesoColor = match(true) {
        $completadasPorcentaje >= 100 => 'bg-green-100 text-green-800',
        $completadasPorcentaje >= 50 => 'bg-blue-100 text-blue-800',
        $completadasPorcentaje >= 25 => 'bg-yellow-100 text-yellow-800',
        default => 'bg-orange-100 text-orange-800'
    };
    
    $procesoTexto = match(true) {
        $completadasPorcentaje >= 100 => 'Completado',
        $completadasPorcentaje >= 50 => 'Avanzado',
        $completadasPorcentaje >= 25 => 'En progreso',
        default => 'Iniciando'
    };
@endphp

<tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
    <!-- Prioridad -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $prioridadColor }}">
            {{ $vac->prioridad }}
        </span>
    </td>
    
    <!-- Candidatos -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        <div class="flex flex-col items-center">
            <span class="text-sm font-medium text-gray-900">{{ cuantoscandidatos($vac->id) }}</span>
            <span class="text-xs text-gray-500">candidatos</span>
        </div>
    </td>
    
    <!-- Puesto -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        <div class="max-w-xs">
            <div class="flex items-center justify-center">
                <div class="text-sm font-medium text-gray-900 truncate">
                    {{ catalogopuesto($vac->puesto_id) }}
                </div>
                @if(buscarperfil($vac->puesto_id))
                    <a target="_blank" 
                       href="storage/{{ buscarperfil($vac->puesto_id) }}" 
                       class="ml-2 text-blue-600 hover:text-blue-800 transition-colors duration-150"
                       title="Descargar perfil">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="mt-1 space-y-1">
                <div class="text-xs text-gray-500 truncate">{{ $vac->area }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $vac->codigo }}</div>
                <div class="text-xs text-blue-600 truncate">{{ nombre_empresa($vac->company_id) }}</div>
            </div>
        </div>
    </td>
    
    <!-- Proceso -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        <div class="flex flex-col items-center space-y-1">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $procesoColor }}">
                {{ $procesoTexto }}
            </span>
            <span class="text-xs text-gray-500">{{ $vac->completadas }}/{{ $vac->solicitadas }}</span>
            @if($vac->solicitadas > 0)
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" 
                         style="width: {{ min($completadasPorcentaje, 100) }}%"></div>
                </div>
            @endif
        </div>
    </td>
    
    <!-- Tiempo Abierta -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        @if($tab == 'enEspera')
            <div class="text-center space-y-1">
                <div class="text-sm text-gray-900">{{ $fechaFormateada }}</div>
                <div class="text-xs text-gray-500">{{ $ultimaModificacion->format('d/m/Y') }}</div>
                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $diasActiva }} días activa
                </div>
                @if($fechaAlta != 'No disponible')
                    <div class="text-xs text-green-600 font-medium">
                        Ingreso: {{ \Carbon\Carbon::parse($fechaAlta)->format('d/m/Y') }}
                    </div>
                @else
                    <div class="text-xs text-gray-400">Sin fecha de ingreso</div>
                @endif
            </div>
        @elseif($tab == 'historico')
            <div class="text-center space-y-1">
                <div class="text-xs text-gray-500">
                    <span class="font-medium">Inicio:</span> {{ $fechaFormateada }}
                </div>
                <div class="text-xs text-gray-500">
                    <span class="font-medium">Fin:</span> {{ $ultimaModificacion->format('d/m/Y') }}
                </div>
                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 012 2v6a2 2 0 01-2 2h-6"/>
                    </svg>
                    {{ $diasActiva }} días total
                </div>
            </div>
        @else
            <div class="text-center space-y-1">
                <div class="text-sm text-gray-900">{{ $fechaFormateada }}</div>
                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    {{ $diasActiva }} días activa
                </div>
            </div>
        @endif
    </td>
    
    <!-- Seguimiento -->
    <td class="px-6 py-5 whitespace-nowrap text-center">
        @if($tab == 'enProceso')
            <a href="/proceso_vacante/{{ $vac->id }}" 
               class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out shadow-sm" 
               title="Ver seguimiento del proceso">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
        @elseif($tab == 'enEspera')
            <a href="/proceso_vacante/{{ $vac->id }}" 
               class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-150 ease-in-out shadow-sm" 
               title="En espera de ingreso">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </a>
        @else
            <a href="/proceso_vacante/{{ $vac->id }}" 
               class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out shadow-sm" 
               title="Ver histórico">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 6-6"/>
                </svg>
            </a>
        @endif
    </td>
    
    <!-- Acciones (solo en enProceso) -->
    @if($tab == 'enProceso')
        <td class="px-6 py-5 whitespace-nowrap text-center">
            <div class="flex items-center justify-center space-x-2">
                <a href="/proceso_vacante/{{ $vac->id }}" 
                   class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-sm" 
                   title="Ver detalles completos">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>
                {{-- <a href="/vacante/editar/{{ $vac->id }}" 
                   class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm" 
                   title="Editar vacante">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a> --}}
                <button onclick="editVacante({{ $vac->id }})" 
                        data-vacante-id="{{ $vac->id }}"
                        data-company-id="{{ $vac->company_id }}"
                        data-departamento-id="{{ $vac->departamento_id }}"
                        data-puesto-id="{{ $vac->puesto_id }}"
                        data-solicitadas="{{ $vac->solicitadas }}"
                        data-completadas="{{ $vac->completadas ?? '' }}"
                        data-prioridad="{{ $vac->prioridad }}"
                        data-jefe="{{ $vac->jefe ?? '' }}"
                        data-area-id="{{ $vac->area_id }}"
                        data-nivel="{{ $vac->nivel ?? '' }}"
                        data-fecha="{{ $vac->fecha }}"
                        class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm" 
                        title="Editar vacante">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
            </div>
        </td>
    @endif
</tr>