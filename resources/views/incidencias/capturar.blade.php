@extends('layouts.app', ['activePage' => 'Incidencias', 'menuParent' => 'laravel', 'titlePage' => __('Incidencias')])

@section('content')
<style>
    .nav-tabs {
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        border-color: #e9ecef #e9ecef #dee2e6!important;
        color: #495057!important;
    }
    .nav-tabs .nav-link:hover {
        border-color: #e9ecef #e9ecef #dee2e6!important;
        color: #495057!important;
    }
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    .tab-content > .tab-pane {
        display: none;
    }
    .tab-content > .tab-pane.active {
        display: block;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Incidencias</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="incidenciasTabs" role="tablist">
                            @if(auth()->user()->perfil!="Colaborador")
                            <li class="nav-item">
                                <a class="nav-link active" id="horas-extra-tab" data-toggle="tab" href="#horas-extra" role="tab" aria-controls="horas-extra" aria-selected="true">Horas extra</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="asistencias-tab" data-toggle="tab" href="#asistencias" role="tab" aria-controls="asistencias" aria-selected="false">Asistencias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="permisos-tab" data-toggle="tab" href="#permisos" role="tab" aria-controls="permisos" aria-selected="false">Permisos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="compensaciones-tab" data-toggle="tab" href="#compensaciones" role="tab" aria-controls="compensaciones" aria-selected="false">Compensaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="incapacidades-tab" data-toggle="tab" href="#incapacidades" role="tab" aria-controls="incapacidades" aria-selected="false">Incapacidades</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="vacaciones-tab" data-toggle="tab" href="#vacaciones" role="tab" aria-controls="vacaciones" aria-selected="false">Vacaciones</a>
                            </li>
                            @endif
                            @if(auth()->user()->perfil=='Colaborador')
                            <li class="nav-item">
                                <a class="nav-link active" id="vacacionesc-tab" data-toggle="tab" href="#vacacionesc" role="tab" aria-controls="vacacionesc" aria-selected="false">Vacaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="permisosc-tab" data-toggle="tab" href="#permisosc" role="tab" aria-controls="permisosc" aria-selected="false">Permisos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="incapacidadesc-tab" data-toggle="tab" href="#incapacidadesc" role="tab" aria-controls="incapacidadesc" aria-selected="false">Incapacidades</a>
                            </li>
                            
                            @endif
                            
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content" id="incidenciasTabsContent">
                            @if(auth()->user()->perfil!='Colaborador')
                            <div class="tab-pane fade show active" id="horas-extra" role="tabpanel" aria-labelledby="horas-extra-tab">
                              <h3>Horas extras</h3>
                              <form class="" action="{{ route('guardar_horas_extras') }}" method="post">
                                @csrf
                                <div class="card-body">
                                  <div class="row">
                                  <div class="col-md-12 table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Colaborador</th>
                                          <th>Fecha</th>
                                          <th>Horas</th>
                                          <th>Comentario</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($colaboradores as $col)
                                          @if($col->id!=auth()->user()->colaborador_id)
                                          <tr>
                                            <td> {{ qcolab($col->id) }} <input type="hidden" class="form-control" name="colaborador_id[]" value="{{ $col->id }}"> </td>
                                            <td> <input type="date" min="{{ $fechaDosDiasHabilesAtras }}" max="{{ date('Y-m-d') }}" class="form-control" name="fecha[]" value=""> </td>
                                            <td> <input type="number" min="1" class="form-control" name="horas[]" value=""> </td>
                                            <td> <input type="text" name="comentarios[]" class="form-control" value=""> </td>
                                          </tr>
                                          @endif
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="col-md-12 text-center">
                                    <br> <button type="submit" class="btn btn-info" name="button">Capturar</button>
                                  </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="tab-pane fade" id="asistencias" role="tabpanel" aria-labelledby="asistencias-tab">
                              <h3>Asistencias</h3>
                              <form class="" action="{{ route('guardar_asistencias') }}" method="post">
                                @csrf
                                <div class="card-body">
                                  <div class="row">
                                  <div class="col-md-12 table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Colaborador</th>
                                          <th>Fecha</th>
                                          <th>Asistencia</th>
                                          <th>Comentario</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($colaboradores as $col)
                                          @if($col->id!=auth()->user()->colaborador_id)
                                          <tr>
                                            <td> {{ qcolab($col->id) }} <input type="hidden" class="form-control" name="colaborador_id[]" value="{{ $col->id }}"> </td>
                                            <td> <input type="date" class="form-control" name="fecha[]" value="{{ date('Y-m-d') }}"> </td>
                                            <td> <select class="form-control" name="asistencia[]">
                                              <option value="Asistencia">Asistencia</option>
                                              <option value="Retardo">Retardo</option>
                                              <option value="Falta">Falta</option>
                                            </select> </td>
                                            <td> <input type="text" name="comentarios[]" class="form-control" value=""> </td>
                                          </tr>
                                          @endif
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="col-md-12 text-center">
                                    <br> <button type="submit" class="btn btn-info" name="button">Capturar</button>
                                  </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="tab-pane fade" id="permisos" role="tabpanel" aria-labelledby="permisos-tab">
                              <h3>Permisos</h3>
                              <form action="{{ route('guardar_permisos') }}" method="post">
                                @csrf

                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id">
                                    <option value="">Selecciona una opción</option>
                                    @foreach($colaboradores as $col)
                                      @if($col->id!=auth()->user()->colaborador_id)
                                        <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <label>Fecha</label>
                                <div class="form-group">
                                  <input type="date" class="form-control"  name="fecha_permiso" value="" >
                                </div>
                                <label>Tipo</label>
                                <div class="form-group">
                                  <select class="form-control" name="tipo">
                                    <option value="">Selecciona</option>
                                    <option value="Con goce de sueldo">Con goce de sueldo</option>
                                    <option value="Sin goce de sueldo">Sin goce de sueldo</option>
                                  </select>
                                </div>
                                <label>Comentarios</label>
                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Crear</button>
                                </div>

                              </form>
                            </div>
                            <div class="tab-pane fade" id="compensaciones" role="tabpanel" aria-labelledby="compensaciones-tab">
                              <h3>Compensaciones</h3>
                              <form action="{{ route('guardar_gratificaciones') }}" method="post">
                                @csrf

                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id">
                                    <option value="">Selecciona una opción</option>
                                    @foreach($colaboradores as $col)
                                      @if($col->id!=auth()->user()->colaborador_id)
                                        <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <label>Fecha</label>
                                <div class="form-group">
                                  <input type="date" class="form-control"  name="fecha_gratificacion" value="" >
                                </div>
                                <label>Monto</label>
                                <div class="form-group">
                                  <input type="number" min="1" class="form-control" name="monto" value="">
                                </div>
                                <label>Comentarios</label>
                                <div class="form-group">
                                  <textarea name="comentarios" class="form-control"></textarea>
                                </div>
                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Crear</button>
                                </div>

                              </form>
                            </div>
                            <div class="tab-pane fade" id="incapacidades" role="tabpanel" aria-labelledby="incapacidades-tab">
                              <h3>Incapacidades</h3>
                              <form action="{{ route('guardar_incapacidades') }}" method="post">
                                @csrf
                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id">
                                    <option value="">Selecciona una opción</option>
                                    @foreach($colaboradores as $col)
                                      @if($col->id!=auth()->user()->colaborador_id)
                                        <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <label>Apartir del </label>
                                <div class="form-group">
                                  <input type="date" class="form-control"  name="apartir" value="" id="apartir">
                                </div>
                                <label>Expedido el</label>
                                <div class="form-group">
                                  <input type="date" class="form-control"  name="expedido" value="" id="expedido">
                                </div>
                                <label>Número de días autorizados</label>
                                <div class="form-group">
                                  <input type="number" min="1" class="form-control" name="dias" value="">
                                </div>
                                <label>Comentarios</label>
                                <div class="form-group">
                                  <textarea name="comentarios" class="form-control"></textarea>
                                </div>
                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Crear</button>
                                </div>

                              </form>
                            </div>
                            <div class="tab-pane fade" id="vacaciones" role="tabpanel" aria-labelledby="vacaciones-tab">
                              <h3>Vacaciones</h3>
                              <form action="{{ route('guardar_vacaciones') }}" method="post">
                                @csrf

                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id" id="colaborador_id_vacaciones">
                                    <option value="">Selecciona una opción</option>
                                    @foreach($colaboradores as $col)
                                      @if($col->id!=auth()->user()->colaborador_id)
                                        <option value="{{ $col->id }}">{{ $col->nombre.' '.$col->apellido_paterno.' '.$col->apellido_materno }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>

                                <p>Dias de vacaciones del colaborador:  <span id="diasdevacaciones"></span> </p>

                                <label>Fecha inicio</label>
                                <div class="form-group">
                                  <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio_vacaciones" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>

                                <label>Fecha fin</label>
                                <div class="form-group">
                                  <input type="date" class="form-control" name="fecha_fin" id="fecha_fin_vacaciones" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>

                                <p>Total días:  <span id="totaldias">0</span></p>
                                <p id="error-mensaje" style="color:red;"></p> <!-- Mensaje de error -->

                                <label>Comentarios</label>
                                <div class="form-group">
                                  <textarea name="comentarios" class="form-control"></textarea>
                                </div>

                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Crear</button>
                                </div>

                              </form>
                            </div>
                            @endif
                            @if(auth()->user()->perfil=='Colaborador')
                            <div class="tab-pane fade show active" id="vacacionesc" role="tabpanel" aria-labelledby="vacacionesc-tab">
                              <h3>Vacaciones</h3>
                              <form action="{{ route('guardar_vacaciones') }}" method="post">
                                @csrf

                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id" id="colaborador_id_vacaciones_2">
                                    <option value="{{ auth()->user()->colaborador_id }}">{{ auth()->user()->name }}</option>
                                  </select>
                                </div>

                                <p>Dias de vacaciones del colaborador:  <span id="diasdevacaciones2">{{ buscarDiasVacacionesC(auth()->user()->colaborador_id) }}</span> </p>

                                <label>Fecha inicio</label>
                                <div class="form-group">
                                  <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio_vacaciones2" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>

                                <label>Fecha fin</label>
                                <div class="form-group">
                                  <input type="date" class="form-control" name="fecha_fin" id="fecha_fin_vacaciones2" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>

                                <p>Total días a tomar:  <span id="totaldias2">0</span></p>
                                <p id="error-mensaje2" style="color:red;"></p>

                                <label>Comentarios</label>
                                <div class="form-group">
                                  <textarea name="comentarios" class="form-control"></textarea>
                                </div>

                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Solcitar</button>
                                </div>

                              </form>
                            </div>
                            <div class="tab-pane fade" id="permisosc" role="tabpanel" aria-labelledby="permisosc-tab">
                              <h3>Permisos</h3>
                              <form action="{{ route('guardar_permisos') }}" method="post">
                                @csrf

                                <label>Colaboradores</label>
                                <div class="form-group">
                                  <select class="form-control" name="colaborador_id">
                                    <option value="{{ auth()->user()->colaborador_id }}">{{ auth()->user()->name }}</option>
                                  </select>
                                </div>
                                <label>Fecha</label>
                                <div class="form-group">
                                  <input type="date" class="form-control"  name="fecha_permiso" value="" min="{{ date('Y-m-d') }}">
                                </div>
                                <label>Comentarios</label>
                                <div class="form-group">
                                <textarea class="form-control" name="comentarios"></textarea>
                                </div>
                                <div class="text-center">
                                  <button type="submit" class="btn btn-info" name="button">Solicitar</button>
                                </div>
                              </form>
                            </div>
                            <div class="tab-pane fade" id="incapacidadesc" role="tabpanel" aria-labelledby="incapacidadesc-tab">
                              <h3>Incapacidades</h3>
                              <form action="{{ route('guardar_incapacidades') }}" method="post" enctype="multipart/form-data">
                                  @csrf
                                  <label>Colaboradores</label>
                                  <div class="form-group">
                                      <select class="form-control" name="colaborador_id">
                                          <option value="{{ auth()->user()->colaborador_id }}">{{ auth()->user()->name }}</option>
                                      </select>
                                  </div>
                                  <label>Apartir del </label>
                                  <div class="form-group">
                                      <input type="date" class="form-control" name="apartir" value="" id="apartir">
                                  </div>
                                  <label>Expedido el</label>
                                  <div class="form-group">
                                      <input type="date" class="form-control" name="expedido" value="" id="expedido">
                                  </div>
                                  <label>Número de días autorizados</label>
                                  <div class="form-group">
                                      <input type="number" min="1" class="form-control" name="dias" value="">
                                  </div>
                                  <label>Comentarios</label>
                                  <div class="form-group">
                                      <textarea name="comentarios" class="form-control"></textarea>
                                  </div>
                                  <label>Archivo</label>
                                  <div class="">
                                      <input type="file" class="form-control" name="archivo">
                                  </div>
                                  <div class="text-center">
                                      <button type="submit" class="btn btn-info" name="button">Solicitar</button>
                                  </div>
                              </form>

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#colaborador_id_vacaciones').on('change', function() {
            var colaboradorId = $(this).val();

            if (colaboradorId) {
                $.ajax({
                    url: '/colaborador/vacaciones/' + colaboradorId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#diasdevacaciones').text(response.dias);
                    },
                    error: function() {
                        $('#diasdevacaciones').text('Error al obtener días de vacaciones');
                    }
                });
            } else {
                $('#diasdevacaciones').text('0');
            }
        });
    });
