@extends('layouts.app', ['activePage' => 'Bajas', 'menuParent' => 'laravel', 'titlePage' => __('Bajas')])

@section('content')

<style>
.view_sd {
    display: none;
}
.readonly{ border:none; background:none!important; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@php
  $sd=$salario_diario;
  $sdi=0;
  $sn=0;
@endphp

  <div class="content" id="contenido">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Alerta de éxito -->
                <div class="alert alert-success" id="alert-success" style="display: none;">
                    Datos actualizados
                </div>

                <!-- Alerta de error -->
                <div class="alert alert-danger" id="alert-danger" style="display: none;">
                    Error al actualizar datos.
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Baja</h4>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('restaurarBaja') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $baja->id }}" name="baja_id">
                                    <button class="btn btn-info">Reestablecer proceso de baja</button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('cancelarBaja') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $baja->id }}" name="baja_id">
                                    <button class="btn btn-danger">Cancelar proceso de baja</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tramitar') }}" method="post">
                        @csrf
                          <div class="row">
                              <div class="col-md-12">
                                  <h3>{{ qcolab($baja->colaborador_id) }}</h3>
                                  <input type="hidden" id="idcolaborador" name="idcolaborador" value="{{ $baja->colaborador_id }}">
                                  <input type="hidden" id="idbaja" name="idbaja" value="{{ $baja->id }}">

                                  <?php
                                  $fechaFormateada1 = isset($datosBaja) && $datosBaja->fecha_alta
                                      ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_alta)->format('Y-m-d')
                                      : \Carbon\Carbon::createFromFormat('d / m / Y', $falta)->format('Y-m-d');
                                  ?>
                                  <p>Fecha alta:</p>
                                  <input type="date" class="form-control" name="falta" id="fechaAlta" value="{{ $fechaFormateada1 }}">
                                  <?php
                                   // Eliminar los espacios adicionales
                                    $faltaLimpia = str_replace(' ', '', $falta);

                                    // Convertir la fecha limpia a un objeto DateTime
                                    $fechaAlta = DateTime::createFromFormat("d/m/Y", $faltaLimpia);

                                    // Verificar si la conversión fue exitosa
                                    if (!$fechaAlta) {
                                        echo "La fecha de alta es inválida o no coincide con el formato d/m/Y.";
                                        exit;
                                    }

                                    // Fecha actual
                                    $fechaHoy = new DateTime();

                                    // Calcular la diferencia en años completos
                                    $diferencia = $fechaAlta->diff($fechaHoy);

                                    // Obtener el número de años completos
                                    $aniosCompletos = $diferencia->y;
                                  ?>
                                  <p>Años trabajado: <span id="anios_de_servicio">{{ $aniosCompletos }}</span> </p>
                              </div>

                              <div class="col-md-4">
                                  <p>Tipo de baja:</p>
                                  <select class="form-control" name="motivo" id="motivoBaja">
                                      <option value="{{ $baja->motivo }}">{{ $baja->motivo }}</option>
                                      <option value="Renuncia">Renuncia</option>
                                      <option value="Baja solicitada">Baja solicitada</option>
                                  </select>
                              </div>

                              <div class="col-md-4">
                                  <p>Fecha Baja:</p>
                                  <?php
                                  // Verificar si $datosBaja->fecha_baja está definido y no es nulo
                                  $fechaFormateada = isset($datosBaja) && $datosBaja->fecha_baja
                                      ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_baja)->format('Y-m-d')
                                      : \Carbon\Carbon::createFromFormat('d / m / Y', $fbaja)->format('Y-m-d');
                                  ?>
                                  <input type="date" class="form-control" name="fechabajad" id="fechaBaja" value="{{ $fechaFormateada }}">
                                  <?php
                                    $fechaArray = explode('-', $fechaFormateada);
                                    $diatransc = 0;
                                    // Verificar si se separó correctamente y obtener el día
                                    if (count($fechaArray) === 3) {
                                        $diatransc = $fechaArray[2]; // El día estará en la primera posición

                                    } else {
                                        $diatransc = 0;
                                    }
                                    $fechaBaja = \Carbon\Carbon::parse($fechaFormateada);

                                    // Calcular el número del día del año
                                    $numeroDiaAnio = $fechaBaja->dayOfYear;
                                    ?>
                                    <p>Días transcurridos del mes <span id="dias_transcurridos">{{$diatransc}}</span> </p>


                                     <p>Días transcurridos del año <span id="dias_transcurridos_anio">{{ $numeroDiaAnio }}</span> </p>

                                     <?php

                                        $fechaAltanva = isset($datosBaja) && $datosBaja->fecha_alta
                                        ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_alta)->format('Y-m-d')
                                        : \Carbon\Carbon::createFromFormat('d / m / Y', $falta)->format('Y-m-d');

                                        $fechaBajanva = isset($datosBaja) && $datosBaja->fecha_baja
                                        ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_baja)->format('Y-m-d')
                                        : \Carbon\Carbon::createFromFormat('d / m / Y', $fbaja)->format('Y-m-d');

                                        // Crear objetos Carbon
                                        $fechaAltaCarbon = \Carbon\Carbon::parse($fechaAltanva);
                                        $fechaBajaCarbon = \Carbon\Carbon::parse($fechaBajanva);

                                        // Ajustar el año de la fecha alta
                                        $fechaAltaAjustadatres = $fechaAltaCarbon->setYear($fechaBajaCarbon->year);

                                        // Calcular la diferencia en días
                                        $diferenciaDiasesteanio = $fechaAltaAjustadatres->diffInDays($fechaBajaCarbon);
                                     ?>
                                     <p>Días trabajados <span id="dias_trabajados">{{ $diferenciaDiasesteanio }}</span> </p>

                                        <?php
                                                                            // Formatear y ajustar las fechas
                                                                            $fechaAlta = isset($datosBaja) && $datosBaja->fecha_alta
                                                                            ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_alta)->format('Y-m-d')
                                                                            : \Carbon\Carbon::createFromFormat('d / m / Y', $falta)->format('Y-m-d');

                                                                        $fechaBaja = isset($datosBaja) && $datosBaja->fecha_baja
                                                                            ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_baja)->format('Y-m-d')
                                                                            : \Carbon\Carbon::createFromFormat('d / m / Y', $fbaja)->format('Y-m-d');

                                                                        // Crear objetos Carbon
                                                                        $fechaAltaCarbon = \Carbon\Carbon::parse($fechaAlta);
                                                                        $fechaBajaCarbon = \Carbon\Carbon::parse($fechaBaja);

                                                                        // Calcular años completos trabajados
                                                                        $aniosCompletos = $fechaAltaCarbon->diffInYears($fechaBajaCarbon);

                                                                        // Calcular el proporcional del último año incompleto
                                                                        $inicioUltimoAnio = $fechaAltaCarbon->copy()->addYears($aniosCompletos);
                                                                        $diasTrabajadosUltimoAnio = $inicioUltimoAnio->diffInDays($fechaBajaCarbon);

                                                                        // Proporcional de los días (12 días por año)
                                                                        $diasPorAnio = 12;
                                                                        $diasProporcionales = ($diasTrabajadosUltimoAnio / 365) * $diasPorAnio;

                                                                        // Total de días
                                                                        $totalDias = ($aniosCompletos * $diasPorAnio) + $diasProporcionales;

                                                                        // Mostrar los cálculos
                                                                        ?>

                              </div>

                              <div class="col-md-4">
                                  <p>Fecha Elaboración:</p>
                                  <input type="date" class="form-control" name="fecha_elaboracion" id="fecha_elaboracion" value="{{ $datosbaja->fecha_elaboracion ?? date('Y-m-d') }}">
                              </div>
                          </div>
                            <div class="row" style="margin-top: 50px;">
                                <!-- Salario Diario -->
                                <div class="col-md-3">
                                    <div class="text-left">
                                        @if ($datosbaja)
                                            <input type="radio" id="sd" name="salario_diario"
                                                   value="{{ $salario_diario }}"
                                                   {{ $datosbaja->salario_diario == $salario_diario ? 'checked' : '' }}
                                                   onclick="updateSalarioSeleccionado('sd')">
                                        @else
                                            <input type="radio" id="sd" name="salario_diario"
                                                   value="{{ $salario_diario }}"
                                                   checked
                                                   onclick="updateSalarioSeleccionado('sd')">
                                        @endif
                                    </div>
                                    <p>Salario diario</p>
                                    <h3>${{ number_format($salario_diario, 2) }}</h3>
                                </div>

                                <!-- Salario Diario Integrado -->
                                <div class="col-md-3">
                                    <div class="text-left">
                                        @if ($datosbaja)
                                            <input type="radio" id="sdi" name="salario_diario"
                                                   value="{{ $salario_diario_integrado }}"
                                                   {{ $datosbaja->salario_diario == $salario_diario_integrado ? 'checked' : '' }}
                                                   onclick="updateSalarioSeleccionado('sdi')">
                                        @else
                                            <input type="radio" id="sdi" name="salario_diario"
                                                   value="{{ $salario_diario_integrado }}"
                                                   onclick="updateSalarioSeleccionado('sdi')">
                                        @endif
                                    </div>
                                    <p>Salario diario integrado</p>
                                    <h3>${{ number_format($salario_diario_integrado, 2) }}</h3>
                                </div>

                                <!-- Salario Diario Nuevo -->
                                <div class="col-md-3">
                                    <div class="text-left">
                                        @if ($datosbaja)
                                            <input type="radio" id="sdn" name="salario_diario"
                                                   value="{{ $salario_diario_integrado }}"
                                                   {{ $datosbaja->salario_diario == $salario_diario_integrado ? 'checked' : '' }}
                                                   onclick="updateSalarioSeleccionado('sdn')">
                                        @else
                                            <input type="radio" id="sdn" name="salario_diario"
                                                   value="{{ $salario_diario_integrado }}"
                                                   onclick="updateSalarioSeleccionado('sdn')">
                                        @endif
                                    </div>
                                    <p>Salario diario (nuevo)</p>
                                    <input value="{{ number_format($datosbaja->salario_nuevo ?? $salario_diario, 2) }}" class="form-control" id="salario_diario_nuevo_valor" name="salario_diario_nuevo_valor">
                                </div>

                                <!-- Input hidden para el ID de la baja -->
                                <div class="col-md-3">
                                    <input type="hidden" id="idbaja" value="{{ $baja->id }}">
                                    <button type="button" id="toggle-button" class="btn btn-link">
                                        <i class="fas fa-eye"></i> Editar
                                    </button>
                                    <input type="hidden" class="form-control" id="salario_seleccionado" name="salario_seleccionado" readonly>
                                    <div class="form-group view_sd">
                                        <br>
                                        <label for="">Salario mínimo</label>
                                        <input type="text" id="salario_minimo" value="207.44">
                                        <br>
                                        <label for="">uma</label>
                                        <input type="text" id="uma" value="108.57">
                                    </div>
                                </div>
                            </div>




                            <input type="hidden" name="anio" value="{{ $aniostrabajados }}">
                        <input type="hidden" name="colaborador_id" value="{{ $baja->colaborador_id }}">
                        <div class="row">
                          <!-- Tabla de Percepciones -->
                          <div class="col-md-6">
                              <div class="table-responsive h-100 w-100 overflow-hidden" id="categories-table">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>Percepciones</th>
                                              <th class="view_sd">SD</th>
                                              <th>Días</th>
                                              <th>Monto</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>SALARIO NORMAL</td>
                                              <td class="view_sd">
                                                <select class="" id="s_salario" name="s_salario">
                                                <option value="sd" {{ isset($datosbaja) && $datosbaja->s_salario_normal == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_salario_normal == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_salario_normal == 'sdn' ? 'selected' : '' }}>sdn</option>


                                            </select>
                                              </td>
                                               <td id="dias"> <input type="text" class="form-control" name="dias" value="{{ $datosbaja->d_salario_normal ?? $aldiadehoy }}"> </td>
                                                @php
                                                    $monto = $datosbaja->salario_normal ?? ($sd * $aldiadehoy);
                                                    $montoFormateado = number_format($monto, 2);
                                                @endphp
                                              <td><input type="text" name="monto_dias" readonly id="monto_dias" class="form-control readonly" value="{{ $montoFormateado }}"></td>
                                          </tr>

                                          <tr>
                                           <?php
                                                $diasapagar=$datosbaja->d_aguinaldo ?? $diasapagar;
                                                $d2_aguinaldo=$datosbaja->d2_aguinaldo ?? number_format($diasaguinaldo,2);
                                                $aguinaldo=number_format($sd*$d2_aguinaldo,2) ?? number_format($sd*$diasaguinaldo,2);
                                                ?>
                                              <td>AGUINALDO</td>
                                              <td class="view_sd">
                                                <select class="" id="s_aguinaldo" name="s_aguinaldo">
                                                <option value="sd" {{ isset($datosbaja) && $datosbaja->s_aguinaldo == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_aguinaldo == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_aguinaldo == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                              <td>
                                                  <div class="input-group">
                                                      <select class="text-center" name="diaspagaraguinaldo">
                                                        <option value="{{ $datosbaja->d_aguinaldo ?? $diasapagar }}">{{ $datosbaja->d_aguinaldo ?? $diasapagar }}</option>

                                                        @if (($datosbaja->d_aguinaldo ?? $diasapagar) != 15)
                                                            <option value="15">15</option>
                                                        @endif

                                                        @if (($datosbaja->d_aguinaldo ?? $diasapagar) != 20)
                                                            <option value="20">20</option>
                                                        @endif

                                                        @if (($datosbaja->d_aguinaldo ?? $diasapagar) != 25)
                                                            <option value="25">25</option>
                                                        @endif

                                                        @if (($datosbaja->d_aguinaldo ?? $diasapagar) != 30)
                                                            <option value="30">30</option>
                                                        @endif
                                                    </select>

                                                      <input type="text" name="diasaguinaldo" id="diasaguinaldo" class="form-control" value="{{ $datosbaja->d2_aguinaldo ?? number_format($diasaguinaldo,2) }}">
                                                  </div>
                                              </td>
                                              <td><input type="text" name="monto_aguinaldo" readonly id="monto_aguinaldo" class="form-control readonly" value="{{ $aguinaldo }}"></td>
                                          </tr>

                                          <tr>
                                              <td>VACACIONES</td>

                                              <td class="view_sd">
                                                <select class="" id="s_vacaciones" name="s_vacaciones">
                                                <option value="sd" {{ isset($datosbaja) && $datosbaja->s_vacaciones == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_vacaciones == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_vacaciones == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                               <td id="dias_vacaciones"> <input type="text" class="form-control" name="dias_vacaciones" value="{{ $datosbaja->d_vacaciones ?? vacacionesActuales($baja->colaborador_id) }}"> </td>
                                              <td><input type="text" name="monto_vacaciones" readonly id="monto_vacaciones" class="form-control readonly" value="{{ $datosbaja->vacaciones }}"></td>
                                          </tr>

                                          <tr>
                                              <td>VACACIONES Pend</td>
                                              <td class="view_sd">
                                                <select class="" id="s_vacaciones_pend" name="s_vacaciones_pend">
                                                <option value="sd" {{ isset($datosbaja) && $datosbaja->s_vacaciones_pend == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_vacaciones_pend == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_vacaciones_pend == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                               <td id="dias_vacaciones_pend"> <input type="text" class="form-control" name="dias_vacaciones_pend" value="{{ $datosbaja->d_vacaciones_pend ?? vacacionesPendientes($baja->colaborador_id) }}"> </td>
                                              <td><input type="text" name="monto_vacaciones_pend" readonly id="monto_vacaciones_pend" class="form-control readonly" value="{{ $datosbaja->vacaciones_pend }}"></td>
                                          </tr>

                                          <tr>
                                              <td>PRIMA VACACIONAL</td>
                                              <td class="view_sd">

                                              </td>
                                              <td>
                                                  <div class="input-group">
                                                      <input type="text" class="form-control" id="d_primavacacional" name="d_primavacacional" value="{{ $datosbaja->d_prima_vacacional ?? '25' }}">
                                                      <input type="text" class="form-control text-center" disabled value="%" style="width: 30px;">
                                                  </div>
                                              </td>


                                              <td><input type="text" name="monto_prima_vacacional" readonly id="monto_prima_vacacional" class="form-control readonly" value="{{ $datosbaja->prima_vacacional ?? '0' }}"></td>

                                          </tr>

                                          <tr>
                                              <td>PRIMA VACACIONAL Pend</td>
                                              <td class="view_sd">

                                              </td>
                                              <td>
                                                  <div class="input-group">
                                                      <input type="text" class="form-control" id="d_primavacacional_pend" name="d_primavacacional_pend" value="{{ $datosbaja->d_primavacacional_pend ?? '0' }}">
                                                      <input type="text" class="form-control text-center" disabled value="%" style="width: 30px;">
                                                  </div>
                                              </td>


                                              <td><input type="text" name="monto_prima_vacacional_pend" readonly id="monto_prima_vacacional_pend" class="form-control readonly" value="{{ $datosbaja->prima_vacacional_pend ?? '0' }}"></td>

                                          </tr>

                                          <tr>
                                                @php
                                                    // Verifica si el motivo es "Renuncia"
                                                    if ($baja->motivo === 'Renuncia') {
                                                        // Si es renuncia, se usa el valor del incentivo si existe, si no es cero
                                                        $dincentivo = $datosbaja->d_incentivo ?? '0';
                                                    } else {
                                                        // Si no es renuncia, se usa el cálculo que ya tenías
                                                        $dincentivo = $datosbaja->d_incentivo ?? '20';
                                                    }
                                                @endphp
                                              <td>INCENTIVO</td>
                                              <td class="view_sd">
                                              <select class="" id="s_incentivo" name="s_incentivo">
                                              <option value="sd" {{ isset($datosbaja) && $datosbaja->s_incentivo == 'sd' ? 'selected' : '' }}>sd</option>
                                            <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_incentivo == 'sdi' ? 'selected' : '' }}>sdi</option>
                                            <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_incentivo == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                              <td>
                                                  <div class="input-group">
                                                      <input type="text" class="form-control" name="d_incentivo" id="d_incentivo" value="{{ $datosbaja->d_prima_vacacional ?? $dincentivo }}">
                                                      <input type="text" class="form-control text-center" disabled value="%" style="width: 30px;">
                                                  </div>
                                              </td>

                                              <td><input type="text" name="monto_incentivo" readonly id="monto_incentivo" class="form-control readonly" value="{{ $datosbaja->incentivo ?? '0' }}"></td>
                                          </tr>

                                          <tr>
                                              <td>PRIMA DE ANTIGÜEDAD</td>
                                              <td class="view_sd">
                                              <select  id="s_prima_de_antiguedad" name="s_prima_de_antiguedad">
                                                <option value="sd" {{ isset($datosbaja) && $datosbaja->s_prima_de_antiguedad == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_prima_de_antiguedad == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_prima_de_antiguedad == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" name="d_prima_de_antiguedad" id="d_prima_de_antiguedad">
                                              </td>
                                              <td><input type="text" name="monto_prima_de_antiguedad" readonly  id="monto_prima_de_antiguedad" class="form-control readonly" value="{{ $datosbaja->prima_de_antiguedad ?? '0' }}"></td>
                                          </tr>

                                          <tr>
                                             @php
                                            $montoGratificacion = $datosbaja->d_gratificacion ?? '90';
                                            @endphp
                                              <td>GRATIFICACION</td>
                                              <td class="view_sd">
                                              <select class="" id="s_gratificacion" name="s_gratificacion">
                                              <option value="sd" {{ isset($datosbaja) && $datosbaja->s_gratificacion == 'sd' ? 'selected' : '' }}>sd</option>
                                            <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_gratificacion == 'sdi' ? 'selected' : '' }}>sdi</option>
                                            <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_gratificacion == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                              </td>
                                              <td>
                                                  @php
                                                    // Verifica si el motivo es "Renuncia"
                                                    if ($baja->motivo === 'Renuncia') {
                                                        // Si es renuncia, usa el valor de d_gratificacion si existe, si no, es cero
                                                        $montoGratificacion = $datosbaja->d_gratificacion ?? '0';
                                                    } else {
                                                        // Si no es renuncia, se usa el cálculo o el valor de d_gratificacion si existe
                                                        $montoGratificacion = $datosbaja->d_gratificacion ?? (90 * $sdi);
                                                    }
                                                @endphp
                                                <input type="text" class="form-control" name="d_gratificacion" id="d_gratificacion" value="{{ $datosbaja->d_gratificacion ?? '0' }}">
                                              </td>
                                              <td><input type="text" name="monto_gratificacion" readonly id="monto_gratificacion" class="form-control readonly" value="{{ $datosbaja->gratificacion ?? '0' }}"></td>
                                          </tr>

                                          <tr>
                                           @php
                                                // Verifica si el motivo es renuncia
                                                if ($baja->motivo === 'Renuncia') {
                                                    // Si es renuncia, se verifica si hay un valor en d_veinte_dias
                                                    $vdias = $datosbaja->d_veinte_dias ?? 0; // Por defecto en cero
                                                } else {
                                                    // Si no es renuncia, se calcula el monto normalmente
                                                    $vdias = $datosbaja->d_veinte_dias ?? $aniosCompletos;
                                                }
                                            @endphp

                                              <td>20 DIAS POR AÑO</td>

                                              <td class="view_sd">
                                              <select class="" id="s_veinte_dias" name="s_veinte_dias">
                                              <option value="sd" {{ isset($datosbaja) && $datosbaja->s_veinte_dias == 'sd' ? 'selected' : '' }}>sd</option>
                                                <option value="sdi" {{ isset($datosbaja) && $datosbaja->s_veinte_dias == 'sdi' ? 'selected' : '' }}>sdi</option>
                                                <option value="sdn" {{ isset($datosbaja) && $datosbaja->s_veinte_dias == 'sdn' ? 'selected' : '' }}>sdn</option>

                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" name="d_veinte_dias" id="d_veinte_dias" value="{{ $datosbaja->d_veinte_dias ?? $vdias }}">
                                              </td>
                                              <td><input type="text" name="monto_veinte_dias" readonly id="monto_veinte_dias" class="form-control readonly" value="{{ $datosbaja->veinte_dias ?? '0' }}"></td>
                                          </tr>

                                          <tr>
                                              <td>DESPENSA</td>
                                                    <td class="view_sd">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                        <input type="text" class="form-control" name="monto_despensa" value="{{ $datosbaja->d_despensa ?? '0' }}">
                                                            <input type="text" class="form-control text-center" disabled value="%" style="width: 30px;">
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="despensa"  id="despensa" class="form-control" value="{{ $datosbaja->despensa ?? '0' }}"></td>
                                            </tr>

                                          <tr>
                                               @php
                                                // Define el valor total de las percepciones
                                                    $totalPercepciones = $datosbaja->percepciones ?? $totalPercepciones;
                                                @endphp
                                              <td colspan="2">Total percepciones<input type="hidden" name="totalPercepciones" value="{{ $totalPercepciones }}"> </td>
                                              <td class="view_sd"></td>
                                              <td><input type="text" name="totalPercepciones" readonly id="totalPercepciones" class="form-control readonly" value="{{ $totalPercepciones }}" style="font-weight:bolder; font-size:12pt;"></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <!-- Tabla de Deducciones -->
                          <div class="col-md-6">
                              <div class="table-responsive h-100 w-100 overflow-hidden" id="categories-table">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>Deducciones</th>
                                              <th class="view_sd">SD</th>
                                              <th>Monto</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>I.S.R.</td>
                                              <td class="view_sd">
                                                <select class="form-control">
                                                  <option selected>SD</option>
                                                  <option>SDI</option>
                                                  <option>SN</option>
                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" id="isr" name="isr" value="{{ $datosbaja->isrfinal ?? '0.00' }}">
                                              </td>
                                          </tr>

                                          <tr>
                                              <td>I.M.S.S.</td>
                                              <td class="view_sd">
                                                <select class="form-control">
                                                  <option selected>SD</option>
                                                  <option>SDI</option>
                                                  <option>SN</option>
                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" id="imss" name="imss" value="{{ $datosbaja->imss ?? '0.00' }}">
                                              </td>
                                          </tr>

                                          <tr>
                                              <td>DEUDORES</td>
                                              <td class="view_sd">
                                                <select class="form-control">
                                                  <option selected>SD</option>
                                                  <option>SDI</option>
                                                  <option>SN</option>
                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" id="deudores" name="deudores" value="{{ $datosbaja->deudores ?? '0.00' }}">
                                              </td>
                                          </tr>

                                          <tr>
                                              <td>ISR FINIQUITO</td>
                                              <td class="view_sd">
                                                <select class="form-control">
                                                  <option selected>SD</option>
                                                  <option>SDI</option>
                                                  <option>SN</option>
                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" class="form-control" id="isr_finiquito" name="isr_finiquito" value="{{ $datosbaja->isr_finiquito ?? '0.00' }}">
                                              </td>
                                          </tr>
                                             @php
                                                $totalDeducciones = $datosbaja->deducciones ?? $totalDeducciones;
                                            @endphp
                                          <tr>
                                              <td>Total deducciones<input type="hidden" name="totalDeducciones" value="{{ $totalDeducciones }}"></td>
                                              <td class="view_sd"></td>
                                              <td><b>$<span id="totalDeducciones">{{ number_format($datosbaja->deducciones ?? $totalDeducciones, 2) }}</span></b></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <!-- Total Neto a Recibir -->
                          <div class="col-md-12">
                              <label>TOTAL NETO A RECIBIR</label>

                              @php
                                // Define el valor total y limpia los signos de pesos y comas
                                $valorTotal = $datosbaja->total ?? $total;
                                $valorTotal = preg_replace('/[^\d.]/', '', $valorTotal);

                                // Formatea el valor total con dos decimales
                                $valorTotalFormateado = number_format((float)$valorTotal, 2);
                            @endphp

                          </div>
                          <div class="col-md-2">
                             <input type="text" name="total" class="form-control" id="supertotal" readonly value="{{ $valorTotalFormateado }}">
                          </div>

                          <!-- Botón para guardar -->
                          <div class="col-md-12 text-center">
                              <input type="hidden" name="id_baja" value="{{ $baja->id }}">
                              <br>
                              <button type="submit" class="btn btn-info" name="guardar">Guardar</button>
                          </div>
                      </div>

                </form>


                        @if($datosbaja)
                  <br>
                  <div class="row">
                    <div class="col-12 text-center">
                      <form class="" action="{{ route('pdfFiniquito') }}" method="post">
                          @csrf
                          <input type="hidden" name="datosbajaid" value="{{$datosbaja->id ?? '0'}}">
                          <input type="hidden" name="colaborador_id" value="{{$baja->colaborador_id}}">
                          <button type="submit" class="btn btn-link">Imprimir formato</button>
                      </form>
                    </div>
                  </div>
                  <br>
                  <form class="" action="{{ route('comprobante_pago') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      @if($baja->comprobante)
                      <div class="col-md-12 text-center">
                        <a href="/storage/app/public/{{ $baja->comprobante }}" target="_blank">Descargar comprobante</a>
                      </div>
                      @endif
                      <div class="col-md-12 text-center">
                        <div class="">
                          <br><br><br>
                          <label for="">Comprobante de pago</label>
                          <br>
                          <input type="file" name="comprobante" value="" required>
                        </div>
                        <div class="">
                          <br>
                          <input type="hidden" name="baja_id" value="{{ $baja->id }}">
                          <button type="submit" class="btn btn-info" name="button">Subir comprobante</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  @endif


                  @if($baja->comprobante)
                  <div class="col-md-12 text-center">
                    <form class="" action="{{ Route('desvincular') }}" method="post">
                      @csrf
                      <br>
                      <input type="hidden" name="colaborador_id" value="{{$colaborador->id}}">
                      <input type="hidden" name="motivo" value="{{$baja->motivo}}">
                      <input type="hidden" name="baja_id" value="{{$baja->id}}">
                      <input type="hidden" name="fecha_baja" value="{{$baja->fecha_baja}}">
                      <button type="submit" class="btn btn-info" name="submit">Desvincular colaborador</button>
                    </form>
                  </div>
                  @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggle-button').click(function() {
            $('.view_sd').toggle(); // Alterna entre mostrar y ocultar

            // Cambia el ícono dependiendo del estado
            var icon = $(this).find('i');
            if (icon.hasClass('fa-eye')) {
                icon.removeClass('fa-eye').addClass('fa-eye-slash'); // Cambiar a 'ocultar'
            } else {
                icon.removeClass('fa-eye-slash').addClass('fa-eye'); // Cambiar a 'mostrar'
            }
        });
    });

