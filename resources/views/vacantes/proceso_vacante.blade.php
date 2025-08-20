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

<style>
    /* Estilos mejorados para el modal personalizado */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1055; /* Mayor que Bootstrap por defecto */
        overflow: auto;
        padding: 20px;
        box-sizing: border-box;
    }

    .custom-modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .custom-modal-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .btn-close-custom {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        color: #6c757d;
        transition: color 0.2s;
    }

    .btn-close-custom:hover {
        color: #dc3545;
    }

    .demo-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
    }
</style>

<input type="hidden" id="can" value="candidato<?php echo $can; ?>">
<input type="hidden" id="paso" value="tab_paso<?php echo $can; ?>-<?php echo $paso; ?>">

<div class="content">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-md-8">
            <a href="/vacantes" class="flex items-center text-blue-600 hover:text-blue-800 no-underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Regresar
            </a>
        </div>
    </div>

    <!-- Job Information -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="bg-white rounded-lg shadow-sm border p-4">
                <h4 class="text-xl font-semibold mb-4">Información de la Vacante</h4>

                <div class="mb-3">
                    <p><strong>Jefe directo:</strong> {{ qcolab($vacante->jefe) ?: 'No disponible' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-gray-50 rounded p-3 h-100">
                            <p class="text-sm text-gray-600 mb-1">Área</p>
                            <p class="font-medium">{{ $vacante->area }}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-gray-50 rounded p-3 h-100">
                            <p class="text-sm text-gray-600 mb-1">Perfil del Puesto</p>
                            @if(buscarperfildePuesto($vacante->puesto_id))
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="btn btn-sm btn-outline-primary">Ver perfil</button>
                            @else
                            <p class="text-sm text-gray-500">No disponible</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-gray-50 rounded p-3 h-100">
                            <p class="text-sm text-gray-600 mb-1">Puesto</p>
                            <p class="font-medium">{{ catalogopuesto($vacante->puesto_id) }}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-gray-50 rounded p-3 h-100">
                            <p class="text-sm text-gray-600 mb-1">Progreso</p>
                            <p class="font-medium">{{ $vacante->completadas }} / {{ $vacante->solicitadas }}</p>
                            <div class="w-100 bg-gray-200 rounded-full" style="height: 8px;">
                                <div class="bg-green-600 rounded-full h-100"
                                    style="width: {{ $vacante->solicitadas > 0 ? ($vacante->completadas / $vacante->solicitadas) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Candidate Button -->
    @if(auth()->user()->rol=='Reclutamiento')
    <div class="mb-4">
        <div class="text-right">
            <!-- ✅ AHORA ESTE BOTÓN FUNCIONARÁ -->
            <button type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200 ease-in-out"
                onclick="openCustomModal('customAltaCandidato')">
                <i class="fas fa-plus me-2"></i>Agregar candidato
            </button>
        </div>
    </div>
    @endif

    <!-- Candidates Process Stepper -->
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white rounded-lg shadow-sm border p-4">
                <h4 class="text-xl font-semibold mb-4">Proceso de Candidatos</h4>

                <!-- Stepper Header -->
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center position-relative">

                            <!-- Step 1: En Proceso -->
                            <div class="text-center flex-fill">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow"
                                        style="width: 60px; height: 60px; background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                        <i class="fas fa-clock fa-lg"></i>
                                    </div>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $procesos->where('estatus', 'Pendiente')->count() }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-1 font-weight-bold text-primary">En Proceso</p>
                                    <p class="text-sm text-muted mb-0">Evaluación activa</p>
                                </div>
                            </div>

                            <!-- Connection Line 1 -->
                            <div class="flex-fill" style="height: 3px; background: #e9ecef; margin: 0 20px;"></div>

                            <!-- Step 2: Aprobados -->
                            <div class="text-center flex-fill">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow"
                                        style="width: 60px; height: 60px; background: linear-gradient(135deg, #28a745, #1e7e34); color: white;">
                                        <i class="fas fa-check fa-lg"></i>
                                    </div>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                        {{ $procesos->where('estatus', 'Aprobado')->count() }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-1 font-weight-bold text-success">Aprobados</p>
                                    <p class="text-sm text-muted mb-0">Candidatos exitosos</p>
                                </div>
                            </div>

                            <!-- Connection Line 2 -->
                            <div class="flex-fill" style="height: 3px; background: #e9ecef; margin: 0 20px;"></div>

                            <!-- Step 3: Rechazados -->
                            <div class="text-center flex-fill">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow"
                                        style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #bd2130); color: white;">
                                        <i class="fas fa-times fa-lg"></i>
                                    </div>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $procesos->where('estatus', 'Rechazado')->count() }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-1 font-weight-bold text-danger">Rechazados</p>
                                    <p class="text-sm text-muted mb-0">No continúan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidate Lists -->
                <div class="row">

                    <!-- En Proceso -->
                    <div class="col-lg-4 mb-4">
                        <div class="h-100"
                            style="background: #f8f9ff; border: 1px solid #cce7ff; border-radius: 10px; padding: 20px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0">En Proceso</h5>
                                <span class="badge bg-primary">{{ $procesos->where('estatus', 'Pendiente')->count() }}
                                    candidatos</span>
                            </div>

                            @forelse($procesos->where('estatus', 'Pendiente') as $proc)
                            <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                class="d-block text-decoration-none mb-2">
                                <div class="bg-white rounded border p-3 hover-shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                            style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 font-weight-medium text-dark">
                                                {{ candidato($proc->candidato_id) }}</p>
                                            <p class="text-sm text-muted mb-0">En evaluación</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-plus fa-2x text-primary opacity-50 mb-2"></i>
                                <p class="text-primary mb-0">No hay candidatos en proceso</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Aprobados -->
                    <div class="col-lg-4 mb-4">
                        <div class="h-100"
                            style="background: #f8fff9; border: 1px solid #ccffcc; border-radius: 10px; padding: 20px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-success mb-0">Aprobados</h5>
                                <span class="badge bg-success">{{ $procesos->where('estatus', 'Aprobado')->count() }}
                                    candidatos</span>
                            </div>

                            @forelse($procesos->where('estatus', 'Aprobado') as $proc)
                            <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                class="d-block text-decoration-none mb-2">
                                <div class="bg-white rounded border p-3 hover-shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                            style="width: 35px; height: 35px;">
                                            <i class="fas fa-check text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 font-weight-medium text-dark">
                                                {{ candidato($proc->candidato_id) }}</p>
                                            <p class="text-sm text-muted mb-0">Proceso completado</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-check fa-2x text-success opacity-50 mb-2"></i>
                                <p class="text-success mb-0">No hay candidatos aprobados</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rechazados -->
                    <div class="col-lg-4 mb-4">
                        <div class="h-100"
                            style="background: #fff8f8; border: 1px solid #ffcccc; border-radius: 10px; padding: 20px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-danger mb-0">Rechazados</h5>
                                <span class="badge bg-danger">{{ $procesos->where('estatus', 'Rechazado')->count() }}
                                    candidatos</span>
                            </div>

                            @forelse($procesos->where('estatus', 'Rechazado') as $proc)
                            <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}"
                                class="d-block text-decoration-none mb-2">
                                <div class="bg-white rounded border p-3 hover-shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                            style="width: 35px; height: 35px;">
                                            <i class="fas fa-times text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 font-weight-medium text-dark">
                                                {{ candidato($proc->candidato_id) }}</p>
                                            <p class="text-sm text-muted mb-0">No continuó</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-times fa-2x text-danger opacity-50 mb-2"></i>
                                <p class="text-danger mb-0">No hay candidatos rechazados</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="row mt-4 pt-4" style="border-top: 1px solid #e9ecef;">
                    <div class="col-md-3 text-center">
                        <div class="bg-light rounded p-3">
                            <h3 class="mb-1">{{ $procesos->count() }}</h3>
                            <p class="text-muted mb-0">Total candidatos</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="text-primary rounded p-3" style="background: #f8f9ff;">
                            <h3 class="mb-1 text-primary">{{ $procesos->where('estatus', 'Pendiente')->count() }}</h3>
                            <p class="text-primary mb-0">En proceso</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="text-success rounded p-3" style="background: #f8fff9;">
                            <h3 class="mb-1 text-success">{{ $procesos->where('estatus', 'Aprobado')->count() }}</h3>
                            <p class="text-success mb-0">Aprobados</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="text-danger rounded p-3" style="background: #fff8f8;">
                            <h3 class="mb-1 text-danger">{{ $procesos->where('estatus', 'Rechazado')->count() }}</h3>
                            <p class="text-danger mb-0">Rechazados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('vacantes.modals')

