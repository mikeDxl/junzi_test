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
</style>

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
        background-color: #ffffff!important;  /* Establecer fondo blanco */
        border-collapse: collapse;  /* Asegura que las celdas no tengan separación */
    }

    td {
        font-size: 11pt!important;
    }

    th, td {
        padding: 8px;  /* Espaciado dentro de las celdas */
        text-align: left;  /* Alineación de texto en celdas */
    }

    /* Si tienes otras tablas específicas para colaboradores, puedes añadir más personalización */
    .table-bordered {
        border: 1px solid #ddd;  /* Bordes sutiles */
    }

    .table th, .table td {
        border: 1px solid #ddd;
    }
</style>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ubicaciones y Colaboradores</h5>
                    </div>
                    <div class="card-body">
                        <br>
                        <a href="/tabla/centros_de_costo">Centros de costo</a>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ubicación</th>
                                    <th>Salario Mensual</th>
                                    <th>Salario Anual</th>
                                    <th>Edad</th>
                                    <th>Antigüedad</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($ubicaciones as $nombreUbicacion => $ubicacionesGrupo)
                                <tr>
                                    <td> <button class="btn btn-link show-colaboradores" data-ubicacion-id="{{ $ubicacionesGrupo->first()->id }}">
                                            <i class="fa fa-plus"></i> 
                                        </button>
                                        {{ $nombreUbicacion }} ({{cantidadColaboradoresPorUbicacion($ubicacionesGrupo->first()->id)}})</td>
                                    <td>${{ number_format(sumarSalariosPorUbicacion($ubicacionesGrupo->first()->id)*30,2) }}</td>
                                    <td>${{ number_format(sumarSalariosPorUbicacion($ubicacionesGrupo->first()->id)*30*12,2) }}</td>
                                    <td>{{ promedioEdadPorUbicacion($ubicacionesGrupo->first()->id) }}</td>
                                    <td>{{ promedioAntiguedadPorUbicacion($ubicacionesGrupo->first()->id) }}</td>
                                </tr>
                                <!-- Aquí se insertará la tabla de colaboradores debajo de la ubicación -->
                                <tr id="colaboradores-row-{{ $ubicacionesGrupo->first()->id }}" style="display:none;">
                                    <td colspan="5">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Salario Mensual</th>
                                                    <th>Salario Anual</th>
                                                    <th>Edad</th>
                                                    <th>Antigüedad</th>
                                                </tr>
                                            </thead>
                                            <tbody class="colaboradores-list" id="colaboradores-list-{{ $ubicacionesGrupo->first()->id }}">
                                                <!-- Aquí se agregarán los colaboradores -->
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
      $('.show-colaboradores').click(function() {
        var ubicacionId = $(this).data('ubicacion-id');  // Obtener el ID de la ubicación

        $.ajax({
            url: '/ubicaciones/' + ubicacionId + '/colaboradores',  // Llamada al controlador
            type: 'GET',
            success: function(response) {
                if (response.error) {
                    alert(response.error);  // Si hubo un error
                    return;
                }

                // Mostrar la tabla de colaboradores correspondiente a la ubicación
                var tableRow = $('#colaboradores-row-' + ubicacionId);
                var colaboradoresList = $('#colaboradores-list-' + ubicacionId);
                colaboradoresList.empty();  // Limpiar cualquier contenido previo

                // Mostrar los colaboradores
                response.colaboradores.forEach(function(colaborador) {
                    var row = '<tr>' +
                        '<td>' + colaborador.nombre + '</td>' +
                        '<td>' + colaborador.salario_mensual + '</td>' +
                        '<td>' + colaborador.salario_anual + '</td>' +
                        '<td>' + colaborador.edad + '</td>' +
                        '<td>' + colaborador.antiguedad + '</td>' +
                        '</tr>';
                    colaboradoresList.append(row);
                });

                // Alternar la visibilidad de la tabla de colaboradores
                tableRow.toggle();
            },
            error: function(xhr, status, error) {
                console.log('Error al obtener colaboradores:', error);
            }
        });
      });
    </script>
@endpush
