<section class="mt-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Card Principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

      <!-- Header del Card -->
      <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
        <div class="flex flex-col space-y-4">

          <!-- Botón de Rechazar Candidato -->
          @if($procesoinfo->estatus_proceso!='Rechazado')
          <div class="flex justify-end">
            <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                    data-bs-toggle="collapse"
                    data-bs-target="#rechazarCandidatoForm"
                    aria-expanded="false"
                    aria-controls="rechazarCandidatoForm">
              <i class="fas fa-user-times mr-2"></i>
              Rechazar candidato
            </button>

            <!-- Formulario de Rechazo Colapsable -->
            <div class="collapse" id="rechazarCandidatoForm">
              <div class="mt-4 p-6 bg-white border border-red-200 rounded-lg shadow-sm">
                <form onkeydown="return event.key != 'Enter';" action="{{ route('rechazar_candidato') }}" method="post" class="space-y-4">
                    @csrf
                    <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                    <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                    <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                    <input type="hidden" name="estatus" value="Rechazado">

                    <h4 class="text-lg font-semibold text-gray-800 mb-4">¿QUÉ TE PARECIÓ EL PERFIL DEL CANDIDATO?</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Tomó otra oportunidad laboral"
                                   id="radio_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-briefcase text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Tomó otra oportunidad laboral</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Dejó de contestar"
                                   id="radio_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-phone-slash text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Dejó de contestar</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Referencias no convincentes"
                                   id="radio_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-users text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Referencias no convincentes</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Exámen Psicométrico no aprobado"
                                   id="radio_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-brain text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Exámen Psicométrico no aprobado</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Buró laboral no aprobado"
                                   id="radio_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-clipboard-list text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Buró laboral no aprobado</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Semanas cotizadas no coinciden"
                                   id="radio_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Semanas cotizadas no coinciden</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_7_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Documentación dudosa o incompleta"
                                   id="radio_option_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-file-times text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Documentación dudosa o incompleta</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_8_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="No se presentó"
                                   id="radio_option_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-user-clock text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">No se presentó</span>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200"
                               onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                               id="label_option_9_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                            <input type="checkbox" name="motivorechazo[]" value="Candidato prefirió no seguir con el proceso"
                                   id="radio_option_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                            <div class="flex items-center">
                                <i class="fas fa-hand-paper text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Candidato prefirió no seguir con el proceso</span>
                            </div>
                        </label>
                    </div>

                    <div class="flex justify-center pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-times mr-2"></i>
                            Confirmar rechazar candidato
                        </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
          @endif

          <!-- Información del Candidato -->
          <div class="text-center space-y-2">
            @if($procesoinfo->estatus_proceso=='Rechazado')
              <h3 class="text-2xl font-bold text-red-600 line-through">{{ candidato($candidato) }}</h3>
            @elseif($procesoinfo->estatus_proceso=='Aprobado')
              <h3 class="text-2xl font-bold text-green-600">{{ candidato($candidato) }}</h3>
            @else
              <h3 class="text-2xl font-bold text-gray-800">{{ candidato($candidato) }}</h3>
            @endif

            @if($infodelcandidato->comentarios)
              <p class="text-gray-600 italic">{{ $infodelcandidato->comentarios }}</p>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-gray-500">
              <span><strong>Fuente:</strong> {{ $infodelcandidato->fuente }}</span>
              <span><strong>Última actualización:</strong> {{ $procesoinfo->updated_at ?? '' }}</span>
            </div>

            <input type="hidden" id="tipo" value="{{ $tipo }}">
          </div>
        </div>

        <!-- Progress Stepper -->
        <div class="mt-8 p-6 bg-white rounded-lg shadow-sm">
          <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">Progreso del Proceso</h3>

          <!-- Stepper horizontal con círculos conectados -->
          <div class="flex items-center justify-between relative max-w-5xl mx-auto stepper-responsive">
            <?php
            $steps = [
              ['key' => 'curriculum', 'label' => 'Curriculum', 'icon' => 'fa-file-alt'],
              ['key' => 'entrevista', 'label' => 'Entrevista', 'icon' => 'fa-comments'],
              ['key' => 'evaluacion', 'label' => 'Evaluación', 'icon' => 'fa-star'],
              ['key' => 'referencias', 'label' => 'Referencias', 'icon' => 'fa-users'],
              ['key' => 'examen', 'label' => 'Examen', 'icon' => 'fa-clipboard-check'],
              ['key' => 'documentos', 'label' => 'Documentos', 'icon' => 'fa-folder'],
              ['key' => 'nomina', 'label' => 'Nómina', 'icon' => 'fa-check-circle']
            ];

            // Determinar estado de cada paso basado en las variables originales
            $stepStates = [];
            $stepStates[0] = strpos($clase_fa1, 'check') !== false ? 'completed' : 'pending';
            $stepStates[1] = strpos($clase_fa2, 'check') !== false ? 'completed' : (strpos($clase_fa2, 'lock') !== false ? 'locked' : 'pending');
            $stepStates[2] = strpos($clase_fa3, 'check') !== false ? 'completed' : (strpos($clase_fa3, 'lock') !== false ? 'locked' : 'pending');
            $stepStates[3] = strpos($clase_fa4, 'check') !== false ? 'completed' : (strpos($clase_fa4, 'lock') !== false ? 'locked' : 'pending');
            $stepStates[4] = strpos($clase_fa5, 'check') !== false ? 'completed' : (strpos($clase_fa5, 'lock') !== false ? 'locked' : 'pending');
            $stepStates[5] = strpos($clase_fa6, 'check') !== false ? 'completed' : (strpos($clase_fa6, 'lock') !== false ? 'locked' : 'pending');
            $stepStates[6] = strpos($clase_fa7, 'check') !== false ? 'completed' : (strpos($clase_fa7, 'lock') !== false ? 'locked' : 'pending');
            ?>

            @foreach($steps as $index => $step)
              <div class="flex flex-col items-center relative z-10">
                <!-- Círculo del paso -->
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg transition-all duration-300
                    @if($stepStates[$index] == 'completed')
                        bg-blue-600
                    @elseif($stepStates[$index] == 'pending')
                        bg-blue-500 ring-4 ring-blue-200
                    @else
                        bg-gray-300
                    @endif">

                    @if($stepStates[$index] == 'completed')
                        <i class="fas fa-check text-lg"></i>
                    @elseif($stepStates[$index] == 'locked')
                        <i class="fas fa-lock text-sm"></i>
                    @else
                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                    @endif
                </div>

                <!-- Label del paso -->
                <div class="mt-3 text-xs font-medium text-center max-w-20
                    @if($stepStates[$index] == 'completed')
                        text-blue-700 font-semibold
                    @elseif($stepStates[$index] == 'pending')
                        text-blue-600 font-bold
                    @else
                        text-gray-400
                    @endif">
                    {{ $step['label'] }}
                </div>
              </div>

              <!-- Línea conectora -->
              @if($index < count($steps) - 1)
                <div class="flex-1 h-1 mx-4 rounded-full
                    @if($stepStates[$index] == 'completed')
                        bg-blue-600
                    @else
                        bg-gray-300
                    @endif">
                </div>
              @endif
            @endforeach
          </div>

          <!-- Progress Bar -->
          <div class="mt-6">
            <?php
            $completedSteps = count(array_filter($stepStates, function($state) { return $state == 'completed'; }));
            $progressPercentage = ($completedSteps / count($steps)) * 100;
            ?>
            <div class="w-full bg-gray-200 rounded-full h-2 max-w-5xl mx-auto">
              <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
            </div>
            <p class="text-center text-sm text-gray-600 mt-2">
              {{ $completedSteps }} de {{ count($steps) }} pasos completados ({{ round($progressPercentage) }}%)
            </p>
          </div>
        </div>

        <!-- Navigation Pills -->
        <nav class="mt-6">
          <div class="flex flex-wrap justify-center gap-2">
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa1 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Curriculum</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa2 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Programar<br>Entrevista</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa3 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Resultado<br>Entrevista</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa4 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Referencias</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa5 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Exámen<br>psicométrico</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa6 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Documentación</span>
            </a>
            <a class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer">
              <span class="text-lg mb-1"><i class="{{ $clase_fa7 }}" aria-hidden="true"></i></span>
              <span class="text-xs font-medium">Alta candidato</span>
            </a>
          </div>
        </nav>
      </div>

      <!-- Contenido del Card -->
      <div class="p-6">

        <!-- Tab 1: Curriculum -->
        <div class="tab hidden">
          @if($procesoinfo->curriculum)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

              <!-- Panel de Calificaciones -->
              <div class="lg:col-span-1 space-y-6">
                @if ($datosPreguntasAvg->isNotEmpty())
                  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Promedio: {{ number_format($promedio,2) }}</h3>

                    @foreach ($datosPreguntasAvg as $pregunta)
                      <div class="mb-4">
                        <div class="flex items-center justify-between">
                          <p class="text-sm font-medium text-gray-700">{{ $pregunta->pregunta }}:</p>
                          <div class="flex">
                            @for ($i = 1; $i <= $pregunta->valoracion; $i++)
                              <i class="fas fa-star text-yellow-400 text-sm"></i>
                            @endfor
                          </div>
                        </div>
                      </div>
                    @endforeach

                    <button class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                            data-bs-toggle="collapse"
                            href="#collapseExample"
                            role="button"
                            aria-expanded="false"
                            aria-controls="collapseExample">
                      <i class="fas fa-edit mr-2"></i>
                      Cambiar respuestas
                    </button>

                    <div class="collapse mt-4" id="collapseExample">
                      <!-- Formulario de calificación existente aquí -->
                    </div>
                  </div>
                @else
                  <!-- Formulario inicial de calificación -->
                  <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Calificar Curriculum</h4>
                    <form id="ratingForm" action="{{ route('calificar') }}" method="post" class="space-y-4">
                      @csrf
                      <!-- Preguntas de calificación con estrellas -->
                      <!-- [Contenido del formulario original aquí] -->
                    </form>
                  </div>
                @endif
              </div>

              <!-- Visor de PDF -->
              <div class="lg:col-span-2">
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                  <iframe src="/storage/app/public/{{ $procesoinfo->curriculum }}#zoom=100&navpanes=0&view=FitH"
                          class="w-full h-96 lg:h-[600px] border-0"
                          title="Curriculum del candidato">
                  </iframe>
                </div>
              </div>
            </div>
          @else
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-8 rounded-lg text-center">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full mb-4">
                <i class="fas fa-lock text-2xl text-gray-400"></i>
              </div>
              <p class="text-gray-600 font-medium">Contenido no disponible</p>
            </div>
          @endif
        </div>

        <!-- Tab 2: Programar Entrevista -->
        <div class="tab hidden">
          @if($procesoinfo->curriculum)
            <!-- Contenido de programar entrevista -->
          @else
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-8 rounded-lg text-center">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full mb-4">
                <i class="fas fa-lock text-2xl text-gray-400"></i>
              </div>
              <p class="text-gray-600 font-medium">Contenido no disponible</p>
            </div>
          @endif
        </div>

        <!-- Otros tabs seguirían el mismo patrón... -->

      </div>

      <!-- Footer del Card -->
      <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex justify-center space-x-4">
          <button type="button"
                  id="back_button"
                  class="hidden px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                  onclick="back()">
            <i class="fas fa-arrow-left mr-2"></i>
            Anterior
          </button>

          <button type="button"
                  id="next_button"
                  class="hidden px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                  onclick="next()">
            Siguiente
            <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Estilos adicionales -->
