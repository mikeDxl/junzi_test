@extends('layouts.app', ['activePage' => 'Hallazgos', 'menuParent' => 'auditoria', 'titlePage' => __('Editar Hallazgo')])

@section('content')
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 10px 0;
        }

        .message {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            position: relative;
            word-wrap: break-word;
        }

        .from-others {
            align-self: flex-start;
            background-color: #f1f0f0;
            border-top-left-radius: 0;
        }

        .from-me {
            align-self: flex-end;
            background-color: #dcf8c6;
            border-top-right-radius: 0;
            text-align: right;
        }

        .meta {
            font-size: 0.75rem;
            color: #666;
            margin-top: 5px;
        }

        .chat-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
    </style>

    <div class="content">
        <div class="container">
            <h2>Editar Hallazgo <span style="color: #6b7280;">({{ $hallazgo->estatus }})</span></h2>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('hallazgo.update', $hallazgo->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="colaborador_name">Colaborador</label>
                    <select id="colaborador_name" name="colaborador_id[]" multiple class="form-control">
                        @foreach($colaboradores as $col)
                            <option value="{{ $col->id }}" {{ in_array($col->id, explode(',', $hallazgo->responsable)) ? 'selected' : '' }}>
                                {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="colaborador_name2">Jefatura</label>
                    <select id="colaborador_name2" name="jefe" class="form-control">
                        <option value="">Selecciona</option>
                        @foreach($colaboradores as $col)
                            <option value="{{ $col->id }}" {{ $hallazgo->jefe == $col->id ? 'selected' : '' }}>
                                {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="hallazgo">Títiulo</label>
                    <select name="titulo" id="titulo" class="form-control">
                        @if(isset($hallazgo->titulo) && $hallazgo->titulo)
                            <option value="{{ $hallazgo->titulo }}" selected>
                                {{ $hallazgo->titysubtit->titulo . ' ' . $hallazgo->titysubtit->subtitulo }}
                            </option>
                        @else
                            <option value="">Selecciona una opción</option>
                        @endif
                        @foreach($titulos as $titulo)
                            @if($titulo->id != $hallazgo->titulo)
                                <option value="{{ $titulo->id }}" {{ isset($hallazgo->titulo) && $hallazgo->titulo == $titulo->id ? 'selected' : '' }}>
                                    {{ $titulo->titulo . ' ' . $titulo->subtitulo }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                </div>

                <div class="form-group">
                    <label for="hallazgo">Hallazgo</label>
                    <textarea id="hallazgo" name="hallazgo" class="form-control"
                        rows="3">{!! nl2br(e($hallazgo->hallazgo)) !!}</textarea>
                </div>

                <div class="form-group">
                    <label for="sugerencia">Sugerencia</label>
                    <textarea id="sugerencia" name="sugerencia" class="form-control"
                        rows="3">{!! nl2br(e($hallazgo->sugerencia)) !!}</textarea>
                </div>

                <div class="form-group">
                    <label for="plan_de_accion">Plan de acción</label>
                    <textarea id="plan_de_accion" name="plan_de_accion" class="form-control"
                        rows="3">{!! nl2br(e($hallazgo->plan_de_accion)) !!}</textarea>
                </div>

                <div class="form-group">
                    <label for="fecha_presentacion">Fecha presentación</label>
                    <input type="date" id="fecha_presentacion" name="fecha_presentacion" class="form-control"
                        value="{{ $hallazgo->fecha_presentacion }}">
                </div>

                <div class="form-group">
                    <label for="fecha_compromiso">Fecha compromiso</label>
                    <input type="date" id="fecha_compromiso" name="fecha_compromiso" class="form-control"
                        value="{{ $hallazgo->fecha_compromiso }}">
                </div>
                <div class="form-group">
                    <label for="fecha_identificacion">Fecha identificación</label>
                    <input type="date" id="fecha_identificacion" name="fecha_identificacion" class="form-control"
                        value="{{ $hallazgo->fecha_identificacion }}">
                </div>


                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                        <option value="Operativo" {{ $hallazgo->tipo == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                        <option value="Administrativo" {{ $hallazgo->tipo == 'Administrativo' ? 'selected' : '' }}>
                            Administrativo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comentarios">Comentarios Auditoria</label>
                    <textarea id="comentarios" name="comentarios" class="form-control" rows="3"></textarea>
                </div>



                <div id="message-container" style="display: none; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                    <p id="message-text"></p>
                </div>

                <div class="">
                    @if($archivos)
                        <p>Evidencias actuales: </p>
                        @foreach ($archivos as $archivo)
                            @if($archivo->id_user == auth()->user()->id)
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;"
                                    id="archivo-{{ $archivo->id }}">
                                    <a href="{{ asset('storage/app/public/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}"
                                        target="_blank">
                                        {{ $archivo->comentario }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <script>
                    // Eliminar archivo con AJAX
                    document.querySelectorAll('.btn-eliminar').forEach(button => {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();

                            var archivo = this.getAttribute('data-archivo');
                            var hallazgoId = this.getAttribute('data-hallazgo');

                            // Confirmar eliminación
                            if (!confirm('¿Estás seguro de que deseas eliminar esta evidencia?')) {
                                return;
                            }

                            // Enviar solicitud AJAX
                            fetch("{{ route('hallazgo.evidencia.eliminar', ['hallazgo' => '__hallazgo_id__']) }}".replace('__hallazgo_id__', hallazgoId), {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    archivo: archivo
                                })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    const messageContainer = document.getElementById('message-container');
                                    const messageText = document.getElementById('message-text');

                                    if (data.success) {
                                        // Mostrar mensaje de éxito
                                        messageContainer.style.display = 'block';
                                        messageContainer.style.backgroundColor = 'green';
                                        messageContainer.style.color = 'white';
                                        messageText.textContent = data.message;

                                        // Eliminar el archivo de la vista
                                        const archivoDiv = document.getElementById('archivo-' + archivo);
                                        archivoDiv.innerHTML = 'Archivo borrado';
                                        archivoDiv.style.color = 'green';
                                        setTimeout(() => archivoDiv.remove(), 3000); // Eliminar el div después de 3 segundos
                                    } else {
                                        // Mostrar mensaje de error
                                        messageContainer.style.display = 'block';
                                        messageContainer.style.backgroundColor = 'red';
                                        messageContainer.style.color = 'white';
                                        messageText.textContent = data.message;
                                    }

                                    // Ocultar el mensaje después de 5 segundos
                                    setTimeout(() => {
                                        messageContainer.style.display = 'none';
                                    }, 5000);
                                })
                                .catch(error => {
                                    // Mostrar mensaje de error
                                    const messageContainer = document.getElementById('message-container');
                                    const messageText = document.getElementById('message-text');
                                    messageContainer.style.display = 'block';
                                    messageContainer.style.backgroundColor = 'red';
                                    messageContainer.style.color = 'white';
                                    messageText.textContent = 'Error al procesar la solicitud.';

                                    // Ocultar el mensaje después de 5 segundos
                                    setTimeout(() => {
                                        messageContainer.style.display = 'none';
                                    }, 5000);
                                });
                        });
                    });

                </script>


                <br>
                <br>
                <br>
                <label for="evidencia">Evidencia</label>
                <input type="file" id="evidencia" name="evidencia[]" class="form-control" multiple>
        </div>
        <br>
        <br>
        <hr>

        <div class="form-group">
            <label for="fecha_presentacion">Fecha de respuesta</label>
            <p>{{ $hallazgo->fecha_colaborador }}</p>
        </div>
        @if($archivos)
            <p>Evidencia Colaborador: </p>
            @foreach ($archivos as $archivo)
                @if($archivo->id_user != auth()->user()->id)
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;" id="archivo-{{ $archivo->id }}">
                        <a href="{{ asset('storage/app/public/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/' . $hallazgo->id . '/' . $archivo->id . '/' . $archivo->comentario) }}"
                            target="_blank">
                            {{ $archivo->comentario }}
                        </a>
                    </div>
                @endif
            @endforeach
        @endif

        <br>
        <br>
        <br>
        <div class="form-group">
            <label for="comentarios">Comentarios Colaborador</label>
            @foreach ($comentarios as $comentario)
                @if($comentario->id_user != auth()->user()->id)
                    <p>Creado por: {{ $comentario->usuario->name }} {!! nl2br(e($comentario->comentario)) !!}</p>
                    <p>{{ $comentario->created_at->format('d/m/Y H:i') }}</p>
                @endif
            @endforeach

        </div>

        <div class="chat-container">
            <div class="chat-title">Conversación con Colaborador</div>

            @foreach ($comentarios as $comentario)
                @php
                    $esAuditoria = $comentario->id_user == auth()->user()->id;
                @endphp

                <div class="message {{ $esAuditoria ? 'from-me' : 'from-others' }}">
                    <strong>{{ $comentario->usuario->name }}</strong><br>
                    {!! nl2br(e($comentario->comentario)) !!}
                    <div class="meta">{{ $comentario->created_at->format('d/m/Y H:i') }}</div>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="fecha_cierre">Fecha de cierre</label>
            <input type="date" id="fecha_cierre" name="fecha_cierre" class="form-control"
                value="{{ $hallazgo->fecha_cierre }}">
        </div>

        <div class="text-center">
            <button id="submit-btn" type="submit" class="btn btn-info">Actualizar Hallazgo </button>
        </div>
        </form>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('hallazgo.cerrar',$hallazgo->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">Cerrar hallazgo</button>
                </form>
            </div>

            <div class="col-md-6 text-end text-right">
                <form action="{{ route('eliminar_hallazgo') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="{{ $hallazgo->id }}" name="hallazgo_id">
                    <button type="submit" class="btn btn-danger">Eliminar hallazgo</button>
                </form>
            </div>
        </div>
    </div>

    </div>

    <script>
        document.getElementById('submit-btn').addEventListener('click', function (event) {
            console.log('Botón de submit presionado');

            // Aquí debes forzar el envío del formulario
            this.closest('form').submit();
        });
    </script>

@endsection