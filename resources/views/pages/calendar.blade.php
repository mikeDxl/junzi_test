@php
    $noJQuery = true;
@endphp

@extends('home', [
    'activePage' => 'calendario', 
    'menuParent' => 'calendario', 
    'titlePage' => __('Calendar'),
    'noJQuery' => true  // Variable adicional por si el layout la usa
])

@section('contentJunzi')
<!-- FullCalendar v6 CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

{{-- CSS personalizado --}}
<style>
  /* Tu CSS personalizado aquí - mismo que tienes */
  :root {
    --fc-border-color: #d1d5db;
    --fc-button-bg-color: #374151;
    --fc-button-border-color: #374151;
    --fc-button-hover-bg-color: #1f2937;
    --fc-button-hover-border-color: #1f2937;
    --fc-button-active-bg-color: #111827;
    --fc-button-active-border-color: #111827;
  }

  .fc {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 0.875rem;
    max-width: 100%;
    overflow: hidden;
  }
  
  .fc-theme-standard td, 
  .fc-theme-standard th {
    border-color: var(--fc-border-color);
    border-width: 1px;
    padding: 0;
    vertical-align: top;
  }
  
  .fc-scrollgrid {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    table-layout: fixed;
  }
  
  .fc-scrollgrid-section > * {
    width: 100%;
    box-sizing: border-box;
  }
  
  .fc-daygrid {
    width: 100% !important;
  }
  
  .fc-daygrid-day {
    min-height: 80px;
    position: relative;
    box-sizing: border-box;
  }
  
  .fc-daygrid-day-frame {
    min-height: 80px;
    position: relative;
    box-sizing: border-box;
  }
  
  .fc-button-primary {
    background-color: var(--fc-button-bg-color) !important;
    border-color: var(--fc-button-border-color) !important;
    color: #ffffff !important;
    padding: 0.375rem 0.75rem !important;
    border-radius: 0.25rem !important;
    font-weight: 500 !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    border-width: 1px !important;
    border-style: solid !important;
  }
  
  .fc-button-primary:hover:not(:disabled) {
    background-color: var(--fc-button-hover-bg-color) !important;
    border-color: var(--fc-button-hover-border-color) !important;
  }
  
  .fc-button-primary:focus,
  .fc-button-primary:active {
    background-color: var(--fc-button-active-bg-color) !important;
    border-color: var(--fc-button-active-border-color) !important;
    box-shadow: 0 0 0 2px rgba(55, 65, 81, 0.1) !important;
  }
  
  .fc-button-primary:disabled {
    background-color: #9ca3af !important;
    border-color: #9ca3af !important;
    opacity: 0.5 !important;
    cursor: not-allowed !important;
  }
  
  .fc-daygrid-day.fc-day-today {
    background-color: #fef3c7 !important;
    position: relative;
  }
  
  .fc-daygrid-day.fc-day-today::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #f59e0b;
    z-index: 1;
  }
  
  .fc-event {
    border: none !important;
    border-radius: 3px !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    margin: 1px !important;
    padding: 1px 3px !important;
    min-height: 16px !important;
    line-height: 1.2 !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    box-sizing: border-box !important;
  }
  
  .fc-event:hover {
    opacity: 0.8 !important;
  }
  
  .fc-event-main {
    padding: 1px 3px !important;
  }
  
  .fc-event-title {
    font-size: 0.75rem !important;
    line-height: 1.2 !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
  }
  
  .fc-toolbar {
    margin-bottom: 1rem !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 0.5rem !important;
  }
  
  .fc-toolbar-title {
    font-size: 1.25rem !important;
    font-weight: 600 !important;
    color: #1f2937 !important;
    margin: 0 !important;
    line-height: 1.5 !important;
  }
  
  .fc-col-header-cell {
    background-color: #f9fafb !important;
    font-weight: 600 !important;
    color: #374151 !important;
    padding: 0.5rem 0.25rem !important;
    text-align: center !important;
    font-size: 0.75rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.025em !important;
    border-bottom: 2px solid #e5e7eb !important;
  }
  
  .fc-daygrid-day-number {
    color: #374151 !important;
    font-weight: 500 !important;
    padding: 0.25rem !important;
    font-size: 0.875rem !important;
    text-decoration: none !important;
    display: block !important;
    text-align: right !important;
  }
  
  /* Event Colors */
  .fc-event.todo { 
    background-color: #3b82f6 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #1d4ed8 !important;
  }
  .fc-event.entrevistas { 
    background-color: #10b981 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #047857 !important;
  }
  .fc-event.bajas { 
    background-color: #ef4444 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #dc2626 !important;
  }
  .fc-event.ingresos { 
    background-color: #8b5cf6 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #7c3aed !important;
  }
  .fc-event.vacaciones { 
    background-color: #f59e0b !important; 
    color: #ffffff !important; 
    border-left: 3px solid #d97706 !important;
  }
  .fc-event.permisos { 
    background-color: #6366f1 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #4f46e5 !important;
  }
  .fc-event.incapacidades { 
    background-color: #f97316 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #ea580c !important;
  }
  .fc-event.hallazgos { 
    background-color: #ec4899 !important; 
    color: #ffffff !important; 
    border-left: 3px solid #db2777 !important;
  }
