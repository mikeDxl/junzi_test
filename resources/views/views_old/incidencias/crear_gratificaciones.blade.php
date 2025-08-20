@extends('layouts.app', ['activePage' => 'Gratificaciones', 'menuParent' => 'laravel', 'titlePage' => __('Gratificaciones')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Capturar gratificaciones</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('guardar_gratificaciones') }}" method="post">
                          @csrf

                          <label>Colaboradores</label>
                          <div class="form-group">
                            <select class="form-control" name="colaborador_id">
                              <option value="">Selecciona una opción</option>
                              @foreach($colaboradores as $col)
                                <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                              @endforeach
                            </select>
                          </div>
                          <label>Fecha</label>
                          <div class="form-group">
                            <input type="date" class="form-control"  name="fecha_gratificacion" value="" >
                          </div>
                          <label>Monto</label>
                          <div class="form-group">
                            <input type="number" step="0.1" class="form-control" name="monto" value="">
                          </div>
                          <label>Comentarios</label>
                          <div class="form-group">
                            <textarea name="comentarios" class="form-control"></textarea>
                          </div>
                          <div class="text-center">
                            <button type="submit" class="btn btn-info" name="button">Crear</button>
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

  <script type="text/javascript">
  document.getElementById('fecha_gratificacion').addEventListener('input', function() {
  var fechaInput = new Date(this.value);
  var fechaMinima = new Date();
  var fechaMaxima = new Date();
  fechaMaxima.setMonth(fechaMaxima.getMonth() + 1); // Suma un mes

  if (fechaInput < fechaMinima || fechaInput > fechaMaxima) {
      alert('La fecha debe estar entre mañana y el último día del mes en curso.');
      this.value = ''; // Limpiar el campo si la fecha es inválida
  }
});
  </script>
@endsection

@push('js')
@endpush
