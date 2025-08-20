@extends('layouts.app', ['activePage' => 'Entregables', 'menuParent' => 'forms', 'titlePage' => __('Entregables')])

@section('content')
    <div class="content">
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

        <h2>Programar Entregable para Auditoria</h2>

        <form action="{{ route('entregas_auditoria.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="id_reporte">Reporte</label>
                <select name="id_reporte" id="id_reporte" class="form-control">
                    <option value="">Seleccione un reporte</option>
                    @foreach($configReportes as $reporte)
                        <option value="{{ $reporte->id }}" data-periodo="{{ $reporte->periodo }}">
                            {{ $reporte->reporte }} ({{ $reporte->periodo }})
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="form-group" id="fecha_semanal" style="display: none;">
                <label for="dia_semanal">Día de la Semana</label>
                <select name="dia_semanal" id="dia_semanal" class="form-control">
                    <option value="">Seleccione un día</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sabado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
            </div>

            <div class="form-group" id="fecha_mensual" style="display: none;">
                <label for="dia_mensual">Día del Mes</label>
                <input type="number" name="dia_mensual" id="dia_mensual" class="form-control" min="1" max="31">
            </div>


            <div class="form-group">
                <label for="responsable">Responsable</label>
                <select name="responsable" id="responsable" class="form-control colabselect" required>
                    <option value="">Seleccione un Responsable</option>
                    @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador }}">{{ qcolab($colaborador) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Asignamos el evento change a #id_reporte
        $('#id_reporte').on('change', function() {
            // Verificamos si la función está ejecutándose
           // alert('Función ejecutada con jQuery');

            // Obtener el reporte seleccionado
            const reporte = $(this).find('option:selected');
            const periodo = reporte.data('periodo');

            // Depuración: Verificar qué valor se está obteniendo
            console.log('Periodo seleccionado:', periodo);

            // Ocultar todos los campos de fecha
            $('#fecha_semanal').hide();
            $('#fecha_mensual').hide();
            $('#fecha_de_entrega_group').hide(); // Asegurarse de que existe

            // Mostrar el campo adecuado dependiendo del periodo
            if (periodo === 'Semanal') {
                $('#fecha_semanal').show();
            } else if (periodo === 'Mensual') {
                $('#fecha_mensual').show();
            } else {
                $('#fecha_de_entrega_group').show();
            }
        });
    });
</script>

    </div>
@endsection
