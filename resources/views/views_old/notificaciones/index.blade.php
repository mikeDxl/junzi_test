@extends('layouts.app', ['activePage' => 'Notificationes', 'menuParent' => 'laravel', 'titlePage' => __('Notificationes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Notificaciones</h4>
              </div>
              <div class="card-body">

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Titulo') }}
                      </th>
                      <th>
                        {{ __('Fecha') }}
                      </th>
                      <th>
                        {{ __('Estatus') }}
                      </th>
                      <th>
                        {{ __('Ir') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($notificaciones as $notificacion)
                      <?php
                      $abierto=$notificacion->abierto;

                      $estatus='No leido';
                      if ($abierto==0 || $abierto==1) { $estatus='No leido'; }
                      if ($abierto==2) { $estatus='Leido'; }
                       ?>
                      <tr>
                        <td>{{ $notificacion->texto }}</td>
                        <td>{{ $notificacion->fecha }}</td>
                        <td>{{ $estatus }}</td>
                        <td> <a href="{{ $notificacion->ruta }}" class="btn btn-link">Ir</a> </td>
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
