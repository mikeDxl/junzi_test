@extends('layouts.app', ['activePage' => 'Candidatos', 'menuParent' => 'laravel', 'titlePage' => __('Candidatos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Candidatos</h4>
              </div>
              <div class="card-body">



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
                        {{ __('Curriculum') }}
                      </th>
                      <th>
                        {{ __('Vacante') }}
                      </th>
                      <th>Estatus</th>
                      <th>Opciones</th>
                    </thead>
                    <tbody>


                      @foreach($candidatos as $cand)

                      <tr>
                        <td>{{ $cand->nombre }}</td>
                        <td>{{ $cand->apellido_paterno }}</td>
                        <td>{{ $cand->apellido_materno }}</td>
                        <td> <a href="/storage/public/{{ $cand->cv }}">Descargar</a> </td>
                        <td> <a href="/proceso_vacante/{{ buscarprocesolink($cand->id) }}#{{ $cand->id }}"> {{ buscarproceso($cand->id) }} </a> </td>
                        <td></td>
                        <td></td>
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
          { "orderable": false, "targets": 6 },
        ],
      });
    });
  </script>
@endpush
