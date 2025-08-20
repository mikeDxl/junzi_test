@extends('layouts.app', ['activePage' => 'HorasExtra', 'menuParent' => 'laravel', 'titlePage' => __('HorasExtra')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-right mb-3">
          <a href="/capturar_horas_extra" class="btn btn-sm btn-default">{{ __('Capturar Horas extra') }}</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Horas Extra</h4>
              </div>
              <div class="card-body">

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Colaborador') }}
                      </th>
                      <th>
                        {{ __('Horas') }}
                      </th>
                      <th>
                        {{ __('Fecha') }}
                      </th>
                      <th>
                        {{ __('Estatus') }}
                      </th>
                    </thead>
                    <tbody>

                      @foreach($horas_extra as $he)
                      <tr>
                        <td>
                          {{ qcolab($he->colaborador_id) }}
                        </td>
                        <td>
                          {{ $he->cantidad }}
                        </td>
                        <td>
                          {{ str_replace(' 12:00:00:AM','',$he->fecha_hora_extra) }}
                        </td>
                        <td>
                          {{ $he->estatus }}
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
          { "orderable": false, "targets": 5 },
        ],
      });
    });
  </script>
@endpush
