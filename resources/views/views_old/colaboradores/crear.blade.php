@extends('layouts.app', ['activePage' => 'Alta Colaborador', 'menuParent' => 'forms', 'titlePage' => __('Alta Colaborador')])

@section('content')

<style media="screen">
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
-webkit-appearance: none;
appearance: none;
margin: 0;
}
</style>
<div class="content">
  <div class="col-md-12 mr-auto ml-auto">
    <!--      Wizard container        -->
    <div class="wizard-container">
      <div class="card card-wizard" data-color="primary" id="wizardProfile">
        <form action="/colaboradores/alta" method="post" enctype="multipart/form-data">
          @csrf
          <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
          <div class="card-header text-center">
            <h3 class="card-title">
              Alta colaborador
            </h3>
            <h5 class="description">Completa todos los campos.</h5>
            <div class="wizard-navigation">
              <div class="progress-with-circle">
                <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
              </div>
              <ul>
                <li class="nav-item">
                  <a class="nav-link active" href="#paso1" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Datos personales</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#paso2" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Posición y salarios</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#paso3" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Datos extra y Familiares</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#paso4" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Dirección y contacto</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#paso5" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Ficha médica y beneficiarios</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a class="nav-link" href="#paso6" data-toggle="tab">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Enlace Nomipac</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane show active" id="paso1">
                <h5 class="info-text"> Datos personales</h5>
                <div class="row justify-content-center mt-5">
                  <div class="col-sm-5">
                    <label for="">Razón social</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="razon_social" required id="id_razon_social">
                        <option value="">Selecciona:</option>
                        @foreach($razones as $rz)
                        <option value="{{ $rz->id }}">{{ $rz->razon_social }}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>
                  <div class="col-sm-5">
                    <label for="">RFC*</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="rfc" minlength="13" maxlength="13" required class="form-control"  style="text-transform:uppercase;">
                    </div>

                  </div>
                  <div class="col-sm-5">
                    <label for="">CURP*</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text"  name="curp" minlength="18" maxlength="18" placeholder="CURP" required class="form-control" style="text-transform:uppercase;">
                    </div>

                  </div>

                  <div class="col-sm-5">
                    <label for="">Nombre</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required  name="nombre" class="form-control" placeholder="Nombre" style="text-transform:uppercase;">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Apellido Paterno</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required  name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" style="text-transform:uppercase;">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Apellido Materno</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required  name="apellido_materno" class="form-control" placeholder="Apellido Materno" style="text-transform:uppercase;">
                    </div>
                  </div>

                  <?php
                  $hoy = new DateTime();

                  // Resta 18 años al objeto DateTime
                  $hace18Anios = $hoy->sub(new DateInterval('P18Y'));

                  // Obtén la fecha resultante
                  $fechaHace18Anios = $hace18Anios->format('Y-m-d');
                   ?>

                  <div class="col-sm-5">
                    <label for="">Fecha de nacimiento</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="date" required  name="fecha_nacimiento" class="form-control" placeholder="Fecha de Nacimiento" max="{{ $fechaHace18Anios }}">
                    </div>
                  </div>


                  <div class="row" style="margin-left:80px; margin-top:50px;">
                    <div class="col-sm-5">
                      <label for="">Número de seguro social</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <input type="number" required  name="nss" class="form-control" >
                      </div>
                    </div>

                    <div class="col-sm-5">
                      <label for="">Número de crédito de INFONAVIT</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <input type="number" name="infonavit" class="form-control" >
                      </div>
                    </div>

                    <div class="col-sm-5">
                      <label for="">Monto de descuento de INFONAVIT</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <input type="text" name="monto_descuento" class="form-control">
                      </div>
                    </div>


                    <div class="col-sm-5">
                      <label for="">Tipo de descuento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <select id="tipoDescuento" class="form-control" name="tipoDescuento">
                          <option value="Factor de descuento">Factor de descuento</option>
                          <option value="Cuota Fija">Cuota Fija</option>
                          <option value="Porcentaje">Porcentaje</option>
                          <!-- Puedes agregar más opciones aquí si es necesario -->
                        </select>
                      </div>
                    </div>


                    <div class="col-sm-5">
                      <label for="">Fecha de inicio descuento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <input type="date" name="fecha_inicio" class="form-control" placeholder="Fecha de inicio descuento">
                      </div>
                    </div>


                    <div class="col-sm-5" style="display:none;">
                      <label for="">Fecha final descuento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                          </div>
                        </div>
                        <input type="date" name="fecha_fin" class="form-control" placeholder="Fecha de fin descuento">
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <br>
                    <h5 class="info-text">Datos Bancarios</h5>
                    <br>
                  </div>



                  <div class="col-sm-5">
                    <label for="">Banco</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select id="banco"  name="banco" class="form-control">
                          <option value="">Selecciona</option>
                          @foreach($bancos as $banco)
                          <option value="{{ $banco->codigo }}">{{ $banco->banco }}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <label>Método de pago</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="tipodemetododepago">
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodemetododepago as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <label for="">Cuenta de cheques</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" name="cuenta_cheques" class="form-control" >
                    </div>
                  </div>




                  <div class="col-sm-5">
                    <label for="">Clabe interbancaria</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" name="clabe_interbancaria" minlength="18" maxlength="18" class="form-control">
                    </div>
                  </div>

                </div>
              </div>
              <div class="tab-pane" id="paso2">
                <h5 class="info-text">Posición</h5>
                <div class="row justify-content-center">
                  <div class="col-lg-12 text-center">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                      <div class="fileinput-new thumbnail">
                        <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail"></div>
                      <div>
                        <span class="btn btn-info btn-simple btn-file">
                          <span class="fileinput-new">Subir fotografía</span>
                          <span class="fileinput-exists">Cambiar</span>
                          <input type="file" name="fotografia" />
                        </span>
                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Número de empleado</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" required readonly  name="numero_de_empleado" class="form-control" id="numero_de_empleado" placeholder="Número de empleado" min="{{ $numero_de_empleado }}" pattern="[0-9]*" value="{{ $numero_de_empleado }}">
                      <input type="hidden"  name="idempleado" class="form-control" placeholder="Número de empleado" pattern="[0-9]*" value="{{ $idempleado }}">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Fecha de ingreso</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="date" name="fecha_ingreso" required class="form-control"  min="{{ date('Y-m-d') }}" placeholder="Fecha de ingreso">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Centro de costo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="centro_de_costos">
                        <option value="">Selecciona una opción:</option>
                        @foreach($centro_de_costos as $cc)
                        <option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Departamento</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control"  required name="departamento">
                          <option value="">Selecciona una opción:</option>
                          @foreach($catalogoDepartamentos as $cd)
                          <option value="{{ $cd->id }}">{{ $cd->departamento }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Puesto</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="puesto">
                        <option value="">Selecciona una opción:</option>
                        @foreach($catalogoPuestos as $cp)
                        <option value="{{ $cp->id }}">{{ $cp->puesto }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Jefe directo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="jefe_directo" id="jefe_directo" >

                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Registro patronal</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="registro_patronal">
                        <option value="">Selecciona una opción</option>
                        @foreach($registropatronal as $rp)
                        <option value="{{ $rp->id }}">{{ $rp->registro_patronal}}</option>
                        @endforeach
                      </select>

                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Tipo de contrato</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="tiposdecontrato">
                        <option value="">Selecciona una opción</option>
                        @foreach($tiposdecontratos as $tc)
                        <option value="{{ $tc->id }}">{{ $tc->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Tipo de periodo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="tiposdeperiodo">
                        <option value="">Selecciona una opción</option>
                        @foreach($tiposdeperiodo as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Tipo de prestación</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="tipodeprestacion">
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodeprestacion as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <label>Turno de trabajo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>

                      <select class="form-control" name="tipodeturnodetrabajo">
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodeturnodetrabajo as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label>Tipo de jornada</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>

                      <select class="form-control" name="tipodejornada">
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodejornada as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <br>
                    <h5 class="info-text">Salarios</h5>
                    <br>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Salario diario</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" required  name="salario_diario" min="141.70" class="form-control" placeholder="0.00">
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Base de cotización</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                        <input type="text"  name="base_de_cotizacion" class="form-control" placeholder="0.00">
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Salario base de cotización parte fija</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text"  name="sbc_parte_fija" class="form-control" placeholder="0.00">
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Salario base de cotización parte variable</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text"  name="sbc_parte_variable" class="form-control" placeholder="0.00">
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Salario base de cotización</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text"  name="sbc_base_de_cotizacion" class="form-control" placeholder="0.00">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Sindicalizado</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="sindicalizado" required>
                        <option value="">Selecciona una opción</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Base de pago</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="tipodebasedepago" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodebasedepago as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>

                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Zona de salario</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="tipodezonadesalario" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($tipodezonadesalario as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Tipo de régimen</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="tipoderegimen" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($tipoderegimen as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->tipo}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Número de Fonacot</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>

                      <input type="text" name="fonacot" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">Número de Afore</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="afore" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-5" style="display:none;">
                    <label for="">U.M.F</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="umf" class="form-control">
                    </div>
                  </div>

                </div>
              </div>
              <div class="tab-pane" id="paso3">
                <div class="row justify-content-center">
                  <div class="col-sm-12">
                    <h5 class="info-text"> Datos extra </h5>
                  </div>

                  <div class="col-sm-5">
                    <label for="">Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="email" required name="email" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Género</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="genero">
                        <option value="">Selecciona una opción</option>
                        @foreach($genero as $gen)
                        <option value="{{ $gen->genero }}">{{ $gen->genero }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Entidad federativa de nacimiento</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="estado_nacimiento">
                        <option value="">Selecciona una opción</option>
                        @foreach($estados as $estado)
                        <option value="{{ $estado->estado }}">{{ $estado->estado }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Cuidad</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required name="ciudad_nacimiento" class="form-control" placeholder="Ciudad de nacimiento">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Estado civil</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="estado_civil">
                        <option value="">Selecciona una opción</option>
                        @foreach($estado_civil as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->estado_civil }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <p> <br> </p>
                    <h5 class="info-text"> Familiares </h5>
                  </div>
                  <div class="col-md-1">

                  </div>
                  <div class="col-md-10">
                    <div class="row" id="familiares1">
                      <div class="col-md-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-single-02"></i>
                            </div>
                          </div>
                          <input type="text" name="familiar_nombre[]" class="form-control" placeholder="Nombre">
                        </div>
                      </div>

                      <div class="col-md-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-single-02"></i>
                            </div>
                          </div>
                          <input type="text" name="familiar_relacion[]" class="form-control" placeholder="Relación">
                        </div>
                      </div>

                      <div class="col-md-1">
                        <button type="button" name="button" class="btn btn-success btn-sm add" data-target="familiares1"> + </button>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
              <div class="tab-pane" id="paso4">
                <div class="row justify-content-center">
                  <div class="col-sm-12">
                    <h5 class="info-text"> Dirección y contacto </h5>
                  </div>

                  <div class="col-sm-10">
                    <label for="">Calle y número</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required name="calle" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Colonia</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required name="colonia" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Código postal</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" required name="postal" class="form-control" >
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <label for="">Ciudad</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" required name="ciudad" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Estado</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" required name="estado">
                        <option value="">Selecciona una opción</option>
                        @foreach($estados as $estado)
                        <option value="{{ $estado->estado }}">{{ $estado->estado }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Teléfono</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number"  name="telefono" class="form-control" placeholder="Teléfono">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Celular</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="number" minlength="10" maxlength="10" required name="address" class="form-control" placeholder="Celular">
                    </div>
                  </div>


                </div>
              </div>
              <div class="tab-pane" id="paso5">
                <div class="row justify-content-center">
                  <div class="col-sm-12">
                    <h5 class="info-text"> Ficha médica </h5>
                  </div>

                  <div class="col-sm-5">
                    <label for="">Tipo de sangre</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select id="tipoSangre" class="form-control" name="tipo_de_sangre">
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
                  <div class="col-sm-5">
                    <label for="">¿Tiene alergias?</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control" name="alergias">
                        <option value="">Selecciona una opción:</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-10">
                    <label for="">Describe las alergias</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="descripcion_alergias" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Contacto de emergencia</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="contacto_emergencia" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <label for="">Teléfono contacto de emergencia</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" name="teleffono_emergencia" class="form-control" >
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <p> <br> </p>
                    <h5 class="info-text"> Beneficiarios </h5>

                    <br>
                  </div>

                  <div class="col-md-1">

                  </div>
                  <div class="col-md-11">
                    <div class="row" > <!-- El primer conjunto tiene id="beneficiarios1" -->
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-single-02"></i>
                            </div>
                          </div>
                          <input type="text" name="beneficiario_nombre[]" class="form-control" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-phone"></i>
                            </div>
                          </div>
                          <input type="text" name="beneficiario_telefono[]" class="form-control" placeholder="Teléfono">
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="col-md-1">

                  </div>
                  <div class="col-md-11">
                    <div class="row" > <!-- El primer conjunto tiene id="beneficiarios1" -->
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-single-02"></i>
                            </div>
                          </div>
                          <input type="text" name="beneficiario_nombre[]" class="form-control" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="tim-icons icon-phone"></i>
                            </div>
                          </div>
                          <input type="text" name="beneficiario_telefono[]" class="form-control" placeholder="Teléfono">
                        </div>
                      </div>

                    </div>

                  </div>


                </div>
              </div>
              <div class="tab-pane" id="paso6">
                <div class="row justify-content-center">
                  <div class="col-sm-8">
                    <h5 class="info-text"> ¿Guardar colaborador en base de datos de Nomipaq? </h5>
                  </div>

                  <div class="col-sm-2">
                    <div class="input-group">
                      <input type="checkbox" name="address" class="form-control" placeholder="">
                    </div>
                  </div>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <select class="form-control"  name="base_de_datos">
                        <option value="">Selecciona una opción</option>
                        @foreach($conexiones as $conex)
                        <option value="{{ $conex->name }}">{{ $conex->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>



                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="pull-right">
              <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente' />
              <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Guardar' />
            </div>
            <div class="pull-left">
              <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Anterior' />
            </div>
            <div class="clearfix"></div>
          </div>
        </form>
      </div>
    </div>
    <!-- wizard container -->
  </div>
</div>
@endsection

@push('js')


<script>
  // Obtén la casilla de verificación y la div "row_infonavit"
  var checkbox = document.getElementById("ver_infonavit");
  var rowInfonavit = document.getElementById("row_infonavit");

  // Agrega un evento para detectar cambios en la casilla de verificación
  checkbox.addEventListener("change", function () {
    // Si la casilla de verificación está marcada, muestra la div
    if (checkbox.checked) {
      rowInfonavit.style.display = "block";
    } else {
      // Si la casilla de verificación está desmarcada, oculta la div
      rowInfonavit.style.display = "none";
    }
  });
</script>

<script>

  $(document).ready(function () {
    // Manejar la adición y eliminación de elementos
    $('.add').on('click', function () {
      var targetId = $(this).data('target');
      var $clone = $('#' + targetId).clone();
      var newIndex = $('.row[id^="familiares"]').length + 1;
      var newId = 'familiares' + newIndex;

      // Cambiar el id y name del contenedor clonado
      $clone.attr('id', newId);
      $clone.find('[name]').each(function () {
        var nameAttr = $(this).attr('name');
        $(this).attr('name', nameAttr.replace(/\[\d+\]/, '[' + newIndex + ']'));
      });

      // Cambiar el botón a '-'
      $clone.find('.add').text(' - ').removeClass('add').addClass('remove').data('target', newId);

      // Agregar el clon al final
      $clone.insertAfter($('#' + targetId));
    });

    $('.row').on('click', '.remove', function () {
      $(this).closest('.row').remove();
    });
  });
</script>


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
    $(document).ready(function() {
      // Initialise the wizard
      demo.initNowUiWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
    });
  </script>

  <script>
  $(document).ready(function() {
      $('#id_razon_social').change(function() {
          var company_id = $(this).val();

          // Realizar la solicitud Ajax
          $.ajax({
              url: "{{ route('get.max.employee.number', ':company_id') }}".replace(':company_id', company_id),
              type: 'GET',
              success: function(response) {
                  // Sumar 1 al número máximo obtenido
                  var maxEmployeeNumber = response.max_employee_number + 1;
                  $('#numero_de_empleado').val(maxEmployeeNumber);
              },
              error: function(xhr, status, error) {
                  console.error(error);
              }
          });
      });
  });
  </script>
@endpush
