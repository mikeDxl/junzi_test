@extends('layouts.app', ['activePage' => 'Colaboradores', 'menuParent' => 'laravel', 'titlePage' => __('Colaboradores')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Colaboradores</h4>


              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-4" >


                  </div>
                  <div class="col-4 text-right mb-3">
                    <a href="/colaboradores/externos" class="btn btn-sm btn-default">{{ __('Externos') }}</a>
                  </div>
                  <div class="col-4 text-right mb-3">
                    <a href="/colaboradores/crear" class="btn btn-sm btn-default">{{ __('Agregar colaborador') }}</a>
                  </div>
                </div>



                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Nombre') }}
                      </th>
                      <th>
                        {{ __('Apellido Paterno') }}
                      </th>
                      <th>
                        {{ __('Apellido Materno') }}
                      </th>
                      <th>
                        {{ __('Centro de costos') }}
                      </th>
                      <th>
                        {{ __('Razón social') }}
                      </th>
                      <th>Datos</th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($colaboradores as $col)
                      <tr>
                        <td>
                          {{ $col->nombre }}
                        </td>
                        <td>
                          {{ $col->apellido_paterno }}
                        </td>
                        <td>
                          {{ $col->apellido_materno }}
                        </td>
                        <td>{{ $col->organigrama }}</td>
                        <td>{{ empresa($col->company_id) }}</td>
                        <td>
                          <div class="progress-container progress-sm">
                            <div class="progress">
                              <span class="progress-value">{{ progresoColab($col->id) }}%</span>
                              <div class="progress-bar" role="progressbar" aria-valuenow="{{ progresoColab($col->id) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ progresoColab($col->id) }}%;"></div>
                            </div>
                          </div>
                        </td>

                          <td class="td-actions text-right">
                            <form action= method="post">

                              <a href="/vista-colaborador/{{$col->id}}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-badge"></i></a>

                              @if(auth()->user()->rol=='Reclutamiento')
                              <a href="/editar-colaborador/{{$col->id}}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                              @endif

                            </form>
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
