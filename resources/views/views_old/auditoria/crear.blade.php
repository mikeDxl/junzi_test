@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Crear auditoría</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('crear_auditoria') }}" method="post" >
                          @csrf
                          <label>Tipo</label>
                          <div class="form-group">
                            <select class="form-control" name="tipo">
                              <option value="Programada">Programada</option>
                              <option value="Especial">Especial</option>
                              <option value="Extraordinaria">Extraordinaria</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Centro de costos</label>
                            <select class="form-control" name="area">
                              @foreach($centro_de_costos as $cc)
                                <option value="{{ $cc->centro_de_costo }}">{{ $cc->centro_de_costo }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Ubicación</label>
                            <select class="form-control" name="ubicacion">
                              @foreach($ubicaciones as $ubi)
                                @if($ubi->ubicacion!="")
                                <option value="{{ $ubi->ubicacion }}">{{ $ubi->ubicacion }}</option>
                                @endif
                              @endforeach
                            </select>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-info" name="button">Crear</button>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">

                  </div>

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
