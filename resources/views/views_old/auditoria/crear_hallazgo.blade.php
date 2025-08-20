@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Crear hallazgo</h4>
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
                    <form action="{{ route('crear_hallazgo') }}" method="post" enctype="multipart/form-data">
                      @csrf

                      <div class="form-group">
                        <label>Colaborador</label>
                        <select class="form-control" id="colaborador_name"  name="colaborador_id[]" multiple>
                          @foreach($colaboradores as $col)
                            <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Hallazgo</label>
                        <textarea name="hallazgo" class="form-control" style="resize:none;"></textarea>
                      </div>

                      <div class="form-group">
                        <label>Fecha presentación</label>
                        <input type="date" name="fecha_presentacion" value="" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Fecha compromiso</label>
                        <input type="date" name="fecha_compromiso" value="" class="form-control">
                      </div>


                      <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" name="tipo">
                          <option value="">Selecciona</option>
                          <option value="Operativo">Operativo</option>
                          <option value="Administrativo">Administrativo</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Comentarios</label>
                        <textarea name="comentarios" class="form-control" style="resize:none;"></textarea>
                      </div>

                      <div>
                        <label>Evidencia</label>
                        <input type="file" name="evidencia" value="">
                      </div>

                      <div class="text-center">
                        <input type="hidden" name="tipo" value="{{ $auditoria->tipo }}">
                        <input type="hidden" name="area" value="{{ $auditoria->area }}">
                        <input type="hidden" name="ubicacion" value="{{ $auditoria->ubicacion }}">
                        <input type="hidden" name="anio" value="{{ $auditoria->anio }}">
                        <input type="hidden" name="folio" value="{{ $auditoria->folio }}">
                        <input type="hidden" name="auditoria_id" value="{{ $auditoria->id }}">
                        <br>
                        <button type="submit" class="btn btn-info" name="button">Crear</button>
                      </div>

                    </form>
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

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

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
