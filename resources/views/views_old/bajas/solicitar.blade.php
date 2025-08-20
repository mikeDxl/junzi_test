@extends('layouts.app', ['activePage' => 'Colaboradores', 'menuParent' => 'laravel', 'titlePage' => __('Colaboradores')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Colaboradores</h4>
              </div>
              <div class="card-body">



                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Nombre') }}
                      </th>
                      <th>
                        {{ __('Puesto') }}
                      </th>
                      <th>
                        Solicitar Baja
                      </th>
                    </thead>
                    <tbody>


                      @foreach($colaboradores as $colab)

                      <tr>
                        <td>{{ qcolab($colab->colaborador_id) }}</td>
                        <td>{{ catalogopuesto($colab->puesto) }}</td>
                        <td> <button type="button" class="btn btn-link"
                          onclick="MostrarPanel5('{{ $colab->colaborador_id }}' , '{{ $as->id }}' , '{{ qcolabv($as->colaborador_id) }}' ,  '{{ $as->codigo }}' )"
                           data-bs-toggle="modal" data-bs-target="#modalPanel5"
                           name="button">Solicitar baja</button> </td>
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

  <div class="modal fade" id="modalPanel5" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form class="" action="{{ route('eliminardelorganigrama') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="panel-content">
              <div class="panel-header2">
                <h5 class="panel-title text-center">Eliminar del organigrama</h5>
              </div>
              <div class="panel-body">

                <div class="row">
                  <div class="col-6">

                    <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
                    <input type="hidden" name="area" value="{{ $area }}">
                    <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">

                    <div class="form-group">
                      <label for="">Opciones</label>
                      <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="tipo_de_eliminacion" id="tipo_de_eliminacion" onchange="opciones();">
                        <option value="">Selecciona una opción</option>
                        <option value="1">Dar de baja al colaborador</option>
                        <option value="2">Dar de baja al colaborador y crear vacante</option>
                        <option value="3">Eliminar solo del organigrama</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-6">

                    <div class="row">
                      <div class="col-12">
                        <small>En caso de que existan colaboradores en un nivel inmediato inferior, selecciona un nuevo jefe directo para asignarselos.</small>
                      </div>
                    </div>
                    <div class="form-group">

                      <label for="">Nuevo Jefe Directo</label>
                      <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="nuevo_jefe">
                        <option value="">Selecciona una opción</option>
                        @foreach($asignados as $as)
                          <option value="{{ $as->colaborador_id }}">{{ qcolab($as->colaborador_id) }}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>
                </div>



                  <div class="" id="div_baja" style="display:none;">


                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Fecha de baja</label>
                          <input type="date" min="{{ date('Y-m-d') }}" name="fecha_baja" class="form-control">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Motivo baja</label>
                          <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="tipobaja">
                            <option value="">Selecciona el tipo de baja:</option>
                            <option value="Renuncia">Renuncia</option>
                            <option value="Baja solicitada">Baja solicitada</option>
                          </select>
                        </div>
                      </div>
                    </div>


                  </div>

              </div>

            </div>
          </div>
          <div class="modal-footer">
            <div class="container">
              <div class="row">
                <div class="col-6 text-center">

                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
                <div class="col-6 text-center">

                  <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('js')

<script type="text/javascript">
function MostrarPanel5(idcolab){}
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
          { "orderable": false, "targets": 6 },
        ],
      });
    });
  </script>
@endpush