<style>
/* Efectos para las opciones de rechazo */
.rating-option.active {
  @apply bg-red-100 border-red-400 shadow-md;
}

/* Estilos para las estrellas */
.star {
  @apply text-2xl text-gray-300 cursor-pointer transition-colors duration-200;
}

.star:hover,
.star.active {
  @apply text-yellow-400;
}

/* Responsive stepper para móviles */
@media (max-width: 768px) {
  .stepper-responsive {
    flex-direction: column;
    align-items: flex-start;
    space-y: 4;
  }

  .stepper-responsive .flex-1 {
    width: 2px;
    height: 2rem;
    margin: 0.5rem 0;
    margin-left: 1.5rem;
  }

  .stepper-responsive > div:not(.flex-1) {
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

/* Tab navigation active state */
.tab-pills.active {
  @apply bg-blue-500 text-white border-blue-500;
}

/* Efectos hover para los tabs */
.tab-pills:hover {
  @apply shadow-md transform scale-105;
}
</style>

<!-- Scripts JavaScript mejorados -->
<script type="text/javascript">
// Variables globales
let current = {{ $current ?? 0 }};
let tabs = [];
let tabs_pill = [];

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar elementos
    tabs = document.querySelectorAll(".tab");
    tabs_pill = document.querySelectorAll(".tab-pills");

    // Cargar datos del formulario inicial
    if (tabs.length > 0 && tabs_pill.length > 0) {
        loadFormData(current);
    }

    // Event listeners para navegación de tabs
    tabs_pill.forEach((pill, index) => {
        pill.addEventListener('click', function() {
            current = index;
            loadFormData(current);
        });
    });

    // Inicializar sistema de calificación con estrellas
    initializeStarRating();

    // Inicializar validaciones de formularios
    initializeFormValidations();

    // Inicializar funcionalidad de selección de horas
    initializeTimeSelectors();
});