</style>

<div class="min-h-screen bg-gray-50 py-5">
  <div class="max-w-7xl mx-auto px-3 mt-5 sm:px-6 lg:px-8">
    <!-- Header with controls and filters -->
    <div class="bg-white rounded-lg shadow-sm mb-4 p-4">
      <div class="flex flex-col gap-4">
        <!-- Top row: Title and Quick Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <h1 class="text-2xl font-bold text-gray-900">Calendario</h1>
          
          <!-- Quick Actions -->
          <div class="flex items-center gap-2">
            <button id="prevMonth" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button id="nextMonth" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
            <button id="todayBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
              Hoy
            </button>
            <button id="refreshBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
              <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Actualizar
            </button>
          </div>
        </div>

        <!-- Bottom row: Horizontal Filters -->
        <div class="border-t border-gray-200 pt-4">
          <form action="{{ route('calendar.filtro') }}" method="post" id="filtro-form">
            @csrf
            <input type="hidden" name="ajax" value="1" id="ajax-input">
            
            <div class="flex flex-wrap items-center gap-3">
              <!-- Todo Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="todo" 
                       {{ $filtro == 'todo' ? 'checked' : '' }}
                       class="h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                  Todo
                </span>
              </label>

              @if(auth()->user()->perfil!='Colaborador')
              <!-- Entrevistas Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="entrevistas" 
                       {{ $filtro == 'entrevistas' ? 'checked' : '' }}
                       class="h-3 w-3 text-green-600 focus:ring-green-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                  Entrevistas
                </span>
              </label>

              <!-- Bajas Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="bajas" 
                       {{ $filtro == 'bajas' ? 'checked' : '' }}
                       class="h-3 w-3 text-red-600 focus:ring-red-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                  Bajas
                </span>
              </label>

              <!-- Ingresos Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="ingresos" 
                       {{ $filtro == 'ingresos' ? 'checked' : '' }}
                       class="h-3 w-3 text-purple-600 focus:ring-purple-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-1"></span>
                  Ingresos
                </span>
              </label>
              @endif

              <!-- Vacaciones Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="vacaciones" 
                       {{ $filtro == 'vacaciones' ? 'checked' : '' }}
                       class="h-3 w-3 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
                  Vacaciones
                </span>
              </label>

              <!-- Permisos Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="permisos" 
                       {{ $filtro == 'permisos' ? 'checked' : '' }}
                       class="h-3 w-3 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-indigo-500 rounded-full mr-1"></span>
                  Permisos
                </span>
              </label>

              <!-- Incapacidades Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="incapacidades" 
                       {{ $filtro == 'incapacidades' ? 'checked' : '' }}
                       class="h-3 w-3 text-orange-600 focus:ring-orange-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-orange-500 rounded-full mr-1"></span>
                  Incapacidades
                </span>
              </label>

              <!-- Hallazgos Filter -->
              <label class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200">
                <input type="radio" 
                       name="filtro" 
                       value="hallazgos" 
                       {{ $filtro == 'hallazgos' ? 'checked' : '' }}
                       class="h-3 w-3 text-pink-600 focus:ring-pink-500 border-gray-300">
                <span class="ml-2 flex items-center text-sm font-medium text-gray-700">
                  <span class="w-2 h-2 bg-pink-500 rounded-full mr-1"></span>
                  Hallazgos
                </span>
              </label>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
      <!-- Calendar Main Content -->
      <div class="col-span-1">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
          <!-- Loading Indicator -->
          <div id="calendar-loading" class="hidden p-8 text-center">
            <div class="inline-flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Cargando calendario...
            </div>
          </div>
          
          <!-- Error Message -->
          <div id="calendar-error" class="hidden p-8 text-center text-red-600">
            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-medium">Error al cargar el calendario</p>
            <button id="retry-btn" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
              Reintentar
            </button>
          </div>
          <!-- Calendar Container -->
          <div id="fullCalendar" class="min-h-[600px]"></div>
        </div>
      </div>
    
      <!-- Event Details Modal -->
      <div id="event-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
          <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 id="modal-title" class="text-lg font-semibold text-gray-900"></h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div id="modal-content" class="space-y-3"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- Remover jQuery si está presente -->
