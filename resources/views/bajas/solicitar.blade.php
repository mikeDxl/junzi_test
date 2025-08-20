@extends('layouts.app', ['activePage' => 'Colaboradores', 'menuParent' => 'laravel', 'titlePage' => __('Colaboradores')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Solicitar baja</h4>
              </div>
              <div class="card-body">
                <form action="{{ route('bajas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="colaborador_id">Colaborador</label>
                        <select name="colaborador_id" id="colaborador_id" class="form-control colabselect">
                            <option value="">Selecciona:</option>
                            @foreach($colaboradores as $colaborador)
                                <option value="{{ $colaborador->colaborador_id }}">{{ qcolab($colaborador->colaborador_id) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_baja">Fecha de Baja</label>
                        <input type="date" name="fecha_baja" id="fecha_baja" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="motivo">Motivo</label>
                        <select name="motivo" id="motivo" class="form-control" required>
                            <option value="">Selecciona un motivo:</option>
                            <option value="Renuncia">Renuncia</option>
                            <option value="Baja inmediata">Baja inmediata</option>
                            <option value="Baja programada">Baja programada</option>
                        </select>
                    </div>

                    <div class="mb-3" style="padding:10px 30px;">
                        <input type="checkbox" class="form-check-input" id="generar_vacante" name="generar_vacante" value="1">
                        <label class="form-check-label" for="generar_vacante">¿Requiere generar una vacante?</label>
                    </div>

                    <button type="submit" class="btn btn-info">Solicitar Baja</button>
                </form>

              </div>
            </div>
        </div>
      </div>
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
