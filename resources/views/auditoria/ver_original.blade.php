@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
    <style media="screen">
        .tabs-container {
            width: 100%;
            margin: 20px 0;
        }

        .custom-tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
        }

        .custom-tab-button {
            flex: 1;
            padding: 10px 20px;
            background-color: #f1f1f1;
            border: none;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .custom-tab-button.active {
            background-color: #3358f4;
            color: #ffffff;
            font-weight: bold;
            border-bottom: 2px solid #000;
        }

        .custom-tab-button:hover {
            background-color: #dddddd;
        }

        .custom-tab-content {
            padding: 20px;
            background-color: #ffffff;
        }

        .custom-tab-pane {
            display: none;
        }

        .custom-tab-pane.active {
            display: block;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table-header {
            background-color: #3358f4;
            color: #ffffff;
        }

        .custom-table th,
        .custom-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }

        .custom-table th {
            text-align: left;
        }

        .custom-button {
            background-color: #3358f4;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 14px;
        }

        .custom-button:hover {
            background-color: #2247d1;
        }

        th {
            color: #fff !important;
        }

        .responsables-cell {
            position: relative;
            /* Necesario para el posicionamiento absoluto del tooltip */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            /* Ajusta según sea necesario */
        }

        .responsables-tooltip {
            display: none;
            position: absolute;
            background: #333;
            color: #fff;
            padding: 10px;
            border-radius: 3px;
            z-index: 1000;
            max-width: 300px;
            word-wrap: break-word;
            left: 0;
            top: 100%;
            /* Asegura que el tooltip se muestre debajo de la celda */
            margin-top: 5px;
            /* Espacio entre la celda y el tooltip */
            white-space: normal;
            /* Permite el salto de línea en el tooltip */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* Agrega sombra para mejorar la visibilidad */
        }

        .responsables-cell:hover .responsables-tooltip {
            display: block;
        }

        .table-responsive {
            overflow: visible;
            /* Asegura que el contenido (tooltip) no se corte */
        }

        .tooltip-inner {
            max-width: 300px;
            /* Ajusta el ancho máximo del tooltip */
            white-space: normal;
            /* Permite el salto de línea */
            text-overflow: clip;
            /* Evita el recorte del texto */
        }

        .responsables-tooltip {
            display: block !important;
            position: absolute;
            background: #333;
            color: #fff;
            padding: 10px;
            border-radius: 3px;
            z-index: 1000;
            max-width: 300px;
            word-wrap: break-word;
            left: 0;
            top: 100%;
            margin-top: 5px;
            white-space: normal;
            box-shadow: 0 2px 5px rgba(253, 240, 240, 0.2);
        }

        .text-success{ color:green!important;}
    </style>
    <div class="content">
        <div class="">
            @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function () {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500); // elimina el elemento del DOM
            }
        }, 3000); // Desaparece después de 3 segundos
    </script>
