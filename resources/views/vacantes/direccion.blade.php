@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Vacantes</h4>
              </div>
              <form class="" action="{{ route('prioridad') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-2">

                      </div>
                      <div class="col-md-8">
                        <div class="card">
                          <div class="card-header">
                            <h5 class="card-title">Vacantes Pendientes {{ count($vacantes) }}</h5>
                          </div>
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table">
                                <thead class="text-primary">
                                  <tr>
                                    <th class="text-center">
                                      Puesto
                                    </th>
                                    <th class="text-center">
                                      Tiempo abierta
                                    </th>
                                    <th class="text-center">
                                      Prioridad
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>

                                  @foreach($vacantes as $vac)
                                  <tr>
                                    <td>
                                      {{ puestosid($vac->puesto_id) }} @if(buscarperfil($vac->puesto_id)) <span> <a target="_blank" href="storage/{{ buscarperfil($vac->puesto_id) }}"> <i class="tim-icons icon-cloud-download-93"></i> </a> </span> @endif
                                      <br><small>{{ $vac->codigo }}</small>
                                    </td>
                                    <td class="text-center">
                                      {{ str_replace(' 12:00:00:AM','',$vac->fecha) }}
                                    </td>
                                    <td class="text-center">
                                      <input type="hidden" name="idvacante[]" value="{{ $vac->id }}">
                                      <select class="form-control" name="prioridad[]">
                                        <option selected value="{{ $vac->prioridad }}">{{ $vac->prioridad }}</option>
                                        @if($vac->prioridad!='Alta')
                                        <option value="Alta">Alta</option>
                                        @endif
                                        @if($vac->prioridad!='Media')
                                        <option value="Media">Media</option>
                                        @endif
                                        @if($vac->prioridad!='Baja')
                                        <option value="Baja">Baja</option>
                                        @endif
                                      </select>
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
                </div>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info" name="button">Actualizar</button>
                  </div>
                </div>
              </form>
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
