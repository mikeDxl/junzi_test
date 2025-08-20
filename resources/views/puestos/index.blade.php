@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Puestos</h4>
              </div>
              <div class="card-body">

                  <div class="row">
                    <div class="col-12 text-right mb-3">
                      <a href="" class="btn btn-sm btn-info">{{ __('Agregar') }}</a>
                    </div>
                  </div>

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Puesto') }}
                      </th>
                      <th>
                        {{ __('Tipo') }}
                      </th>
                      <th>
                        {{ __('Perfil') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($puestos as $pu)
                      <tr>
                        <td>
                          {{ $pu->puesto }}
                        </td>
                        <td>{{ $pu->tipo }}</td>
                        <td>
                          @if($pu->perfil)
                          <a target="_blank" href="storage/app/public/{{ $pu->perfil }}">Descargar</a>
                          @endif
                        </td>
                          <td class="td-actions text-right">
                            <a href="puesto/{{ $pu->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
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
    "pageLength": 50, // Mostrar 25 filas por defecto
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