<script>
// Detectar y remover jQuery ANTES de cargar FullCalendar
(function() {
    // Remover jQuery completamente del scope global
    if (typeof jQuery !== 'undefined') {
        console.warn('jQuery detectado - eliminando para evitar conflictos');
        window.jQuery = undefined;
        window.$ = undefined;
        delete window.jQuery;
        delete window.$;
    }
    
})();
</script>


@push('scripts')

<!-- Cargar FullCalendar v6 -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js"></script>


<!-- Verificar carga y ejecutar calendario -->
<script>

// Variables del calendario
let calendar;
let allEvents = @json($eventos);
let currentFilter = '{{ $filtro }}';

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // console.log('=== INICIALIZANDO CALENDARIO ===');
    
    // Verificar que FullCalendar esté disponible
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar no está disponible');
        showError('FullCalendar no se cargó correctamente');
        return;
    }
    
    // Inicializar con delay para asegurar carga completa
    setTimeout(() => {
        initializeCalendar();
        initializeFilters();
        console.log('Calendario inicializado correctamente');
    }, 200);
});

function initializeCalendar() {
    const calendarEl = document.getElementById('fullCalendar');
    const loadingEl = document.getElementById('calendar-loading');
    const errorEl = document.getElementById('calendar-error');
    
    if (!calendarEl) {
        console.error('Elemento #fullCalendar no encontrado');
        return;
    }

    try {
        console.log('Creando instancia de FullCalendar...');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            // Configuración básica
            initialView: 'dayGridMonth',
            locale: 'es',
            
            // Toolbar
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            
            // Textos en español
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            
            // Configuración de eventos
            events: Array.isArray(allEvents) ? allEvents : [],
            height: 'auto',
            aspectRatio: 1.35,
            
            // Event handlers
            eventDidMount: function(info) {
                try {
                    if (info.event.extendedProps?.tipo) {
                        info.el.classList.add(info.event.extendedProps.tipo);
                    }
                } catch (e) {
                    console.warn('Error en eventDidMount:', e);
                }
            },
            
            eventClick: function(info) {
                try {
                    info.jsEvent.preventDefault();
                    showEventModal(info.event);
                } catch (e) {
                    console.error('Error en eventClick:', e);
                }
            },
            
            loading: function(bool) {
                try {
                    if (bool) {
                        if (loadingEl) loadingEl.classList.remove('hidden');
                        calendarEl.classList.add('opacity-50');
                    } else {
                        if (loadingEl) loadingEl.classList.add('hidden');
                        calendarEl.classList.remove('opacity-50');
                    }
                } catch (e) {
                    console.warn('Error en loading callback:', e);
                }
            }
        });
        
        console.log('Renderizando calendario...');
        calendar.render();
        console.log('Calendario renderizado exitosamente');
        
        // Configurar botones de navegación
        setupNavigationButtons();
        
    } catch (error) {
        console.error('Error al inicializar calendario:', error);
        showError(`Error: ${error.message}`);
    }
}

function setupNavigationButtons() {
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');
    const todayBtn = document.getElementById('todayBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (calendar) calendar.prev();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (calendar) calendar.next();
        });
    }
    
    if (todayBtn) {
        todayBtn.addEventListener('click', () => {
            if (calendar) calendar.today();
        });
    }
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            if (calendar) calendar.refetchEvents();
        });
    }
    
    console.log('Botones de navegación configurados');
}

function initializeFilters() {
    const filterInputs = document.querySelectorAll('input[name="filtro"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                handleFilterChange(this);
            }
        });
    });
    
    // Modal functionality
    const closeModalBtn = document.getElementById('close-modal');
    const eventModal = document.getElementById('event-modal');
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeEventModal);
    }
    
    if (eventModal) {
        eventModal.addEventListener('click', function(e) {
            if (e.target === this) closeEventModal();
        });
    }
    
    console.log('Filtros configurados:', filterInputs.length);
}