</script>

<script>
    // Aplicar formato de moneda con Cleave.js
    new Cleave('#salario_diario', {
        prefix: '$',                     // Agregar símbolo de pesos
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalMark: '.',
        delimiter: ',',                   // Usar coma para los miles
        numeralDecimalScale: 2,           // Forzar 2 decimales
        numeralPositiveOnly: true         // Solo números positivos
    });
</script>

<script>
    // Función para actualizar el campo de salario seleccionado
    function updateSalarioSeleccionado(salario) {
        document.getElementById('salario_seleccionado').value = salario;
        recalcularTodo();
    }

    // Al cargar la página, verificar qué radio está seleccionado y actualizar el input
    window.onload = function() {
        const radioChecked = document.querySelector('input[name="salario_diario"]:checked');
        if (radioChecked) {
            updateSalarioSeleccionado(radioChecked.id);
            calcularISR();
        }
    };
</script>
<script>
    $(document).ready(function(){
        // Escucha el cambio del select
        $('#motivoBaja').change(function(){
            var motivoBaja = $(this).val(); // Obtén el valor seleccionado
            var colaboradorId = $('#idcolaborador').val(); // Obtén el ID del colaborador

            // Realiza la petición AJAX
            $.ajax({
                url: "{{ route('actualizarMotivoBaja') }}",  // Ruta para actualizar el motivo
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // Token CSRF
                    motivo: motivoBaja,
                    colaborador_id: colaboradorId
                },
                success: function(response) {
                    if(response.success) {
                        // Muestra el mensaje de éxito
                        $('#alert-success').text('Motivo de baja actualizado correctamente.').fadeIn().delay(3000).fadeOut();
                        recalcularTodo();
                    } else {
                        // Si no es exitoso, muestra el mensaje de error
                        $('#alert-danger').text('No se pudo actualizar el motivo de baja.').fadeIn().delay(3000).fadeOut();
                    }
                },
                error: function(xhr, status, error) {
                    // Muestra el mensaje de error en caso de fallo de la petición
                    $('#alert-danger').text('Error al actualizar el motivo de baja.').fadeIn().delay(3000).fadeOut();
                }
            });
        });
    });
