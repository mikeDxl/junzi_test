@extends('layouts.app', ['activePage' => 'Vacaciones', 'menuParent' => 'laravel', 'titlePage' => __('Vacaciones')])

@section('content')
  <div class="content">
    <div class="container-fluid">

      <div class="row">

        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Vacaciones</h4>
              </div>
              <div class="card-body">


                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Colaborador') }}
                      </th>
                      <th>
                        {{ __('Antiguedad') }}
                      </th>
                      <th class="text-center">
                        {{ __('2022') }}
                      </th>
                      <th class="text-center">
                        {{ __('2023') }}
                      </th>
                      <th class="text-center">
                        {{ __('2024') }}
                      </th>
                      <th class="text-center">
                        {{ __('Total') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actualizar') }}
                      </th>
                      <th>
                        {{ __('Fecha ingreso') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($vacaciones_pendientes as $vp)
                      <?php
                      $campo_actual = 'a' . date('Y');
                      $campo_ant = 'a' . date('Y')-1;
                      $campo_ant2 = 'a' . date('Y')-2;
                       ?>
                      <tr>
                        <td>{{ qcolab($vp->colaborador_id) ?? '' }}</td>
                        <td>{{$vp->antiguedad ?? '' }}</td>
                        <td class="text-center">{{$vp->$campo_ant2 ?? '' }}</td>
                        <td class="text-center">{{$vp->$campo_ant ?? '' }}</td>
                        <td class="text-center">{{$vp->$campo_actual ?? '' }}</td>
                        <td class="text-center">{{$vp->total ?? '' }}</td>
                        <td>
                          <form action="{{ route('vacaciones_pendientes') }}" method="post">
                            @csrf
                            <input type="hidden" name="colaborador_id" value="{{$vp->colaborador_id}}">
                            <input type="number" name="tomadas" class="form-control" value="0">
                          <span>  <button type="submit" class="btn btn-info" name="button"> Actualizar </button></span>
                          </form>
                        </td>
                        <td class="text-center">{{$vp->fecha_alta}}</td>
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