function handleFilterChange(element) {
    const form = document.getElementById('filtro-form');
    if (!form) return;
    
    try {
        const filterContainer = element.closest('.flex.flex-wrap');
        if (filterContainer) {
            filterContainer.style.opacity = '0.6';
        }
        
        if (window.fetch) {
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                    document.querySelector('input[name="_token"]')?.value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.eventos) {
                    allEvents = data.eventos;
                    if (calendar) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(allEvents);
                    }
                    console.log(`Filtro aplicado: ${element.value}, Eventos: ${allEvents.length}`);
                } else {
                    console.warn('Sin datos de eventos del servidor');
                    form.submit();
                }
            })
            .catch(error => {
                console.error('Error en filtro AJAX:', error);
                form.submit();
            })
            .finally(() => {
                if (filterContainer) {
                    filterContainer.style.opacity = '1';
                }
            });
        } else {
            form.submit();
        }
    } catch (e) {
        console.error('Error en handleFilterChange:', e);
        form.submit();
    }
}

function showEventModal(event) {
    try {
        const modal = document.getElementById('event-modal');
        const title = document.getElementById('modal-title');
        const content = document.getElementById('modal-content');
        
        if (!modal || !title || !content) return;
        
        title.textContent = event.title || 'Sin título';
        
        const eventStart = event.start ? event.start.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }) : 'Fecha no disponible';
        
        let eventTime = '';
        if (event.start && !event.allDay) {
            eventTime = event.start.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit'
            });
            if (event.end) {
                eventTime += ' - ' + event.end.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        }
        
        const eventDescription = event.extendedProps?.descripcion || '';
        const eventType = event.extendedProps?.tipo ? 
            event.extendedProps.tipo.charAt(0).toUpperCase() + event.extendedProps.tipo.slice(1) : '';
        
        const eventTypeColors = {
            'todo': '#3b82f6',
            'entrevistas': '#10b981',
            'bajas': '#ef4444',
            'ingresos': '#8b5cf6',
            'vacaciones': '#f59e0b',
            'permisos': '#6366f1',
            'incapacidades': '#f97316',
            'hallazgos': '#ec4899'
        };
        
        const iconColor = event.extendedProps?.tipo ? 
            (eventTypeColors[event.extendedProps.tipo] || '#3b82f6') : '#3b82f6';
        
        let htmlContent = '';
        
        if (eventType) {
            htmlContent += `
                <div class="mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                          style="background-color: ${iconColor}20; color: ${iconColor};">
                        <span class="w-2 h-2 rounded-full mr-2" style="background-color: ${iconColor};"></span>
                        ${eventType}
                    </span>
                </div>
            `;
        }
        
        htmlContent += `
            <div class="space-y-3">
                <div>
                    <div class="flex items-center text-sm font-medium text-gray-900 mb-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Fecha
                    </div>
                    <p class="text-gray-700 ml-6">${eventStart}</p>
                </div>
        `;
        
        if (eventTime) {
            htmlContent += `
                <div>
                    <div class="flex items-center text-sm font-medium text-gray-900 mb-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hora
                    </div>
                    <p class="text-gray-700 ml-6">${eventTime}</p>
                </div>
            `;
        }
        
        if (eventDescription) {
            htmlContent += `
                <div>
                    <div class="flex items-center text-sm font-medium text-gray-900 mb-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Descripción
                    </div>
                    <p class="text-gray-700 ml-6">${eventDescription}</p>
                </div>
            `;
        }
        
        htmlContent += '</div>';
        
        content.innerHTML = htmlContent;
        modal.classList.remove('hidden');
        
    } catch (e) {
        console.error('Error in showEventModal:', e);
    }
}

function closeEventModal() {
    try {
        const modal = document.getElementById('event-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    } catch (e) {
        console.error('Error in closeEventModal:', e);
    }
}

function showError(message) {
    const errorEl = document.getElementById('calendar-error');
    const loadingEl = document.getElementById('calendar-loading');
    
    if (errorEl) {
        errorEl.classList.remove('hidden');
        errorEl.innerHTML = `
            <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium text-red-600">Error al cargar el calendario</p>
            <p class="text-sm text-gray-600 mt-1">${message}</p>
            <button onclick="location.reload()" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Recargar página
            </button>
        `;
    }
    
    if (loadingEl) {
        loadingEl.classList.add('hidden');
    }
}

// Event listeners globales
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
    }
});

// Manejo de errores globales
window.addEventListener('error', function(e) {
    if (e.message.includes('FullCalendar') || e.message.includes('addClass')) {
        console.error('Error de FullCalendar capturado:', e);
        showError(`Error del calendario: ${e.message}`);
    }
});

console.log('Script del calendario cargado completamente');
</script>
@endpush