// Función para cargar datos del formulario
function loadFormData(n) {
    if (tabs.length === 0 || tabs_pill.length === 0) {
        console.warn('Elementos .tab o .tab-pills no encontrados');
        return;
    }

    // Remover clases activas
    tabs_pill.forEach(pill => pill.classList.remove("active"));
    tabs.forEach(tab => tab.classList.add("hidden"));

    // Activar tab actual
    if (tabs_pill[n]) {
        tabs_pill[n].classList.add("active");
    }
    if (tabs[n]) {
        tabs[n].classList.remove("hidden");
    }

    // Actualizar botones de navegación
    updateNavigationButtons(n);
}

// Función para actualizar botones de navegación
function updateNavigationButtons(n) {
    const backButton = document.getElementById("back_button");
    const nextButton = document.getElementById("next_button");

    if (backButton) {
        backButton.style.display = n === 0 ? "none" : "inline-flex";
        backButton.disabled = n === 0;
    }

    if (nextButton) {
        nextButton.style.display = "inline-flex";
        if (n === tabs.length - 1) {
            nextButton.innerHTML = '<i class="fas fa-check mr-2"></i>Finalizar';
            nextButton.removeAttribute("onclick");
        } else {
            nextButton.innerHTML = 'Siguiente<i class="fas fa-arrow-right ml-2"></i>';
            nextButton.setAttribute("onclick", "next()");
        }
    }
}

