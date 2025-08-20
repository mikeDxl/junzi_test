@extends('layouts.app', ['activePage' => 'Bajas', 'menuParent' => 'laravel', 'titlePage' => __('Bajas')])

@section('content')
  <div class="content" id="contenido">
    <div class="container-fluid">
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
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Baja</h4>
              </div>
              <div class="card-body">
                <form action="{{ route('tramitar') }}" method="post">
              @csrf
                <div class="row">
                  <div class="col-md-12">
                    <h3>{{ qcolab($baja->colaborador_id) }}</h3>
                    <p>Fecha alta: {{ $falta }}</p>
                  </div>
                  <div class="col-md-4">
                    <p>Tipo de baja:</p>
                    <select class="form-control" name="motivo">
                      <option value="{{ $baja->motivo }}">{{ $baja->motivo }}</option>
                      <option value="Renuncia">Renuncia</option>
                      <option value="Baja solicitada">Baja solicitada</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <p>Fecha Baja:</p>
                    <?php
                    // Verificar si $datosBaja->fecha_baja está definido y no es nulo
                    if(isset($datosBaja) && $datosBaja->fecha_baja) {
                        // Convertir la fecha al formato 'Y-m-d'
                        $fechaFormateada = \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_baja)->format('Y-m-d');
                    } else {
                        // Convertir la fecha al formato 'Y-m-d' usando $baja->fecha_baja
                        $fechaFormateada = \Carbon\Carbon::createFromFormat('d / m / Y', $fbaja)->format('Y-m-d');
                    }
                    ?>

                    <input type="date" class="form-control" name="fechabajad" value="{{ $fechaFormateada }}">
                  </div>
                  <div class="col-md-4">
                    <p>Fecha Elaboración:</p>
                    <input type="date" class="form-control" name="fecha_elaboracion" value="{{ $datosbaja->fecha_elaboracion ?? date('Y-m-d') }}">
                  </div>


                </div>
                <div class="row" style="margin-top:50px;">

                  <div class="col-md-3">
                    <div class="text-left">
                      @if ($datosbaja)
                          @if($datosbaja->salario_diario==$salario_diario)
                          <input type="radio" checked name="salario_diario" value="{{$salario_diario}}">
                          @else
                          <input type="radio" name="salario_diario" value="{{$salario_diario}}">
                          @endif
                      @else
                      <input type="radio" checked name="salario_diario" value="{{$salario_diario}}">
                      @endif

                    </div>
                    <p>Salario diario</p>
                    <h3>${{ number_format($salario_diario,2) }}</h3>
                    

                    <p>Días del año trabajados: {{ $dias }}</p>
                    <p>Años trabajados: {{ $aniostrabajados }}</p>
                    <p>Días después de aniversario {{ $diasanivhoy }}</p>

                  </div>
                  <div class="col-md-3">
                    <div class="text-left">
                      @if ($datosbaja)
                        @if($datosbaja->salario_diario==$salario_diario_integrado)
                        <input type="radio" checked name="salario_diario" value="{{$salario_diario_integrado}}">
                        @else
                        <input type="radio" name="salario_diario" value="{{$salario_diario_integrado}}">
                        @endif
                      @else
                      <input type="radio" name="salario_diario" value="{{$salario_diario_integrado}}">
                      @endif

                    </div>
                    <p>Salario diario integrado</p>
                    <h3>${{ number_format($salario_diario_integrado,2) }}</h3>
                  </div>
                </div>
                <input type="hidden" name="anio" value="{{ $aniostrabajados }}">


                  <input type="hidden" name="colaborador_id" value="{{ $baja->colaborador_id }}">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                        <table class="table">
                          <thead>
                            <th>Percepciones</th>
                            <th>Días</th>
                            <th>Monto</th>
                          </thead>
                          <tbody>
                            <tr>
                              <td>SALARIO NORMAL</td>
                              <td id="dias"> <input type="text" class="form-control" name="dias" value="{{ $datosbaja->d_salario_normal ?? $aldiadehoy }}"> </td>
                              @php
                                  // Calcula el monto del salario
                                  $monto = $datosbaja->salario_normal ?? ($colaborador->salario_diario * $aldiadehoy);

                                  // Formatea el monto del salario con dos decimales
                                  $montoFormateado = number_format($monto, 2);
                              @endphp

                              <td>$<span id="monto_dias">{{ $montoFormateado }}</span></td>

                            </tr>
                            <tr>
                              <td>AGUINALDO</td>
                              <?php
                              $diasapagar=$datosbaja->d_aguinaldo ?? $diasapagar;
                              $d2_aguinaldo=$datosbaja->d2_aguinaldo ?? number_format($diasaguinaldo,2);
                              $aguinaldo=number_format($colaborador->salario_diario*$d2_aguinaldo,2) ?? number_format($colaborador->salario_diario*$diasaguinaldo,2);
                               ?>
                              <td id="diasaguinaldo">
                                <div class="input-group">
                                  <select class="text-center" name="diaspagaraguinaldo">
                                    <option value="{{ $datosbaja->d_aguinaldo ?? $diasapagar }}">{{ $datosbaja->d_aguinaldo ?? $diasapagar }}</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                  </select>
                                  <input type="text" name="diasaguinaldo" class="form-control" value="{{ $datosbaja->d2_aguinaldo ?? number_format($diasaguinaldo,2) }}">
                                </div>
                              </td>
                              <td id="monto_aguinaldo">$<span>{{ $aguinaldo }}</span></td>
                            </tr>
                            <tr>
                              <td>VACACIONES</td>

                              @php
                                $dvacaciones = $datosbaja->d_vacaciones ?? $dias_vacaciones;
                            @endphp
                              <td id="dias_vacaciones"> <input type="text" class="form-control" name="dias_vacaciones" value="{{ number_format($dvacaciones,2) }}"> </td>
                              @php
                                // Calcula el monto de las vacaciones
                                $montoVacaciones = $datosbaja->vacaciones ?? ($colaborador->salario_diario * $dias_vacaciones);

                                // Formatea el monto de las vacaciones con dos decimales
                                $montoVacacionesFormateado = number_format($montoVacaciones, 2);
                            @endphp

                            <td id="monto_vacaciones">$<span>{{ $montoVacacionesFormateado }}</span></td>

                            </tr>
                            <tr>
                              <td>VACACIONES Pend.</td>
                              <td > <input type="text" class="form-control" name="dias_vacaciones_pend" value="{{ $vacaciones_pendientes ?? '0' }}"> </td>
                              <td >$<span> {{ $vacaciones_pendientes*$colaborador->salario_diario }} </span></td>
                            </tr>
                            <tr>
                              <td>PRIMA VACACIONAL</td>
                              <?php $vac=$colaborador->salario_diario*$dias_vacaciones; ?>
                              <td>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="monto_prima_vacacional" value="{{ $datosbaja->d_primavacacional ?? '25' }}">
                                  <input type="text" class="form-control text-center" disabled name="" value="%" style="width:30px;">
                                </div>
                              </td>
                              @php
                                // Verificar si $montoVacacionesFormateado es numérico y convertirlo a float si es necesario
                                $montoVacaciones = is_numeric($montoVacacionesFormateado) ? (float)$montoVacacionesFormateado : 0;

                                // Calcular $montoPrimaVacacional solo si $montoVacaciones es numérico y mayor que 0
                                $montoPrimaVacacional = $datosbaja->prima_vacacional ?? ($montoVacaciones * 0.25);

                                // Formatear el monto
                                $montoPrimaVacacionalFormateado = number_format($montoPrimaVacacional, 2);
                            @endphp


                              <td id="monto_prima_vacacional">$<span>{{ $montoPrimaVacacionalFormateado }}</span></td>

                            </tr>
                            <tr>
                              <td>INCENTIVO</td>
                              <td>
                                <div class="input-group">
                                  @php
                                      $montoIncentivo = $datosbaja->d_incentivo ?? '20';
                                  @endphp

                                  <input type="text" class="form-control" name="monto_incentivo" value="{{ $montoIncentivo }}">

                                  <input type="text" class="form-control text-center" disabled name="" value="%" style="width:30px;">
                                </div>
                              </td>
                              @php
                                  $montoIncentivo = $datosbaja->incentivo ?? ($colaborador->salario_diario * $aldiadehoy) * 0.20;
                                  $montoIncentivoFormateado = number_format($montoIncentivo, 2);
                              @endphp

                              <td>$<span id="monto_incentivo">{{ $montoIncentivoFormateado }}</span></td>
                            </tr>
                            @php
                              $montoPrimaDeAntiguedad = $datosbaja->d_prima_de_antiguedad ?? '12';
                          @endphp

                          <tr>
                              <td>PRIMA DE ANTIGÜEDAD</td>
                              <td id="prima_total">
                                  <input type="text" class="form-control" name="monto_prima_de_antiguedad" value="{{ $montoPrimaDeAntiguedad }}">
                              </td>
                              <td>$<span id="monto_prima_de_antiguedad">{{ number_format($datosbaja->prima_de_antiguedad ?? $prima_de_antiguedad, 2) }}</span></td>
                          </tr>

                          @php
                              $montoGratificacion = $datosbaja->d_gratificacion ?? '90';
                            @endphp

                            <tr>
                              <td>GRATIFICACION</td>
                              <td id="gratificacion">
                                  <input type="text" class="form-control" name="monto_gratificacion" value="{{ $montoGratificacion }}">
                              </td>
                              <td>$<span id="monto_gratificacion">{{ number_format($datosbaja->gratificacion ?? 90 * $colaborador->salario_diario, 2) }}</span></td>
                            </tr>

                            @php
                                // Calcula el monto de los 20 días por año
                                $montoVeinteDias = $datosbaja->d_veinte_dias ?? number_format(calcularAniosDesdeDias($diastodos) * 20);
                            @endphp

                            <tr>
                                <td>20 DIAS POR AÑO</td>
                                <td id="veinte_dias">
                                    <input type="text" class="form-control" name="monto_veinte_dias" value="{{ $montoVeinteDias }}">
                                </td>
                                <td>$<span id="monto_veinte_dias">{{ number_format($datosbaja->veinte_dias ?? (calcularAniosDesdeDias($diastodos) * 20) * $colaborador->salario_diario, 2) }}</span></td>
                            </tr>


                            @php
                                $d_despensa = $datosbaja->d_despensa ?? '15';
                                $montoDespensa = $datosbaja->despensa ?? $colaborador->salario_diario * $aldiadehoy * 0.15;
                            @endphp

                            <tr>
                                <td>DESPENSA</td>
                                <td><input type="text" class="form-control" name="monto_despensa" value="{{ $d_despensa }}"></td>
                                <td>$<span id="despensa">{{ number_format($montoDespensa) }}</span></td>
                            </tr>
                            @php
                              // Define el valor total de las percepciones
                                $totalPercepciones = $datosbaja->percepciones ?? $totalPercepciones;
                            @endphp

                            <tr>
                                <td colspan="2">Total percepciones <input type="hidden" name="totalPercepciones" value="{{ $totalPercepciones }}"> </td>
                                <td><b>$<span id="totalPercepciones">{{ number_format($totalPercepciones, 2) }}</span></b> </td>
                            </tr>


                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                        <table class="table">
                          <thead>
                            <th>Deducciones</th>
                            <th>Monto</th>
                          </thead>
                          <tbody>
                            <tr>
                              @php
                                  $isrfinal = $datosbaja->isr ?? $isr;
                              @endphp
                              <td>I.S.R.</td>
                              <td>
                                  <span id="isr">
                                      <input type="text" class="form-control" name="isr" value="{{ number_format($isrfinal, 2) }}">
                                  </span>
                              </td>
                            </tr>
                            <tr>
                              <td>I.M.S.S.</td>
                              <td><input type="text" class="form-control" name="imss" value="{{ $datosbaja->imss ?? '0.00' }}"></td>
                            </tr>
                            <tr>
                              <td>DEUDORES</td>
                              <td> <input type="text" class="form-control" name="deudores"  value="{{ $datosbaja->deudores ?? '0.00' }}"> </td>
                            </tr>
                            <tr>
                              <td>ISR FINIQUITO</td>
                              <td> <input type="text" class="form-control" name="isr_finiquito"  value="{{ $datosbaja->isr_finiquito ?? '0.00' }}"> </td>
                            </tr>

                              @php
                                  $totalDeducciones = $datosbaja->deducciones ?? $totalDeducciones;
                              @endphp

                              <tr>
                                  <td>Total deducciones <input type="hidden" name="totalDeducciones" value="{{ $totalDeducciones }}"> </td>
                                  <td><b>$<span id="totalDeducciones">{{ number_format($datosbaja->deducciones ?? $totalDeducciones, 2) }}</span></b> </td>
                              </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-12">
                      TOTAL NETO A RECIBIR
                    </div>

                    <div class="col-md-2">
                      @php
                          // Define el valor total
                          $valorTotal = $datosbaja->total ?? $total;
                          // Formatea el valor total con dos decimales
                          $valorTotalFormateado = number_format($valorTotal, 2);
                      @endphp

                      <input type="text" name="total" class="form-control" readonly value="{{ $valorTotalFormateado }}">
                    </div>

                    <div class="col-md-12 text-center">
                      <input type="hidden" name="id_baja" value="{{ $baja->id }}">
                      <br>
                      <button type="submit" class="btn btn-info" name="guardar">Calcular</button>
                    </div>
                  </div>
              </form>


                  </div>

                  @if($datosbaja)
                  <br>
                  <div class="row">
                    <div class="col-12 text-center">
                      <form class="" action="{{ route('pdfFiniquito') }}" method="post">
                          @csrf
                          <input type="hidden" name="datosbajaid" value="{{$datosbaja->id ?? '0'}}">
                          <input type="hidden" name="colaborador_id" value="{{$colaborador->id}}">
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
@endsection

@push('js')
<script src="http://lylgroup.mx/js/filesaver.js" type="text/javascript"></script>
<script src="http://lylgroup.mx/js/html2canvas.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $("#crearimagen").click(function() {

          html2canvas($("#contenido"), {
              onrendered: function(canvas) {
                  theCanvas = canvas;
                //  document.body.appendChild(canvas);
                var captura=document.getElementById('captura').value;
                  canvas.toBlob(function(blob) {
                    saveAs(blob, captura);
                  });

              }
          });
      });
  });
</script>
  <script>
    $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Buscar",
        },
        "columnDefs": [
          { "orderable": false, "targets": 4 },
        ],
      });
    });
  </script>
@endpush