</script>

    <script>
        $('#fechaBaja').change(function(){
            var nuevaFechaBaja = $(this).val(); // Obtén el valor de la nueva fecha
            var colaboradorId = $('#idcolaborador').val(); // Obtén el ID del colaborador
            let idBaja = document.getElementById('idbaja').value;


            // Realiza la petición AJAX para actualizar la fecha de baja
            $.ajax({
                url: "{{ route('actualizarFechaBaja') }}",  // Ruta para actualizar la fecha
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // Token CSRF
                    fecha_baja: nuevaFechaBaja,
                    colaborador_id: colaboradorId,
                    idBaja: idBaja,
                },
                success: function(response) {

                    if(response.success) {
                        $('#alert-success').text(response.message).fadeIn().delay(3000).fadeOut();
                        recalcularTodo();
                        calcularISR();
                    } else {
                        $('#alert-danger').text(response.message).fadeIn().delay(3000).fadeOut();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error de AJAX: ", error);
                    var errorMessage = xhr.responseJSON.message || 'Error desconocido';
                    $('#alert-danger').text(errorMessage).fadeIn().delay(3000).fadeOut();
                }
            });
        });

    </script>


    <script>
        $('#fecha_elaboracion').change(function(){
            var nuevaFechaElaboracion = $(this).val(); // Obtén el valor de la nueva fecha de elaboración
            var colaboradorId = $('#idcolaborador').val(); // Obtén el ID del colaborador

            console.log("Fecha de elaboración seleccionada: " + nuevaFechaElaboracion);
            console.log("Colaborador ID: " + colaboradorId);

            // Realiza la petición AJAX para actualizar la fecha de elaboración
            $.ajax({
                url: "{{ route('actualizarFechaElaboracion') }}",  // Ruta para actualizar la fecha
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // Token CSRF
                    fecha_elaboracion: nuevaFechaElaboracion,
                    colaborador_id: colaboradorId
                },
                success: function(response) {
                    console.log("Respuesta del servidor: ", response);
                    if(response.success) {
                        $('#alert-success').text(response.message).fadeIn().delay(3000).fadeOut();
                        recalcularTodo();
                        calcularISR();
                    } else {
                        $('#alert-danger').text(response.message).fadeIn().delay(3000).fadeOut();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error de AJAX: ", error);
                    var errorMessage = xhr.responseJSON.message || 'Error desconocido';
                    $('#alert-danger').text(errorMessage).fadeIn().delay(3000).fadeOut();
                }
            });
        });

    </script>

