<div class="card card-tasks">
    <div class="card-header">
        <h6 class="title d-inline">Pendientes</h6>
        <p class="card-category d-inline">today</p>
        <div class="dropdown">
            <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                <i class="tim-icons icon-settings-gear-63"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#pablo">Action</a>
                <a class="dropdown-item" href="#pablo">Another action</a>
                <a class="dropdown-item" href="#pablo">Something else</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-full-width table-responsive">
            <table class="table" id="pendientesTable">
                <tbody>
                    <!-- Los pendientes se cargarán aquí mediante AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("dashboard.cards.pendientes") }}',
            method: 'GET',
            success: function(data) {
                var tableBody = $('#pendientesTable tbody');
                tableBody.empty(); // Limpiar la tabla antes de agregar nuevos datos

                $.each(data, function(index, pendiente) {
                    tableBody.append(
                        '<tr>' +
                        '<td>' +
                        '<p class="title">' + pendiente.texto + '</p>' +
                        '<p class="text-muted">' + pendiente.fecha + '</p>' +
                        '</td>' +
                        '<td class="td-actions text-right">' +
                        '<a href="' + pendiente.ruta + '" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">' +
                        '>' +
                        '</a>' +
                        '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar los pendientes: ", error);
            }
        });
    });
</script>
