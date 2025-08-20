<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Card Principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <!-- Header del Card -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">

            <!-- Botón de Rechazar Candidato -->
            @if($procesoinfo->estatus_proceso!='Rechazado')
            <div class="flex justify-end mb-6">
                <button
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                    data-bs-toggle="collapse" data-bs-target="#rechazarCandidatoForm" aria-expanded="false"
                    aria-controls="rechazarCandidatoForm">
                    <i class="fas fa-user-times mr-2"></i>
                    Rechazar candidato
                </button>
            </div>

            <!-- Formulario de Rechazo Colapsable -->
            <div class="collapse" id="rechazarCandidatoForm">
                <div class="mb-6 p-6 bg-white border border-red-200 rounded-lg shadow-sm">
                    <form onkeydown="return event.key != 'Enter';" action="{{ route('rechazar_candidato') }}"
                        method="post" class="space-y-6">
                        @csrf
                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                        <input type="hidden" name="estatus" value="Rechazado">

                        <h4 class="text-lg font-semibold text-gray-800 mb-4">¿QUÉ TE PARECIÓ EL PERFIL DEL CANDIDATO?
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Tomó otra oportunidad laboral"
                                    id="radio_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-briefcase text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Tomó otra oportunidad laboral</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Dejó de contestar"
                                    id="radio_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-phone-slash text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Dejó de contestar</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Referencias no convincentes"
                                    id="radio_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Referencias no convincentes</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Exámen Psicométrico no aprobado"
                                    id="radio_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-brain text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Exámen Psicométrico no
                                        aprobado</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Buró laboral no aprobado"
                                    id="radio_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Buró laboral no aprobado</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Semanas cotizadas no coinciden"
                                    id="radio_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-times text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Semanas cotizadas no
                                        coinciden</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_7_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="Documentación dudosa o incompleta"
                                    id="radio_option_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-file-times text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Documentación dudosa o
                                        incompleta</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_8_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]" value="No se presentó"
                                    id="radio_option_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-user-clock text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">No se presentó</span>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200 rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}"
                                onclick="radioOption(this.id, 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                id="label_option_9_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                <input type="checkbox" name="motivorechazo[]"
                                    value="Candidato prefirió no seguir con el proceso"
                                    id="radio_option_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" class="hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-hand-paper text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Candidato prefirió no seguir con el
                                        proceso</span>
                                </div>
                            </label>
                        </div>

                        <div class="flex justify-center pt-4">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-times mr-2"></i>
                                Confirmar rechazar candidato
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Información del Candidato -->
            <div class="text-center space-y-4 mb-8">
                @if($procesoinfo->estatus_proceso=='Rechazado')
                <h3 class="text-3xl font-bold text-red-600 line-through">{{ candidato($candidato) }}</h3>
                @elseif($procesoinfo->estatus_proceso=='Aprobado')
                <h3 class="text-3xl font-bold text-green-600">{{ candidato($candidato) }}</h3>
                @else
                <h3 class="text-3xl font-bold text-gray-800">{{ candidato($candidato) }}</h3>
                @endif

                @if($infodelcandidato->comentarios)
                <p class="text-gray-600 italic text-lg">{{ $infodelcandidato->comentarios }}</p>
                @endif

                <div
                    class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-gray-500">
                    <span><strong>Fuente:</strong> {{ $infodelcandidato->fuente }}</span>
                </div>
            </div>

            <!-- Progress Stepper -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
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
                    @if($index < count($steps) - 1) <div class="flex-1 h-1 mx-4 rounded-full
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
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $progressPercentage }}%"></div>
                </div>
                <p class="text-center text-sm text-gray-600 mt-2">
                    {{ $completedSteps }} de {{ count($steps) }} pasos completados ({{ round($progressPercentage) }}%)
                </p>
            </div>
        </div>

        <!-- Navigation Pills -->
        <nav class="mt-6">
            <div class="flex flex-wrap justify-center gap-2">
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa1 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Curriculum</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa2 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Programar<br>Entrevista</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa3 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Resultado<br>Entrevista</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa4 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Referencias</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa5 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Exámen<br>psicométrico</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
                    <span class="text-lg mb-1"><i class="{{ $clase_fa6 }}" aria-hidden="true"></i></span>
                    <span class="text-xs font-medium">Documentación</span>
                </a>
                <a
                    class="tab-pills flex flex-col items-center p-3 text-center bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 cursor-pointer min-w-[120px]">
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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Panel de Calificaciones -->
                <div class="space-y-6">
                    <p class="text-red-600 font-medium" id="mensajedeerror"></p>

                    @if ($datosPreguntasAvg->isNotEmpty())
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Promedio: {{ number_format($promedio,2) }}
                        </h3>

                        @foreach ($datosPreguntasAvg as $pregunta)
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-700">
                                    {{ $pregunta->pregunta }}:
                                    @if($pregunta->pregunta != 'Ubicación geográfica')
                                    <span class="text-red-500">*</span>
                                    @endif
                                </p>
                                <div class="flex">
                                    @for ($i = 1; $i <= $pregunta->valoracion; $i++)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <button
                            class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                            data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar respuestas
                        </button>

                        <div class="collapse mt-4" id="collapseExample">
                            <form id="ratingForm" action="{{ route('calificar') }}" method="post"
                                onsubmit="return validarFormulario();" class="space-y-4">
                                @csrf

                                <!-- Preguntas de calificación -->
                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Experiencia adecuada <span
                                                class="text-red-500">*</span></p>
                                        <div class="stars" id="expStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                                        <input type="hidden" name="valoracion[]" id="expRating" value="0">
                                    </div>
                                </div>

                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Habilidades técnicas <span
                                                class="text-red-500">*</span></p>
                                        <div class="stars" id="techSkillsStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                                        <input type="hidden" name="valoracion[]" id="techSkillsRating" value="0">
                                    </div>
                                </div>

                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Perfil demográfico <span
                                                class="text-red-500">*</span></p>
                                        <div class="stars" id="demographicStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Perfil demográfico">
                                        <input type="hidden" name="valoracion[]" id="demographicRating" value="0">
                                    </div>
                                </div>

                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Ubicación geográfica</p>
                                        <div class="stars" id="locationStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                                        <input type="hidden" name="valoracion[]" id="locationRating" value="0">
                                    </div>
                                </div>

                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Escolaridad <span
                                                class="text-red-500">*</span></p>
                                        <div class="stars" id="educationStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Escolaridad">
                                        <input type="hidden" name="valoracion[]" id="educationRating" value="0">
                                    </div>
                                </div>

                                <div class="question p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-700">Estabilidad laboral <span
                                                class="text-red-500">*</span></p>
                                        <div class="stars" id="jobStabilityStars"></div>
                                        <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                                        <input type="hidden" name="valoracion[]" id="jobStabilityRating" value="0">
                                    </div>
                                </div>

                                <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                                <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                                <input type="hidden" name="etapa" value="Curriculum">
                                <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">

                                <div class="text-center">
                                    <p id="error-mensajes" class="text-red-600 mb-4 hidden"></p>
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-save mr-2"></i>
                                        Enviar calificaciones
                                    </button>
                                    <div id="aviso_faltantes"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else

                    <!-- Formulario inicial de calificación -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Calificar Curriculum</h4>
                        <form id="ratingForm" action="{{ route('calificar') }}" method="post" class="space-y-4">
                            @csrf

                            <!-- Preguntas de calificación -->
                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Experiencia adecuada <span
                                            class="text-red-500">*</span></p>
                                    <div class="stars" id="expStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                                    <input type="hidden" name="valoracion[]" id="expRating" value="0">
                                </div>
                            </div>

                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Habilidades técnicas <span
                                            class="text-red-500">*</span></p>
                                    <div class="stars" id="techSkillsStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                                    <input type="hidden" name="valoracion[]" id="techSkillsRating" value="0">
                                </div>
                            </div>

                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Perfil demográfico <span
                                            class="text-red-500">*</span></p>
                                    <div class="stars" id="demographicStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Perfil demográfico">
                                    <input type="hidden" name="valoracion[]" id="demographicRating" value="0">
                                </div>
                            </div>

                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Ubicación geográfica</p>
                                    <div class="stars" id="locationStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                                    <input type="hidden" name="valoracion[]" id="locationRating" value="0">
                                </div>
                            </div>

                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Escolaridad <span class="text-red-500">*</span>
                                    </p>
                                    <div class="stars" id="educationStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Escolaridad">
                                    <input type="hidden" name="valoracion[]" id="educationRating" value="0">
                                </div>
                            </div>

                            <div class="question p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-700">Estabilidad laboral <span
                                            class="text-red-500">*</span></p>
                                    <div class="stars" id="jobStabilityStars"></div>
                                    <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                                    <input type="hidden" name="valoracion[]" id="jobStabilityRating" value="0">
                                </div>
                            </div>

                            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                            <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                            <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                            <input type="hidden" name="etapa" value="Curriculum">
                            <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">

                            <div class="text-center">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-save mr-2"></i>
                                    Enviar calificaciones
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Visor de PDF -->
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <iframe src="/storage/app/public/{{ $procesoinfo->curriculum }}#zoom=100&navpanes=0&view=FitH"
                            class="w-full h-96 lg:h-[600px] border-0" title="Curriculum del candidato">
                        </iframe>
                    </div>

                    <!-- Cambiar CV -->
                    <div class="text-center">
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_cv{{ $vacante->id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_cv{{ $vacante->id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                    </div>

                    <form onkeydown="return event.key != 'Enter';" action="{{ route('vacantes_subircv') }}"
                        method="post" enctype="multipart/form-data" class="hidden"
                        id="div_cambiar_file_cv{{ $vacante_id }}_{{ $candidato }}">
                        @csrf
                        <div class="p-6 border border-gray-200 rounded-lg">
                            <div class="space-y-4">
                                <div
                                    class="flex flex-col items-center p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 transition-colors duration-200">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-4"></i>
                                    <label class="cursor-pointer">
                                        <span
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                            <i class="fas fa-file-upload mr-2"></i>
                                            Buscar CV
                                        </span>
                                        <input type="file" name="cv" class="hidden" accept=".pdf,.doc,.docx">
                                    </label>
                                </div>

                                <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                                <input type="hidden" name="candidato_id" value="{{ $candidato }}">

                                <button type="submit"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-upload mr-2"></i>
                                    Subir CV
                                </button>
                            </div>
                        </div>
                    </form>
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
            @if($procesoinfo->entrevista1_fecha)
            <?php
            $fechas1=explode(',',$procesoinfo->entrevista1_fecha);
            $desde1=explode(',',$procesoinfo->entrevista1_desde);
            $hasta1=explode(',',$procesoinfo->entrevista1_hasta);
            ?>

            <div class="space-y-6">
                @if($procesoinfo->entrevista2_fecha)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-calendar-check text-green-600 mr-3"></i>
                        <h4 class="text-lg font-semibold text-green-800">Entrevista Programada</h4>
                    </div>
                    <p class="text-green-700 mb-4">
                        La fecha de la entrevista es:
                        <strong>{{ $procesoinfo->entrevista2_fecha.' '.$procesoinfo->entrevista2_hora }}</strong>
                    </p>

                    @if($procesoinfo->estatus_proceso != 'Rechazado')
                    <button
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                        data-bs-toggle="collapse" href="#collapseExampleCambiarFechas" role="button"
                        aria-expanded="false" aria-controls="collapseExampleCambiarFechas">
                        <i class="fas fa-edit mr-2"></i>
                        Cambiar Fechas
                    </button>

                    <div class="collapse mt-4" id="collapseExampleCambiarFechas">
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <p class="text-gray-700 mb-4">Actualiza la fecha y hora para programar la entrevista
                                {{ qcolab($vacante->jefe) }}</p>

                            <form onkeydown="return event.key != 'Enter';"
                                action="{{ route('programar_fechas_entrevista') }}" method="post" class="space-y-4">
                                @csrf
                                @for ($i = 0; $i < count($fechas1); $i++) <div
                                    class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <input type="radio" name="horario" value="{{ $i }}"
                                            class="horario-radio w-4 h-4 text-blue-600" data-index="{{ $i }}"
                                            @if($procesoinfo->entrevista2_fecha == $fechas1[$i]) checked @endif>
                                    </div>

                                    <div>
                                        <p class="font-medium text-gray-700">{{ $fechas1[$i] ?? '' }}</p>
                                        <input type="hidden" name="fecha[]" value="{{ $fechas1[$i] }}"
                                            class="fecha-input">
                                    </div>

                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-600">Elige un horario entre {{ $desde1[$i] ?? '' }}
                                            y {{ $hasta1[$i] ?? '' }}</p>
                                    </div>

                                    <div>
                                        <?php
                                $inicio = $desde1[$i];
                                $fin = $hasta1[$i];
                                $inicio24 = date("H:i", strtotime($inicio));
                                $fin24 = date("H:i", strtotime($fin));
                                $horarios_disponibles = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00"];
                                $horarios_filtrados = array_filter($horarios_disponibles, function($hora) use ($inicio24, $fin24) {
                                    $hora24 = date("H:i", strtotime($hora));
                                    return $hora24 >= $inicio24 && $hora24 < $fin24;
                                });
                                ?>
                                        <select
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 desde-select"
                                            name="desde[]" data-index="{{ $i }}" required>
                                            @if($procesoinfo->entrevista2_hora)
                                            <?php $hora2 = explode(' - ', $procesoinfo->entrevista2_hora); ?>
                                            <option value="{{ $hora2[0] }}">{{ $hora2[0] }}</option>
                                            @endif
                                            @foreach($horarios_filtrados as $hora)
                                            <option value="{{ date("H:i", strtotime($hora)) }}">{{ $hora }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <select
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hasta-select"
                                            name="hasta[]" data-index="{{ $i }}" required>
                                            @if($procesoinfo->entrevista2_hora)
                                            <option value="{{ $hora2[1] }}">{{ $hora2[1] }}</option>
                                            @endif
                                            @foreach($horarios_filtrados as $hora)
                                            <option value="{{ date("H:i", strtotime($hora)) }}">{{ $hora }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                        </div>
                        @endfor

                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $candidato }}">

                        <div class="text-center pt-4">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Enviar a Jefatura
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-calendar-plus text-blue-600 mr-3"></i>
                    <h4 class="text-lg font-semibold text-blue-800">Programar Entrevista</h4>
                </div>
                <p class="text-blue-700 mb-6">Selecciona una fecha para programar la entrevista con
                    {{ qcolab($vacante->jefe) }}</p>

                <form onkeydown="return event.key != 'Enter';" action="{{ route('programar_fechas_entrevista') }}"
                    method="post" class="space-y-4">
                    @csrf
                    @for ($i = 0; $i < count($fechas1); $i++) <div
                        class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <input type="radio" name="horario" value="{{ $i }}"
                                class="horario-radio2 w-4 h-4 text-blue-600" data-index="{{ $i }}"
                                @if($procesoinfo->entrevista2_fecha == $fechas1[$i]) checked @endif>
                        </div>

                        <div>
                            <p class="font-medium text-gray-700">{{ $fechas1[$i] ?? '' }}</p>
                            <input type="hidden" name="fecha[]" value="{{ $fechas1[$i] }}" class="fecha-input2">
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Elige un horario entre {{ $desde1[$i] ?? '' }} y
                                {{ $hasta1[$i] ?? '' }}</p>
                        </div>

                        <div>
                            <?php
                          $inicio = $desde1[$i];
                          $fin = $hasta1[$i];
                          $inicio24 = date("H:i", strtotime($inicio));
                          $fin24 = date("H:i", strtotime($fin));
                          $horarios_disponibles = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00"];
                          $horarios_filtradosdesde = array_filter($horarios_disponibles, function($hora) use ($inicio24, $fin24) {
                              $hora24 = date("H:i", strtotime($hora));
                              return $hora24 >= $inicio24 && $hora24 < $fin24;
                          });
                          $horarios_filtrados = array_filter($horarios_disponibles, function($hora) use ($inicio24, $fin24) {
                              $hora24 = date("H:i", strtotime($hora));
                              return $hora24 >= $inicio24 && $hora24 <= $fin24;
                          });
                          ?>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 desde-select2"
                                name="desde[]" data-index="{{ $i }}"
                                data-horarios="{{ implode(',', $horarios_filtrados) }}" required>
                                <option value="">Seleccionar inicio</option>
                                @foreach($horarios_filtradosdesde as $hora)
                                <option value="{{ date("H:i", strtotime($hora)) }}">{{ $hora }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hasta-select2"
                                name="hasta[]" data-index="{{ $i }}" required>
                                <option value="">Seleccionar fin</option>
                            </select>
                        </div>
            </div>
            @endfor

            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
            <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
            <input type="hidden" name="candidato_id" value="{{ $candidato }}">

            <div class="text-center pt-4">
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar a Jefatura
                </button>
            </div>
            </form>
        </div>
        @endif
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

<!-- Tab 3: Resultado Entrevista -->
<div class="tab hidden">
    @if($procesoinfo->estatus_entrevista)
    @if($procesoinfo->estatus_entrevista=='aprobado')
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <i class="fas fa-check text-2xl text-green-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-green-800 uppercase">{{ $procesoinfo->estatus_entrevista }}</h3>
    </div>
    @elseif($procesoinfo->estatus_entrevista=='rechazado')
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
            <i class="fas fa-times text-2xl text-red-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-red-800 uppercase">{{ $procesoinfo->estatus_entrevista }}</h3>
    </div>
    @endif
    @else
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-8 rounded-lg text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full mb-4">
            <i class="fas fa-lock text-2xl text-gray-400"></i>
        </div>
        <p class="text-gray-600 font-medium">Contenido no disponible</p>
    </div>
    @endif
</div>

<!-- Tab 4: Referencias -->
<div class="tab hidden">
    @if($procesoinfo->estatus_entrevista=='aprobado')
    <div class="bg-white rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 mb-6">Documentos de Referencias</h4>

        <form id="referenciasForm" onkeydown="return event.key != 'Enter';" action="{{ route('subir_referencias') }}"
            method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Buró Laboral -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <h5 class="font-semibold text-gray-700 mb-4">Buró Laboral</h5>

                    <div class="space-y-4">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200">
                            <label class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <span class="block text-sm font-medium text-gray-700">Seleccionar archivo</span>
                                <input type="file" name="buro" id="buro" class="hidden">
                            </label>
                        </div>

                        @if(buscarburo($candidato , $vacante->id)!="")
                        <a href="/storage/app/public/{{ buscarburo($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Buró Laboral
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Carta de Recomendación 1 -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <h5 class="font-semibold text-gray-700 mb-4">Carta de recomendación 1 <span
                            class="text-red-500">*</span></h5>

                    <div class="space-y-4">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200">
                            <label class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <span class="block text-sm font-medium text-gray-700">Seleccionar archivo</span>
                                <input type="file" name="carta" id="carta" class="hidden">
                            </label>
                        </div>

                        @if(buscarcarta($candidato , $vacante->id)!="")
                        <a href="/storage/app/public/{{ buscarcarta($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Carta
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Carta de Recomendación 2 -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <h5 class="font-semibold text-gray-700 mb-4">Carta de recomendación 2 <span
                            class="text-red-500">*</span></h5>

                    <div class="space-y-4">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200">
                            <label class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <span class="block text-sm font-medium text-gray-700">Seleccionar archivo</span>
                                <input type="file" name="carta2" id="carta2" class="hidden">
                            </label>
                        </div>

                        @if(buscarcarta2($candidato , $vacante->id)!="")
                        <a href="/storage/app/public/{{ buscarcarta2($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Carta
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
            <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
            <input type="hidden" name="candidato_id" value="{{ $candidato }}">

            <div class="text-center">
                <p id="error-message" class="text-red-600 mb-4 hidden">Las cartas de recomendación son obligatorias.</p>
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-upload mr-2"></i>
                    Subir referencias
                </button>
            </div>
        </form>
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

<!-- Tab 5: Examen Psicométrico -->
<div class="tab hidden">
    @if($procesoinfo->estatus_entrevista=='aprobado')
    <div class="bg-white rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 mb-6">Examen Psicométrico</h4>

        <form onkeydown="return event.key != 'Enter';" action="{{ route('examen') }}" method="post"
            enctype="multipart/form-data" onsubmit="return validarFormularioExamen();" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Resultados del Examen -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">Resultado del Examen</h5>
                    <div class="space-y-4">
                        <div class="relative">
                            <i
                                class="fas fa-clipboard-check absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="resultados"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ingrese el resultado del examen"
                                value="{{ buscarresultados($candidato , $vacante->id) ?? '' }}" required>
                        </div>
                    </div>
                </div>

                <!-- Subir Archivo del Examen -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">Archivo del Examen</h5>
                    <div class="space-y-4">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center">
                            <label class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <span class="block text-sm font-medium text-gray-700 mb-2">Examen psicométrico</span>
                                <span class="text-xs text-gray-500">Seleccionar archivo (máx. 2MB)</span>
                                <input type="file" name="examenfoto" id="examen" class="hidden">
                            </label>
                        </div>

                        @if(buscarexamen($candidato , $vacante->id)!="")
                        <a href="/storage/app/public/{{ buscarexamen($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Resultado
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
            <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
            <input type="hidden" name="candidato_id" value="{{ $candidato }}">

            <div class="text-center">
                <p id="error-examen" class="text-red-600 mb-4 hidden">* Debes cargar el examen psicométrico.</p>
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Subir resultados
                </button>
            </div>
        </form>
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

<!-- Tab 6: Documentación -->
<div class="tab hidden">
    @if($procesoinfo->estatus_entrevista=='aprobado')
    <div class="bg-white rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 mb-6">Documentación</h4>

        <form action="{{ route('documentacion') }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Identificación -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">Identificación</h5>

                    @if(buscardocumento1($candidato , $vacante->id)!="")
                    <div class="mb-4">
                        @if(estatusDocumento1($candidato , $vacante->id))
                        @if(estatusDocumento1($candidato , $vacante->id)=='Aprobado')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-green-700 text-sm font-medium">{{ estatusDocumento1($candidato , $vacante->id) }}</span>
                        </div>
                        @elseif(estatusDocumento1($candidato , $vacante->id)=='Rechazado')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-red-700 text-sm font-medium">{{ estatusDocumento1($candidato , $vacante->id) }}</span>
                            <p class="text-red-600 text-xs mt-1">{{ comentarioDocumento1($candidato , $vacante->id) }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <a href="/storage/app/public/{{ buscardocumento1($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center mb-3">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Identificación
                        </a>

                        @if(auth()->user()->rol=='Reclutamiento1')
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                        @endif
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center"
                        id="div_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}"
                        @if(buscardocumento1($candidato , $vacante->id)!="") style="display: none;" @endif>
                        <label class="cursor-pointer block">
                            <i class="fas fa-id-card text-3xl text-gray-400 mb-2"></i>
                            <span class="block text-sm font-medium text-gray-700 mb-2">Adjuntar Identificación</span>
                            <input type="file" name="documento1" id="documento1" class="hidden">
                        </label>
                    </div>

                    @if(buscardocumento1($candidato , $vacante->id)!="")
                    <button type="submit"
                        class="w-full mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Subir nuevo documento
                    </button>
                    @endif
                </div>

                <!-- Comprobante de Domicilio -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">Comprobante de domicilio</h5>

                    @if(buscardocumento2($candidato , $vacante->id)!="")
                    <div class="mb-4">
                        @if(estatusDocumento2($candidato , $vacante->id))
                        @if(estatusDocumento2($candidato , $vacante->id)=='Aprobado')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-green-700 text-sm font-medium">{{ estatusDocumento2($candidato , $vacante->id) }}</span>
                        </div>
                        @elseif(estatusDocumento2($candidato , $vacante->id)=='Rechazado')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-red-700 text-sm font-medium">{{ estatusDocumento2($candidato , $vacante->id) }}</span>
                            <p class="text-red-600 text-xs mt-1">{{ comentarioDocumento2($candidato , $vacante->id) }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <a href="/storage/app/public/{{ buscardocumento2($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center mb-3">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Comprobante
                        </a>

                        @if(auth()->user()->rol=='Reclutamiento1')
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                        @endif
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center"
                        id="div_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}"
                        @if(buscardocumento2($candidato , $vacante->id)!="") style="display: none;" @endif>
                        <label class="cursor-pointer block">
                            <i class="fas fa-home text-3xl text-gray-400 mb-2"></i>
                            <span class="block text-sm font-medium text-gray-700 mb-2">Adjuntar Comprobante de
                                domicilio</span>
                            <input type="file" name="documento2" id="documento2" class="hidden">
                        </label>
                    </div>

                    @if(buscardocumento2($candidato , $vacante->id)!="")
                    <button type="submit"
                        class="w-full mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Subir nuevo documento
                    </button>
                    @endif
                </div>

                <!-- CURP -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">CURP</h5>

                    @if(buscardocumento3($candidato , $vacante->id)!="")
                    <div class="mb-4">
                        @if(estatusDocumento3($candidato , $vacante->id))
                        @if(estatusDocumento3($candidato , $vacante->id)=='Aprobado')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-green-700 text-sm font-medium">{{ estatusDocumento3($candidato , $vacante->id) }}</span>
                        </div>
                        @elseif(estatusDocumento3($candidato , $vacante->id)=='Rechazado')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-red-700 text-sm font-medium">{{ estatusDocumento3($candidato , $vacante->id) }}</span>
                            <p class="text-red-600 text-xs mt-1">{{ comentarioDocumento3($candidato , $vacante->id) }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <a href="/storage/app/public/{{ buscardocumento3($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center mb-3">
                            <i class="fas fa-download mr-2"></i>
                            Descargar CURP
                        </a>

                        @if(auth()->user()->rol=='Reclutamiento1')
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                        @endif
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center"
                        id="div_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}"
                        @if(buscardocumento3($candidato , $vacante->id)!="") style="display: none;" @endif>
                        <label class="cursor-pointer block">
                            <i class="fas fa-address-card text-3xl text-gray-400 mb-2"></i>
                            <span class="block text-sm font-medium text-gray-700 mb-2">Adjuntar CURP</span>
                            <input type="file" name="documento3" id="documento3" class="hidden">
                        </label>
                    </div>

                    @if(buscardocumento3($candidato , $vacante->id)!="")
                    <button type="submit"
                        class="w-full mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Subir nuevo documento
                    </button>
                    @endif
                </div>

                <!-- Acta de Nacimiento -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">Acta de nacimiento</h5>

                    @if(buscardocumento4($candidato , $vacante->id)!="")
                    <div class="mb-4">
                        @if(estatusDocumento4($candidato , $vacante->id))
                        @if(estatusDocumento4($candidato , $vacante->id)=='Aprobado')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-green-700 text-sm font-medium">{{ estatusDocumento4($candidato , $vacante->id) }}</span>
                        </div>
                        @elseif(estatusDocumento4($candidato , $vacante->id)=='Rechazado')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-red-700 text-sm font-medium">{{ estatusDocumento4($candidato , $vacante->id) }}</span>
                            <p class="text-red-600 text-xs mt-1">{{ comentarioDocumento4($candidato , $vacante->id) }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <a href="/storage/app/public/{{ buscardocumento4($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center mb-3">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Acta de nacimiento
                        </a>

                        @if(auth()->user()->rol=='Reclutamiento1')
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                        @endif
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center"
                        id="div_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}"
                        @if(buscardocumento4($candidato , $vacante->id)!="") style="display: none;" @endif>
                        <label class="cursor-pointer block">
                            <i class="fas fa-certificate text-3xl text-gray-400 mb-2"></i>
                            <span class="block text-sm font-medium text-gray-700 mb-2">Adjuntar Acta de
                                nacimiento</span>
                            <input type="file" name="documento4" id="documento4" class="hidden">
                        </label>
                    </div>

                    @if(buscardocumento4($candidato , $vacante->id)!="")
                    <button type="submit"
                        class="w-full mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Subir nuevo documento
                    </button>
                    @endif
                </div>

                <!-- IMSS -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h5 class="font-semibold text-gray-700 mb-4">IMSS</h5>

                    @if(buscardocumento5($candidato , $vacante->id)!="")
                    <div class="mb-4">
                        @if(estatusDocumento5($candidato , $vacante->id))
                        @if(estatusDocumento5($candidato , $vacante->id)=='Aprobado')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-green-700 text-sm font-medium">{{ estatusDocumento5($candidato , $vacante->id) }}</span>
                        </div>
                        @elseif(estatusDocumento5($candidato , $vacante->id)=='Rechazado')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <span
                                class="text-red-700 text-sm font-medium">{{ estatusDocumento5($candidato , $vacante->id) }}</span>
                            <p class="text-red-600 text-xs mt-1">{{ comentarioDocumento5($candidato , $vacante->id) }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <a href="/storage/app/public/{{ buscardocumento5($candidato , $vacante->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center mb-3">
                            <i class="fas fa-download mr-2"></i>
                            Descargar IMSS
                        </a>

                        @if(auth()->user()->rol=='Reclutamiento1')
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}')"
                            id="btn_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}">
                            <i class="fas fa-edit mr-2"></i>
                            Cambiar
                        </button>
                        @endif
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors duration-200 text-center"
                        id="div_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}"
                        @if(buscardocumento5($candidato , $vacante->id)!="") style="display: none;" @endif>
                        <label class="cursor-pointer block">
                            <i class="fas fa-hospital text-3xl text-gray-400 mb-2"></i>
                            <span class="block text-sm font-medium text-gray-700 mb-2">Adjuntar IMSS</span>
                            <input type="file" name="documento5" id="documento5" class="hidden">
                        </label>
                    </div>

                    @if(buscardocumento5($candidato , $vacante->id)!="")
                    <button type="submit"
                        class="w-full mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Subir nuevo documento
                    </button>
                    @endif
                </div>
            </div>

            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
            <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
            <input type="hidden" name="candidato_id" value="{{ $candidato }}">

            <div class="text-center">
                <button type="submit"
                    class="inline-flex items-center px-8 py-4 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-upload mr-3"></i>
                    Subir documentos
                </button>
            </div>
        </form>
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

<!-- Tab 7: Alta Candidato/Nómina -->
<div class="tab hidden">
    @if($procesoinfo->estatus_entrevista=='aprobado')
    <div class="bg-white rounded-lg text-center">
        <h4 class="text-lg font-semibold text-gray-800 mb-6">Fecha de Nómina</h4>

        <div class="max-w-md mx-auto">
            <div class="relative">
                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_nomina"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                    placeholder="Fecha" readonly value="{{ fechanomina($proc->candidato_id , $vacante->id) }}">
            </div>

            @if(fechanomina($proc->candidato_id , $vacante->id)!="")
            <div class="mt-6 p-6 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
                <h5 class="text-lg font-semibold text-green-800 mb-2">Proceso Completado</h5>
                <p class="text-green-700">El candidato ha sido procesado exitosamente para nómina.</p>
            </div>
            @endif
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
</div>

<!-- Footer del Card -->
<div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
    <div class="flex justify-center space-x-4">
        <button type="button" id="back_button"
            class="hidden px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200"
            onclick="back()">
            <i class="fas fa-arrow-left mr-2"></i>
            Anterior
        </button>

        <button type="button" id="next_button"
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

    .stepper-responsive>div:not(.flex-1) {
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

/* File upload hover effects */
.file-upload-area:hover {
    @apply border-blue-400 bg-blue-50;
}
</style>

<!-- Scripts JavaScript completos -->
<script type="text/javascript">
// Variables globales
let current = {
    {
        $current ?? 0
    }
};
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

    // Inicializar validación de archivos
    initializeFileValidation();
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
            const requiredRatings = ['expRating', 'techSkillsRating', 'demographicRating', 'educationRating',
                'jobStabilityRating'
            ];
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
                showErrorMessage('Por favor, complete todas las calificaciones requeridas:\n' + mensajes.join(
                    '\n'));
            }
        });
    }

    // Validación del formulario de referencias
    const referenciasForm = document.getElementById('referenciasForm');
    if (referenciasForm) {
        const cartaInput = document.getElementById('carta');
        const carta2Input = document.getElementById('carta2');
        const errorMessage = document.getElementById('error-message');

        const carta1Existente = "{{ buscarcarta($candidato, $vacante->id) ?? '' }}" !== "";
        const carta2Existente = "{{ buscarcarta2($candidato, $vacante->id) ?? '' }}" !== "";

        referenciasForm.addEventListener('submit', function(event) {
            let valid = true;

            if (!carta1Existente && !cartaInput.files.length) {
                valid = false;
            }

            if (!carta2Existente && !carta2Input.files.length) {
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                errorMessage.classList.remove('hidden');
            } else {
                errorMessage.classList.add('hidden');
            }
        });
    }
}

// Función para mostrar mensajes de error
function showErrorMessage(message) {
    const errorElement = document.getElementById('mensajedeerror');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('text-red-600', 'font-medium', 'p-3', 'bg-red-50', 'border', 'border-red-200',
            'rounded-lg');

        setTimeout(() => {
            errorElement.textContent = '';
            errorElement.className = 'text-red-600 font-medium';
        }, 5000);
    } else {
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

            let primeraOpcionValida = selectFin.querySelector("option:not([hidden])");
            if (primeraOpcionValida) {
                selectFin.value = primeraOpcionValida.value;
            }
        });
    }

    // Aplicar a selectores con clases específicas
    const selectsInicio = document.querySelectorAll("select.desde-select, select.desde-select2");
    const selectsFin = document.querySelectorAll("select.hasta-select, select.hasta-select2");

    selectsInicio.forEach((select, index) => {
        if (selectsFin[index]) {
            actualizarHorasFinales(select, selectsFin[index]);
        }
    });

    // Manejo específico para radio buttons de horarios
    const radioButtons = document.querySelectorAll('.horario-radio, .horario-radio2');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const index = this.dataset.index;

            // Desactivar todos los selects
            document.querySelectorAll('select[name="desde[]"], select[name="hasta[]"]').forEach(
                select => {
                    select.required = false;
                });

            // Activar solo los selects del horario seleccionado
            const desdeSelect = document.querySelector(`select[data-index="${index}"][name="desde[]"]`);
            const hastaSelect = document.querySelector(`select[data-index="${index}"][name="hasta[]"]`);

            if (desdeSelect) desdeSelect.required = true;
            if (hastaSelect) hastaSelect.required = true;
        });
    });

    // Manejo para select2 con horarios dinámicos
    const selectsDesde2 = document.querySelectorAll('.desde-select2');
    selectsDesde2.forEach(select => {
        select.addEventListener('change', function() {
            const index = this.dataset.index;
            const selectedTime = this.value;
            const hastaSelect = document.querySelector(`.hasta-select2[data-index="${index}"]`);
            const horarios = this.dataset.horarios.split(',');

            if (hastaSelect) {
                hastaSelect.innerHTML = '';
                horarios.forEach(hora => {
                    if (hora > selectedTime) {
                        const option = document.createElement('option');
                        option.value = hora;
                        option.text = hora;
                        hastaSelect.appendChild(option);
                    }
                });
            }
        });
    });
}

