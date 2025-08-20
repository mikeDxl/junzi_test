@extends('layouts.app', ['activePage' => 'Externos', 'menuParent' => 'forms', 'titlePage' => __('Externos')])

@section('content')
<!-- Formulario de edición de colaborador externo -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Editar Colaborador Externo</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                    <div class="card-body">
                      <form action="{{ route('update_externo', $externo->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Razón Social -->
                        <label>Razón Social</label>
                        <div class="form-group">
                            <select class="form-control" name="company_id" required>
                                <option value="">Selecciona una opción</option>
                                @foreach($razones as $razon)
                                    <option value="{{ $razon->id }}" {{ $externo->company_id == $razon->id ? 'selected' : '' }}>
                                        {{ $razon->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Centro de costos -->
                        <label>Centro de costos</label>
                        <div class="form-group">
                            <select class="form-control" name="centro_de_costo" required>
                                <option value="">Selecciona una opción</option>
                                @foreach($centro_de_costos as $cc)
                                    <option value="{{ $cc->id }}" {{ $externo->area == $cc->id ? 'selected' : '' }}>
                                        {{ $cc->centro_de_costo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jefe directo -->
                        <label>Jefe directo</label>
                        <div class="form-group">
                            <select class="form-control" name="jefe" required id="colaborador_name">
                                <option value="">Selecciona una opción</option>
                                @foreach($colaboradores as $colaborador)
                                    <option value="{{ $colaborador->id }}" {{ $externo->jefe == $colaborador->id ? 'selected' : '' }}>
                                        {{ qcolab($colaborador->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nombre de la Empresa/Persona -->
                        <label>Nombre de la Empresa/Persona</label>
                        <div class="form-group">
                            <input type="text" name="empresa" class="form-control" value="{{ $externo->empresa }}">
                        </div>

                        <!-- RFC -->
                        <label>RFC</label>
                        <div class="form-group">
                            <input type="text" name="rfc" class="form-control" value="{{ $externo->rfc }}">
                        </div>

                        <!-- Tipo -->
                        <label>Tipo</label>
                        <div class="form-group">
                            <select class="form-control" name="tipo" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Empresa" {{ $externo->tipo == 'Empresa' ? 'selected' : '' }}>Empresa</option>
                                <option value="Persona" {{ $externo->tipo == 'Persona' ? 'selected' : '' }}>Persona</option>
                            </select>
                        </div>

                        <!-- Giro -->
                        <label>Giro</label>
                        <div class="form-group">
                            <input type="text" name="giro" class="form-control" value="{{ $externo->giro }}">
                        </div>

                        <!-- Presupuesto mensual -->
                        <label>Presupuesto mensual</label>
                        <div class="form-group">
                            <input type="number" step="0.1" name="presupuesto" class="form-control" value="{{ $externo->presupuesto }}">
                        </div>

                        <!-- Fecha de ingreso -->
                        <label>Fecha de ingreso</label>
                        <div class="form-group">
                            <input type="date" name="ingreso" class="form-control" value="{{ $externo->ingreso }}">
                        </div>

                        <!-- Cantidad -->
                        <label>Cantidad</label>
                        <div class="form-group">
                            <input type="text" name="cantidad" class="form-control" value="{{ $externo->cantidad }}">
                        </div>

                        <!-- Estatus -->
                        <label>Estatus</label>
                        <div class="form-group">
                            <select class="form-control" name="estatus" required>
                                <option value="Activo" {{ $externo->estatus == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ $externo->estatus == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <br>
                            <button class="btn btn-info" type="submit">Actualizar</button>
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
