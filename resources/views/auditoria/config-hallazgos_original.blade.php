@extends('layouts.app', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])


@section('content')
<div class="content">
    <h1>Configuración de Hallazgos</h1>

    <!-- Botón para abrir el modal de creación -->
    <button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo Hallazgo</button>

    <!-- Tabla de listado -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha obligatoria</th>
                <th>Área</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Subtítulo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hallazgos as $hallazgo)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <input type="checkbox" class="toggle-obligatorio"
                        data-id="{{ $hallazgo->id }}"
                        {{ $hallazgo->obligatorio ? 'checked' : '' }}>
                </td>
                <td>{{ $hallazgo->area }}</td>
                <td>{{ $hallazgo->titulo }}</td>
                <td>{{ $hallazgo->tipo }}</td>
                <td>{{ $hallazgo->subtitulo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-obligatorio').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const hallazgoId = this.dataset.id;
            const nuevoEstado = this.checked ? 1 : 0;

            fetch(`/config-hallazgos/obligatorio/${hallazgoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    obligatorio: nuevoEstado
                })
            })
            .then(response => {
                if (!response.ok) throw new Error("Error al actualizar");
                return response.json();
            })
            .then(data => {
                console.log("Actualizado correctamente:", data);
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Hubo un problema al actualizar el estado.");
            });
        });
    });
});
</script>


<!-- Modal de creación -->
<!-- Modal de creación --><!-- Modal de creación -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createForm" method="POST" action="{{ route('config.hallazgos.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Nuevo Hallazgo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campo de selección de área -->
                    <div class="mb-3">
                    <label for="area" class="form-label">Área</label>
                    <select name="area" id="area" class="form-control" required>
                        <option value="">Selecciona un área</option>
                        @foreach($areas as $area)
                            <option value="{{ $area }}">{{ $area }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="addAreaBtn" class="btn btn-link mt-2">Agregar nueva área</button>
                    <input type="text" id="new-area" name="area_nueva" class="form-control mt-2" placeholder="Agregar nueva área" style="display: none;">
                </div>

                <!-- Campo de selección de título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <select name="titulo" id="titulo" class="form-control">
                        <option value="">Selecciona un título</option>
                        @foreach($titulos as $titulo)
                            <option value="{{ $titulo }}">{{ $titulo }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="addTituloBtn" class="btn btn-link mt-2">Agregar nuevo título</button>
                    <input type="text" id="new-titulo" name="titulo_nuevo" class="form-control mt-2" placeholder="Agregar nuevo título" style="display: none;">
                </div>

                <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" required>
                            <option value="">Selecciona:</option>
                            <option value="OPERATIVO">OPERATIVO</option>
                            <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                            <option value="OPERATIVO / ADMINISTRATIVO">OPERATIVO / ADMINISTRATIVO</option>
                            <option value="ADM., OP y RH">ADM., OP y RH</option>
                            <option value="CONTABILIDAD">CONTABILIDAD</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subtitulo" class="form-label">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Modal de edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Hallazgo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Área</label>
                        <input type="text" name="area" id="edit-area" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="edit-titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="">Selecciona:</option>
                            <option value="OPERATIVO">OPERATIVO</option>
                            <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                            <option value="OPERATIVO / ADMINISTRATIVO">OPERATIVO / ADMINISTRATIVO</option>
                            <option value="ADM., OP y RH">ADM., OP y RH</option>
                            <option value="ADM., OP y RH">CONTABLE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-subtitulo" class="form-label">Subtítulo</label>
                        <input type="text" name="subtitulo" id="edit-subtitulo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Enviar formulario de creación
    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('{{ route('config.hallazgos.store') }}', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => location.reload());
    });

    // Rellenar modal de edición
    document.querySelectorAll('[data-bs-target="#editModal"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-area').value = button.dataset.area;
            document.getElementById('edit-titulo').value = button.dataset.titulo;
            document.getElementById('edit-subtitulo').value = button.dataset.subtitulo;
        });
    });

    // Enviar formulario de edición
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit-id').value;
        const formData = new FormData(this);
        fetch(`{{ url('/config-hallazgos/update') }}/${id}`, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => location.reload());
    });

    // Eliminar registro
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            fetch(`{{ url('/config-hallazgos/destroy') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => location.reload());
        });
    });
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const addAreaBtn = document.getElementById('addAreaBtn');
    const addTituloBtn = document.getElementById('addTituloBtn');
    const newAreaInput = document.getElementById('new-area');
    const newTituloInput = document.getElementById('new-titulo');
    const areaSelect = document.getElementById('area');
    const tituloSelect = document.getElementById('titulo');

    // Mostrar campo para nueva área cuando el usuario hace clic en el botón
    addAreaBtn.addEventListener('click', () => {
        newAreaInput.style.display = 'block';
        addAreaBtn.style.display = 'none'; // Ocultar el botón de agregar
        areaSelect.removeAttribute('required'); // Desactivar el required del select
    });

    // Mostrar campo para nuevo título cuando el usuario hace clic en el botón
    addTituloBtn.addEventListener('click', () => {
        newTituloInput.style.display = 'block';
        addTituloBtn.style.display = 'none'; // Ocultar el botón de agregar
        tituloSelect.removeAttribute('required'); // Desactivar el required del select
    });

    // Validación y envío del formulario
    const createForm = document.getElementById('createForm');
    createForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Verificar si el área o el título son nuevos o existentes
        if (!areaSelect.value && !newAreaInput.value) {
            alert('Debes seleccionar o agregar un área.');
            return;
        }

        if (!tituloSelect.value && !newTituloInput.value) {
            alert('Debes seleccionar o agregar un título.');
            return;
        }

        // Enviar el formulario
        //createForm.submit();
        window.location.reload(true);

    });


});

</script>
@endsection
