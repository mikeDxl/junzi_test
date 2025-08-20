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


      <div class="card card-user">
        <div class="card-body" style="height:600px;">
          <h5 class="title">Baja del colaborador</h5>
          @if($org==0)
          <div class="alert alert-danger" style="color:#fff!important;"><p style="color:#fff!important;">No es posible dar de baja al colaborador , porque no está asigando en el Organigrama</p>
           <br> <a style="color:#fff;" href="/organigrama">Ir a Organigrama</a> </div>
          @else
          <form class="" action="{{ route('generarbaja') }}" method="post">
            @csrf
            <select class="form-control" name="tipobaja">
              <option value="">Selecciona el tipo de baja:</option>
              <option value="Renuncia">Renuncia</option>
              <option value="Baja inmediata">Baja inmediata</option>
              <option value="Baja programada">Baja programada</option>
            </select>
            <div class="form-group">
              <input type="date" class="form-control" name="fecha_baja" value="">
            </div>
            <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">
            <button type="submit" class="btn btn-danger btn-sm" name="button">Dar de baja</button>
          </form>
          @endif
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
                  <input class="form-control" name="infonavit" value="{{ $colaborador->infonavit }}"  type="text"  required />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Monto de descuento de INFONAVIT') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="monto_descuento" value="{{ $colaborador->monto_descuento }}"  type="number"  step="0.1" required />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de descuento de INFONAVIT') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select id="tipoDescuento" class="form-control" name="tipo_descuento">
                    <option value="{{ $colaborador->tipo_descuento }}">{{ $colaborador->tipo_descuento }}</option>
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
                  <input class="form-control" name="fecha_inicio" value="{{ str_replace(' 00:00:00' , '',$colaborador->inicio_infonavit) }}"   type="date"  required />
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
                  <select class="form-control" name="banco">
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
              <label class="col-sm-3 col-form-label">{{ __('Tipo de pago') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="metodo_de_pago_id">
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
                  <input class="form-control"   type="text" name="cuenta_cheques"  value="{{ $colaborador->cuenta_cheques }}" />
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('CLABE Interbancaria') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text" name="clabe_interbancaria"   value="{{ $colaborador->clabe_interbancaria }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tarjeta') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="tarjeta"  type="text"   value="{{ $colaborador->tarjeta }}"/>
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
                  <input class="form-control"   type="text" name="numero_de_empleado"   value="{{ $colaborador->numero_de_empleado }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Empresa') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="centro_de_costos" id="centro_de_costos">
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
                  <select class="form-control" name="centro_de_costos" id="centro_de_costos">
                    <option value="{{ $colaborador->organigrama }}">{{ $colaborador->organigrama }}</option>
                    @foreach($centro_de_costos as $cc)
                    <option value="{{ $cc->centro_de_costo }}">{{ $cc->centro_de_costo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Departamento') }} <i class="fa fa-info-circle" title="Cambia el centro de costo para enlistar los departamentos" style="margin-left:5px;"></i>  </label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="departamento" id="departamento">
                    <option value="{{ $colaborador->departamento_id }}">{{ depas2($colaborador->departamento_id , $colaborador->company_id) }}</option>
                    @foreach($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Puesto') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="puesto" id="puesto">
                    <option value="{{ $colaborador->puesto }}">{{ puestos2($colaborador->puesto) }}</option>
                    @foreach($puestos as $puesto)
                    <option value="{{ $puesto->id }}">{{ $puesto->puesto }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Jefe directo') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="jefe_directo" id="jefe_directo" >
                    @if(jefedirecto($colaborador->jefe_directo,$colaborador->company_id)=='No tiene Jefe Directo')
                    <option value="{{jefedirecto($colaborador->jefe_directo,$colaborador->company_id)}}">No tiene jefe directo</option>
                    @else
                    <option value="{{jefedirecto($colaborador->jefe_directo,$colaborador->company_id)}}">{{jefedirecto($colaborador->jefe_directo,$colaborador->company_id)}}</option>
                    @endif
                    @foreach($jefes as $jefe)
                    <option value="{{ $jefe->id }}">{{ $jefe->nombre.' '.$jefe->apellido_paterno.' '.$jefe->apellido_materno }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Registro patronal') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" name="registropatronal">
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
                  <select class="form-control" name="tipocontrato">
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
                  <select class="form-control" name="tipoperiodo">
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
                  <select class="form-control" name="tipoprestacion">
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
                  <select class="form-control" name="tiporegimen">
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
                  <select class="form-control" name="tipoturnodetrabajo">
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
                  <select class="form-control" name="tipojornada">
                    <option value="{{ $colaborador->jornada_id }}">{{ jornada($colaborador->jornada_id) }}</option>
                    <option value="">Selecciona una opción</option>
                    @foreach($tipojornada as $tipo)
                    <option value="{{ $tipo->nomipaq }}">{{ $tipo->tipo }}</option>
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
                  <select class="form-control" name="estado_civil_id">
                    <option value="{{ $colaborador->estado_nacimiento }}">{{ $colaborador->estado_nacimiento }}</option>
                    @foreach($estados as $edo)
                      @if($edo->estado!=$colaborador->estado_nacimiento)
                      <option value="{{ $edo->id }}">{{ $edo->estado }}</option>
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
                  <select class="form-control" name="estado_civil_id">
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
              <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
              <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
            </div>
          </div>
          <div class="card-header">
            <h5 class="card-title">{{ __('Familiares') }}</h5>
          </div>
          <div class="card-body">
            @foreach($familiares as $fam)
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input type="hidden" name="idfam[]" value="{{ $fam->id }}">
                  <input class="form-control"   type="text"   value="{{ $fam->nombre }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Relación') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text"   value="{{ $fam->relacion }}"/>
                </div>
              </div>
            </div>

            @endforeach

            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" type="text" name="familiar_nombre[]" value=""/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Relación') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" type="text" name="familiar_relacion[]" value=""/>
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
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
              </div>
            </div>
            <h5 class="card-title">{{ __('Dirección y contactos') }}</h5>
          </div>
          <div class="card-body">

          </div>
        </div>
      </form>
      <form method="post" enctype="multipart/form-data" action="{{ route('colaboradores.update9') }}" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->id  }}">
                <button type="submit" class="btn btn-info btn-sm btn-link"> <i class="fa fa-save"></i> Actualizar </a>
              </div>
            </div>
            <h5 class="card-title">{{ __('Ficha médica') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Tipo de sangre') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
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
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('¿Tiene alergias?') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="tiene_alergia"  type="text"   value="{{ $colaborador->tiene_alergia }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Alergias') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="alergias"   type="text"   value="{{ $colaborador->alergias }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Contacto de emergencia') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="contacto_emergencia"  type="text"   value="{{ $colaborador->contacto_emergencia }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Teléfono de emergencia') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="telefono_emergencia"   type="text"   value="{{ $colaborador->telefono_emergencia }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="nombre_beneficiario_1"  type="text"   value="{{ $colaborador->nombre_beneficiario_1 }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="telefono_beneficiario_1"  type="text"   value="{{ $colaborador->telefono_beneficiario_1 }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="nombre_beneficiario_2"  type="text"   value="{{ $colaborador->nombre_beneficiario_2 }}"/>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="telefono_beneficiario_2"  type="text"   value="{{ $colaborador->telefono_beneficiario_1 }}"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
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


@endsection

@push('js')

  <script type="text/javascript">
  function buscarDepartamentos(){
       var token = '{{csrf_token()}}';
       var centro_de_costos = document.getElementById('centro_de_costos').value;

       var data={_token:token , centro_de_costos:centro_de_costos };
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
           type    : 'POST',
           url     :'/buscarDepartamentos',
           data    : data,
           datatype: 'html',
           encode  : true,
           success: function (response) {
             document.getElementById('departamento').innerHTML=response;


           },
           error: function(jqXHR, textStatus, errorThrown){

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
  function buscarPuestos(){
       var token = '{{csrf_token()}}';
       var departamento = document.getElementById('departamento').value;

       var data={_token:token , departamento:departamento };
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
           type    : 'POST',
           url     :'/buscarPuestos',
           data    : data,
           datatype: 'html',
           encode  : true,
           success: function (response) {
             document.getElementById('puesto').innerHTML=response;


           },
           error: function(jqXHR, textStatus, errorThrown){

           }
       });

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
@endpush
