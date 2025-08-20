@extends('layouts.app', ['activePage' => 'Departamentos', 'menuParent' => 'laravel', 'titlePage' => __('Departamentos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Departamentos <small> ({{ count($departamentos) }}) </small> </h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-12 text-right mb-3">
                    <form class="" action="{{ route('nuevo_departamento') }}" method="get">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-info">{{ __('Agregar') }}</button>
                    </form>
                  </div>
                </div>

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                        {{ __('Departamento') }}
                      </th>
                      <th>
                        {{ __('Puestos') }}
                      </th>
                      <th>
                        {{ __('Colaboradores') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>
                        @foreach($departamentos as $depto)
                        <tr>
                          <td>
                            {{ $depto->departamento }}
                          </td>
                          <td></td>
                          <td></td>

                            <td class="td-actions text-right">
                              <form>

                                  <a href="/departamento/{{ $depto->id}}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  @if($depto->departamento!="(Ninguno)")
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="eliminar('{{ $depto->departamento }}' , '{{ $depto->id }}' , '{{ $depto->iddepartamento }}')">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                                  @endif
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
      <form action="{{ route('eliminar_departamento') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-header text-center">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <h1 class="modal-title text-center fs-5" id="exampleModalLabel">Eliminar</h1>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <p>¿Confirmas eliminar el departamento <b id="departamento_a_eliminar"></b>?</p>
                <p>Antes de eliminar el departamento debes asignar los colaboradores y los puestos a otro departamento</p>
                <br>
                <div class="form-group">
                  <label for="">Departamentos</label>
                  <select class="form-control" name="departamento_cambio" id="departamento_cambio">
                    @foreach($departamentos as $depto)
                      <option id="depto_cambio_{{ $depto->id }}" class="depto_cambio_{{ $depto->id }}" value="{{ $depto->id }}">{{ $depto->departamento }}</option>
                    @endforeach
                  </select>
                </div>
                <input type="hidden" name="id" id="id_departamento_a_eliminar">
                <input type="hidden" name="iddepartamento" id="iddepartamento_a_eliminar">
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
  function eliminar(departamento , id , iddepartamento){
    var optionToHide = "depto_cambio_" + id;
    var elementos = document.getElementsByClassName(optionToHide);

    // Recorre todos los elementos y ocúltalos
    for (var i = 0; i < elementos.length; i++) {
        elementos[i].style.display = "none";
    }
    document.getElementById('departamento_a_eliminar').innerHTML=departamento;
    document.getElementById('id_departamento_a_eliminar').value=id;
    document.getElementById('iddepartamento_a_eliminar').value=iddepartamento;
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
          { "orderable": false, "targets": 2 },
        ],
      });
    });
  </script>
@endpush
