@extends('layouts.app', ['activePage' => 'Gratificaciones', 'menuParent' => 'laravel', 'titlePage' => __('Gratificaciones')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-right mb-3">
          <a href="/capturar_permisos" class="btn btn-sm btn-default">{{ __('Capturar permisos') }}</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Permisos</h4>
              </div>
              <div class="card-body">

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Colaborador') }}
                      </th>
                      <th>
                        {{ __('Fechas') }}
                      </th>
                      <th>
                        {{ __('Tipo') }}
                      </th>
                      <th>
                        {{ __('Comentario') }}
                      </th>
                      <th>
                        {{ __('Estatus') }}
                      </th>
                    </thead>
                    <tbody>

                      @foreach($permisos as $permiso)
                      <tr>
                        <td>
                          {{ nombreColaborador($permiso->colaborador_id) }}
                        </td>
                        <td>
                          {{ str_replace(' 12:00:00:AM','',$permiso->fecha_permiso) }}
                        </td>
                        <td>
                          {{ $permiso->tipo }}
                        </td>
                        <td>
                          {{ $permiso->comentarios }}
                        </td>
                        <td>
                          {{ $permiso->estatus }}
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