// Funciones de navegación
function next() {
    if (current < tabs.length - 1) {
        tabs[current].classList.add("hidden");
        current++;
        loadFormData(current);
    }
}

function back() {
    if (current > 0) {
        tabs[current].classList.add("hidden");
        current--;
        loadFormData(current);
    }
}

// Sistema de calificación con estrellas
function initializeStarRating() {
    const starContainers = document.querySelectorAll('.stars');

    starContainers.forEach(container => {
        const ratingId = container.id;
        const hiddenInput = document.getElementById(ratingId.replace('Stars', 'Rating'));

        // Crear estrellas
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('i');
            star.className = 'fas fa-star star';
            star.dataset.rating = i;

            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                if (hiddenInput) {
                    hiddenInput.value = rating;
                }

                // Actualizar visualización de estrellas
                const stars = container.querySelectorAll('.star');
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('active');
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                const stars = container.querySelectorAll('.star');
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });

            container.appendChild(star);
        }

        // Reset en mouseleave
        container.addEventListener('mouseleave', function() {
            const currentRating = hiddenInput ? hiddenInput.value : 0;
            const stars = container.querySelectorAll('.star');
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.classList.add('active', 'text-yellow-400');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('active', 'text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
}

// Validaciones de formularios
function initializeFormValidations() {
    // Validación del formulario de curriculum
    const ratingForm = document.getElementById('ratingForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(event) {
            const requiredRatings = ['expRating', 'techSkillsRating', 'demographicRating', 'jobStabilityRating'];
            let valid = true;
            let mensajes = [];

            requiredRatings.forEach(function(ratingId) {
                const rating = document.getElementById(ratingId);
                if (rating && rating.value === '0') {
                    valid = false;
                    const question = rating.closest('.question');
                    if (question) {
                        const label = question.querySelector('p');
                        if (label) {
                            mensajes.push(label.textContent.replace('*', '').trim());
                        }
                        question.classList.add('border-red-300', 'bg-red-50');
                        setTimeout(() => {
                            question.classList.remove('border-red-300', 'bg-red-50');
                        }, 3000);
                    }
                }
            });

            if (!valid) {
                event.preventDefault();
                showErrorMessage('Por favor, complete todas las calificaciones requeridas:\n' + mensajes.join('\n'));
            }
        });
    }

    // Validación del formulario de entrevista
    const ratingForm2 = document.getElementById('ratingForm2');
    if (ratingForm2) {
        ratingForm2.addEventListener('submit', function(event) {
            const requiredRatings = ['idoneidadRating', 'desempenoRating', 'exp2Rating', 'techSkills2Rating', 'location2Rating'];
            let valid = true;

            requiredRatings.forEach(function(ratingId) {
                const rating = document.getElementById(ratingId);
                if (rating && rating.value === '0') {
                    valid = false;
                    showErrorMessage('Por favor, complete todas las calificaciones requeridas.');
                    rating.closest('.question').classList.add('border-red-300', 'bg-red-50');
                }
            });

            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // Botones de aprobar/rechazar en entrevista
    const approveButton = document.getElementById('approveButton');
    const rejectButton = document.getElementById('rejectButton');
    const actionTypeInput = document.getElementById('actionType');
    const hiddenSubmit = document.getElementById('hiddenSubmit');

    if (approveButton && actionTypeInput && hiddenSubmit) {
        approveButton.addEventListener('click', function() {
            actionTypeInput.value = 'approve';
            hiddenSubmit.click();
        });
    }

    if (rejectButton && actionTypeInput && hiddenSubmit) {
        rejectButton.addEventListener('click', function() {
            actionTypeInput.value = 'reject';
            hiddenSubmit.click();
        });
    }
}

// Función para mostrar mensajes de error
function showErrorMessage(message) {
    const errorElement = document.getElementById('mensajedeerror');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('text-red-600', 'font-medium', 'p-3', 'bg-red-50', 'border', 'border-red-200', 'rounded-lg');

        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            errorElement.textContent = '';
            errorElement.className = '';
        }, 5000);
    } else {
        // Fallback a alert si no existe el elemento
        alert(message);
    }
}

