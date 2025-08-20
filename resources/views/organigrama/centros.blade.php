@extends('layouts.app', ['activePage' => 'Costos', 'menuParent' => 'laravel', 'titlePage' => __('Costos')])

@section('content')
    <style>
        .card-body h5 {
            margin-top: 3px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .card {
            margin-bottom: 0px!important;
            margin-top: 0px!important;
            padding-bottom: 0px!important;
            padding-top: 0px!important;
        }
        .card-body {
            margin-bottom: 0px!important;
            margin-top: 0px!important;
            padding-bottom: 0px!important;
            padding-top: 0px!important;
        }
        .card-header {
            margin-bottom: 0px!important;
            margin-top: 0px!important;
            padding-bottom: 0px!important;
            padding-top: 0px!important;
        }
        table {
            margin-bottom: 0px!important;
            margin-top: 0px!important;
            padding-bottom: 0px!important;
            padding-top: 0px!important;
        }
        td {
            font-size: 11pt!important;
        }

        .tabla-puestos {
            background-color: white !important;
        }

        .tabla-puestos td, .tabla-puestos th {
            background-color: white !important;
        }
    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="/tabla/ubicaciones">Ubicaciones</a>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Centro de costo</th>
                                        <th style="width: 15%;">Salario mensual</th>
                                        <th style="width: 15%;">Salario anual</th>
                                        <th style="width: 15%;">Edad</th>
                                        <th style="width: 15%;">Antigüedad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($centrosDeCosto as $centro)
                                        <tr>
                                            <td>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#puestos-row-{{ $centro->id }}" aria-expanded="false" aria-controls="puestos-row-{{ $centro->id }}">
                                                    <i class="fa fa-plus"></i> {{ $centro->centro_de_costo ?: 'Sin nombre' }} ({{cantidadColaboradoresActivosPorCentro($centro->id)}})
                                                </button>
                                            </td>
                                            <td>${{ number_format(sumarSalariosDiariosPorCentro($centro->id),2) }}</td>
                                            <td>${{ number_format(sumarSalariosDiariosPorCentro($centro->id)*12,2) }}</td>
                                            <td>{{ edadPromedioPorCentro($centro->id) }}</td>
                                            <td>{{ antiguedadPromedioPorCentro($centro->id) }}</td>
                                        </tr>

                                        <tr id="puestos-row-{{ $centro->id }}" class="collapse">
                                            <td colspan="5">
                                                <table class="table table-sm table-bordered tabla-puestos">
                                                    <thead>
                                                        <tr>
                                                            <th>Puesto</th>
                                                            <th>Salario mensual</th>
                                                            <th>Salario anual</th>
                                                            <th>Prom. Edad</th>
                                                            <th>Prom. Antigüedad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="puestos-list-{{ $centro->id }}">
                                                        <!-- Aquí se cargarán los puestos mediante AJAX -->
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Cargar puestos de centro de costo cuando se hace click
    $('button[data-toggle="collapse"]').on('click', function() {
        var centroDeCostoId = $(this).data('target').split('-')[2]; // Extraer el centroDeCostoId
        var contenedor = $('#puestos-list-' + centroDeCostoId);

        // Verificar si ya se cargaron los puestos
        if (contenedor.children().length === 0) {
            $.ajax({
                url: '{{ url("/centros") }}/' + centroDeCostoId + '/puestos', // Asegúrate de que esta URL sea correcta
                method: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        var html = '';
                        response.forEach(function(puesto) {
                            html += '<tr>';
                            // Nombre del puesto con el botón de "Ver colaboradores" al lado
                            html += '<td> <button class="btn btn-link cargar-colaboradores" data-id="' + puesto.id_catalogo_puestos_id + '" data-toggle="collapse" data-target="#colaboradores-row-' + puesto.id_catalogo_puestos_id + '"><i class="fa fa-plus"></i></button>' + puesto.catalogo_puesto.puesto + '</td>';
                            html += '<td>' + (puesto.salario_mensual || '-') + '</td>';
                            html += '<td>' + (puesto.salario_anual || '-') + '</td>';
                            html += '<td>' + (puesto.edad || '-') + '</td>';
                            html += '<td>' + (puesto.antiguedad || '-') + '</td>';
                            // Agregar una fila de colaboradores (vacía inicialmente)
                            html += '<tr id="colaboradores-row-' + puesto.id_catalogo_puestos_id + '" class="collapse">';
                            html += '<td colspan="5"><table class="table table-sm table-bordered tabla-puestos">';
                            html += '<thead><tr><th>Nombre</th><th>Salario mensual</th><th>Salario anual</th><th>Prom. Edad</th><th>Prom. Antigüedad</th></tr></thead>';
                            html += '<tbody id="colaboradores-list-' + puesto.id_catalogo_puestos_id + '"></tbody>';
                            html += '</table></td>';
                            html += '</tr>';
                        });
                        contenedor.html(html);
                    } else {
                        contenedor.html('<tr><td colspan="5">No hay puestos asociados.</td></tr>');
                    }
                },
                error: function() {
                    contenedor.html('<tr><td colspan="5">Error al cargar los puestos.</td></tr>');
                }
            });
        }
    });
});

</script>
<script>
  $(document).ready(function() {
    // Cargar colaboradores al hacer click en el botón de ver colaboradores
    $('body').on('click', '.cargar-colaboradores', function() {
        var puestoId = $(this).data('id'); // Extraer el puestoId
        var colaboradoresContenedor = $('#colaboradores-list-' + puestoId);

        // Verificar si ya se cargaron los colaboradores
        if (colaboradoresContenedor.children().length === 0) {
            $.ajax({
                url: '{{ url("/puestos") }}/' + puestoId + '/colaboradores', // Ruta para obtener colaboradores
                method: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        var html = '';
                        response.forEach(function(colaborador) {
                            html += '<tr>';
                            html += '<td>' + colaborador.nombre + '</td>'; // Mostrar el nombre del colaborador
                            html += '<td>' + (colaborador.salario_mensual || '-') + '</td>'; // Mostrar salario mensual
                            html += '<td>' + (colaborador.salario_anual || '-') + '</td>'; // Mostrar salario anual
                            html += '<td>' + (colaborador.edad || '-') + '</td>'; // Mostrar edad
                            html += '<td>' + (colaborador.antiguedad || '-') + '</td>'; // Mostrar antigüedad
                            html += '</tr>';
                        });
                        colaboradoresContenedor.html(html);
                    } else {
                        colaboradoresContenedor.html('<tr><td colspan="5">No hay colaboradores</td></tr>');
                    }
                },
                error: function() {
                    colaboradoresContenedor.html('<tr><td colspan="5">Error al cargar colaboradores</td></tr>');
                }
            });
        }
    });
});

</script>


@endpush