<script>
    function updateSalarioSeleccionado(tipo) {
        // Obtener el salario seleccionado (radio button marcado)
        let salarioSeleccionado = document.querySelector('input[name="salario_diario"]:checked').id;

        // Obtener los valores de los salarios
        let salarioDiario = document.getElementById('sd').value;  // Valor del radio button 'salario_diario'
        let salarioDiarioIntegrado = document.getElementById('sdi').value;  // Valor del radio button 'salario_diario_integrado'
        let salarioNuevo = document.getElementById('sdn').value;  // Valor del radio button 'salario_diario_nuevo'
        let salario_diario_nuevo_valor = document.getElementById('salario_diario_nuevo_valor').value;
        // Obtener el ID de la baja
        let idBaja = document.getElementById('idbaja').value;



        // Realizar la solicitud AJAX para actualizar la tabla
        $.ajax({
            url: '/ruta/actualizar-salario',  // Cambiar por la ruta adecuada
            method: 'POST',
            data: {
                idbaja: idBaja,
                salario_seleccionado: salarioSeleccionado,
                salario_diario: salarioDiario,
                salario_diario_integrado: salarioDiarioIntegrado,
                salario_nuevo: salarioNuevo,
                salario_diario_nuevo_valor: salario_diario_nuevo_valor,
                _token: '{{ csrf_token() }}'  // Token CSRF
            },
            success: function(response) {
                // Manejar la respuesta del servidor si es necesario
                console.log(response);
                // Actualizar el campo oculto con el salario seleccionado
                $('#salario_seleccionado').val(response.salario_seleccionado);
                recalcularTodo();
                calcularISR();
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
            }
        });
    }

