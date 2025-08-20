@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Editar centro de costo</h4>
              </div>
              <div class="card-body">



                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('editar_centro_de_costos') }}" method="post" >
                          @csrf
                          <label>Centro de costo</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="centro_de_costos" value="{{ $cc->centro_de_costo }}">
                          </div>
                          <label>Presupuesto</label>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-6">
                                <input type="number" step="0.1" name="presupuesto" class="form-control" value="">

                              </div>
                              <div class="col-md-6">
                                <select class="form-control" name="anio">
                                  <?php

                                  /*$currentYear = date("Y");
                                  $future = $currentYear + 1;
                                  echo "<option value='$future'>$future</option>";
                                  for ($i = 0; $i < 6; $i++) {
                                    $year = $currentYear - $i;
                                    if($i==0){
                                      echo "<option selected value='$year'>$year</option>";
                                    }else {
                                      echo "<option value='$year'>$year</option>";
                                    }
                                  }*/
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>


                          <div class="text-center">
                            <input type="hidden" name="cc_id" value="{{ $cc->id }}">
                            <button type="submit" class="btn btn-info" name="button">Actualizar</button>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">

                  </div>
                  <div class="col-md-4">
                    <label>Puestos</label>
                    <div class="table-responsive">
                      <table class="table  table-bordered">
                        <thead>
                          <tr>
                            <th>Puesto</th>
                            <th>Colaboradores</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($puestos as $puesto)
                            <tr>
                              <td>{{ $puesto->puesto }}</td>
                              <td>{{ colab_x_puesto($puesto->id) }}</td>
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
