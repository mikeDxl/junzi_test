@extends('layouts.app', ['activePage' => 'Desvinculados', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Auditorias <small> ({{ count($auditorias) }}) </small> </h4>
              </div>
              <div class="card-body">
               
                <div class="row">
                  <div class="col-12 text-right mb-3">
                    <form class="" action="{{ route('auditorias.nueva') }}" method="get">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-info">{{ __('Agregar') }}</button>
                    </form>
                  </div>
                </div>
           

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Código') }}
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

                      @foreach($auditorias as $adt)
                      <tr>
                        <td>
                          {{ $adt->tipo.'-'.$adt->area.'-'.$adt->ubicacion.'-'.$adt->anio.'-'.$adt->folio }}
                        </td>
                        <td>
                          {{ $adt->estatus }}
                        </td>

                          <td class="td-actions text-right">
                            <form action= method="post">

                                <a href="/auditoria/{{ $adt->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>

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
