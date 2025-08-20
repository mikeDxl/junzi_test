@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Colaborador desvinculado</h4>
              </div>
              <div class="card-body">



                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('editar_desvinculados') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <label>Colaborador</label>
                          <div class="form-group">
                            <p> {{ colades($desvinculado->idempleado) }} </p>
                          </div>
                          <label>Fecha Baja</label>
                          <div class="form-group">
                              <p> {{ $desvinculado->fecha_baja }} </p>
                          </div>

                          <label>Reingresar</label>
                          <div class="form-group">
                            <input type="date" class="form-control" value="" required>
                          </div>

                          <br>

                          <div class="text-center">
                            <input type="hidden" name="idempleado" value="{{ $desvinculado->idempleado }}">
                            <input type="hidden" name="company_id" value="{{ $desvinculado->company_id }}">
                            <button type="submit" class="btn btn-info" name="button">Actualizar</button>
                          </div>


                        </form>
                      </div>
                    </div>
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
