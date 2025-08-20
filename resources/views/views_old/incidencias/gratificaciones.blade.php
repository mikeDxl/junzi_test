@extends('layouts.app', ['activePage' => 'Gratificaciones', 'menuParent' => 'laravel', 'titlePage' => __('Gratificaciones')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">>
        <div class="col-12 text-right mb-3">
          <a href="/capturar_gratificaciones" class="btn btn-sm btn-default">{{ __('Capturar gratificaciones') }}</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Gratificaciones</h4>
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
                        {{ __('Monto') }}
                      </th>
                      <th>
                        {{ __('Estatus') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($gratificaciones as $grat)
                      <tr>
                        <td>
                          {{ nombreColaborador($grat->colaborador_id) }}
                        </td>
                        <td>
                          {{ str_replace(' 12:00:00:AM','',$grat->fecha_gratificacion) }}
                        </td>
                        <td>
                          ${{ number_format($grat->monto,2) }}
                        </td>
                        <td>
                          {{ $grat->estatus }}
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
          { "orderable": false, "targets": 4 },
        ],
      });
    });
  </script>
@endpush
