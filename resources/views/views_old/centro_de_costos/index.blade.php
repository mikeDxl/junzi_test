@extends('layouts.app', ['activePage' => 'Centro de costos', 'menuParent' => 'laravel', 'titlePage' => __('Centro de costos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Centro de costos</h4>
              </div>
              <div class="card-body">

                  <div class="row">
                    <div class="col-12 text-right mb-3">
                      <form class="" action="{{ route('nuevo_centro_de_costos') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info">{{ __('Agregar') }}</button>
                      </form>
                    </div>
                  </div>

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Centro de costos') }}
                      </th>
                      <th>
                        {{ __('Colaboradores') }}
                      </th>
                      <th>
                        {{ __('Puestos') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>
                        @foreach($centrodecostos as $cc)
                        <tr>
                          <td> {{ $cc->centro_de_costo }} </td>
                          <td> {{ colab_x_cc($cc->id) }} </td>
                          <td>  </td>
                            <td class="td-actions text-right">
                              <form action= method="post">
                                  <a href="/centro_de_costo/{{ $cc->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="eliminar('{{ $cc->centro_de_costos }}' , '{{ $cc->id }}')">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('eliminar_centro_de_costos') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-header ">
            <h1 class="modal-title text-center fs-5" id="exampleModalLabel">Eliminar</h1>

          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <p>¿Confirmas eliminar el centro de costos <b id="centrodecostos_a_eliminar"></b>?</p>
                <input type="hidden" name="id" id="id_centrodecostos_a_eliminar">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('js')
<script type="text/javascript">
  function eliminar(centrodecostos , id){
    document.getElementById('centrodecostos_a_eliminar').innerHTML=centrodecostos;
    document.getElementById('id_centrodecostos_a_eliminar').value=id;
  }
</script>
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
