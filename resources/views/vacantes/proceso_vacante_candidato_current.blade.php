@extends('home', ['activePage' => 'Proceso Vacante', 'menuParent' => 'forms', 'titlePage' => __('Proceso Vacante')])

@section('contentJunzi')

<?php
if (isset($_GET["can"]) && isset($_GET["paso"])) {
    $can = $_GET["can"];
    $paso = $_GET["paso"];
} else {
    $can = '0';
    $paso = '1';
}
?>

<input type="hidden" id="can" value="candidato<?php echo $can; ?>">
<input type="hidden" id="paso" value="tab_paso<?php echo $can; ?>-<?php echo $paso; ?>">

<style>
/* Estilos para rating (manteniendo los originales) */
.star {
    @apply text-3xl text-gray-400 cursor-pointer transition-colors duration-200;
}

.star:hover,
.star.active {
    @apply text-yellow-400;
}

.rating-option {
    @apply border border-orange-400 rounded-full px-4 py-2 cursor-pointer transition-all duration-200;
}

.rating-option:hover,
.rating-option.active {
    @apply bg-orange-400 text-white;
}

.nav-listo {
    @apply bg-green-500 text-white;
}

.col-file {
    @apply border border-gray-300 m-1 p-2 rounded;
}

.alert-contenido {
    @apply bg-black bg-opacity-50 text-white p-4 rounded;
}

.estrella {
    @apply text-yellow-400;
}

/* Responsive para pantallas pequeñas - stepper vertical */
@media (max-width: 768px) {
    .stepper-responsive {
        flex-direction: column;
        align-items: flex-start;
    }

    .stepper-responsive .flex-1 {
        width: 2px;
        height: 2rem;
        margin: 0.5rem 0;
        margin-left: 1.5rem;
    }

    .stepper-responsive > div {
        flex-direction: row;
        align-items: center;
        width: 100%;
    }

    .stepper-responsive .mt-3 {
        margin-top: 0;
        margin-left: 1rem;
        max-width: none;
    }
}
</style>

<?php
// Inicializar todas las variables de estado para evitar errores
$clase_fa1 = "fa fa-clock";
$clase_fa2 = "fa fa-clock";
$clase_fa3 = "fa fa-clock";
$clase_fa4 = "fa fa-clock";
$clase_fa5 = "fa fa-clock";
$clase_fa6 = "fa fa-clock";
$clase_fa7 = "fa fa-clock";

// Lógica para determinar el estado de cada paso (manteniendo la lógica original)
$steps = [
    ['key' => 'curriculum', 'label' => 'Curriculum', 'icon' => 'fa-file-alt'],
    ['key' => 'entrevista', 'label' => 'Entrevista', 'icon' => 'fa-comments'],
    ['key' => 'evaluacion', 'label' => 'Evaluación', 'icon' => 'fa-star'],
    ['key' => 'referencias', 'label' => 'Referencias', 'icon' => 'fa-users'],
    ['key' => 'examen', 'label' => 'Examen', 'icon' => 'fa-clipboard-check'],
    ['key' => 'documentos', 'label' => 'Documentos', 'icon' => 'fa-folder'],
    ['key' => 'nomina', 'label' => 'Nómina', 'icon' => 'fa-check-circle']
];

// Estado de cada paso
$stepStates = [];

// Paso 1: Curriculum
if ($procesoinfo->curriculum) {
    $clase_fa1 = "fa fa-check";
    $stepStates[0] = 'completed';
} else {
    $clase_fa1 = "fa fa-clock";
    $stepStates[0] = 'pending';
}

// Paso 2: Entrevista
if(auth()->user()->rol=='Reclutamiento'){
    if ($procesoinfo->entrevista2_fecha) {
        $clase_fa2 = "fa fa-check";
        $stepStates[1] = 'completed';
    } else {
        $clase_fa2 = "fa fa-clock";
        $stepStates[1] = 'pending';
    }
} elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura'){
    if ($procesoinfo->entrevista2_fecha) {
        $clase_fa2 = "fa fa-check";
        $stepStates[1] = 'completed';
    } else {
        $clase_fa2 = "fa fa-clock";
        $stepStates[1] = 'pending';
    }
} elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina'){
    if ($procesoinfo->entrevista1_fecha) {
        $clase_fa2 = "fa fa-check";
        $stepStates[1] = 'completed';
    } else {
        $clase_fa2 = "fa fa-clock";
        $stepStates[1] = 'pending';
    }
}