</script>


<script>
    $(document).ready(function () {
        // Detectar cambio en el select de salario
        $('#s_salario').change(function () {
            updateMontoDias();
        });

        // Detectar cambio en el input de días
        $('input[name="dias"]').on('input', function () {
            updateMontoDias();
        });

        function updateMontoDias() {
            // Obtener el valor seleccionado en el select
            var salarioSeleccionado = $('#s_salario').val();

            // Obtener los valores de salario correspondientes a cada opción
            var salarioValues = {
                'sd': $('#sd').val(), // valor para "sd"
                'sdi': $('#sdi').val(), // valor para "sdi"
                'sdn': $('#salario_diario_nuevo_valor').val() // valor para "sdn"
            };

            // Obtener el valor de días
            var dias = parseFloat($('input[name="dias"]').val()) || 0;

            // Obtener el salario correspondiente al valor seleccionado
            var salario = salarioValues[salarioSeleccionado] || 0;

            // Realizar el cálculo del monto
            var monto = salario * dias;

            // Mostrar el resultado formateado en el campo "monto_dias"
            $('#monto_dias').val(monto.toFixed(2));

            let idBaja = document.getElementById('idbaja').value;



            // Enviar los datos por AJAX a una nueva ruta
            $.ajax({
                url: '/ruta/actualizar-dias-de-salario',  // Cambia esta URL por la ruta que necesitas
                method: 'POST',
                data: {
                    idbaja: idBaja,
                    salario: salarioSeleccionado,
                    dias: dias,
                    monto_dias: monto.toFixed(2),
                    _token: '{{ csrf_token() }}'  // Incluye el token CSRF para proteger la solicitud
                },
                success: function (response) {
                    // Limpiar mensajes anteriores
                    $('#alert-success').hide();
                    $('#alert-danger').hide();

                    // Verificar la respuesta del servidor para mostrar el mensaje
                    if (response.success) {
                        $('#alert-success').text(response.message).show().fadeOut(3000);
                        recalcularTodo();
                        calcularISR();

                    } else {
                        $('#alert-danger').text(response.message).show().fadeOut(3000);
                    }
                },
                error: function () {
                    // Limpiar mensajes anteriores
                    $('#alert-success').hide();
                    $('#alert-danger').hide();

                    // Mostrar el mensaje de error en caso de falla
                    $('#alert-danger').text('Error al actualizar los datos.').show().fadeOut(3000);
                }
            });
        }

        // Llamar a la función para inicializar el valor al cargar la página
        updateMontoDias();
        calcularSuma();
    });
</script>

<script>
    $(document).ready(function () {
        // Detectar cambios en el select de días a pagar y en los inputs
        $('select[name="diaspagaraguinaldo"], #diasaguinaldo, #s_aguinaldo').on('change input', function () {
            calcularAguinaldo();
        });

        function calcularAguinaldo() {
            // Obtener valores
            var diasPagarAguinaldo = $('select[name="diaspagaraguinaldo"]').val();
            var diasAguinaldo = parseFloat($('#diasaguinaldo').val()) || 0;
            var salarioSeleccionado = $('#s_aguinaldo').val();

            var anios_de_servicio = parseFloat($('#anios_de_servicio').text()) || 0;

            var fechaBaja = document.getElementById('fechaBaja').value;
            var fecha = new Date(fechaBaja);

            var fechaIngreso = document.getElementById('fechaBaja').value;


            var fechaAlta = document.getElementById('fechaAlta').value;
            var fecha_alta = new Date(fechaAlta);

            var difdiasfechas=0;

            if(anios_de_servicio>1){
                // Obtener el primer día de enero del mismo año
            var primerDiaEnero = new Date(fecha.getFullYear(), 0, 1);

            // Calcular la diferencia en milisegundos entre el primer día de enero y la fecha seleccionada
            var diferenciaEnTiempo = fecha - primerDiaEnero;

            // Convertir la diferencia en milisegundos a días
            var diasTranscurridos = Math.floor(diferenciaEnTiempo / (1000 * 60 * 60 * 24));

            difdiasfechas=diasTranscurridos;


            }else{
                var diferenciaEnTiempo = fecha_baja - fecha_alta;

                // Convertir la diferencia en milisegundos a días
                var diferenciaEnDias = Math.floor(diferenciaEnTiempo / (1000 * 60 * 60 * 24));

                difdiasfechas=diferenciaEnDias;

            }





            // Obtener los valores de salario correspondientes
            var salarioValues = {
                'sd': $('#sd').val(), // valor para "sd"
                'sdi': $('#sdi').val(), // valor para "sdi"
                'sdn': $('#salario_diario_nuevo_valor').val() // valor para "sdn"
            };

            var salarioDiario = parseFloat(salarioValues[salarioSeleccionado]) || 0;

            // Calcular el monto de aguinaldo
            var montoAguinaldo = (diasPagarAguinaldo*diasAguinaldo)/365;

            montoAguinaldo=montoAguinaldo*salarioDiario;

            $('#monto_aguinaldo').val(montoAguinaldo.toFixed(2));

            // Actualizar el campo de monto
            $('#diasaguinaldo').val(difdiasfechas);

            let idBaja = document.getElementById('idbaja').value;

            // Enviar los datos al servidor
            $.ajax({
                url: '/ruta/actualizar-aguinaldo',
                method: 'POST',
                data: {
                    idbaja: idBaja,
                    diaspagaraguinaldo: diasPagarAguinaldo,
                    diasaguinaldo: diasAguinaldo,
                    salario_diario: salarioDiario,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#alert-success').text('Aguinaldo actualizado correctamente.').show().fadeOut(3000);
                        calcularSuma();
                        recalcularTodo();
                        calcularISR();
                    }
                },
                error: function () {
                    $('#alert-danger').text('Error al actualizar el aguinaldo.').show().fadeOut(3000);
                }
            });
        }

        // Llamar a la función para inicializar los valores al cargar la página
        calcularAguinaldo();
        calcularSuma();
    });
</script>


<script>
    $(document).ready(function () {
    $('#dias_vacaciones input, #s_vacaciones').on('change input', function () {
        calcularVacaciones();
    });

    function calcularVacaciones() {
        var diasVacaciones = parseFloat($('#dias_vacaciones input').val()) || 0;
        var salarioSeleccionado = $('#s_vacaciones').val();

        // Valores de salario diario
        var salarioValues = {
            'sd': parseFloat($('#sd').val()) || 0,
            'sdi': parseFloat($('#sdi').val()) || 0,
            'sdn': $('#salario_diario_nuevo_valor').val() || 0
        };

        var salarioDiario = salarioValues[salarioSeleccionado] || 0;
        var montoVacaciones = diasVacaciones * salarioDiario;

        $('#monto_vacaciones').val(montoVacaciones.toFixed(2));

        let idBaja = document.getElementById('idbaja').value;

        $.ajax({
            url: '/ruta/actualizar-vacaciones',
            method: 'POST',
            data: {
                idbaja: idBaja,
                salarioSeleccionado: salarioSeleccionado,
                dias_vacaciones: diasVacaciones,
                salario_diario: salarioDiario,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Vacaciones actualizadas correctamente.').show().fadeOut(3000);
                    calcularSuma();
                    recalcularTodo();
                    calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar las vacaciones.').show().fadeOut(3000);
            }
        });
    }
});

</script>