<script>
window.openCustomModal = function(modalId) {
    try {
        console.log('Intentando abrir modal:', modalId);
        
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal no encontrado:', modalId);
            return;
        }

        // Mostrar modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        
        // Prevenir scroll del body
        document.body.style.overflow = 'hidden';
        
        console.log('Modal abierto exitosamente:', modalId);
        
    } catch (error) {
        console.error('Error al abrir modal:', error);
        alert('Error al abrir el modal. Por favor, inténtalo de nuevo.');
    }
};

// Función para cerrar modal personalizado
window.closeCustomModal = function(modalId) {
    try {
        console.log('Cerrando modal:', modalId);
        
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal no encontrado:', modalId);
            return;
        }

        // Ocultar modal
        modal.classList.remove('show');
        modal.style.display = 'none';
        
        // Restaurar scroll del body
        document.body.style.overflow = 'auto';
        
        // Limpiar formulario si existe
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
        
        console.log('Modal cerrado exitosamente:', modalId);
        
    } catch (error) {
        console.error('Error al cerrar modal:', error);
    }
};

// Manejo del formulario
window.handleFormSubmit = function(event) {
    event.preventDefault();
    
    try {
        const form = event.target;
        const formData = new FormData(form);
        
        // Aquí puedes agregar la lógica para enviar el formulario
        console.log('Datos del formulario:', Object.fromEntries(formData));
        
        // Simular envío exitoso
        alert('Candidato agregado exitosamente!');
        closeCustomModal('customAltaCandidato');
        
    } catch (error) {
        console.error('Error al procesar el formulario:', error);
        alert('Error al guardar el candidato. Por favor, inténtalo de nuevo.');
    }
};
</script>

