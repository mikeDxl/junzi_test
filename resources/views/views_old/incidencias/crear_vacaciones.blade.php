@extends('layouts.app', ['activePage' => 'Vacaciones', 'menuParent' => 'laravel', 'titlePage' => __('Vacaciones')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Solicitar vacaciones</h4>

              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('guardar_vacaciones') }}" method="post">
                          @csrf
                          <label>Colaboradores</label>
                          <div class="form-group">
                            <select class="form-control" name="colaborador_id" id="id_colaborador" onchange="buscarDiasVacaciones();">
                              <option value="">Selecciona una opción</option>
                              @foreach($colaboradores as $col)
                                <option value="{{ $col->id }}">{{ qcolab($col->id) }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">Días de vacaciones</label>
                            <input type="text" name="dias" id="dias" readonly class="form-control">
                          </div>
                          <label>Fecha inicio</label>
                          <div class="form-group">
                            <input type="date" class="form-control" onchange="buscarDiasVacaciones();" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" name="desde" id="desde" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                          </div>
                          <label>Fecha fin</label>
                          <div class="form-group">
                            <input type="date" class="form-control" id="hasta" name="hasta" value="">
                          </div>
                          <label>Comentarios</label>
                          <div class="form-group">
                            <textarea name="comenatrios" class="form-control"></textarea>
                          </div>
                          <div class="text-center">
                            <button type="submit" class="btn btn-info" id="btnCrear" style="display:none;" name="button">Crear</button>
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
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script type="text/javascript">
  function buscarDiasVacaciones() {
    var token = '{{csrf_token()}}';
    var id_colaborador = document.getElementById('id_colaborador').value;

    var data = { _token: token, id_colaborador: id_colaborador };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/buscarDiasVacaciones',
        data: data,
        datatype: 'html',
        encode: true,
        success: function (response) {
            document.getElementById('dias').value=response;
            var diasHabiles = parseInt(response); // Convierte a número entero
            var fechaDesde = new Date(document.getElementById('desde').value); // Obtiene la fecha desde el campo "desde"

            // Calcula la fecha máxima permitida
            var fechaMaxima = calcularFechaMaxima(fechaDesde, diasHabiles);


            // Establece la fecha máxima en el campo "hasta"
            document.getElementById('hasta').setAttribute('max', fechaMaxima);

            // Si la fecha actualmente seleccionada en "hasta" es posterior a la fecha máxima, ajústala
            var fechaHasta = new Date(document.getElementById('hasta').value);
            if (fechaHasta > fechaMaxima) {
                document.getElementById('hasta').value = fechaMaxima.toISOString().slice(0, 10);
            }

            document.getElementById('btnCrear').style.display='block';
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });
}

// Función para calcular la fecha máxima con días hábiles
function calcularFechaMaxima(fecha, diasHabiles) {
    var fechaMaxima = new Date(fecha);

    while (diasHabiles > 0) {
        fechaMaxima.setDate(fechaMaxima.getDate() + 1);
        if (fechaMaxima.getDay() !== 0 && fechaMaxima.getDay() !== 6) {
            // Si no es sábado ni domingo, resta un día hábil
            diasHabiles--;
        }
    }

    return fechaMaxima.toISOString().slice(0, 10);
}

  </script>
@endsection

@push('js')
@endpush