// Paso 3: Evaluación/Estatus entrevista
if(auth()->user()->rol=='Reclutamiento'){
    if ($procesoinfo->estatus_entrevista) {
        $clase_fa3 = "fa fa-check";
        $stepStates[2] = 'completed';
    } else {
        $clase_fa3 = "fa fa-clock";
        $stepStates[2] = 'pending';
    }
} elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura'){
    if ($procesoinfo->estatus_entrevista) {
        $clase_fa3 = "fa fa-check";
        $stepStates[2] = 'completed';
    } else {
        $clase_fa3 = "fa fa-clock";
        $stepStates[2] = 'pending';
    }
} elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina'){
    if ($procesoinfo->estatus_entrevista) {
        $clase_fa3 = "fa fa-check";
        $stepStates[2] = 'completed';
    } else {
        $clase_fa3 = "fa fa-clock";
        $stepStates[2] = 'pending';
    }
}

// Lógica para los pasos restantes
if ($procesoinfo->estatus_entrevista=='aprobado') {
    // Paso 4: Referencias
    if ($procesoinfo->referencia_nombre2 && $procesoinfo->referencia_telefono2) {
        $clase_fa4 = "fa fa-check";
        $stepStates[3] = 'completed';
    } else {
        $clase_fa4 = "fa fa-clock";
        $stepStates[3] = 'pending';
    }

    // Paso 5: Examen
    if ($procesoinfo->examen) {
        $clase_fa5 = "fa fa-check";
        $stepStates[4] = 'completed';
    } else {
        $clase_fa5 = "fa fa-clock";
        $stepStates[4] = 'pending';
    }

    // Paso 6: Documentos
    if ($procesoinfo->estatus_documento1=='Aprobado' && $procesoinfo->estatus_documento2=='Aprobado' && $procesoinfo->estatus_documento3=='Aprobado' && $procesoinfo->estatus_documento4=='Aprobado' && $procesoinfo->estatus_documento5=='Aprobado') {
        $clase_fa6 = "fa fa-check";
        $stepStates[5] = 'completed';
    } else {
        $clase_fa6 = "fa fa-clock";
        $stepStates[5] = 'pending';
    }

    $clase_fa7 = "fa fa-clock";
    $stepStates[6] = 'pending';
} else {
    $clase_fa4 = "fa fa-lock";
    $clase_fa5 = "fa fa-lock";
    $clase_fa6 = "fa fa-lock";
    $clase_fa7 = "fa fa-lock";
    $stepStates[3] = 'locked';
    $stepStates[4] = 'locked';
    $stepStates[5] = 'locked';
    $stepStates[6] = 'locked';
}

// Paso 7: Nómina (verificar al final)
if ($procesoinfo->fecha_nomina!="") {
    $clase_fa7 = "fa fa-check";
    $stepStates[6] = 'completed';
}

