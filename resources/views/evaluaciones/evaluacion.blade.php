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
                        <form action="{{ route('guardarEvaluacion') }}" method="post">
                          @csrf
                          <input type="hidden" value="{{ $id_colaborador }}" name="id_colaborador">
                          <input type="hidden" value="{{ $id_evaluador }}" name="id_evaluador">

                          <div class="form-group">
                              <label>¿El colaborador toma responsabilidad por alcanzar los objetivos a pesar de un entorno cambiante y toma acciones claras para enfocar sus esfuerzos?</label><br>
                              <label><input type="radio" name="pregunta1" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta1" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta1" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="form-group">
                              <label>¿El colaborador busca oportunidades para innovar o mejorar en beneficio del negocio y cliente y se adelanta a las posibles consecuencias de sus decisiones?</label><br>
                              <label><input type="radio" name="pregunta2" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta2" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta2" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="form-group">
                              <label>¿El colaborador crea un ambiente que fomenta la cooperación y comunicación entre compañeros además de estar dispuesto a compartir la información y los recursos?</label><br>
                              <label><input type="radio" name="pregunta3" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta3" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta3" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="form-group">
                              <label>¿El colaborador demuestra congruencia entre sus palabras y acciones, promueve la transparencia, cuestiona las incongruencias e impacta positivamente la moral del equipo?</label><br>
                              <label><input type="radio" name="pregunta4" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta4" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta4" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="form-group">
                              <label>¿El colaborador demuestra apego a los VALORES GONIE; se desenvuelve con proactividad, honradez, unidad, orden y humildad?</label><br>
                              <label><input type="radio" name="pregunta5" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta5" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta5" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="form-group">
                              <label>¿El colaborador demuestra habilidades de liderazgo, desarrolla a su gente, impulsa a mirar más allá de la tarea, brinda opción para encontrar múltiples alternativas, permite que las personas operen con eficiencia y busquen resultados e impacta positivamente la moral del equipo?</label><br>
                              <label><input type="radio" name="pregunta6" value="Pocas veces" required> Pocas veces</label><br>
                              <label><input type="radio" name="pregunta6" value="Con frecuencia"> Con frecuencia</label><br>
                              <label><input type="radio" name="pregunta6" value="Más de lo esperado"> Más de lo esperado</label>
                          </div>

                          <div class="text-center">
                              <button type="submit" class="btn btn-info">Enviar</button>
                          </div>
                      </form>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">

                  </div>

                </div>
              </div>
            </div>
        </div>
      </div>


    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Buscar",
        },
        "columnDefs": [
          { "orderable": false, "targets": 4 },
        ],
      });
    });
  </script>
@endpush
