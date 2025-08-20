@extends('layouts.app', ['activePage' => 'Perfil Colaborador', 'menuParent' => 'laravel', 'titlePage' => __('Perfil Colaborador')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" autocomplete="off">
          @csrf
          @method('put')

          <div class="card-header">
            <h5 class="title">Perfil Colaborador</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('Fotografía') }}</label>
              <div class="col-sm-9">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                  <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
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
                  <input class="form-control" name="name" id="input-name" type="text"  required="true" aria-required="true"/>

                </div>
              </div>
              <label class="col-sm-3 col-form-label">{{ __('Apellido Paterno') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="name" id="input-name" type="text" required="true" aria-required="true"/>

                </div>
              </div>
              <label class="col-sm-3 col-form-label">{{ __('Apellido Materno') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" name="name" id="input-name" type="text" required="true" aria-required="true"/>

                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('RFC') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text"  required />

                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label">{{ __('CURP') }}</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control"   type="text"  required />
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
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Num de crédito de INFONAVIT') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Monto de descuento de INFONAVIT') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha inicio descuento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha fin descuento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
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
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de pago') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Cuenta de cheques') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('CLABE Interbancaria') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tarjeta') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha fin descuento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
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
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha de ingreso') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Centro de costos') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Departamento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Puesto') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Jefe directo') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Registro patronal') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de contrato') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de periodo') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de prestación') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Método de pago') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Turno de trabajo') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo de jornada') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
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
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Base de cotización') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('SBC parte Fija') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('SBC parte Variable') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('SBC') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Fecha fin descuento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Sindicalizado') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Base de pago') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Zona de salario') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Tipo Régimen') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Número FONACOT') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Afore') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>


          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('U.M.F') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
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
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Género') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Entidad federativa de nacimiento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Ciudad de nacimiento') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-form-label">{{ __('Estado Civil') }}</label>
            <div class="col-sm-9">
              <div class="form-group">
                <input class="form-control"   type="text"  required />
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

        </div>
      </div>


      <div class="card">
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

        </div>
      </div>









    </div>
    <div class="col-md-4">
      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
            <div class="author">
              <div class="block block-one"></div>
              <div class="block block-two"></div>
              <div class="block block-three"></div>
              <div class="block block-four"></div>
              <a href="javascript:void(0)">
                <img class="avatar" src="">
                <h5 class="title">Nombre del colaborador</h5>
              </a>
              <div class="text-left">
                <p class="description">
                  Puesto:
                </p>
                <p class="description">
                  Edad:
                </p>
                <p class="description">
                  Departamento:
                </p>
                <p class="description">
                  Antiguedad:
                </p>
                <p class="description">
                  Fecha de Nacimiento:
                </p>
                <p class="description">
                  Teléfono:
                </p>
                <p class="description">
                  Email:
                </p>
                <p class="description">
                  Ubicación:
                </p>
                <p class="description">
                  Estatus:
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
                <h5 class="title">Documentos del colaborador</h5>
              </a>
              <div class="text-left">
                <p class="description">
                  Identificación:
                </p>
                <p class="description">
                  Acta de nacimiento:
                </p>
                <p class="description">
                  CURP:
                </p>
                <p class="description">
                  IMSS:
                </p>
                <p class="description">
                  Comprobante de domicilio:
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
                <h5 class="title">Baja del colaborador</h5>
              </a>
              <button type="button" class="btn btn-danger" name="button">Dar de baja</button>

            </div>
          </p>

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