<script>
    $(document).ready(function () {
    $('#dias_vacaciones_pend input, #s_vacaciones_pend').on('change input', function () {
        calcularVacacionesPend();
    });

    function calcularVacacionesPend() {
        var diasVacaciones = parseFloat($('#dias_vacaciones_pend input').val()) || 0;
        var salarioSeleccionado = $('#s_vacaciones_pend').val();



        // Valores de salario diario
        var salarioValues = {
            'sd': parseFloat($('#sd').val()) || 0,
            'sdi': parseFloat($('#sdi').val()) || 0,
            'sdn': $('#salario_diario_nuevo_valor').val() || 0
        };

        var salarioDiario = salarioValues[salarioSeleccionado] || 0;
        var montoVacaciones = diasVacaciones * salarioDiario;

        $('#monto_vacaciones_pend').val(montoVacaciones.toFixed(2));

        let idBaja = document.getElementById('idbaja').value;

        $.ajax({
            url: '/ruta/actualizar-vacaciones-pendientes',
            method: 'POST',
            data: {
                idbaja: idBaja,
                salarioSeleccionado: salarioSeleccionado,
                dias_vacaciones: diasVacaciones,
                salario_diario: salarioDiario,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Vacaciones pendientes actualizadas correctamente.').show().fadeOut(3000);
                    calcularSuma();
                    recalcularTodo();
                    calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar las vacaciones pendientes.').show().fadeOut(3000);
            }
        });
    }
});

</script>


<script>

$(document).ready(function () {
    // Escuchar cambios en el porcentaje de prima vacacional o en el monto de vacaciones
    $('#d_primavacacional, #monto_vacaciones').on('change input', function () {
        calcularPrimaVacacional();
    });

    function calcularPrimaVacacional() {
        // Recuperar el porcentaje de la prima vacacional ingresado
        var porcentajePrima = parseFloat($('#d_primavacacional').val()) || 0;
        porcentajePrima=porcentajePrima/100;
        // Recuperar el monto de vacaciones
        var montoVacaciones = parseFloat($('#monto_vacaciones').val().replace(/,/g, '')) || 0;

        // Calcular el monto de la prima vacacional
        var montoPrimaVacacional = porcentajePrima * montoVacaciones;



        // Mostrar el monto calculado en el input correspondiente
        $('#monto_prima_vacacional').val(montoPrimaVacacional.toFixed(2));

        // Obtener el ID necesario para actualizar en la base de datos
        let idBaja = document.getElementById('idbaja').value;

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '/ruta/actualizar-prima-vacacional', // Ruta definida en web.php
            method: 'POST',
            data: {
                idbaja: idBaja,
                porcentajePrima: porcentajePrima*100,
                montoVacaciones: montoVacaciones,
                montoPrimaVacacional: montoPrimaVacacional,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Prima vacacional actualizada correctamente.').show().fadeOut(3000);
                        calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar la prima vacacional.').show().fadeOut(3000);
            }
        });
    }
});

</script>


<script>

$(document).ready(function () {
    // Escuchar cambios en el porcentaje de prima vacacional o en el monto de vacaciones
    $('#d_primavacacional_pend, #monto_vacaciones_pend').on('change input', function () {
        calcularPrimaVacacionalPend();
    });

    function calcularPrimaVacacionalPend() {
        // Recuperar el porcentaje de la prima vacacional ingresado
        var porcentajePrima = parseFloat($('#d_primavacacional_pend').val()) || 0;
        porcentajePrima=porcentajePrima/100;
        // Recuperar el monto de vacaciones
        var montoVacaciones = parseFloat($('#monto_vacaciones_pend').val().replace(/,/g, '')) || 0;

        // Calcular el monto de la prima vacacional
        var montoPrimaVacacional = porcentajePrima * montoVacaciones;



        // Mostrar el monto calculado en el input correspondiente
        $('#monto_prima_vacacional_pend').val(montoPrimaVacacional.toFixed(2));

        // Obtener el ID necesario para actualizar en la base de datos
        let idBaja = document.getElementById('idbaja').value;

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '/ruta/actualizar-prima-vacacional-pendiente', // Ruta definida en web.php
            method: 'POST',
            data: {
                idbaja: idBaja,
                porcentajePrima: porcentajePrima*100,
                montoVacaciones: montoVacaciones,
                montoPrimaVacacional: montoPrimaVacacional,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Prima vacacional pendiente actualizada correctamente.').show().fadeOut(3000);
                        calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar la prima vacacional pendiente.').show().fadeOut(3000);
            }
        });
    }
});

</script>



<script>

$(document).ready(function () {
    // Escuchar cambios en el porcentaje de prima vacacional o en el monto de vacaciones
    $('#d_incentivo, #monto_incentivo, #s_incentivo').on('change input', function () {
        calcularIncentivo();
    });

    function calcularIncentivo() {

        var dias_transcurridos = parseFloat($('#dias_transcurridos').text()) || 0;


        var porcentajeIncentivo = parseFloat($('#d_incentivo').val()) || 0;

        var salarioSeleccionado = $('#s_incentivo').val();

        porcentajeIncentivo=porcentajeIncentivo/100;


        var salarioValues = {
            'sd': parseFloat($('#sd').val()) || 0,
            'sdi': parseFloat($('#sdi').val()) || 0,
            'sdn': $('#salario_diario_nuevo_valor').val() || 0
        };

        var salarioDiario = salarioValues[salarioSeleccionado] || 0;
        var incentivo = (dias_transcurridos * salarioDiario)*porcentajeIncentivo;


        // Mostrar el monto calculado en el input correspondiente
        $('#monto_incentivo').val(incentivo.toFixed(2));

        // Obtener el ID necesario para actualizar en la base de datos
        let idBaja = document.getElementById('idbaja').value;

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '/ruta/actualizar-incentivo', // Ruta definida en web.php
            method: 'POST',
            data: {
                idbaja: idBaja,
                salario_diario: salarioDiario,
                porcentajeIncentivo: porcentajeIncentivo*100,
                incentivo: incentivo,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Incentivo actualizado correctamente.').show().fadeOut(3000);
                    calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar el incentivo.').show().fadeOut(3000);
            }
        });
    }
});

</script>


<script>
    $(document).ready(function () {
    // Escuchar cambios en el porcentaje de prima vacacional o en el monto de vacaciones
    $('#d_gratificacion, #monto_gratificacion, #s_gratificacion').on('change input', function () {
        calcularGratificacion();
    });

    function calcularGratificacion() {
        // Obtener el valor seleccionado para el salario (sd, sdi, sdn)
        var salarioSeleccionado = $('#s_gratificacion').val();

        // Definir los valores de salario en función de lo seleccionado
        var salarioValues = {
            'sd': parseFloat($('#sd').val()) || 0,     // Obtener valor de salario diario
            'sdi': parseFloat($('#sdi').val()) || 0,   // Obtener valor de salario diario integrado
            'sdn': parseFloat($('#salario_diario_nuevo_valor').val()) || 0  // Obtener otro salario si es seleccionado
        };

        // Seleccionar el salario correspondiente
        var salarioDiario = salarioValues[salarioSeleccionado] || 0;

        // Obtener el valor de d_gratificacion y asegurarse de que sea un número
        var d_gratificacion = parseFloat($('#d_gratificacion').val()) || 0;  // Convertir a número, por si acaso

        // Calcular la gratificación
        var gratificacion = d_gratificacion * salarioDiario;

        // Mostrar el monto calculado en el input correspondiente
        $('#monto_gratificacion').val(gratificacion.toFixed(2));

        // Obtener el ID necesario para actualizar en la base de datos
        var idBaja = document.getElementById('idbaja').value;

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '/ruta/actualizar-gratificacion', // Ruta definida en web.php
            method: 'POST',
            data: {
                idbaja: idBaja,
                d_gratificacion: d_gratificacion,
                salario_diario: salarioDiario,
                gratificacion: gratificacion,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Gratificación actualizada correctamente.').show().fadeOut(3000);
                    calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar la gratificación.').show().fadeOut(3000);
            }
        });
    }
});

</script>


<script>

