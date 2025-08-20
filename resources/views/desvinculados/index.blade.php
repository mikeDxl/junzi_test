@extends('layouts.app', ['activePage' => 'Desvinculados', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Desvinculados <small> ({{ count($desvinculados) }}) </small> </h4>
              </div>
              <div class="card-body">



                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Nombre') }}
                      </th>
                      <th>
                        {{ __('CURP') }}
                      </th>
                      <th>
                        {{ __('Fecha Baja') }}
                      </th>
                      <th>
                        {{ __('Motivo') }}
                      </th>

                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($desvinculados as $dv)
                      <tr>
                        <td>
                          {{ colades_nombre($dv->idempleado) }} {{ colades_apaterno($dv->idempleado) }} {{ colades_amaterno($dv->idempleado) }}
                        </td>
                        <td>
                          {{ $dv->curp }}
                        </td>
                        <td>{{ str_replace(' 00:00:00', '', $dv->fecha_baja) }}</td>
                        <td>
                          {{ $dv->causabaja }}
                        </td>

                          <td class="td-actions text-right">
                            <form action= method="post">

                                <a href="/desvinculado/{{ $dv->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>

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
