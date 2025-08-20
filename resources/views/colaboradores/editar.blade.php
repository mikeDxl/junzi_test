@extends('layouts.app', ['activePage' => 'Perfil Colaborador', 'menuParent' => 'laravel', 'titlePage' => __('Perfil Colaborador')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      {{-- Verificar si hay un mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Verificar si hay un mensaje de error --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="alert alert-danger" id="div-alert-danger" style="display:none;">
        </div>

    </div>
    <div class="col-md-5">
      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
            <div class="author">
                <img class="avatar" src="/storage/app/public/{{ $colaborador->fotografia }}" >
                <h5 class="title">{{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}</h5>
              <div class="text-left">
                <p class="description">
                  <small>Puesto:</small> <br> <b> <small>{{ npuesto($colaborador->puesto) }}</small> </b>
                </p>
                <p class="description">
                  <small>Edad:</small> <b></b>
                </p>
                <p class="description">
                  <small>Departamento:</small> <b> <br> <small>{{ depas2($colaborador->departamento_id , $colaborador->company_id) }}</small> </b>
                </p>
                <p class="description">
                  <small>Antiguedad:</small> <b> <small>{{ calcularAniosTranscurridos($colaborador->fecha_alta) }}</small> </b>
                </p>
                <p class="description">
                  <small>Fecha de Nacimiento:</small> <b> <small>{{ $colaborador->fecha_nacimiento }}</small> </b>
                </p>
                <p class="description">
                  <small>Teléfono:</small> <b> <small>{{ $colaborador->telefono }}</small> </b>
                </p>
                <p class="description">
                  <small>Email:</small> <b> <small>{{ $colaborador->email }}</small> </b>
                </p>
                <p class="description">
                  <small>Estatus: <b>{{ $colaborador->estatus }}</b> </small>
                </p>
              </div>
            </div>
          </p>

        </div>

      </div>


      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
            <div class="author">
              <form method="POST" action="{{ route('actualizar_roles') }}">
              <div class="text-right">
              <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar</button>
              </div>

              <div class="text-left">


              <div class="form-group">
                <label for="">Usuario</label>
                <input type="email" name="colaborador_email" class="form-control" value="{{ queEmail($colaborador->id) }}" required>
            </div>
              <h5 class="title">Roles del colaborador</h5>

                    <table class="table">
                        @csrf
                        <tbody>
                            <tr>
                                <th>Rol</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>RH</th>
                                <td>
                                    <input type="checkbox" name="nomina" value="1" {{ rolRH($colaborador->id) == 1 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <th>Reclutamiento</th>
                                <td>
                                    <input type="checkbox" name="reclutamiento" value="1" {{ rolReclutamiento($colaborador->id) == 1 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <th>Auditoria</th>
                                <td>
                                    <input type="checkbox" name="auditoria" value="1" {{ rolAuditoria($colaborador->id) == 1 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <th>Jefatura</th>
                                <td>
                                    <input type="checkbox" name="jefatura" value="1" {{ rolJefatura($colaborador->id) == 1 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <th>Colaborador</th>
                                <td>
                                    <input type="checkbox" name="colaborador" value="1" {{ rolColaborador($colaborador->id) == 'Colaborador' ? 'checked' : '' }}>
                                </td>
                            </tr>
                        </tbody>

                        <div class="form-group text-end">

                            <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">

                        </div>

                    </table>



              </div>
              </form>
            </div>
          </p>

        </div>

      </div>


      <div class="card card-user">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <h5 class="title">Documentos del colaborador</h5>
            </div>
            <div class="col-3">
              <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalUploadDocumento1"> <i class="text-info fa fa-upload"></i> </button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <table class="table table-responsive">
                  <thead>
                      <tr>
                          <th>Documento</th>
                          <th>Enlace</th>
                          <th>Eliminar</th> <!-- Nueva columna para acciones -->
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($tiposdedocumentos as $documento)
                          <tr>
                              <td>{{ $documento->tipo }}</td>
                              <td><a href="{{ asset('storage/app/documentos/'.$colaborador->id.'/'.$documento->ruta) }}" target="_blank">Ver Documento</a></td>
                              <td>
                                  <!-- Botón para eliminar el documento -->
                                  <form action="{{ route('colaboradores.eliminarDocumento', $documento->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-link" onclick="return confirm('¿Está seguro de querer eliminar este documento?')">
                                        <i class="text-danger fa fa-trash"></i>
                                      </button>
                                  </form>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>


            </div>
          </div>

        </div>

      </div>

    </div>
    <div class="col-md-7">
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update1') }}" autocomplete="off">
          @csrf
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-12 text-right">
                    <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                    <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </button>
                  </div>
                </div>
                <h5 class="title">Perfil Colaborador</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <label class="col-sm-3 col-form-label">{{ __('Fotografía') }}</label>
                  <div class="col-sm-9">
                    <img class="img-fluid" style="max-height:90px;" src="/storage/app/public/{{ $colaborador->fotografia }}" >
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                      <div class="fileinput-preview fileinput-exists thumbnail img-circle" style="height:90px!important; width:90px!important;"></div>
                      <div>
                        <span class="btn btn-round btn-rose btn-file">
                          <span class="fileinput-new">{{ __('Agregar') }}</span>
                          <span class="fileinput-exists">{{ __('Cambiar') }}</span>
                          <input type="file" name="photo" id = "input-picture"/>
                        </span>
                        <br />
                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> {{ __('Borrar') }}</a>
                      </div>
                      @include('alerts.feedback', ['field' => 'photo'])
                    </div>
                  </div>
                </div>
                <div class="row" id="profile">
                  <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-9">
                      <div class="form-group">
                          <input class="form-control" name="nombre" id="input-nombre" type="text" style="text-transform:uppercase;" required="true" aria-required="true"
                                 value="{{ $colaborador->nombre }}" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                      </div>
                  </div>
                  <label class="col-sm-3 col-form-label">{{ __('Apellido Paterno') }}</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" pattern="[A-Za-z\s]+" name="apellido_paterno" style="text-transform:uppercase;" id="input-paterno" type="text" required="true" aria-required="true" value="{{ $colaborador->apellido_paterno }}"/>

                    </div>
                  </div>
                  <label class="col-sm-3 col-form-label">{{ __('Apellido Materno') }}</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" pattern="[A-Za-z\s]+" name="apellido_materno" style="text-transform:uppercase;" id="input-materno" type="text" required="true" aria-required="true" value="{{ $colaborador->apellido_materno }}"/>

                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">{{ __('RFC') }}</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control"  maxlength="13" id="rfc" style="text-transform:uppercase;" type="text" required name="rfc" value="{{ $colaborador->rfc }}"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">{{ __('CURP') }}</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control"  maxlength="18" id="curp" style="text-transform:uppercase;" type="text" name="curp" required value="{{ $colaborador->curp }}"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update2') }}" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </button>
              </div>
            </div>
            <h5 class="card-title">{{ __('Infonavit') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Num Seguro Social') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="nss"   type="text"  required value="{{ $colaborador->nss }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Num de crédito de INFONAVIT') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="infonavit" value="{{ $colaborador->infonavit }}"  type="text"   />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Monto de descuento de INFONAVIT') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="monto_descuento" value="{{ $colaborador->monto_descuento }}"  type="number"  step="0.1"  />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de descuento de INFONAVIT') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select id="tipoDescuento colabselect" class="form-control" name="tipo_descuento">
                    @if(!empty($colaborador->tipo_descuento))
                        <option value="{{ $colaborador->tipo_descuento }}" selected>{{ $colaborador->tipo_descuento }}</option>
                        <option value="">Selecciona</option>
                    @else
                        <option value="" selected>Selecciona</option>
                    @endif
                    <option value="Descuento por nómina">Descuento por nómina</option>
                    <option value="Pago directo">Pago directo</option>
                    <option value="Transferencia bancaria">Transferencia bancaria</option>
                    <option value="Pago en ventanilla bancaria">Pago en ventanilla bancaria</option>
                    <option value="Pago adelantado">Pago adelantado</option>
                    <!-- Puedes agregar más opciones aquí si es necesario -->
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Fecha inicio descuento') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="fecha_inicio" value="{{ str_replace(' 00:00:00' , '',$colaborador->inicio_infonavit) }}"   type="date"   />
                </div>
              </div>
            </div>

          </div>
        </div>
      </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update3') }}" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
              </div>
            </div>
            <h5 class="card-title">{{ __('Datos bancarios') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Banco') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="banco">
                    <option value="{{ $colaborador->banco }}">{{ qbanco($colaborador->banco) }}</option>
                    @foreach($bancos as $ban)
                      @if($ban->clave!=$colaborador->banco)
                      <option value="{{ $ban->clave }}">{{ $ban->banco }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Método de pago') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="metodo_de_pago_id">
                    <option value="{{ $colaborador->metodo_de_pago_id }}">{{ tipodemetododepago($colaborador->metodo_de_pago_id) }}</option>
                    @foreach($tipometododepago as $tp)
                      @if($tp->id!=$colaborador->metodo_de_pago_id)
                      <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Cuenta de cheques') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"  type="text" name="cuenta_cheques"  value="{{ $colaborador->cuenta_cheques }}" />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('CLABE Interbancaria') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"  min="18" type="text" name="clabe_interbancaria"   value="{{ $colaborador->clabe_interbancaria }}"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update4') }}" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
              </div>
            </div>
            <h5 class="card-title">{{ __('Posición y Salarios') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Número de empleado') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                     {{ $colaborador->numero_de_empleado }}
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Empresa') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="company_id" id="empresa">
                    <option value="{{ $colaborador->company_id }}">{{ nombre_empresa($colaborador->company_id) }}</option>
                    @foreach($empresas as $emp)
                      @if($emp->id!=$colaborador->company_id)
                      <option value="{{ $emp->id }}">{{ $emp->razon_social }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Centro de costos') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="centro_de_costos" id="centro_de_costos">
                    <option value="{{ $colaborador->organigrama }}">{{ $colaborador->organigrama }}</option>
                    @foreach($centro_de_costos as $cc)
                    <option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Departamento') }} <i class="fa fa-info-circle" title="Cambia el centro de costo para enlistar los departamentos" style="margin-left:5px;"></i>  </label>
              <div class="col-sm-9">
                <div class="form-group" id="div-departamento">
                  <select class="form-control colabselect" name="departamento" id="departamento">
                    <option value="{{ $colaborador->departamento_id }}">{{ depas2($colaborador->departamento_id , $colaborador->company_id) }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Puesto') }}</label>
              <div class="col-sm-9">
                <div class="form-group" id="div-puesto">
                  <select class="form-control colabselect" name="puesto" id="puesto">
                    <option value="{{ $colaborador->puesto }}">{{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Jefe directo') }}</label>
              <div class="col-sm-9">
                <div class="form-group" id="div-jefe">
                  <select class="form-control colabselect" name="jefe_directo" id="jefe_directo" >
                    @if(qcolab($colaborador->jefe_directo))
                    <option value="{{ $colaborador->jefe_directo }}">{{ qcolab($colaborador->jefe_directo) }}</option>
                    @else
                    <option value="">No tiene jefe directo</option>
                    @endif
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Registro patronal') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="registropatronal">
                    <option value="{{ $colaborador->registro_patronal_id }}">{{ tipoderegistropatronal($colaborador->registro_patronal_id,$colaborador->company_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($registropatronal as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->registro_patronal }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de contrato') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tipocontrato">
                    <option value="{{ $colaborador->tipo_de_contrato_id }}">{{ tipodecontrato($colaborador->tipo_de_contrato_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipocontratos as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de periodo') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tipoperiodo">
                    <option value="{{ $colaborador->periodo_id }}">{{ tipodeperiodo($colaborador->periodo_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipoperiodos as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de prestación') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tipoprestacion">
                    <option value="{{ $colaborador->prestacion_id }}">{{ tipodeprestacion($colaborador->prestacion_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipoprestacion as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de Régimen') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tiporegimen">
                    <option value="{{ $colaborador->regimen_id }}">{{ tipoderegimen($colaborador->regimen_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tiporegimen as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Turno de trabajo') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tipoturnodetrabajo">
                    <option value="{{ $colaborador->turno_de_trabajo_id }}">{{ turnodetrabajo($colaborador->turno_de_trabajo_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipoturnodetrabajo as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de jornada') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="tipojornada">
                    <option value="{{ $colaborador->jornada_id }}">{{ jornada($colaborador->jornada_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipojornada as $tipo)
                    <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


          </div>
        </div>
      </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update6') }}" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
              </div>
            </div>
            <h5 class="card-title">{{ __('Datos extra') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="email"  type="text"   value="{{ $colaborador->email }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Género') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="genero">
                    <option value="{{ $colaborador->genero }}">{{ $colaborador->genero }}</option>
                      @foreach($generos as $genero)
                        @if($genero->genero!=$colaborador->genero)
                        <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                        @endif
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Entidad federativa de nacimiento') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="estado_nacimiento">
                    <option value="{{ $colaborador->estado_nacimiento }}">{{ $colaborador->estado_nacimiento }}</option>
                    @foreach($estados as $edo)
                      @if($edo->estado!=$colaborador->estado_nacimiento)
                      <option value="{{ $edo->estado }}">{{ $edo->estado }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Ciudad de nacimiento') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="ciudad_nacimiento"  type="text"   value="{{ $colaborador->ciudad_nacimiento }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Estado Civil') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control colabselect" name="estado_civil_id">
                    <option value="{{ $colaborador->estado_civil_id }}">{{ $colaborador->estado_civil_id }}</option>
                    @foreach($estadosciviles as $edocivil)
                      @if($edocivil->id!=$colaborador->estado_civil_id)
                      <option value="{{ $edocivil->id }}">{{ $edocivil->estado_civil }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>



          </div>
        </div>
      </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update7') }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">
                    <button type="submit" class="btn btn-info btn-sm btn-link">
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title">{{ __('Dirección y contactos') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Dirección') }}</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="direccion" value="{{ $colaborador->direccion }}" />
                        </div>
                    </div>
                </div>

                @foreach($familiares as $fam)
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="hidden" name="idfam[]" value="{{ $fam->id }}">
                            <input class="form-control" type="text" name="familiar_nombre[]" value="{{ $fam->nombre }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Relación') }}</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="familiar_relacion[]" value="{{ $fam->relacion }}" />
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Nuevos familiares -->
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="familiar_nombre[]" value=""  />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Relación') }}</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="familiar_relacion[]" value="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update8') }}" autocomplete="off">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">
                    <button type="submit" class="btn btn-info btn-sm btn-link">
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
            <h5 class="card-title">{{ __('Salarios') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Salario diario') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" name="salario_diario" type="text" value="{{ $colaborador->salario_diario }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Base de cotización') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select class="form-control colabselect" name="base_de_cotizacion_id">
                            <option value="{{ $colaborador->base_de_cotizacion_id }}">{{ tipodebasedecotizacion($colaborador->base_de_cotizacion_id) }}</option>
                            <option value="">Selecciona una opción</option>
                            @foreach($tipobasedecotizacion as $tipo)
                            <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Sindicalizado') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" name="sindicalizado" type="text" value="{{ $colaborador->sindicalizado }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Base de pago') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select class="form-control colabselect" name="base_de_pago_id">
                            <option value="{{ $colaborador->base_de_pago_id }}">{{ tipodebasedepago($colaborador->base_de_pago_id) }}</option>
                            <option value="">Selecciona una opción</option>
                            @foreach($tipobasedepago as $tipo)
                            <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Zona de salario') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select class="form-control colabselect" name="zona_de_salario_id">
                            <option value="{{ $colaborador->zona_de_salario_id }}">{{ tipodezonadesalario($colaborador->zona_de_salario_id) }}</option>
                            <option value="">Selecciona una opción</option>
                            @foreach($tipozonasalario as $tipo)
                            <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Número FONACOT') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" name="fonacot" type="text" value="{{ $colaborador->fonacot }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Afore') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" name="afore" type="text" value="{{ $colaborador->afore }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('U.M.F') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" name="umf" type="text" value="{{ $colaborador->umf }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update9') }}" autocomplete="off">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">
                    <button type="submit" class="btn btn-info btn-sm btn-link">
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
            <h5 class="card-title">{{ __('Ficha médica') }}</h5>
        </div>
        <div class="card-body">
            <!-- Información de salud -->
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Tipo de sangre') }}</label>
                <div class="col-sm-9">
                    <select id="tipoSangre" class="form-control" name="tipo_de_sangre">
                        <option value="">{{ $colaborador->tipo_de_sangre }}</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('¿Tiene alergias?') }}</label>
                <div class="col-sm-9">
                    <input class="form-control" name="tiene_alergia" type="text" value="{{ $colaborador->tiene_alergia }}" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Alergias') }}</label>
                <div class="col-sm-9">
                    <input class="form-control" name="alergias" type="text" value="{{ $colaborador->alergias }}" />
                </div>
            </div>

            <!-- Beneficiarios existentes -->
            <h5 class="mt-3">{{ __('Beneficiarios existentes') }}</h5>
            @foreach ($beneficiarios as $beneficiario)
                <div class="row">
                    <input type="hidden" name="beneficiario_id[]" value="{{ $beneficiario->id }}">
                    <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="beneficiario_nombre[]" type="text" value="{{ $beneficiario->nombre }}" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="beneficiario_telefono[]" type="text" value="{{ $beneficiario->telefono }}" />
                    </div>
                </div>
            @endforeach

            <!-- Agregar nuevos beneficiarios -->
            <h5 class="mt-3">{{ __('Agregar nuevos beneficiarios') }}</h5>
            <div id="nuevos-beneficiarios">
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="nuevo_beneficiario_nombre[]" type="text" value="" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="nuevo_beneficiario_telefono[]" type="text" value="" />
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="agregarBeneficiario()">Agregar Beneficiario</button>
        </div>
    </div>
</form>

<script>
    function agregarBeneficiario() {
        const container = document.getElementById('nuevos-beneficiarios');
        const nuevoBeneficiario = `
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
                <div class="col-sm-9">
                    <input class="form-control" name="nuevo_beneficiario_nombre[]" type="text" value="" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
                <div class="col-sm-9">
                    <input class="form-control" name="nuevo_beneficiario_telefono[]" type="text" value="" />
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', nuevoBeneficiario);
    }
</script>

    </div>

  </div>
</div>


<div class="modal fade" id="modalDocumento1" tabindex="-1" aria-labelledby="modalDocumento1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @foreach($documentos as $doc)
              @if($doc->tipo=='documento1')
                <iframe src="/storage/app/public/{{ $doc->tipo }}" width="100%" height="600"></iframe>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDocumento2" tabindex="-1" aria-labelledby="modalDocumento2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @foreach($documentos as $doc)
              @if($doc->tipo=='documento2')
                <iframe src="/storage/app/public/{{ $doc->tipo }}" width="100%" height="600"></iframe>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalDocumento3" tabindex="-1" aria-labelledby="modalDocumento3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @foreach($documentos as $doc)
              @if($doc->tipo=='documento3')
                <iframe src="/storage/app/public/{{ $doc->tipo }}" width="100%" height="600"></iframe>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDocumento4" tabindex="-1" aria-labelledby="modalDocumento4" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @foreach($documentos as $doc)
              @if($doc->tipo=='documento4')
                <iframe src="/storage/app/public/{{ $doc->tipo }}" width="100%" height="600"></iframe>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDocumento5" tabindex="-1" aria-labelledby="modalDocumento5" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @foreach($documentos as $doc)
              @if($doc->tipo=='documento5')
                <iframe src="/storage/app/public/{{ $doc->tipo }}" width="100%" height="600"></iframe>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalUploadDocumento1" tabindex="-1" aria-labelledby="modalDocumento1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="" action="{{ route('colaboradores.cargarDocumentos') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idcolab" value="{{ $colaborador->id }}">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Subir documento</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre del documento</label>
                            <select class="form-control" name="tipo" required id="tipodoc" onchange="toggleTextInput()">
                                <option value="INE">INE</option>
                                <option value="Comprobante de domicilio">Comprobante de domicilio</option>
                                <option value="IMSS">IMSS</option>
                                <option value="CURP">CURP</option>
                                <option value="Acta de nacimiento">Acta de nacimiento</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <input type="text" class="form-control" name="tipo2" id="tipodoctexto" style="display:none;">
                        </div>
                        <div>
                            <label for="">Documento</label>
                            <input type="file" name="documento" class="form-control" value="" required>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <br>
                        <input type="hidden" name="idcolab" value="{{ $colaborador->id }}">
                        <button type="submit" class="btn btn-info">Subir documento</button>
                    </div>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
  document.getElementById('centro_de_costos').addEventListener('change', function () {

    buscarDepartamentos();
    buscarPuestos();
    buscarJefeDirecto();

});
function buscarDepartamentos() {
    // Obtener el token CSRF directamente desde una variable JavaScript (Laravel lo pasa a través de la vista)
    var token = "{{ csrf_token() }}";  // Laravel genera el token y lo pasa aquí

    // Obtener el valor del centro de costos
    var centro_de_costos = document.getElementById('centro_de_costos').value;

    // Datos que se enviarán en la solicitud
    var data = {
        _token: token,
        centro_de_costos: centro_de_costos
    };

    // Configurar los encabezados de la solicitud AJAX
    $.ajax({
        type: 'POST',
        url: '/buscarDepartamentos',  // La URL a la que se enviará la solicitud
        data: data,  // Los datos que se enviarán
        datatype: 'json',  // Esperamos una respuesta JSON
        success: function (response) {
            // Verificar si la respuesta es un array
            if (Array.isArray(response)) {
                var divDepartamento = document.getElementById('div-departamento');
                divDepartamento.innerHTML = '';  // Limpiar el contenido anterior

                // Crear un nuevo elemento select para los departamentos
                var newSelect = document.createElement('select');
                newSelect.className = 'form-control colabselect';
                newSelect.name = 'departamento';
                newSelect.id = 'departamento';

                // Agregar las opciones al select
                response.forEach(function (departamento) {
                    var option = document.createElement('option');
                    option.value = departamento.id;  // ID del departamento
                    option.textContent = departamento.departamento;  // Nombre del departamento
                    newSelect.appendChild(option);
                });

                // Añadir el nuevo select al contenedor
                divDepartamento.appendChild(newSelect);

                // Inicializar Choices.js en el nuevo select
                new Choices(newSelect);
            } else {
                // Si la respuesta no es un array, mostrar un error
                console.error('La respuesta no es un array:', response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Mostrar mensaje de error en caso de falla
            var alertDiv = document.getElementById('div-alert-danger');
            alertDiv.innerHTML = 'Ocurrió un error al buscar los departamentos. Por favor, intenta de nuevo.';
            alertDiv.classList.remove('d-none');  // Hacer visible la alerta
        }
    });
}


function buscarPuestos() {
    // Obtener el token CSRF directamente desde una variable JavaScript (Laravel lo pasa a través de la vista)
    var token = "{{ csrf_token() }}";  // Laravel genera el token y lo pasa aquí

    // Obtener el valor del centro de costos
    var centro_de_costos = document.getElementById('centro_de_costos').value;

    // Datos que se enviarán en la solicitud
    var data = {
        _token: token,
        centro_de_costos: centro_de_costos
    };

    // Configurar los encabezados de la solicitud AJAX
    $.ajax({
        type: 'POST',
        url: '/buscarPuestos',  // La URL a la que se enviará la solicitud
        data: data,  // Los datos que se enviarán
        datatype: 'json',  // Esperamos una respuesta JSON
        success: function (response) {
            // Verificar si la respuesta es un array
            if (Array.isArray(response)) {
                var divPuesto = document.getElementById('div-puesto');
                divPuesto.innerHTML = '';

                // Crear un nuevo elemento select para los puestos
                var newSelect = document.createElement('select');
                newSelect.className = 'form-control colabselect';
                newSelect.name = 'puesto';
                newSelect.id = 'puesto';

                // Agregar las opciones al select
                response.forEach(function (puesto) {
                    var option = document.createElement('option');
                    option.value = puesto.id;  // ID del puesto
                    option.textContent = puesto.puesto;  // Nombre del puesto
                    newSelect.appendChild(option);
                });

                // Añadir el nuevo select al contenedor
                divPuesto.appendChild(newSelect);

                // Inicializar Choices.js en el nuevo select
                new Choices(newSelect);
            } else {
                // Si la respuesta no es un array, mostrar un error
                console.error('La respuesta no es un array:', response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Mostrar mensaje de error en caso de falla
            var alertDiv = document.getElementById('div-alert-danger');
            alertDiv.innerHTML = 'Ocurrió un error al buscar los puestos. Por favor, intenta de nuevo.';
            alertDiv.classList.remove('d-none');  // Hacer visible la alerta
        }
    });
}


function buscarJefeDirecto() {
    // Obtener el token CSRF directamente desde una variable JavaScript (Laravel lo pasa a través de la vista)
    var token = "{{ csrf_token() }}";  // Laravel genera el token y lo pasa aquí

    // Obtener el valor del centro de costos
    var centro_de_costos = document.getElementById('centro_de_costos').value;

    // Datos que se enviarán en la solicitud
    var data = {
        _token: token,
        centro_de_costos: centro_de_costos
    };

    // Configurar los encabezados de la solicitud AJAX
    $.ajax({
        type: 'POST',
        url: '/buscarJefesDirectos',  // La URL a la que se enviará la solicitud
        data: data,  // Los datos que se enviarán
        datatype: 'json',  // Esperamos una respuesta JSON
        success: function (response) {
            // Verificar si la respuesta es un array
            if (Array.isArray(response)) {
                var divJefe = document.getElementById('div-jefe');
                divJefe.innerHTML = '';

                // Crear un nuevo elemento select para los puestos
                var newSelect = document.createElement('select');
                newSelect.className = 'form-control colabselect';
                newSelect.name = 'jefe_directo';
                newSelect.id = 'jefe_directo_id';

                // Agregar las opciones al select
                response.forEach(function (colaborador) {
                    var option = document.createElement('option');
                    option.value = colaborador.id;  // ID del puesto
                    option.textContent = colaborador.colaborador;  // Nombre del puesto
                    newSelect.appendChild(option);
                });

                // Añadir el nuevo select al contenedor
                divJefe.appendChild(newSelect);

                // Inicializar Choices.js en el nuevo select
                new Choices(newSelect);
            } else {
                // Si la respuesta no es un array, mostrar un error
                console.error('La respuesta no es un array:', response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Mostrar mensaje de error en caso de falla
            var alertDiv = document.getElementById('div-alert-danger');
            alertDiv.innerHTML = 'Ocurrió un error al buscar los colaboradores. Por favor, intenta de nuevo.';
            alertDiv.classList.remove('d-none');  // Hacer visible la alerta
        }
    });
}

</script>


<script type="text/javascript">
function toggleTextInput() {
    var selectElement = document.getElementById('tipodoc');
    var textInputElement = document.getElementById('tipodoctexto');

    if (selectElement.value === 'Otro') {
        textInputElement.style.display = 'block';
        textInputElement.required = true;
    } else {
        textInputElement.style.display = 'none';
        textInputElement.required = false;
        textInputElement.value = '';
    }
}

</script>

  <script type="text/javascript">
  function buscarColaborador(){
       var token = '{{csrf_token()}}';
       var puesto = document.getElementById('puesto').value;

       var data={_token:token , puesto:puesto };
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
           type    : 'POST',
           url     :'/buscarColaborador',
           data    : data,
           datatype: 'html',
           encode  : true,
           success: function (response) {
             document.getElementById('jefe_directo').innerHTML=response;


           },
           error: function(jqXHR, textStatus, errorThrown){

           }
       });

     }

  </script>
<script>
  $(document).ready(function () {
    @if ($errors->has('not_allow_profile'))
      $.notify({
        icon: "close",
        message: "{{ $errors->first('not_allow_profile') }}"
      }, {
        type: 'danger',
        timer: 3000,
        placement: {
          from: 'top',
          align: 'right'
        }
      });
    @endif
  });
  $(document).ready(function () {
    @if ($errors->has('not_allow_password'))
      $.notify({
        icon: "close",
        message: "{{ $errors->first('not_allow_password') }}"
      }, {
        type: 'danger',
        timer: 3000,
        placement: {
          from: 'top',
          align: 'right'
        }
      });
    @endif
  });
</script>



@endsection