// Inicializar selectores de tiempo
function initializeTimeSelectors() {
    // Función para actualizar horas finales basadas en hora inicial
    function actualizarHorasFinales(selectInicio, selectFin) {
        selectInicio.addEventListener("change", function() {
            let horaInicio = this.value;
            let opcionesFin = selectFin.querySelectorAll("option");

            opcionesFin.forEach(opcion => {
                if (opcion.value <= horaInicio) {
                    opcion.hidden = true;
                } else {
                    opcion.hidden = false;
                }
            });

            // Seleccionar automáticamente la primera opción válida
            let primeraOpcionValida = selectFin.querySelector("option:not([hidden])");
            if (primeraOpcionValida) {
                selectFin.value = primeraOpcionValida.value;
            }
        });
    }

    // Aplicar a todos los selectores de hora
    const selectsInicio = document.querySelectorAll("select[name='desde[]']");
    const selectsFin = document.querySelectorAll("select[name='hasta[]']");

    selectsInicio.forEach((select, index) => {
        if (selectsFin[index]) {
            actualizarHorasFinales(select, selectsFin[index]);
        }
    });

    // Selectores con clases específicas
    const selectsInicioEdit = document.querySelectorAll("select.horaseditar1, select.horaseditar3");
    const selectsFinEdit = document.querySelectorAll("select.horaseditar2, select.horaseditar3");

    selectsInicioEdit.forEach((select, index) => {
        if (selectsFinEdit[index]) {
            actualizarHorasFinales(select, selectsFinEdit[index]);
        }
    });
}

// Función para manejar opciones de rechazo
function radioOption(labelId, groupClass) {
    // Remover active de todas las opciones del grupo
    const allOptions = document.querySelectorAll('.' + groupClass);
    allOptions.forEach(option => {
        option.classList.remove('active');
        option.classList.remove('bg-red-100', 'border-red-400', 'shadow-md');
        option.classList.add('border-gray-200');
    });

    // Activar la opción seleccionada
    const selectedLabel = document.getElementById(labelId);
    if (selectedLabel) {
        selectedLabel.classList.add('active');
        selectedLabel.classList.add('bg-red-100', 'border-red-400', 'shadow-md');
        selectedLabel.classList.remove('border-gray-200');

        // Marcar el checkbox correspondiente
        const checkbox = selectedLabel.querySelector('input[type="checkbox"]');
        if (checkbox) {
            // Desmarcar todos los checkboxes del grupo primero
            allOptions.forEach(option => {
                const cb = option.querySelector('input[type="checkbox"]');
                if (cb) cb.checked = false;
            });

            // Marcar el seleccionado
            checkbox.checked = true;
        }
    }
}

