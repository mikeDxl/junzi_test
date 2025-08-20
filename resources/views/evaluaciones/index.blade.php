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
                        <form action="{{ route('evaluaciones.store') }}" method="post" >
                          @csrf

                          <label>Colaborador</label>
                          <div class="form-group">
                            <select class="form-control" id="colaborador_name"  name="id_colaborador">
                              @foreach($colaboradores as $col)
                                <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                              @endforeach
                            </select>
                          </div>


                          <label>Evaluador(es)</label>
                          <div class="form-group">
                            <select class="form-control" id="colaborador_name2"  name="id_evaluador[]" multiple>
                              @foreach($colaboradores as $col)
                                <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                              @endforeach
                            </select>
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

      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>Colaborador</th>
                      <th>Evaluador</th>
                      <th>Estatus</th>
                      <th>Abrir</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($evaluaciones as $evaluacion)
                  <tr>
                      <td>{{ qcolab($evaluacion->id_colaborador) ?? '' }}</td>
                      <td>{{ qcolab($evaluacion->id_evaluador) ?? '' }}</td>
                      <td>
                          @if ($evaluacion->pregunta1 && $evaluacion->pregunta2 && $evaluacion->pregunta3 && $evaluacion->pregunta4 && $evaluacion->pregunta5 && $evaluacion->pregunta6)
                              Evaluada
                          @else
                              Pendiente
                          @endif
                      </td>
                      <td>
                          <a href="/evaluaciones/evaluar/{{$evaluacion->id_evaluador}}/{{$evaluacion->id_colaborador}}" class="btn btn-link btn-sm">Abrir</a>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>

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
