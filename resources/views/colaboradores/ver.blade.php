@extends('layouts.app', ['activePage' => 'Perfil Colaborador', 'menuParent' => 'laravel', 'titlePage' => __('Perfil Colaborador')])

@section('content')

<style media="screen">
  .form-control{ border: none; pointer-events: none!important; }
  select {
    -webkit-appearance: none!important; /* Para navegadores WebKit como Chrome y Safari */
    -moz-appearance: none!important; /* Para navegadores basados en Mozilla como Firefox */
    appearance: none!important; /* Para otros navegadores */
}
input[type="date"]::-webkit-calendar-picker-indicator {
    display: none!important;
}
</style>
<div class="content">
  <div class="row">
    <div class="col-md-12 text-right">
      <a class="btn btn-link text-info" href="/editar-colaborador/{{ $colaborador->id }}"> Editar Colaborador </a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-5">
      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
            <div class="author">
              <a href="javascript:void(0)">
                <img class="avatar" src="/storage/app/public/{{ $colaborador->fotografia }}" >
                <h5 class="title">{{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}</h5>
              </a>
              <div class="text-left">
                <p class="description">
                  <small>Puesto:</small> <br> <b> <small>{{ npuesto($colaborador->puesto) }}</small> </b>
                </p>
                <p class="description">
                  <small>Edad:</small> <b></b>
                </p>
                <p class="description">
                  <small>Departamento:</small> <b> <br> <small>{{ depas2($colaborador->departamento_id,$colaborador->company_id) }}</small> </b>
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
              <a href="javascript:void(0)">
                <h5 class="title">Roles del colaborador</h5>
              </a>
              <div class="text-left">
                    <table class="table">
                    <tbody>
                            <tr>
                                <th>Rol</th>
                                <th>Permiso</th>
                            </tr>
                            <tr>
                                <th>RH</th>
                                <td>{{ rolRH($colaborador->id) == 1 ? 'Sí' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Reclutamiento</th>
                                <td>{{ rolReclutamiento($colaborador->id) == 1 ? 'Sí' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Auditoria</th>
                                <td>{{ rolAuditoria($colaborador->id) == 1 ? 'Sí' : 'No' }}</td>
                            </tr>
                        </tbody>

                    </table>
              </div>
            </div>
          </p>

        </div>

      </div>


      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
            <div class="author">
              <a href="javascript:void(0)">
                <h5 class="title">Documentos del colaborador</h5>
              </a>
              <div class="text-left">

                <table class="table table-responsive">

                    <tr>
                      <td>Identificación:</td>
                      <td> @if(docs('documento1' , $colaborador->id))<button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalDocumento1"> <i class="text-default fa fa-download"></i> </button>@endif </td>


                    </tr>

                  <tr>
                    <td>Comprobante de domicilio:</td>
                    <td> @if(docs('documento2' , $colaborador->id))<button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalDocumento2"> <i class="text-default fa fa-download"></i> </button> @endif</td>

                  </tr>
                  <tr>
                    <td>Acta de nacimiento:</td>
                    <td> @if(docs('documento3' , $colaborador->id))<button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalDocumento3"> <i class="text-default fa fa-download"></i> </button>@endif </td>

                  </tr>
                  <tr>
                    <td>CURP:</td>
                    <td> @if(docs('documento4' , $colaborador->id))<button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalDocumento4"> <i class="text-default fa fa-download"></i> </button> @endif</td>

                  </tr>
                  <tr>
                    <td>IMSS:</td>
                    <td> @if(docs('documento5' , $colaborador->id))<button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalDocumento5"> <i class="text-default fa fa-download"></i> </button> @endif</td>

                  </tr>
                </table>

              </div>
            </div>
          </p>

        </div>

      </div>

      <div class="card card-user">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Colaborador</th>
                    <th>Nivel</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $vacantes = [];
                    $colaboradores = [];
                @endphp

                @foreach($organigramas as $organigrama)
                    @if(qcolab($organigrama->colaborador_id) === 'Colaborador no encontrado')
                        @php $vacantes[] = $organigrama; @endphp
                    @else
                        @php $colaboradores[] = $organigrama; @endphp
                    @endif
                @endforeach

                {{-- Mostrar primero los colaboradores encontrados --}}
                @foreach($colaboradores as $organigrama)
                    <tr>
                        <td>{{ qcolab($organigrama->colaborador_id) }}</td>
                        <td>{{ $organigrama->nivel }}</td>
                    </tr>
                @endforeach

                {{-- Mostrar después las vacantes --}}
                @foreach($vacantes as $organigrama)
                    <tr>
                        <td>Vacante</td>
                        <td>{{ $organigrama->nivel }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        </div>

      </div>



    </div>
    <div class="col-md-7">
      <div class="card">
        <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" autocomplete="off">
          @csrf
          @method('put')

          <div class="card-header">
            <h5 class="title">Perfil Colaborador</h5>
          </div>
          <div class="card-body">

            <div class="row" id="profile">
              <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="name" id="input-name" type="text"  ="true" aria-="true" value="{{ $colaborador->nombre }}"/>

                </div>
              </div>
              <label class="col-sm-3 col-form-label">{{ __('Apellido Paterno') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="name" id="input-name" type="text" ="true" aria-="true" value="{{ $colaborador->apellido_paterno }}"/>

                </div>
              </div>
              <label class="col-sm-3 col-form-label">{{ __('Apellido Materno') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="name" id="input-name" type="text" ="true" aria-="true" value="{{ $colaborador->apellido_materno }}"/>

                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('RFC') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text"   value="{{ $colaborador->rfc }}"/>

                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('CURP') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text"   value="{{ $colaborador->curp }}"/>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
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
                <input class="form-control" name="monto_descuento" value="{{ $colaborador->monto_descuento }}"  type="text" required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de descuento de INFONAVIT') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control" name="fecha_inicio" value="{{ $colaborador->tipo_descuento }}"   type="text"  required />

              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha inicio descuento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control" name="inicio_infonavit" value="{{ $colaborador->inicio_infonavit }}"   type="date"  required />
              </div>
            </div>
          </div>



        </div>
      </div>


      <div class="card">
        <div class="card-header">
          <h5 class="card-title">{{ __('Datos bancarios') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Banco') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control" value="{{ qbanco($colaborador->banco) }}" />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Método de pago') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control" value="{{ tipodemetododepago($colaborador->metodo_de_pago_id) }}" />

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
        </div>
      </div>

      <div class="card">
        <div class="card-header">
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
            <label class="col-sm-3 col-form-label">{{ __('Centro de costos') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"  type="text" value="{{ $colaborador->organigrama }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Departamento') }} </label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"  type="text" value="{{ depas2($colaborador->departamento_id , $colaborador->company_id) }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Puesto') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                 <input class="form-control"  type="text" value="{{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Jefe directo') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input type="text" class="form-control" name="" value="{{ qcolab($colaborador->jefe_directo) }}">
              </div>
            </div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Registro patronal') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input type="text" class="form-control" name="" value="{{ tipoderegistropatronal($colaborador->registro_patronal_id,$colaborador->company_id) }}">

              </div>
            </div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de contrato') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input type="text" class="form-control" name="" value="{{ tipodecontrato($colaborador->tipo_de_contrato_id) }}">

              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de periodo') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input type="text" class="form-control" name="" value="{{ tipodeperiodo($colaborador->periodo_id) }}">

              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de prestación') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <select class="form-control" name="tipoprestacion">
                  <option value="{{ $colaborador->prestacion_id }}">{{ tipodeprestacion($colaborador->prestacion_id) }}</option>

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

                </select>
              </div>
            </div>
          </div>


        </div>
      </div>




      <div class="card">
        <div class="card-header">
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
                             {{ tipodebasedecotizacion($colaborador->base_de_cotizacion_id) }}
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
                             {{ tipodebasedepago($colaborador->base_de_pago_id) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Zona de salario') }}</label>
                <div class="col-sm-9">
                    <div class="form-group">
                          {{ tipodezonadesalario($colaborador->zona_de_salario_id) }}
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




      <div class="card">
        <div class="card-header">
          <h5 class="card-title">{{ __('Datos extra') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"   value="{{ $colaborador->email }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Género') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  value="{{ $colaborador->genero }}" />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Entidad federativa de nacimiento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"   value="{{ $colaborador->estado_nacimiento }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Ciudad de nacimiento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"   value="{{ $colaborador->ciudad_nacimiento }}"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Estado Civil') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"   value="{{ $colaborador->estado_civil_id }}"/>
              </div>
            </div>
          </div>



        </div>
      </div>



      <div class="card">
        <div class="card-header">
          <h5 class="card-title">{{ __('Familiares') }}</h5>
        </div>
        <div class="card-body">
          @foreach($familiares as $fam)
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
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
        </div>
      </div>


      <div class="card" style="display:none;">
        <div class="card-header">
          <h5 class="card-title">{{ __('Dirección y contactos') }}</h5>
        </div>
        <div class="card-body">

        </div>
      </div>


      <div class="card">
        <div class="card-header">
          <h5 class="card-title">{{ __('Ficha médica') }}</h5>
        </div>
        <div class="card-body">
            <!-- Información de salud -->
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Tipo de sangre') }}</label>
                <div class="col-sm-9">
                {{ $colaborador->tipo_de_sangre }}
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('¿Tiene alergias?') }}</label>
                <div class="col-sm-9">
                {{ $colaborador->tiene_alergia }}
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Alergias') }}</label>
                <div class="col-sm-9">
                {{ $colaborador->alergias }}
                </div>
            </div>

            <!-- Beneficiarios existentes -->
            <h5 class="mt-3">{{ __('Beneficiarios existentes') }}</h5>
            @foreach ($beneficiarios as $beneficiario)
                <div class="row">
                    <input type="hidden" name="beneficiario_id[]" value="{{ $beneficiario->id }}">
                    <label class="col-sm-3 col-form-label">{{ __('Nombre beneficiario') }}</label>
                    <div class="col-sm-9">
                    {{ $beneficiario->nombre }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">{{ __('Teléfono beneficiario') }}</label>
                    <div class="col-sm-9">
                    {{ $beneficiario->telefono }}
                    </div>
                </div>
            @endforeach

        </div>
      </div>



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


@endsection

@push('js')
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
