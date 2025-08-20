@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Permisos</h4>
              </div>
              <form class="" action="{{ route('validarPermisos') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-header">
                          </div>
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table">
                                <thead class="text-primary">
                                  <tr>
                                    <th class="text-center">
                                      Colaborador
                                    </th>
                                    <th class="text-center">
                                      Solicitud
                                    </th>
                                    <th class="text-center">
                                      Jefatura
                                    </th>
                                    <th class="text-center">
                                      Tipo
                                    </th>
                                    <th class="text-center">
                                      Estatus
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>


                                  @foreach($permisos as $permiso)
                                  <tr>
                                    <td class="text-center"> {{ qcolab($permiso->colaborador_id) }} </td>
                                    <td class="text-center"> {{ str_replace(' 12:00:00:AM','',$permiso->fecha_solicitud) }} </td>
                                    <td class="text-center"> {{ qcolab($permiso->jefe_directo_id) }} </td>
                                    <td class="text-center"> {{ $permiso->tipo }} </td>
                                    <td class="text-center">
                                      <input type="hidden" name="idpermiso[]" value="{{ $permiso->id }}">
                                      <select class="form-control" name="estatus[]">
                                        <option selected value="{{ $permiso->estatus }}">{{ $permiso->estatus }}</option>
                                        @if($permiso->estatus!='Pendiente')
                                        <option value="Pendiente">Pendiente</option>
                                        @endif
                                        @if($permiso->estatus!='Aprobada')
                                        <option value="Aprobada">Aprobada</option>
                                        @endif
                                        @if($permiso->estatus!='Rechazada')
                                        <option value="Rechazada">Rechazada</option>
                                        @endif
                                      </select>
                                      </select>
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
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info" name="button">Actualizar</button>
                  </div>
                </div>
              </form>
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
