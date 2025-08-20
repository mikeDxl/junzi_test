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
                                  $fechaFormateada = isset($datosBaja) && $datosBaja->fecha_baja 
                                      ? \Carbon\Carbon::createFromFormat('d / m / Y', $datosBaja->fecha_baja)->format('Y-m-d') 
                                      : \Carbon\Carbon::createFromFormat('d / m / Y', $fbaja)->format('Y-m-d');
                                  ?>
                                  <input type="date" class="form-control" name="fechabajad" value="{{ $fechaFormateada }}">
                              </div>

                              <div class="col-md-4">
                                  <p>Fecha Elaboración:</p>
                                  <input type="date" class="form-control" name="fecha_elaboracion" value="{{ $datosbaja->fecha_elaboracion ?? date('Y-m-d') }}">
                              </div>
                          </div>
                          <div class="row" style="margin-top: 50px;">
                              <!-- Salario Diario -->
                              <div class="col-md-3">
                              <input type="hidden"  name="salario_diario_normal" value="{{ $salario_diario }}" >
                                  <div class="text-left">
                                      @if ($datosbaja)
                                          <input type="radio" id="sd" name="salario_diario" 
                                                value="{{ $salario_diario }}" 
                                                {{ $datosbaja->salario_diario == $salario_diario ? 'checked' : '' }} onclick="updateSalarioSeleccionado('sd')">
                                      @else
                                          <input type="radio" id="sd" name="salario_diario" 
                                                value="{{ $salario_diario }}" 
                                                checked onclick="updateSalarioSeleccionado('sd')">
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
                                                {{ $datosbaja->salario_diario == $salario_diario_integrado ? 'checked' : '' }} onclick="updateSalarioSeleccionado('sdi')">
                                          @php
                                              $sdi = $datosbaja->salario_diario == $salario_diario_integrado ? $salario_diario_integrado : $sd;
                                          @endphp
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
                              <input type="hidden"  name="salario_diario_integral" value="{{ $salario_diario_integrado }}" >
                              
                                  <div class="text-left">
                                      @if ($datosbaja)
                                          <input type="radio" id="sdn" name="salario_diario" 
                                                value="{{ $salario_diario_integrado }}" 
                                                {{ $datosbaja->salario_diario == $salario_diario_integrado ? 'checked' : '' }} onclick="updateSalarioSeleccionado('sdn')">
                                          @php
                                              $sdi = $datosbaja->salario_diario == $salario_diario_integrado ? $salario_diario_integrado : $sd;
                                          @endphp
                                      @else
                                          <input type="radio" id="sdn" name="salario_diario" 
                                                value="{{ $salario_diario_integrado }}" 
                                                onclick="updateSalarioSeleccionado('sdn')">
                                      @endif
                                  </div>
                                  <p>Salario diario (nuevo)</p>
                                  <input value="{{ number_format($salario_diario, 2) }}" class="form-control" id="salario_diario" name="salario_diario_nuevo">
                              </div>

                              
                              <div class="col-md-3">
                                  <button type="button" id="toggle-button" class="btn btn-link">
                                    <i class="fas fa-eye"></i> Editar<!-- Ícono por defecto (mostrar) -->
                                </button>
                                  <input type="hidden" class="form-control" id="salario_seleccionado" name="salario_seleccionado" readonly>
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
                                                <select id="s_salario" name="s_salario" class="">
                                                    <option selected>SD</option>
                                                    <option>SDI</option>
                                                    <option>SN</option>
                                                </select>
                                            </td>
                                            <td id="dias">
                                                <input type="text" class="form-control" name="dias" value="{{ $datosbaja->d_salario_normal ?? $aldiadehoy }}">
                                            </td>
                                            @php
                                                $monto = $datosbaja->salario_normal ?? ($sd * $aldiadehoy);
                                                $montoFormateado = number_format($monto, 2);
                                            @endphp
                                            <td>
                                                <input type="text" name="monto_dias" readonly id="monto_dias" class="form-control readonly" value="{{ $montoFormateado }}">
                                            </td>
                                        </tr>

                                        <!-- Espacios para futuras filas, actualmente vacíos -->
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr></tr>
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
                                                  <input type="text" class="form-control" name="isr" value="{{ $datosbaja->isrfinal ?? '0.00' }}">
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
                                                  <input type="text" class="form-control" name="imss" value="{{ $datosbaja->imss ?? '0.00' }}">
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
                                                  <input type="text" class="form-control" name="deudores" value="{{ $datosbaja->deudores ?? '0.00' }}">
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
                                                  <input type="text" class="form-control" name="isr_finiquito" value="{{ $datosbaja->isr_finiquito ?? '0.00' }}">
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
                          // Define el valor total
                          $valorTotal = $datosbaja->total ?? $total;
                          // Formatea el valor total con dos decimales
                          $valorTotalFormateado = number_format($valorTotal, 2);
                      @endphp
                          </div>
                          <div class="col-md-2">
                             <input type="text" name="total" class="form-control" readonly value="{{ $valorTotalFormateado }}">
                          </div>

                          <!-- Botón para guardar -->
                          <div class="col-md-12 text-center">
                              <input type="hidden" name="id_baja" value="{{ $baja->id }}">
                              <input type="hidden" name="colaborador_id" value="{{ $baja->colaborador_id }}">
                              
                              <br>
                              <button type="submit" class="btn btn-info" name="guardar">Calcular</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
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
    }

    // Al cargar la página, verificar qué radio está seleccionado y actualizar el input
    window.onload = function() {
        const radioChecked = document.querySelector('input[name="salario_diario"]:checked');
        if (radioChecked) {
            updateSalarioSeleccionado(radioChecked.id);
        }
    };
</script>
@endpush
