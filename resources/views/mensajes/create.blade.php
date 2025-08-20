@extends('layouts.app', ['activePage' => 'Mensajes', 'menuParent' => 'laravel', 'titlePage' => __('Crear Mensaje')])

@section('content')

<div class="content">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <form action="{{ route('mensajes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="grupo_id">Seleccionar Grupo</label>
            <select name="grupo_id" id="grupo_id" class="form-control" required>
                <option value="">Seleccione un grupo</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="contenido" class="form-control" rows="10"></textarea>
        </div>

        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha_fin">Fecha de Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
        </div>

        <button type="submit" class="btn btn-info btn-sm">Guardar Mensaje</button>
    </form>
</div>

@endsection

@push('js')
<script src="https://cdn.tiny.cloud/1/36uuscduiw1ba0hfj8mmvt8fsenzyfpx4dsn208frjlqvccu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
 tinymce.init({
    selector: '#mensaje',
    plugins: 'lists link image preview paste imagetools',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | preview',
    images_upload_url: '/upload-image', // Ruta para manejar la subida de imágenes
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr = new XMLHttpRequest();
        var formData = new FormData();
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        xhr.withCredentials = false;
        xhr.open('POST', '/upload-image');

        // Agregar el token CSRF a las cabeceras
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onload = function() {
            if (xhr.status < 200 || xhr.status >= 300) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            var json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.location);
        };

        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    },
});


</script>
@endpush