// Función para actualizar el progreso visual del stepper
function updateStepperProgress() {
    // Esta función se puede llamar cuando cambie el estado de un paso
    console.log('Actualizando progreso del stepper...');
}

// Manejo de eventos del teclado
document.addEventListener('keydown', function(event) {
    // Prevenir envío con Enter en formularios específicos
    const form = event.target.closest('form');
    if (form && form.hasAttribute('onkeydown')) {
        if (event.key === 'Enter' && event.target.tagName !== 'TEXTAREA' && event.target.tagName !== 'BUTTON') {
            event.preventDefault();
        }
    }

    // Navegación con flechas del teclado
    if (event.key === 'ArrowRight' && event.ctrlKey) {
        event.preventDefault();
        next();
    } else if (event.key === 'ArrowLeft' && event.ctrlKey) {
        event.preventDefault();
        back();
    }
});

// Función de debug para desarrollo
function debugWizard() {
    console.log('=== Debug del Wizard ===');
    console.log('Current step:', current);
    console.log('Total tabs:', tabs.length);
    console.log('Total tab pills:', tabs_pill.length);
    console.log('Active tab:', tabs[current]);
    console.log('Active pill:', tabs_pill[current]);
}

// Hacer disponible la función de debug globalmente
window.debugWizard = debugWizard;

// Log de inicialización
console.log('Sistema de wizard con Tailwind CSS inicializado correctamente');
</script>

<!-- Scripts adicionales para funcionalidades específicas -->
<script type="text/javascript">
// Script específico para manejo de formularios de calificación con validación mejorada
document.addEventListener('DOMContentLoaded', function() {

    // Función para manejar el envío de formularios de calificación
    function handleRatingFormSubmit(formId, requiredFields, errorElementId) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function(event) {
            let isValid = true;
            let missingFields = [];

            requiredFields.forEach(function(fieldId) {
                const field = document.getElementById(fieldId);
                if (field && field.value === '0') {
                    isValid = false;
                    const question = field.closest('.question');
                    if (question) {
                        const label = question.querySelector('p');
                        if (label) {
                            missingFields.push(label.textContent.replace('*', '').trim());
                        }

                        // Añadir efectos visuales de error
                        question.classList.add('border-2', 'border-red-300', 'bg-red-50', 'rounded-lg', 'p-2');

                        // Remover efectos después de 3 segundos
                        setTimeout(() => {
                            question.classList.remove('border-2', 'border-red-300', 'bg-red-50', 'rounded-lg', 'p-2');
                        }, 3000);
                    }
                }
            });

            if (!isValid) {
                event.preventDefault();

                // Mostrar mensaje de error
                const errorElement = document.getElementById(errorElementId);
                if (errorElement) {
                    errorElement.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                <span class="text-red-700 font-medium">Por favor, complete las siguientes calificaciones:</span>
                            </div>
                            <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                                ${missingFields.map(field => `<li>${field}</li>`).join('')}
                            </ul>
                        </div>
                    `;

                    // Scroll al mensaje de error
                    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    // Fallback a alert
                    alert('Por favor, complete todas las calificaciones requeridas:\n' + missingFields.join('\n'));
                }
            }
        });
    }

    // Configurar validaciones para diferentes formularios
    handleRatingFormSubmit('ratingForm',
        ['expRating', 'techSkillsRating', 'demographicRating', 'jobStabilityRating'],
        'mensajedeerror'
    );

    handleRatingFormSubmit('ratingForm2',
        ['idoneidadRating', 'desempenoRating', 'exp2Rating', 'techSkills2Rating', 'location2Rating'],
        'mensajedeerror'
    );

    handleRatingFormSubmit('ratingForm3',
        ['idoneidadRating', 'desempenoRating', 'exp2Rating', 'techSkills2Rating', 'location2Rating'],
        'mensajedeerror'
    );
});

// Función para mejorar la experiencia del usuario con animaciones
function addSmoothTransitions() {
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.style.transition = 'all 0.3s ease-in-out';
    });

    const tabPills = document.querySelectorAll('.tab-pills');
    tabPills.forEach(pill => {
        pill.style.transition = 'all 0.2s ease-in-out';
    });
}

// Aplicar transiciones suaves
document.addEventListener('DOMContentLoaded', addSmoothTransitions);
</script>
