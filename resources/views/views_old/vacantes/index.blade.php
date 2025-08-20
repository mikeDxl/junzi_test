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
              <div class="card-body">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="tools float-right">
                          <div class="dropdown" style="display:none;">
                            <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                              <i class="tim-icons icon-settings-gear-63"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#pablo">Action</a>
                              <a class="dropdown-item" href="#pablo">Another action</a>
                              <a class="dropdown-item" href="#pablo">Something else</a>
                              <a class="dropdown-item text-danger" href="#pablo">Remove Data</a>
                            </div>
                          </div>
                        </div>
                        <h5 class="card-title">Proceso de Reclutamiento</h5>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table" id="datatables">
                            <thead class="text-primary">
                              <tr>
                                <th>
                                  Prioridad
                                </th>
                                <th>
                                  # Candidatos
                                </th>
                                <th>
                                  Puesto
                                </th>
                                <th>
                                  Proceso
                                </th>
                                <th class="text-right">
                                  Tiempo abierta
                                </th>
                                <th class="text-right">
                                  Seguimiento
                                </th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>

                              @foreach($vacantes as $vac)
                              <tr>
                                <td>{{ $vac->prioridad }}</td>
                                <td>
                                  {{ cuantoscandidatos($vac->id) }}
                                </td>
                                <td>
                                  {{ catalogopuesto($vac->puesto_id) }} @if(buscarperfil($vac->puesto_id)) <span> <a target="_blank" href="storage/{{ buscarperfil($vac->puesto_id) }}"> <i class="tim-icons icon-cloud-download-93"></i> </a> </span> @endif
                                  <br><small>{{ $vac->area }}</small>
                                  <br><small>{{ $vac->codigo }}</small>
                                  <br><small>{{ nombre_empresa($vac->company_id) }}</small>
                                </td>
                                <td class="text-center">
                                  {{ $vac->completadas.'/'.$vac->solicitadas }}
                                </td>
                                <td class="text-right">
                                  {{ str_replace(' 12:00:00:AM','',$vac->fecha) }}
                                </td>
                                <td class="text-right">
                                  <a href="/proceso_vacante/{{ $vac->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-minimal-right"></i></a>
                                </td>
                                <td></td>
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
          { "orderable": true, "targets": 6 },
        ],
      });
    });
  </script>
@endpush