$(document).ready(function () {
    // Escuchar cambios en el select y el input
    $('#s_veinte_dias, #d_veinte_dias').on('change input', function () {
        calcularMontoVeinteDias();
    });

    function calcularMontoVeinteDias() {
        // Obtener el valor del input de años trabajados
        var anosTrabajados = parseFloat($('#d_veinte_dias').val()) || 0;

        // Obtener el valor del select seleccionado
        var salarioSeleccionado = $('#s_veinte_dias').val();

        // Obtener los valores de los salarios
        var salarioValues = {
            'sd': parseFloat($('#sd').val()) || 0,
            'sdi': parseFloat($('#sdi').val()) || 0,
            'sdn': $('#salario_diario_nuevo_valor').val() || 0
        };

        // Obtener el salario diario según el valor seleccionado en el select
        var salarioDiario = salarioValues[salarioSeleccionado] || 0;



        // Calcular el monto total (20 días por cada año trabajado)
        var montoVeinteDias = 20 * anosTrabajados * salarioDiario;

        // Mostrar el monto calculado en el input correspondiente
        $('#monto_veinte_dias').val(montoVeinteDias.toFixed(2));

        let idBaja = document.getElementById('idbaja').value;

        // Opcional: Enviar el resultado al servidor vía AJAX si es necesario
        $.ajax({
            url: '/ruta/actualizar-veinte-dias', // Ruta definida en tu archivo web.php
            method: 'POST',
            data: {
                idbaja: idBaja,
                anos_trabajados: anosTrabajados,
                salario_diario: salarioDiario,
                monto_veinte_dias: montoVeinteDias,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Monto de 20 días por año actualizado correctamente.').show().fadeOut(3000);
                    calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar el monto de 20 días por año.').show().fadeOut(3000);
            }
        });
    }
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener elementos del DOM
    const salarioMinimoInput = document.getElementById('salario_minimo');
    const selectPrima = document.getElementById('s_prima_de_antiguedad');
    const inputSalarioTopado = document.getElementById('d_prima_de_antiguedad');
    const montoPrimaInput = document.getElementById('monto_prima_de_antiguedad');
    const aniosServicioSpan = document.getElementById('anios_de_servicio');
    const fechaAltaInput = document.getElementById('fechaAlta');
    const fechaBajaInput = document.getElementById('fechaBaja');

    const diasProporcionales = document.getElementById('dias_trabajados').innerHTML;
    // Función para calcular días adicionales del último año
    function calcularDiasProporcionales(fechaAlta, fechaBaja) {
        const ultimoAniversario = new Date(fechaBaja.getFullYear(), fechaAlta.getMonth(), fechaAlta.getDate());
        if (fechaBaja < ultimoAniversario) {
            ultimoAniversario.setFullYear(ultimoAniversario.getFullYear() - 1);
        }
        const diasProporcionales = Math.floor((fechaBaja - ultimoAniversario) / (1000 * 60 * 60 * 24));
        return diasProporcionales;
    }

    // Función para calcular y enviar prima
    function calcularYEnviarPrima() {
        // Obtener fechas
        const fechaAlta = new Date(fechaAltaInput.value);
        const fechaBaja = new Date(fechaBajaInput.value);

        if (isNaN(fechaAlta) || isNaN(fechaBaja)) {
            console.error('Fechas inválidas');
            return;
        }

        // Calcular años completos y días proporcionales
        const aniosServicio = parseInt(aniosServicioSpan?.textContent) || 0;
        const diasProporcionales = calcularDiasProporcionales(fechaAlta, fechaBaja);

        // Calcular total de días para la prima
        const diasPrimaAntiguedad = aniosServicio * 12 + Math.floor((diasProporcionales / 365) * 12);

        // Obtener valores del select dinámicamente
        const salarioValues = {
            'sd': parseFloat(document.getElementById('sd')?.value) || 0,
            'sdi': parseFloat(document.getElementById('sdi')?.value) || 0,
            'sdn': parseFloat(document.getElementById('salario_diario_nuevo_valor')?.value) || 0,
        };

        // Obtener datos de entrada
        const salarioSeleccionado = salarioValues[selectPrima.value] || 0;
        const salarioMinimo = parseFloat(salarioMinimoInput?.value) || 0;
        const salarioTopadoManual = parseFloat(inputSalarioTopado?.value) || null;

        // Calcular salario topado
        const salarioTopado = salarioTopadoManual !== null ? salarioTopadoManual : Math.min(salarioSeleccionado, salarioMinimo * 2);

        // Calcular monto de prima de antigüedad
        const montoPrima = salarioTopado * diasPrimaAntiguedad;

        // Actualizar los valores en la vista
        inputSalarioTopado.value = diasPrimaAntiguedad; // Mostrar días totales aplicables
        montoPrimaInput.value = montoPrima.toFixed(2); // Actualizar el campo readonly con el monto calculado


        // Preparar datos para enviar al servidor
        let idBaja = document.getElementById('idbaja').value;

        const data = {
            idbaja: idBaja,
            salario_minimo: salarioMinimo,
            salario_seleccionado: salarioSeleccionado,
            anios_servicio: aniosServicio,
            dias_proporcionales: diasProporcionales,
            dias_prima: diasPrimaAntiguedad,
            salario_topado: salarioTopado,
            monto_prima: montoPrima,
        };

        // Enviar datos al servidor
        $.ajax({
            url: '/ruta/calcular-prima-de-antiguedad', // Ruta del controlador
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Token CSRF
            },
            success: function (response) {
                if (response.success) {
                    $('#alert-success').text('Prima de antigüedad actualizada correctamente.').show().fadeOut(3000);
                    calcularSuma();
                        recalcularTodo();
                        calcularISR();
                }
            },
            error: function () {
                $('#alert-danger').text('Error al actualizar la prima de antigüedad.').show().fadeOut(3000);
            },
        });
    }

    // Listeners para cambios en los inputs
    $('#s_prima_de_antiguedad, #d_prima_de_antiguedad').on('change input', function () {
        calcularYEnviarPrima();
    });
    salarioMinimoInput.addEventListener('input', calcularYEnviarPrima);
    selectPrima.addEventListener('change', calcularYEnviarPrima);
    inputSalarioTopado.addEventListener('input', calcularYEnviarPrima);

    // Inicializar el cálculo
    calcularYEnviarPrima();
});
</script>