// Determinar paso activo
$currentStep = 0;
foreach($stepStates as $index => $state) {
    if ($state == 'pending') {
        $currentStep = $index;
        break;
    }
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <a href="/vacantes" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200 mb-6">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Regresar</span>
            </a>
        </div>

        <!-- Información del jefe directo -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <p class="text-gray-700">
                <span class="font-semibold">Jefe directo:</span>
                {{ qcolab($vacante->jefe) ?: 'No disponible' }}
            </p>
        </div>

        <!-- Información de la vacante -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Proceso Vacante</h1>
                    <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                        <span><strong>Área:</strong> {{$vacante->area}}</span>
                        <span><strong>Puesto:</strong> {{ catalogopuesto($vacante->puesto_id) }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Cantidad: {{  $vacante->completadas.' / '.$vacante->solicitadas }}
                        </span>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    @if(buscarperfildePuesto($vacante->puesto_id))
                        <button type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Ver perfil del puesto
                        </button>
                    @else
                        <span class="text-sm text-gray-500">No hay perfil de puesto para mostrar</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botón agregar candidato -->
        @if(auth()->user()->rol=='Reclutamiento' && $vacante->completadas<$vacante->solicitadas)
        <div class="flex justify-end mb-6">
            <button type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleAltaCandidato"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Agregar candidato
            </button>
        </div>
        @endif

        <!-- Sección de candidatos -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Estado de Candidatos</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Candidatos Aprobados -->
                <div class="space-y-4">
                    <button class="w-full flex items-center justify-between p-4 text-left bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors duration-200"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseAprobados"
                            aria-expanded="false"
                            aria-controls="collapseAprobados">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="font-medium text-green-800">Aprobados</span>
                        </div>
                        <i class="fas fa-chevron-down text-green-600"></i>
                    </button>

                    <div class="collapse" id="collapseAprobados">
                        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-2">
                            @foreach($procesos as $proc)
                                @if($proc->estatus=='Aprobado')
                                    <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                       class="block p-3 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200 border border-transparent hover:border-blue-200">
                                        <i class="fas fa-user mr-2"></i>
                                        {{ candidato($proc->candidato_id) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Candidatos En Proceso -->
                <div class="space-y-4">
                    <button class="w-full flex items-center justify-between p-4 text-left bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapsePendientes"
                            aria-expanded="false"
                            aria-controls="collapsePendientes">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="font-medium text-blue-800">En proceso</span>
                        </div>
                        <i class="fas fa-chevron-down text-blue-600"></i>
                    </button>

                    <div class="collapse" id="collapsePendientes">
                        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-2">
                            @foreach($procesos as $proc)
                                @if($proc->estatus=='Pendiente')
                                    <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                       class="block p-3 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200 border border-transparent hover:border-blue-200">
                                        <i class="fas fa-user-clock mr-2"></i>
                                        {{ candidato($proc->candidato_id) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Candidatos Rechazados -->
                <div class="space-y-4">
                    <button class="w-full flex items-center justify-between p-4 text-left bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors duration-200"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseRechazados"
                            aria-expanded="false"
                            aria-controls="collapseRechazados">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                            <span class="font-medium text-red-800">Rechazados</span>
                        </div>
                        <i class="fas fa-chevron-down text-red-600"></i>
                    </button>

                    <div class="collapse" id="collapseRechazados">
                        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-2">
                            @foreach($procesos as $proc)
                                @if($proc->estatus=='Rechazado')
                                    <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                       class="block p-3 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200 border border-transparent hover:border-blue-200">
                                        <i class="fas fa-user-times mr-2"></i>
                                        {{ candidato($proc->candidato_id) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Wizards según el rol -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @if(auth()->user()->reclutamiento=='1')
                @include('vacantes.wizard_reclutamiento')
            @elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura')
                @if($vacante->jefe==auth()->user()->colaborador_id)
                    @include('vacantes.wizard_nomina_all')
                @else
                    @include('vacantes.wizard_nomina')
                @endif
            @elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina')
                @include('vacantes.wizard_jefatura')
            @endif
        </div>

        <!-- Motivos de rechazo -->
        @if(count($motivos)>0)
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Motivos de Rechazo</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Motivo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($motivos as $motivo)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $motivo->motivo }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Función PHP para convertir estrellas -->
<?php
function convertirEstrellas($numEstrellas)
{
    $htmlEstrellas = '';
    for ($i = 1; $i <= $numEstrellas; $i++) {
        $htmlEstrellas .= '<span class="estrella">&#9733;</span>';
    }
    return $htmlEstrellas;
}
?>

@include('vacantes.modals')

@endsection

@push('js')

<?php
// Inicializar la variable $current si no existe
if (!isset($current)) {
    $current = 0;
}

// Ajuste del current según el rol
if (auth()->user()->rol=='Nómina' ) {
    if($current<=2){
        $current=0;
    }else {
        $current=$current-2;
    }
}
?>

<script type="text/javascript">
// Solución para errores de JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que las variables existan antes de usarlas
    var current = {{ $current ?? 0 }};

    // Función para verificar si existe un elemento
    function elementExists(selector) {
        return document.querySelector(selector) !== null;
    }

    // Función mejorada para inicializar tabs solo si existen
    function initializeTabs() {
        var tabs = document.querySelectorAll(".tab");
        var tabs_pill = document.querySelectorAll(".tab-pills");

        if (tabs.length > 0 && tabs_pill.length > 0) {
            loadFormData(current);
        }
    }

    function loadFormData(n) {
        var tabs = document.querySelectorAll(".tab");
        var tabs_pill = document.querySelectorAll(".tab-pills");

        if (tabs.length === 0 || tabs_pill.length === 0) {
            console.warn('Elementos .tab o .tab-pills no encontrados');
            return;
        }

        // Remover clase active de todos los pills
        tabs_pill.forEach(function(pill) {
            pill.classList.remove("active");
        });

        // Agregar clase active al pill actual
        if (tabs_pill[n]) {
            tabs_pill[n].classList.add("active");
        }

        // Ocultar todos los tabs
        tabs.forEach(function(tab) {
            tab.classList.add("d-none");
        });

        // Mostrar tab actual
        if (tabs[n]) {
            tabs[n].classList.remove("d-none");
        }

        // Manejar botones de navegación
        var backButton = document.getElementById("back_button");
        var nextButton = document.getElementById("next_button");

        if (backButton) {
            backButton.disabled = (n === 0);
        }

        if (nextButton) {
            if (n === tabs.length - 1) {
                nextButton.textContent = "Programar alta";
                nextButton.removeAttribute("onclick");
            } else {
                nextButton.setAttribute("type", "button");
                nextButton.textContent = "Siguiente";
                nextButton.setAttribute("onclick", "next()");
            }
        }
    }

    // Funciones globales para navegación
    window.next = function() {
        var tabs = document.querySelectorAll(".tab");
        if (current < tabs.length - 1) {
            if (tabs[current]) {
                tabs[current].classList.add("d-none");
            }
            current++;
            loadFormData(current);
        }
    };

    window.back = function() {
        if (current > 0) {
            var tabs = document.querySelectorAll(".tab");
            if (tabs[current]) {
                tabs[current].classList.add("d-none");
            }
            current--;
            loadFormData(current);
        }
    };

    // Event listeners para tabs con verificación de existencia
    if (elementExists(".tab-pills")) {
        document.querySelectorAll(".tab-pills").forEach(function(pill, index) {
            pill.addEventListener('click', function() {
                current = index;
                loadFormData(current);
            });
        });
    }

    // Inicializar tabs
    initializeTabs();

    // Manejo mejorado de formularios de rating con verificación
    var ratingForm = document.getElementById('ratingForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(event) {
            let isValid = true;
            let mensajes = [];

            var questions = document.querySelectorAll('.question');
            if (questions.length > 0) {
                questions.forEach(function(question) {
                    let pregunta = question.querySelector('p');
                    if (pregunta && pregunta.innerHTML.includes('<span class="text-danger">*</span>')) {
                        let input = question.querySelector('input[name="valoracion[]"]');
                        if (input && input.value == "0") {
                            isValid = false;
                            mensajes.push(pregunta.textContent.replace('*', '').trim());
                        }
                    }
                });
            }

            if (!isValid) {
                event.preventDefault();
                alert('Debes calificar las siguientes preguntas antes de continuar:\n\n' + mensajes.join('\n'));
            }
        });
    }

    // Manejo de estrellas de rating con verificación
    var stars = document.querySelectorAll('.star');
    if (stars.length > 0) {
        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                var rating = this.getAttribute('data-rating');
                var container = this.closest('.star-rating');
                if (container) {
                    var starElements = container.querySelectorAll('.star');

                    starElements.forEach(function(s, index) {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                }
            });
        });
    }

    // Manejo de opciones de rating con verificación
    var ratingOptions = document.querySelectorAll('.rating-option');
    if (ratingOptions.length > 0) {
        ratingOptions.forEach(function(option) {
            option.addEventListener('click', function() {
                var container = this.closest('.rating-options');
                if (container) {
                    container.querySelectorAll('.rating-option').forEach(function(opt) {
                        opt.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });
    }

    // Manejo de errores de archivos PDF no encontrados
    function handlePDFError() {
        var pdfElements = document.querySelectorAll('embed[src*=".pdf"], iframe[src*=".pdf"], object[data*=".pdf"]');

        if (pdfElements.length > 0) {
            pdfElements.forEach(function(element) {
                element.addEventListener('error', function() {
                    console.warn('PDF no encontrado:', this.src || this.data);

                    // Crear mensaje de error personalizado
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-yellow-800';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>El archivo PDF no está disponible en este momento.';

                    // Reemplazar el elemento con el mensaje de error
                    if (this.parentNode) {
                        this.parentNode.replaceChild(errorDiv, this);
                    }
                });
            });
        }
    }

    // Ejecutar manejo de errores PDF
    handlePDFError();


});

// Función auxiliar para debugging
// function debugInfo() {
//     console.log('Current step:', current);
//     console.log('Available tabs:', document.querySelectorAll('.tab').length);
//     console.log('Available tab pills:', document.querySelectorAll('.tab-pills').length);
//     console.log('Rating form exists:', !!document.getElementById('ratingForm'));
// }

// Hacer disponible para debugging en consola
window.debugInfo = debugInfo;
</script>

@endpush