@endsection

@push('js')
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->

<script>
var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".tab-pills");

loadFormData(current);

function loadFormData(n) {
    $(tabs_pill[n]).addClass("active");
    $(tabs[n]).removeClass("d-none");
    $("#back_button").attr("disabled", n == 0 ? true : false);
    n == tabs.length - 1 ?
        $("#next_button").text("Submit").removeAttr("onclick") :
        $("#next_button")
        .attr("type", "button")
        .text("Next")
        .attr("onclick", "next()");
}

function next() {
    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).removeClass("active");

    current++;
    loadFormData(current);
}

function back() {
    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).removeClass("active");

    current--;
    loadFormData(current);
}

// ✅ Inicialización cuando el DOM esté listo (funcionalidades adicionales)
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modales...');

    try {
        // Cerrar modal al hacer clic en el fondo
        document.querySelectorAll('.custom-modal').forEach(function(modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    const modalId = modal.getAttribute('id');
                    closeCustomModal(modalId);
                }
            });
        });

        // Cerrar modal con la tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('.custom-modal.show');
                if (openModal) {
                    const modalId = openModal.getAttribute('id');
                    closeCustomModal(modalId);
                }
            }
        });

        // Validación del archivo de curriculum
        const curriculumInput = document.getElementById('customCurriculum');
        if (curriculumInput) {
            curriculumInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validar tamaño (2MB máximo)
                    // const maxSize = 2 * 1024 * 1024;
                    // if (file.size > maxSize) {
                    //     alert('El archivo es demasiado grande. El tamaño máximo permitido es 2MB.');
                    //     this.value = '';
                    //     return;
                    // }

                    // Validar tipo de archivo
                    const allowedTypes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    
                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipo de archivo no permitido. Por favor, selecciona un archivo PDF, DOC o DOCX.');
                        this.value = '';
                        return;
                    }

                    console.log('Archivo válido seleccionado:', file.name);
                }
            });
        }

        console.log('Modales inicializados correctamente');

    } catch (error) {
        console.error('Error en la inicialización:', error);
    }
});
</script>
@endpush