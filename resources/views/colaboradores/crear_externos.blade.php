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
                      <form action="{{ route('alta_externos') }}" method="post">
                        @csrf
                        <label>Razón Social</label>
                        <div class="form-group">
                          <select class="form-control" name="company_id" required>
                            <option value="">Selecciona una opción</option>
                            @foreach($razones as $razon)
                              <option value="{{ $razon->id }}">{{ $razon->razon_social }}</option>
                            @endforeach
                          </select>
                        </div>
                        <label>Centro de costos</label>
                        <div class="form-group">
                          <select class="form-control" name="centro_de_costo" required>
                            <option value="">Selecciona una opción</option>
                            @foreach($centro_de_costos as $cc)
                              <option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>
                            @endforeach
                          </select>
                        </div>
                        <label>Jefe directo</label>
                        <div class="form-group">
                          <select class="form-control" name="jefe" required id="colaborador_name">
                            <option value="">Selecciona una opción</option>
                            @foreach($uniqueColaboradores as $colaborador)
                                <option value="{{ $colaborador->id }}">{{ qcolab($colaborador->id) }}</option>
                            @endforeach
                          </select>
                        </div>
                        <label>Nombre de la Empresa/Persona</label>
                        <div class="form-group">
                          <input type="text" name="empresa" class="form-control" value="">
                        </div>
                        <label>RFC</label>
                        <div class="form-group">
                          <input type="text" name="rfc" class="form-control" value="">
                        </div>
                        <label>Tipo</label>
                        <div class="form-group">
                          <select class="form-control" name="tipo" required>
                            <option value="">Selecciona una opción</option>
                              <option value="Empresa">Empresa</option>
                              <option value="Persona">Persona</option>
                          </select>
                        </div>
                        <label>Giro</label>
                        <div class="form-group">
                          <input type="text" name="giro" class="form-control" value="">
                        </div>
                        <label>Presupuesto mensual</label>
                        <div class="form-group">
                          <input type="number" step="0.1" name="presupuesto" class="form-control" value="">
                        </div>
                        <label>Fecha de ingreso</label>
                        <div class="form-group">
                          <input type="date" name="ingreso" class="form-control" value="">
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
