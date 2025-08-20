@extends('layouts.app', ['activePage' => 'Externos', 'menuParent' => 'forms', 'titlePage' => __('Externos')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Colaboradres externos</h4>
            </div>
            <div class="card-body">



              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                    <div class="card-body">
                      <form action="{{ route('alta_externos') }}" method="post" >
                        @csrf
                        <label>Empresa</label>
                        <div class="form-group">
                          <input type="text" name="empresa" class="form-control" value="">
                        </div>
                        <label>Centro de costos</label>
                        <div class="form-group">
                          <select class="form-control" name="centro_de_costo" required>
                            <option value="">Selecciona una opción</option>
                            @foreach($centro_de_costos as $cc)
                              <option value="{{ $cc->id }}">{{ $cc->centro_de_costos }}</option>
                            @endforeach
                          </select>
                        </div>
                        <label>Tipo</label>
                        <div class="form-group">
                          <input type="text" name="tipo" class="form-control" value="">
                        </div>
                        <label>Presupuesto</label>
                        <div class="form-group">
                          <input type="number" step="0.1" name="presupuesto" class="form-control" value="">
                        </div>
                        <label>Cantidad</label>
                        <div class="form-group">
                          <input type="text" name="cantidad" class="form-control" value="">
                        </div>

                        <div class="form-group">
                          <br>
                          <button  class="btn btn-info" type="submit">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">

                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