@endif


            <h2>Hallazgos de la Auditoría:
                {{
        ($auditoria->tipo ?? '') . '-' .
        ($auditoria->area ?? '') . '-' .
        ($auditoria->anio ?? '') . '-' .
        ($auditoria->folio ?? '').'-'.$auditoria->id
                    }}
            </h2>


            <!-- Tabla de hallazgos -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr style="background:#424242;">
                            <th>{{ __('Área') }}</th>
                            <th>{{ __('Sub área') }}</th>
                            <th>{{ __('Hallazgo') }}</th>
                            <th>{{ __('Tipo') }}</th>
                            <th>{{ __('Fecha de Presentación') }}</th>
                            <th>{{ __('Fecha Compromiso') }}</th>
                            <th>{{ __('Fecha Identificación') }}</th>
                            <th>{{ __('Comentarios') }}</th>
                            <th>{{ __('Auditados') }}</th>
                            <th>{{ __('Jefe Auditado') }}</th>
                            <th>{{ __('Fecha de Cierre') }}</th>
                            <th>{{ __('Días de Tolerancia') }}</th>
                            <th>{{ __('Estatus') }}</th>
                            <th>{{ __('Respuesta') }}</th>
                            <th class="text-right">{{ __('Opciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hallazgos as $hallazgo)
                            @php
                                $responsableIds = explode(',', $hallazgo->responsable);
                                $auditados = array_map(function ($id) {
                                    return qcolab($id);
                                }, $responsableIds);
                                $nombresAuditados = implode(', ', $auditados);
                                $jefeAuditadoId = $hallazgo->jefe;
                                $fechaCompromiso = \Carbon\Carbon::parse($hallazgo->fecha_compromiso);

                                $fechaCierre = \Carbon\Carbon::parse($hallazgo->fecha_cierre);

                                // Obtener la fecha actual
                                $fechaActual = \Carbon\Carbon::now();

                                // Inicializar variable de días sin cerrar
                                $diasSinCerrar = null;

                                $diasCerrado = null;

                                // Solo calcular si no hay fecha de cierre
                                if (!$hallazgo->fecha_cierre) {
                                    // Calcular la diferencia en días (puede ser positiva o negativa)
                                    $diasSinCerrar = $fechaActual->diffInDays($fechaCompromiso, false);
                                } else {
                                    $diasCerrado = $fechaCierre->diffInDays($fechaCompromiso, false);
                                }
                              @endphp
                            @php
                                $responsableIds = explode(',', $hallazgo->responsable);
                            @endphp

                            @if(auth()->user()->auditoria != "1" && in_array(auth()->user()->colaborador_id, $responsableIds))
                            <tr>
                                <td> {{ $hallazgo->titysubtit->area ?? '' }} </td>
                                <td> {{ $hallazgo->titysubtit->titulo ?? '' }} </td>
                                <td> {{ $hallazgo->titysubtit->subtitulo ?? '' }} </td>
                                <td> {{ $hallazgo->tipo }} </td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_presentacion)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_compromiso)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_identificacion)->format('d/m/Y') }}</td>
                                <td title="{!! nl2br(e($hallazgo->comentarios)) !!}"> {!! nl2br(e($hallazgo->comentarios)) !!}
                                </td>
                                <td>
                                    @if(count($auditados) > 2)
                                        <span title="{{ $nombresAuditados }}">{{ count($responsableIds) }} auditados</span>
                                    @else
                                        {{ $nombresAuditados }}
                                    @endif
                                </td>
                                <td>{{ $jefeAuditadoId ? qcolab($jefeAuditadoId) : '' }}</td>
                                <td>{{ $hallazgo->fecha_cierre ? \Carbon\Carbon::parse($hallazgo->fecha_cierre)->format('d/m/Y') : '' }}
                                </td>
                                <td>
                                    @if(is_null($diasSinCerrar))
                                        {{ $diasCerrado }}
                                    @else
                                        <b class="{{ $diasSinCerrar >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $diasSinCerrar }}
                                        </b>
                                    @endif
                                </td>
                                <td> {{ $hallazgo->estatus }} </td>
                                <td> {{ $hallazgo->respuesta ?? '' }} </td>
                                <td class="text-right">
                                    @if($hallazgo->estatus != 'Cerrado' || auth()->user()->auditoria == '1')
                                        <a href="/hallazgo/{{ $hallazgo->id }}/edit" class="btn btn-link text-info">Ver hallazgo</a>
                                    @endif
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td> {{ $hallazgo->titysubtit->area ?? '' }} </td>
                                <td> {{ $hallazgo->titysubtit->titulo ?? '' }} </td>
                                <td> {{ $hallazgo->titysubtit->subtitulo ?? '' }} </td>
                                <td> {{ $hallazgo->tipo }} </td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_presentacion)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_compromiso)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($hallazgo->fecha_identificacion)->format('d/m/Y') }}</td>
                                <td title="{!! nl2br(e($hallazgo->comentarios)) !!}"> {!! nl2br(e($hallazgo->comentarios)) !!}
                                </td>
                                <td>
                                    @if(count($auditados) > 2)
                                        <span title="{{ $nombresAuditados }}">{{ count($responsableIds) }} auditados</span>
                                    @else
                                        {{ $nombresAuditados }}
                                    @endif
                                </td>
                                <td>{{ $jefeAuditadoId ? qcolab($jefeAuditadoId) : '' }}</td>
                                <td>{{ $hallazgo->fecha_cierre ? \Carbon\Carbon::parse($hallazgo->fecha_cierre)->format('d/m/Y') : '' }}
                                </td>
                                <td>
                                    @if(is_null($diasSinCerrar))
                                        {{ $diasCerrado }}
                                    @else
                                        <b class="{{ $diasSinCerrar >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $diasSinCerrar }}
                                        </b>
                                    @endif
                                </td>
                                <td> {{ $hallazgo->estatus }} </td>
                                <td> {{ $hallazgo->respuesta ?? '' }} </td>
                                <td class="text-right">
                                    @if($hallazgo->estatus != 'Cerrado' || auth()->user()->auditoria == '1')
                                        <a href="/hallazgo/{{ $hallazgo->id }}/edit" class="btn btn-link text-info">Ver hallazgo</a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach


                    </tbody>
                </table>
            </div>

            <!-- Formularios -->
            @if(auth()->user()->auditoria == '1')
                <div class="row">
                    <!-- Formulario para editar la auditoría -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header btn btn-link" data-toggle="collapse" data-target="#form-auditoria"
                                aria-expanded="true" aria-controls="form-auditoria">
                                Editar Auditoría
                            </div>
                            <div id="form-auditoria" class="collapse ">
                                <div class="card-body">
                                    <form action="{{ route('auditoria.update', $auditoria->id) }}" method="post">
                                        @csrf
                                        @method('PUT')

                                        <label>Tipo</label>
                                        <div class="form-group">
                                            <select class="form-control" name="tipo">
                                                <option value="Programada" {{ $auditoria->tipo == 'PRO' ? 'selected' : '' }}>Programada</option>
                                                <option value="Especial" {{ $auditoria->tipo == 'ESP' ? 'selected' : '' }}>Especial</option>
                                                <option value="Extraordinaria" {{ $auditoria->tipo == 'EXT' ? 'selected' : '' }}>Extraordinaria</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Empresa</label>
                                            <select class="form-control" name="area">
                                                <option value="" disabled>Seleccionar</option>
                                                @foreach($claves as $clave)
                                                    <option value="{{ $clave->clave }}" {{ $auditoria->area == $clave->clave ? 'selected' : '' }}>
                                                        {{ $clave->nombre }} ['{{ $clave->clave }}']
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info">Actualizar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario para crear un hallazgo -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header btn btn-link" data-toggle="collapse" data-target="#form-hallazgo"
                                aria-expanded="true" aria-controls="form-hallazgo">
                                Crear Hallazgo
                            </div>
                            <div id="form-hallazgo" class="collapse ">
                                <div class="card-body">
                                    <form action="{{ route('crear_hallazgo') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="colaborador_name">Colaborador</label>
                                            <select id="colaborador_name" name="colaborador_id[]" multiple class="form-control">
                                                @foreach($colaboradores as $col)
                                                    <option value="{{ $col->id }}">
                                                        {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="hallazgo">Área</label>
                                            <select name="area" id="areaseleccionada" class="form-control"
                                                onchange="filtrarTitulos()">
                                                <option value="">Selecciona</option>
                                                @foreach($areash as $areach)
                                                    <option value="{{ $areach }}">{{ $areach }}</option>
                                                @endforeach
                                            </select>


                                        </div>
                                        <div class="form-group">
                                            <label for="hallazgo">Título</label>
                                            <select name="titulo" id="tituloseleccionado" class="form-control"
                                                onchange="filtrarSubTitulos()">
                                                <option value="">Selecciona</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="hallazgo">Hallazgos</label>
                                            <select name="hallazgo" id="subtituloseleccionado" class="form-control">
                                                <option value="">Selecciona</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="sugerencia">Sugerencia</label>
                                            <textarea id="sugerencia" name="sugerencia" class="form-control"
                                                rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_de_accion">Plan de acción</label>
                                            <textarea id="plan_de_accion" name="plan_de_accion" class="form-control"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_presentacion">Fecha presentación de informe</label>
                                            <input type="date" id="fecha_presentacion" name="fecha_presentacion"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="fecha_compromiso">Fecha compromiso</label>
                                            <input type="date" id="fecha_compromiso" name="fecha_compromiso"
                                                class="form-control" min="">
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_identificacion">Fecha identificación</label>
                                            <input type="date" id="fecha_identificacion" name="fecha_identificacion"
                                                class="form-control" min="">
                                        </div>
                                        <!-- \Carbon\Carbon::now()->toDateString()  -->
                                        <div class="form-group">
                                            <label for="comentarios">Comentarios</label>
                                            <textarea id="comentarios" name="comentarios" class="form-control"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="">
                                            <label for="evidencia">Evidencia de auditoría</label>
                                            <input type="file" id="evidencia" name="evidencia" class="form-control">
                                        </div>
                                        <input type="hidden" name="tipo" value="{{ $auditoria->tipo }}">
                                        <input type="hidden" name="area" value="{{ $auditoria->area }}">
                                        <input type="hidden" name="ubicacion" value="{{ $auditoria->ubicacion }}">
                                        <input type="hidden" name="anio" value="{{ $auditoria->anio }}">
                                        <input type="hidden" name="folio" value="{{ $auditoria->folio }}">
                                        <input type="hidden" name="auditoria_id" value="{{ $auditoria->id }}">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info">Crear Hallazgo</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                <div class="col-md-12 text-end">
                    <form action="{{ route('eliminar_auditoria') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" value="{{ $auditoria->id }}" name="auditoria_id">
                        <button type="submit" class="btn btn-danger">Eliminar auditoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        function filtrarTitulos() {
            var areaSeleccionada = document.getElementById('areaseleccionada').value;
            console.log('Área seleccionada:', areaSeleccionada);

            if (areaSeleccionada) {
                $.ajax({
                    url: "{{ route('obtener-titulos') }}",
                    method: 'POST',
                    data: {
                        area: areaSeleccionada,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Titulos filtrados:', response);

                        // Asegurarse de que la respuesta sea un arreglo
                        if (Array.isArray(response)) {
                            var selectTitulo = document.getElementById('tituloseleccionado');
                            selectTitulo.innerHTML = '<option value="">Selecciona</option>';

                            response.forEach(function (titulo) {
                                var option = document.createElement('option');
                                option.value = titulo;
                                option.textContent = titulo;
                                selectTitulo.appendChild(option);
                            });
                        } else {
                            console.error("La respuesta no es un arreglo:", response);
                        }
                    },

                    error: function (xhr, status, error) {
                        console.error('Error en la petición:', error);
                    }
                });
            }
        }
    </script>
    <script>
        // Objeto para guardar la configuración de cada subtítulo
        var configSubtitulos = {};

        function filtrarSubTitulos() {
            var areaSeleccionada = document.getElementById('tituloseleccionado').value;
            console.log('Título seleccionado:', areaSeleccionada);

            if (areaSeleccionada) {
                $.ajax({
                    url: "{{ route('obtener-subtitulos') }}",
                    method: 'POST',
                    data: {
                        area: areaSeleccionada,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Subtítulos filtrados:', response);

                        if (Array.isArray(response)) {
                            var selectTitulo = document.getElementById('subtituloseleccionado');
                            selectTitulo.innerHTML = '<option value="">Selecciona</option>';

                            // Limpiar config anterior
                            configSubtitulos = {};

                            response.forEach(function (item) {
                                var option = document.createElement('option');
                                option.value = item.subtitulo;
                                option.textContent = item.subtitulo;
                                selectTitulo.appendChild(option);

                                // Guardar la config
                                configSubtitulos[item.subtitulo] = item.obligatorio;
                            });
                        } else {
                            console.error("La respuesta no es un arreglo:", response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la petición:', error);
                    }
                });
            }
        }

        // Ejecutar al cargar el documento
        document.addEventListener('DOMContentLoaded', function () {
            var selectSubtitulo = document.getElementById('subtituloseleccionado');
            var fechaInput = document.getElementById('fecha_compromiso');

            selectSubtitulo.addEventListener('change', function () {
                var subtituloSeleccionado = this.value;
                var obligatorio = configSubtitulos[subtituloSeleccionado];

                if (parseInt(obligatorio) === 1) {
                    fechaInput.setAttribute('required', 'required');
                    console.log("Campo 'fecha_compromiso' es obligatorio.");
                } else {
                    fechaInput.removeAttribute('required');
                    console.log("Campo 'fecha_compromiso' es opcional.");
                }

            });
        });
    </script>




@endsection