</script>
@if(auth()->user()->perfil=='Colaborador')

<script>
    $(document).ready(function() {
        function calculateTotalDays2() {
            var startDate = $('#fecha_inicio_vacaciones2').val();
            var endDate = $('#fecha_fin_vacaciones2').val();
            var availableDays = parseInt($('#diasdevacaciones2').text()); // Días disponibles

            if (startDate && endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);

                if (end >= start) {
                    var totalDays = 0;

                    // Recorremos cada día entre las fechas
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        // Verificar si el día no es domingo (día 0)
                        if (currentDate.getDay() !== 0) {
                            totalDays++;
                        }
                        // Avanzar al siguiente día
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    $('#totaldias2').text(totalDays);

                    // Verificar si los días seleccionados exceden los días disponibles
                    if (totalDays > availableDays) {
                        $('#error-mensaje2').text('Las fechas seleccionadas exceden los días que tienes libres para vacaciones.');
                    } else {
                        $('#error-mensaje2').text(''); // Limpiar el mensaje de error si es válido
                    }
                } else {
                    $('#totaldias2').text('0');
                    $('#error-mensaje2').text('La fecha de fin no puede ser anterior a la fecha de inicio.');
                }
            } else {
                $('#totaldias2').text('0');
                $('#error-mensaje2').text('');
            }
        }

        // Llamar a la función cuando se cambian las fechas del formulario duplicado
        $('#fecha_inicio_vacaciones2, #fecha_fin_vacaciones2').on('change', calculateTotalDays2);
    });
