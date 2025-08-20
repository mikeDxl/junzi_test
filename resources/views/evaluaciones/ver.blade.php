@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crear evaluaciones</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <div class="card-body">
                                        <p>Evaluación de:</p>
                                        <h2>{{ qcolab($id_colaborador) }}</h2>

                                        <p>Evaluador por:</p>
                                        <h2>{{ qcolab($id_evaluador) }}</h2>

                                        <div class="form-group">
                                            <label>¿El colaborador toma responsabilidad por alcanzar los objetivos a pesar de un entorno cambiante y toma acciones claras para enfocar sus esfuerzos?</label><br>
                                            <label><input type="radio" name="pregunta1" value="Pocas veces" {{ $evaluacion->pregunta1 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta1" value="Con frecuencia" {{ $evaluacion->pregunta1 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta1" value="Más de lo esperado" {{ $evaluacion->pregunta1 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                        <div class="form-group">
                                            <label>¿El colaborador busca oportunidades para innovar o mejorar en beneficio del negocio y cliente y se adelanta a las posibles consecuencias de sus decisiones?</label><br>
                                            <label><input type="radio" name="pregunta2" value="Pocas veces" {{ $evaluacion->pregunta2 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta2" value="Con frecuencia" {{ $evaluacion->pregunta2 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta2" value="Más de lo esperado" {{ $evaluacion->pregunta2 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                        <div class="form-group">
                                            <label>¿El colaborador crea un ambiente que fomenta la cooperación y comunicación entre compañeros además de estar dispuesto a compartir la información y los recursos?</label><br>
                                            <label><input type="radio" name="pregunta3" value="Pocas veces" {{ $evaluacion->pregunta3 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta3" value="Con frecuencia" {{ $evaluacion->pregunta3 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta3" value="Más de lo esperado" {{ $evaluacion->pregunta3 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                        <div class="form-group">
                                            <label>¿El colaborador demuestra congruencia entre sus palabras y acciones, promueve la transparencia, cuestiona las incongruencias e impacta positivamente la moral del equipo?</label><br>
                                            <label><input type="radio" name="pregunta4" value="Pocas veces" {{ $evaluacion->pregunta4 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta4" value="Con frecuencia" {{ $evaluacion->pregunta4 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta4" value="Más de lo esperado" {{ $evaluacion->pregunta4 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                        <div class="form-group">
                                            <label>¿El colaborador demuestra apego a los VALORES GONIE; se desenvuelve con proactividad, honradez, unidad, orden y humildad?</label><br>
                                            <label><input type="radio" name="pregunta5" value="Pocas veces" {{ $evaluacion->pregunta5 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta5" value="Con frecuencia" {{ $evaluacion->pregunta5 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta5" value="Más de lo esperado" {{ $evaluacion->pregunta5 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                        <div class="form-group">
                                            <label>¿El colaborador demuestra habilidades de liderazgo, desarrolla a su gente, impulsa a mirar más allá de la tarea, brinda opción para encontrar múltiples alternativas, permite que las personas operen con eficiencia y busquen resultados e impacta positivamente la moral del equipo?</label><br>
                                            <label><input type="radio" name="pregunta6" value="Pocas veces" {{ $evaluacion->pregunta6 == 'Pocas veces' ? 'checked' : '' }} required> Pocas veces</label><br>
                                            <label><input type="radio" name="pregunta6" value="Con frecuencia" {{ $evaluacion->pregunta6 == 'Con frecuencia' ? 'checked' : '' }}> Con frecuencia</label><br>
                                            <label><input type="radio" name="pregunta6" value="Más de lo esperado" {{ $evaluacion->pregunta6 == 'Más de lo esperado' ? 'checked' : '' }}> Más de lo esperado</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Add any additional content here -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
