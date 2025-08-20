@extends('layouts.app', ['activePage' => 'Hallazgos', 'menuParent' => 'auditoria', 'titlePage' => __('Editar Hallazgo')])

@section('content')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
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
</style>
<div class="content">
  <div class="container">
      <h2>Editar Hallazgo</h2>

      <form action="{{ route('hallazgo.update', $hallazgo->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <table class="table table-bordered">
            <tr>
                <th>Jefe responsable</th>
                <td colspan="3">{{ qcolab($hallazgo->jefe) }}</td>
            </tr>
            <tr>
                <th>Hallazgo</th>
                <td colspan="3">{!! nl2br(e($hallazgo->hallazgo)) !!}</td>
            </tr>
            <tr>
                <th>Sugerencia</th>
                <td colspan="3">{!! nl2br(e($hallazgo->sugerencia)) !!}</td>
            </tr>
            <tr>
                <th>Plan de acción</th>
                <td colspan="3">{!! nl2br(e($hallazgo->plan_de_accion)) !!}</td>
            </tr>
            <tr>
                <th>Fecha presentación</th>
                <td>{{ $hallazgo->fecha_presentacion }}</td>
                <th>Fecha compromiso</th>
                <td>{{ $hallazgo->fecha_compromiso }}</td>
            </tr>
             <tr>
                <th colspan="2">Fecha identifación</th>
                <td colspan="2">{{ $hallazgo->fecha_identificacion }}</td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td>{{ $hallazgo->tipo }}</td>
                <th>Estatus:</th>
                <td>{{ $hallazgo->estatus }}</td>
            </tr>
            <tr>
    <th>Comentarios Auditoria</th>
    <td colspan="3">
        <div class="chat-container">
            @foreach ($comentarios as $comentario)
                @if($comentario->id_user != auth()->user()->id)
                    <div class="message from-others">
                        <strong>{{ $comentario->usuario->name }}</strong><br>
                        {!! nl2br(e($comentario->comentario)) !!}
                        <div class="meta">{{ $comentario->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </td>
</tr>

<tr>
    <th>Comentarios</th>
    <td colspan="3">
        <div class="chat-container">
            @foreach ($comentarios as $comentario)
                @if($comentario->id_user == auth()->user()->id)
                    <div class="message from-me">
                        <strong>{{ $comentario->usuario->name }}</strong><br>
                        {!! nl2br(e($comentario->comentario)) !!}
                        <div class="meta">{{ $comentario->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </td>
</tr>
        </table>


          <div class="form-group">
              <label for="comentarios">Comentarios Colaborador</label>
              <!--
              <textarea id="comentarios" name="comentarios_colaborador" class="form-control" rows="3">{!! nl2br(e($hallazgo->comentarios_colaborador)) !!}</textarea>-->
              <textarea id="comentarios" name="comentarios_colaborador" class="form-control" rows="3"></textarea>
          </div>

          <div class="">
              @if($archivos)
              <p>Evidencia auditoria: </p>
                        @foreach ($archivos as $archivo)
                            @if($archivo->id_user!=auth()->user()->id)
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;"
                                id="archivo-{{ $archivo->id }}">
                                <a href="{{ asset('storage/app/public/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/'. $hallazgo->id . '/'. $archivo->id . '/' . $archivo->comentario) }}"
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
              <label for="evidencia">Evidencia colaborador</label>

                <div id="existing-files">
                    @if($archivos)
                        @foreach ($archivos as $archivo)
                            @if($archivo->id_user==auth()->user()->id)
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;"
                                id="archivo-{{ $archivo->id }}">
                                <a href="{{ asset('storage/app/public/auditorias/' . $auditoria->tipo . '/' . $auditoria->area . '/' . $auditoria->anio . '/' . $auditoria->folio . '/'. $hallazgo->id . '/'. $archivo->id . '/' . $archivo->comentario) }}"
                                    target="_blank">
                                    {{ $archivo->comentario }}
                                </a>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div id="file-inputs">
                    <input type="file" name="evidencia_colaborador[]" class="form-control mt-2">
                </div>

                <button type="button" id="add-file" class="btn btn-sm btn-default mt-2">+</button>

                <script>
                 document.addEventListener("DOMContentLoaded", function () {
                        document.getElementById('add-file').addEventListener('click', function () {
                            let fileInputs = document.getElementById('file-inputs');
                            let input = document.createElement('input');
                            input.type = 'file';
                            input.name = 'evidencia_colaborador[]';
                            input.classList.add('form-control', 'mt-2');
                            fileInputs.appendChild(input);
                        });

                        // Agregar evento a todos los botones de eliminar
                        document.querySelectorAll('.remove-file').forEach(button => {
                            button.addEventListener('click', function () {
                                let fileDiv = this.closest('.file-item'); // Obtener el div del archivo
                                if (fileDiv) {
                                    // Crear un input hidden para enviar a Laravel qué archivo eliminar
                                    let input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'eliminar_evidencias[]';
                                    input.value = this.getAttribute('data-file');

                                    // Agregar el input hidden al formulario antes de eliminar el div
                                    fileDiv.parentNode.appendChild(input);

                                    // Eliminar el elemento del DOM
                                    fileDiv.remove();
                                }
                            });
                        });
                    });

                </script>

          </div>


          <div class="text-center">
              <button type="submit" class="btn btn-info">Actualizar Hallazgo</button>
          </div>
      </form>
  </div>
</div>

@endsection