</script>



@endif

<script>
    $(document).ready(function() {
        function calculateTotalDays() {
            var startDate = $('#fecha_inicio_vacaciones').val();
            var endDate = $('#fecha_fin_vacaciones').val();
            var availableDays = parseInt($('#diasdevacaciones').text()); // Días disponibles

            if (startDate && endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);

                if (end >= start) {
                    var totalDays = 0;

                    // Recorremos cada día entre las fechas
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        // Verificar si el día no es domingo (día 0)
                        if (currentDate.getDay() !== 0) {
                            totalDays++;
                        }
                        // Avanzar al siguiente día
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    $('#totaldias').text(totalDays);

                    // Verificar si los días seleccionados exceden los días disponibles
                    if (totalDays > availableDays) {
                        $('#error-mensaje').text('Las fechas seleccionadas exceden los días que tienes libres para vacaciones.');
                    } else {
                        $('#error-mensaje').text(''); // Limpiar el mensaje de error si es válido
                    }
                } else {
                    $('#totaldias').text('0');
                    $('#error-mensaje').text('La fecha de fin no puede ser anterior a la fecha de inicio.');
                }
            } else {
                $('#totaldias').text('0');
                $('#error-mensaje').text('');
            }
        }

        // Llamar a la función cuando se cambian las fechas
        $('#fecha_inicio_vacaciones, #fecha_fin_vacaciones').on('change', calculateTotalDays);
    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#incidenciasTabs a'));
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</s>


@endpush
