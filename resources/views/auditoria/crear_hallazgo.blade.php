@extends('home', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('contentJunzi')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Editar hallazgo</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12">
                      <h4>Código</h4>
                      <h4>{{ $auditoria->tipo }}-{{ $auditoria->area }}-{{ $auditoria->ubicacion }}-{{ $auditoria->anio }}-{{ $auditoria->folio }}</h4>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th>Hallazgo</th>
                <th>Responsable</th>
                <th>Fecha de presentación</th>
                <th>Fecha Compromiso</th>
                <th>Evidencia</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hallazgos as $hallazgo)
              <tr>
                <td></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}

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
