@extends('layouts.app', ['activePage' => 'Entregables', 'menuParent' => 'forms', 'titlePage' => __('Entregas de Auditoría')])

@section('content')
    <div class="content">
        <h2>Listado de Entregas de Auditoría</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            /* Estilo para las Tabs */
.nav-tabs .nav-link {
    background-color: #495057!important;
    border: 1px solid #dee2e6!important;
    color: #dee2e6!important;
    margin-right: 5px;
    border-radius: 0.25rem;
}

.nav-tabs .nav-link.active {
    background-color: #007bff!important;
    color: #fff!important;
    border-color: #007bff!important;
}

.nav-tabs .nav-link:hover {
    background-color: #007bff!important;
    color: #007bff1!important;
}

.tab-content {
    border: 1px solid #dee2e6!important;
    border-top: none!important;
    background-color: #ffffff!important;
    padding: 20px;
    border-radius: 0 0 0.25rem 0.25rem;
}

        </style>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pendientes-tab" data-bs-toggle="tab" href="#pendientes" role="tab" aria-controls="pendientes" aria-selected="true">Pendientes</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="enviadas-tab" data-bs-toggle="tab" href="#enviadas" role="tab" aria-controls="enviadas" aria-selected="false">Enviadas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="completadas-tab" data-bs-toggle="tab" href="#completadas" role="tab" aria-controls="completadas" aria-selected="false">Completadas</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Tab Pendientes -->
            <div class="tab-pane fade show active" id="pendientes" role="tabpanel" aria-labelledby="pendientes-tab">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Días de Retraso</th>
                            <th>Subir archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_pendientes as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}</td>
                                <td>
                                    @php
                                        $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                        $hoy = \Carbon\Carbon::now();
                                        $diferencia = $hoy->diffInDays($fechaEntrega, false);
                                    @endphp

                                    @if ($diferencia >= 0)
                                        {{ $diferencia }} días restantes
                                    @else
                                        {{ abs($diferencia) }} días de retraso
                                    @endif
                                </td>

                                <td>
                                    <!-- El botón para cargar el archivo se muestra inicialmente, pero se oculta cuando hay un archivo seleccionado -->
                                    <form id="uploadForm" action="{{ route('entregas_auditoria.upload', ['id' => $entrega->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <!-- Input de tipo file, oculto visualmente pero accesible para selección -->
                                            <input type="file" style="display:none;" id="archivo_adjunto" name="archivo_adjunto" required>
                                        </div>

                                        <!-- Etiqueta que actúa como botón para abrir el selector de archivos -->
                                        <label for="archivo_adjunto" id="fileLabel" class="btn btn-link btn-sm">Cargar archivo</label>

                                        <!-- Nombre del archivo seleccionado (aparece solo si hay un archivo) -->
                                        <span id="fileName" style="display:none;"></span>

                                        <!-- El botón de enviar archivo, inicialmente oculto -->
                                        <button type="submit" id="submitBtn" class="btn btn-link" style="display:none;">Enviar Archivo</button>
                                    </form>
                                    @if($entrega->archivo_adjunto)
                                    <br>
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar</a>
                                    @endif
                                </td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab enviadas -->
            <div class="tab-pane fade" id="enviadas" role="tabpanel" aria-labelledby="enviadas-tab">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Días de Retraso</th>
                            <th>Archivo Adjunto</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_enviadas as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}</td>
                                <td>
                                    @php
                                        $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                        $fechaCompletada = \Carbon\Carbon::parse($entrega->fecha_completada);
                                        $diferencia = $fechaEntrega->diffInDays($fechaCompletada, false);
                                    @endphp

                                    @if ($diferencia >= 0)
                                        Sin retraso
                                    @else
                                        {{ abs($diferencia) }} días de retraso
                                    @endif
                                </td>
                                <td>
                                    @if($entrega->archivo_adjunto)
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar</a>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('entregas_auditoria.pendiente') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button class="btn btn-link text-success"> <i class="fa fa-check"></i> </button>
                                    </form>
                                    <form action="{{ route('entregas_auditoria.completar') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button class="btn btn-link text-danger"> <i class="fa fa-times"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Tab Completadas -->
            <div class="tab-pane fade" id="completadas" role="tabpanel" aria-labelledby="completadas-tab">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Días de Retraso</th>
                            <th>Archivo Adjunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_completadas as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_completada) }}</td>
                                <td>
                                    @php
                                        $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                        $fechaCompletada = \Carbon\Carbon::parse($entrega->fecha_completada);
                                        $diferencia = $fechaEntrega->diffInDays($fechaCompletada, false);
                                    @endphp

                                    @if ($diferencia >= 0)
                                        Sin retraso
                                    @else
                                        {{ abs($diferencia) }} días de retraso
                                    @endif
                                </td>
                                <td>
                                    @if($entrega->archivo_adjunto)
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   <!-- Modal -->
<div class="modal fade" id="modalSubirArchivo" tabindex="-1" aria-labelledby="modalSubirArchivoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSubirArchivoLabel">Subir Archivo Adjunto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="archivo_adjunto" class="form-label">Archivo Adjunto:</label>
                    <input type="file" class="form-control" id="archivo_adjunto" name="archivo_adjunto" required>
                </div>
                <button type="submit" class="btn btn-info">Subir Archivo</button>
            </form>

            </div>
        </div>
    </div>
</div>
<script>
    // Obtenemos los elementos relevantes del DOM
    const fileInput = document.getElementById('archivo_adjunto');
    const fileLabel = document.getElementById('fileLabel');
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');

    // Evento cuando se selecciona un archivo
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            // Si hay un archivo, mostrar el nombre y el botón de enviar
            const selectedFile = fileInput.files[0];
            fileName.style.display = 'inline'; // Mostrar nombre del archivo
            fileName.textContent = selectedFile.name; // Establecer el nombre del archivo

            submitBtn.style.display = 'inline'; // Mostrar el botón de enviar

            // Ocultar la etiqueta de "Cargar archivo"
            fileLabel.style.display = 'none';
        } else {
            // Si no hay archivo, ocultar el nombre y el botón de enviar
            fileName.style.display = 'none';
            submitBtn.style.display = 'none';
            fileLabel.style.display = 'inline'; // Mostrar nuevamente la etiqueta de "Cargar archivo"
        }
    });
</script>
@endsection
