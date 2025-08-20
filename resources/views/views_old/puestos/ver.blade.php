@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Puestos</h4>
              </div>
              <div class="card-body">



                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('subirperfil') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <label>Puesto</label>
                          <div class="form-group">
                            <input type="text" name="puesto" class="form-control" required value="{{ $puesto->puesto }}">
                          </div>
                          <label>Departamento</label>
                          <div class="form-group">
                            <select class="form-control" name="departamento" required>
                              <option value="{{ $puesto->departamento_id }}">{{ depas2($puesto->departamento_id) }}</option>
                              <option value="">Selecciona una opción</option>
                              @foreach($departamentos as $depto)
                              <option value="{{ $depto->iddepartamento }}">{{ $depto->departamento }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                              <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">

                            </div>

                            <div>
                              <span class="btn btn-info btn-sm btn-simple btn-file">
                                <span class="fileinput-new">Buscar Perfil de Puesto</span>
                                <span class="fileinput-exists">Cambiar</span>
                                <input type="file" name="perfil" accept="application/pdf"/>
                              </span>
                              <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                              <input type="hidden" name="puesto_id" value="{{ $puesto->id }}">

                            </div>

                            <div class="form-group">
                              <br>
                              <button  class="btn btn-info" type="submit">Actualizar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    @if($puesto->perfil)
                    <div class="form-group">
                      <iframe src="/storage/app/public/{{ $puesto->perfil }}" frameborder="0" width="100%" height="600px"></iframe>
                    </div>
                    @endif
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
