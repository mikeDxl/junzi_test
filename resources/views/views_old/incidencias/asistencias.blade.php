@extends('layouts.app', ['activePage' => 'Asistencias', 'menuParent' => 'laravel', 'titlePage' => __('Asistencias')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">>
        <div class="col-12 text-right mb-3">
          <a href="/capturar_asistencias" class="btn btn-sm btn-default">{{ __('Capturar asistencias') }}</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Asistencias</h4>
              </div>
              <div class="card-body">

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Colaborador') }}
                      </th>
                      <th>
                        {{ __('Fecha') }}
                      </th>
                      <th>
                        {{ __('Asistencia') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($asistencias as $asist)
                      <tr>
                        <td>
                          {{ qcolab($asist->colaborador_id) }}
                        </td>
                        <td>
                          {{ str_replace(' 12:00:00:AM' ,'',$asist->fecha) }}
                        </td>
                        <td>
                          {{ $asist->asistencia }}
                        </td>


                          <td class="td-actions text-right">
                            <form action= method="post">

                              <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-badge"></i></a>

                              <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>

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
          { "orderable": false, "targets": 3 },
        ],
      });
    });
  </script>
@endpush