// Validación de archivos
function initializeFileValidation() {
    const maxFileSize = 2 * 1024 * 1024; // 2 MB
    const fileInputs = ['buro', 'carta', 'carta2', 'examen', 'documento1', 'documento2', 'documento3', 'documento4',
        'documento5'
    ];

    fileInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.size > maxFileSize) {
                    alert(
                        'El archivo seleccionado es mayor a 2MB. Por favor, seleccione un archivo más pequeño.');
                    event.target.value = '';
                }
            });
        }
    });
}

// Función para validar formulario de examen
function validarFormularioExamen() {
    const examen = document.getElementById('examen').files.length;
    const errorExamen = document.getElementById('error-examen');
    const existeExamen = "{{ buscarexamen($candidato , $vacante->id) ?? '' }}" !== "";

    if (examen === 0 && !existeExamen) {
        errorExamen.classList.remove('hidden');
        return false;
    }

    errorExamen.classList.add('hidden');
    return true;
}

// Función para validar formulario de curriculum
function validarFormulario() {
    const campos = [{
            id: 'expRating',
            nombre: 'Experiencia adecuada'
        },
        {
            id: 'techSkillsRating',
            nombre: 'Habilidades técnicas'
        },
        {
            id: 'demographicRating',
            nombre: 'Perfil demográfico'
        },
        {
            id: 'educationRating',
            nombre: 'Escolaridad'
        },
        {
            id: 'jobStabilityRating',
            nombre: 'Estabilidad laboral'
        }
    ];

    let mensajes = [];
    campos.forEach(function(campo) {
        const valor = document.getElementById(campo.id).value;
        if (valor == "0" || valor === "") {
            mensajes.push(campo.nombre);
        }
    });

    const errorMensajes = document.getElementById('error-mensajes');
    if (mensajes.length > 0) {
        errorMensajes.innerText = 'Los campos ' + mensajes.join(', ') + ' son obligatorios.';
        errorMensajes.classList.remove('hidden');
        return false;
    }

    errorMensajes.classList.add('hidden');
    return true;
}

