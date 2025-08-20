@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Editar Razón Social</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsivem-0 h-100 w-100 overflow-hidden" >
                      <div class="card-body">
                        <form action="{{ route('companies.update', $company->id) }}" method="post">
                          @csrf
                          @method('PUT')

                          <label>Base de datos</label>
                          <div class="form-group">
                              <input type="text" class="form-control" disabled name="nombre" readonly value="{{ $company->nombre }}">
                          </div>

                          <label>Razón Social</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="razon_social" value="{{ $company->razon_social }}">
                          </div>

                          <label>RFC</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="rfc" value="{{ $company->rfc }}">
                          </div>

                          <label>Calle</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="calle" value="{{ $company->calle }}">
                          </div>

                          <label>Colonia</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="colonia" value="{{ $company->colonia }}">
                          </div>

                          <label>Código Postal</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="codigo_postal" value="{{ $company->codigo_postal }}">
                          </div>

                          <label>Municipio</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="municipio" value="{{ $company->municipio }}">
                          </div>

                          <label>Ciudad</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="ciudad" value="{{ $company->ciudad }}">
                          </div>

                          <label>Estado</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="estado" value="{{ $company->estado }}">
                          </div>

                          <div class="text-center">
                              <button type="submit" class="btn btn-info" >Actualizar</button>
                          </div>
                      </form>


                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">

                  </div>
                  <div class="col-md-4" style="">

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



@endpush