<script>
    function calcularSuma() {
        var totalPercepciones = 0;
        var totalDeducciones = 0;

        // Obtener y sumar los valores de percepciones, eliminando comas
        var percepcionesInputs = [
            '#monto_dias',
            '#monto_aguinaldo',
            '#monto_vacaciones',
            '#monto_vacaciones_pend',
            '#monto_prima_vacacional',
            '#monto_prima_vacacional_pend',
            '#monto_incentivo',
            '#monto_prima_de_antiguedad',
            '#monto_gratificacion',
            '#monto_veinte_dias',
            '#despensa'
        ];

        percepcionesInputs.forEach(function (id) {
            var value = $(id).val().replace(/,/g, ''); // Eliminar comas
            totalPercepciones += parseFloat(value) || 0; // Sumar el valor, manejando valores no numéricos
        });

        // Mostrar el total de percepciones con separador de comas
        $('#totalPercepciones').val(totalPercepciones.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        // Obtener y sumar los valores de deducciones, eliminando comas
        var deduccionesInputs = [
            '#isr',
            '#imss',
            '#deudores',
            '#isr_finiquito'
        ];

        deduccionesInputs.forEach(function (id) {
            var value = $(id).val().replace(/,/g, ''); // Eliminar comas
            totalDeducciones += parseFloat(value) || 0; // Sumar el valor, manejando valores no numéricos
        });

        // Mostrar el total de deducciones con separador de comas
        $('#totalDeducciones').text(totalDeducciones.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        // Calcular el super total (percepciones - deducciones)
        var superTotal = totalPercepciones - totalDeducciones;

        // Mostrar el super total con separador de comas
        $('#supertotal').val(superTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    // Ejecutar la suma cada 2 segundos
    setInterval(function() {
        calcularSuma();
    }, 2000);

    // Inicializar el cálculo al cargar la página
    $(document).ready(function() {
        calcularSuma();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isrField = document.getElementById("isr");

        // Función para eliminar comas y signos de valores de texto
        function quitarComasYSignos(valor) {
            return parseFloat(valor.replace(/[$,]/g, '')) || 0; // Elimina signos y convierte a número
        }

        function obtenerLimiteInferior(baseGravable) {
            // Construimos la URL con el parámetro base gravable
            const url = `{{ route('obtener-limite-inferior', ['base' => '__base__']) }}`.replace('__base__', baseGravable);

            console.log('URL de solicitud:', url); // Verifica la URL generada

            fetch(url, {
                method: "GET", // Usamos GET para hacer la solicitud
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Añadimos el token CSRF para protección
                },
            })
            .then(response => response.json())
            .then(data => {

                if (data.limite_inferior !== undefined) {
                    if (isrField) {
                        isrField.value = parseFloat(data.limite_inferior).toFixed(2); // Mostramos la cuota fija con dos decimales
                    }

                   var paso3 = parseFloat(baseGravable) - parseFloat(data.limite_inferior);

                   isrField.value = paso3.toFixed(2);

                    // Enviar paso3 a la ruta calcular-porcentaje
                    enviarPorcentaje(baseGravable);
                } else {
                    // Si no se recibe la cuota fija, ponemos el valor por defecto
                    if (isrField) {
                        isrField.value = "0.00";
                    }
                }
            })
            .catch(error => {
                if (isrField) {
                    isrField.value = "0.00"; // En caso de error, mostramos un valor por defecto
                }
            });
        }

        // Función que calcula el ISR
        function calcularISR() {
            // Obtener los valores individuales y procesarlos
            var montoDias = quitarComasYSignos(document.getElementById("monto_dias")?.value || "0");
            var montoAguinaldo = quitarComasYSignos(document.getElementById("monto_aguinaldo")?.value || "0");
            var montoVacaciones = quitarComasYSignos(document.getElementById("monto_vacaciones")?.value || "0");
            var montoPrimaVacacional = quitarComasYSignos(document.getElementById("monto_prima_vacacional")?.value || "0");
            var montoIncentivo = quitarComasYSignos(document.getElementById("monto_incentivo")?.value || "0");

            // Ajustes a los montos (si es necesario)
            montoAguinaldo = montoAguinaldo - (30 * 108.57);  // Ajuste fijo
            montoPrimaVacacional = montoPrimaVacacional - (15 * 108.57);  // Ajuste fijo

            // Suma total de la base gravable
            const total = montoDias + montoAguinaldo + montoVacaciones + montoPrimaVacacional + montoIncentivo;

            obtenerLimiteInferior(total);


        }

        // Función para enviar el valor de paso3 a la ruta calcular-porcentaje
        function enviarPorcentaje(baseGravable) {
            const url = `{{ route('calcular-porcentaje', ['baseGravable' => '__baseGravable__']) }}`.replace('__baseGravable__', baseGravable);

            fetch(url, {
                method: "GET", // Usamos GET para hacer la solicitud
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Añadimos el token CSRF para protección
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del cálculo de porcentaje:', data); // Verifica la respuesta
                // Aquí puedes hacer algo con la respuesta del cálculo de porcentaje
                var porcentaje = parseFloat(data.porcentaje);

                var paso4 =  (porcentaje*baseGravable)/100;

                obtenerCuotaFija(baseGravable);

            })
            .catch(error => {
                console.error("Error al calcular el porcentaje:", error);
            });
        }

        function obtenerCuotaFija(baseGravable) {
            const url = `{{ route('obtener-cuota-fija', ['baseGravable' => '__baseGravable__']) }}`.replace('__baseGravable__', baseGravable);

            fetch(url, {
                method: "GET", // Usamos GET para hacer la solicitud
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Añadimos el token CSRF para protección
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del cálculo de porcentaje:', data); // Verifica la respuesta
                // Aquí puedes hacer algo con la respuesta del cálculo de porcentaje
                var isr_final = parseFloat(data.cuota_fija);


                if (isrField) {
                    isrField.value = isr_final.toFixed(2); // En caso de error, mostramos un valor por defecto
                   isrField.value = isr_final.toFixed(2);
                }

            })
            .catch(error => {
                console.error("Error al calcular el porcentaje:", error);
            });
        }

        // Ejecutar el cálculo inicial al cargar el DOM
        calcularISR();

        // Recalcular si los valores cambian dinámicamente
        ["monto_dias", "monto_aguinaldo", "monto_vacaciones", "monto_prima_vacacional", "monto_incentivo"].forEach(id => {
            const elemento = document.getElementById(id);
            if (elemento) {
                // Escuchar los cambios en los campos
                elemento.addEventListener("input", function() {
                    console.log(id + " ha cambiado");  // Verifica que el campo haya cambiado
                    calcularISR(); // Llama a la función para recalcular el ISR
                    calcularSuma();
                        recalcularTodo();
                        calcularISR();
                });
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Función para limpiar comas y signos de pesos
    function cleanInput(value) {
        return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;  // Elimina todo lo que no sea número o punto decimal
    }

    // Función para calcular la suma de los tres campos y actualizar el campo isr_finiquito
    function calcularISRFiniquito() {
        // Obtenemos los valores de los tres inputs
        const primaDeAntiguedad = document.getElementById('monto_prima_de_antiguedad').value;
        const gratificacion = document.getElementById('monto_gratificacion').value;
        const veinteDias = document.getElementById('monto_veinte_dias').value;
       // Obtener los valores desde los inputs
        let uma = parseFloat(document.getElementById('uma').value) || 0;
        let dias_trabajados = parseFloat(document.getElementById('dias_trabajados').value) || 0;

        // Limpiar las entradas de las otras variables y calcular paso1
        let primaDeAntiguedad = parseFloat(document.getElementById('primaDeAntiguedad').value) || 0;
        let gratificacion = parseFloat(document.getElementById('gratificacion').value) || 0;
        let veinteDias = parseFloat(document.getElementById('veinteDias').value) || 0;

        function cleanInput(value) {
            return parseFloat(value) || 0; // Convierte a número o devuelve 0 si no es válido
        }

        // Cálculo de paso1
        const paso1 = cleanInput(primaDeAntiguedad) + cleanInput(gratificacion) + cleanInput(veinteDias);

        // Cálculo de paso2
        const paso2 = (uma * 90) * dias_trabajados;


        // Cálculo de paso3 (paso1 - paso2)
        const paso3 = paso1 - paso2;

        const paso4 = 1319.57*30;

        const paso5 = paso4*0.02;

        const paso6 = paso4 + paso5;

        const paso7 = 42537.59;

        const paso8 = paso6 - paso7;

        const paso9 = paso8 * 0.30;

        const paso10 = 7980.73;

        const paso11 = paso9 + paso10;

        const paso12 = paso6 / paso11;

        const paso13 = paso12 * 100;

        const paso14 = paso3 * paso12;



        // Mostramos el resultado de paso3 en el campo isr_finiquito
        document.getElementById('isr_finiquito').value = paso14.toFixed(2);  // Muestra paso3 con dos decimales
    }

    // Escuchamos los cambios en los tres campos
    document.getElementById('monto_prima_de_antiguedad').addEventListener('input', calcularISRFiniquito);
    document.getElementById('monto_gratificacion').addEventListener('input', calcularISRFiniquito);
    document.getElementById('monto_veinte_dias').addEventListener('input', calcularISRFiniquito);

    // Llamamos a la función inicialmente para tener el valor de isr_finiquito cargado
    calcularISRFiniquito();

                        calcularSuma();
                        recalcularTodo();
                        calcularISR();
});


</script>


<script>

document.addEventListener("DOMContentLoaded", function() {
    // Función para limpiar el valor y convertirlo a número
    function cleanInput(value) {
        return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;  // Elimina lo que no sea número o punto decimal
    }

    // Función para actualizar el campo despensa basado en monto_despensa
    function actualizarDespensa() {
        const montoDias = cleanInput(document.getElementById('monto_dias').value);  // Valor de monto_dias
        const montoDespensa = cleanInput(document.querySelector('input[name="monto_despensa"]').value);  // Valor de monto_despensa (porcentaje)

        // Si monto_despensa tiene valor, calculamos el valor en despensa (monto_dias * porcentaje / 100)
        if (montoDespensa !== 0) {
            const resultadoDespensa = montoDias * (montoDespensa / 100);
            document.getElementById('despensa').value = resultadoDespensa.toFixed(2);  // Mostramos el resultado
        }
    }

    // Función para actualizar monto_despensa basado en despensa
    function actualizarMontoDespensa() {
        const montoDias = cleanInput(document.getElementById('monto_dias').value);  // Valor de monto_dias
        const valorDespensa = cleanInput(document.getElementById('despensa').value);  // Valor de despensa

        // Si despensa tiene valor, calculamos el porcentaje sobre monto_dias (despensa / monto_dias) * 100
        if (valorDespensa !== 0 && montoDias !== 0) {
            const porcentaje = (valorDespensa / montoDias) * 100;
            document.querySelector('input[name="monto_despensa"]').value = porcentaje.toFixed(2);  // Mostramos el porcentaje
        }
    }

    // Función para escuchar el cambio en monto_dias
    function actualizarCalculados() {
        actualizarDespensa();
        actualizarMontoDespensa();
    }

    // Eventos para escuchar cambios en monto_despensa, despensa y monto_dias
    document.querySelector('input[name="monto_despensa"]').addEventListener('input', actualizarDespensa);
    document.getElementById('despensa').addEventListener('input', actualizarMontoDespensa);
    document.getElementById('monto_dias').addEventListener('input', actualizarCalculados);

    // Llamadas iniciales para cargar los valores correctos si ya existen
    actualizarCalculados();
    calcularSuma();
    calcularISR();
});

</script>


<script>

    function recalcularTodo(){

        updateMontoDias();
        calcularAguinaldo();
        calcularVacaciones();
        calcularVacacionesPend();
        calcularPrimaVacacional();
        calcularPrimaVacacionalPend();
        calcularIncentivo();
        calcularGratificacion();
        calcularMontoVeinteDias();
        calcularYEnviarPrima();
        calcularSuma();
        calcularISR();

    }

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Ejecuta recalcularTodo() cada 10 segundos
    setInterval(recalcularTodo, 20000);
});

</script>
@endsection