// Función para manejar opciones de rechazo
function radioOption(labelId, groupClass) {
    const allOptions = document.querySelectorAll('.' + groupClass);
    allOptions.forEach(option => {
        option.classList.remove('active');
        option.classList.remove('bg-red-100', 'border-red-400', 'shadow-md');
        option.classList.add('border-gray-200');
    });

    const selectedLabel = document.getElementById(labelId);
    if (selectedLabel) {
        selectedLabel.classList.add('active');
        selectedLabel.classList.add('bg-red-100', 'border-red-400', 'shadow-md');
        selectedLabel.classList.remove('border-gray-200');

        const checkbox = selectedLabel.querySelector('input[type="checkbox"]');
        if (checkbox) {
            allOptions.forEach(option => {
                const cb = option.querySelector('input[type="checkbox"]');
                if (cb) cb.checked = false;
            });
            checkbox.checked = true;
        }
    }
}

// Función para mostrar/ocultar divs de archivos
function mostrarDivFile(buttonId, divId) {
    const div = document.getElementById(divId);
    if (div) {
        div.style.display = div.style.display === 'none' ? 'block' : 'none';
    }
}

// Función de debug
// function debugWizard() {
//     console.log('=== Debug del Wizard ===');
//     console.log('Current step:', current);
//     console.log('Total tabs:', tabs.length);
//     console.log('Total tab pills:', tabs_pill.length);
//     console.log('Active tab:', tabs[current]);
//     console.log('Active pill:', tabs_pill[current]);
// }

// Hacer disponible globalmente
window.debugWizard = debugWizard;
window.validarFormulario = validarFormulario;
window.validarFormularioExamen = validarFormularioExamen;
window.radioOption = radioOption;
window.mostrarDivFile = mostrarDivFile;

console.log('Sistema completo de wizard con Tailwind CSS inicializado');
</script>
