@extends('layouts.app', ['activePage' => 'TrazabilidadVentas', 'menuParent' => 'ventas', 'titlePage' => __('Trazabilidad Ventas')])

@section('content')
<div class="content">
    <div class="container">
        <h2>Lista de Trazabilidad Ventas</h2>

        <a href="{{ route('trazabilidad_ventas.create') }}" class="btn btn-success mb-3">Crear Nuevo Registro</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Filtrar por</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('trazabilidad_ventas.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                <select class="form-control" id="anio" name="anio">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select class="form-control" id="mes" name="mes">
                                    @foreach($allMonths as $monthValue => $monthName)
                                        <option value="{{ $monthValue }}" {{ $monthValue == $selectedMonth ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-info">Filtrar</button>
                            <a href="{{ route('trazabilidad_ventas.index') }}" class="btn btn-default ml-2">Resetear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de datos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Planta</th>
                    <th>Nota de Entrega</th>
                    <th>Factura</th>
                    <th>Carta Porte</th>
                    <th>Complemento Carta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trazabilidadVentas as $trazabilidadVenta)
                    <tr>
                        <td>{{ $trazabilidadVenta->empresa }}</td>
                        <td>{{ $trazabilidadVenta->planta }}</td>
                        <td>{{ $trazabilidadVenta->nota_de_entrega }}</td>
                        <td>{{ $trazabilidadVenta->factura }}</td>
                        <td>{{ $trazabilidadVenta->carta_porte }}</td>
                        <td>{{ $trazabilidadVenta->complemento_carta }}</td>
                        <td>
                            <a href="{{ route('trazabilidad_ventas.edit', $trazabilidadVenta->id) }}" class="btn btn-info btn-sm">Editar</a>
                            <form action="{{ route('trazabilidad_ventas.destroy', $trazabilidadVenta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

                <!-- Nueva gráfica: Por Documento -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Estadísticas por Documento</h4>
            </div>
            <div class="card-body">
                <canvas id="ventasPorDocumentoChart" height="100"></canvas>
            </div>
        </div>

        <!-- Gráfica por Área (NUEVA) -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Estadísticas de Ventas por Planta</h4>
            </div>
            <div class="card-body">
                <canvas id="ventasAreaChart" height="100"></canvas>
            </div>
        </div>



    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxArea = document.getElementById('ventasAreaChart').getContext('2d');
    const chartDataArea = {
        areas: @json($chartDataAreas['areas']),
        nota_entrega: @json($chartDataAreas['nota_entrega']),
        factura: @json($chartDataAreas['factura']),
        carta_porte: @json($chartDataAreas['carta_porte']),
        complemento_carta: @json($chartDataAreas['complemento_carta'])
    };

    const replaceZeroWithNull = (value) => value === 0 ? null : value;

    const datasetsArea = [
        {
            label: 'Nota de Entrega',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.nota_entrega[area] || null)),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Factura',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.factura[area] || null)),
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Carta Porte',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.carta_porte[area] || null)),
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        },
        {
            label: 'Complemento Carta',
            data: chartDataArea.areas.map(area => replaceZeroWithNull(chartDataArea.complemento_carta[area] || null)),
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(255, 255, 255,0.2)',
            tension: 0.1,
            spanGaps: true
        }
    ];

    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: chartDataArea.areas,
            datasets: datasetsArea
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    min: 0,
                    title: {
                        display: true,
                        text: 'Porcentaje (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Plantas'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Métricas por planta'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw === null ?
                                `${context.dataset.label}: Sin dato` :
                                `${context.dataset.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });

    const ctxPorDocumento = document.getElementById('ventasPorDocumentoChart').getContext('2d');

    // Transformar los datos para que cada planta sea un dataset
    const documentos = ['Nota de Entrega', 'Factura', 'Carta Porte', 'Complemento Carta'];

    const plantas = chartDataArea.areas;

    const datasetsPorDocumento = plantas.map(planta => {
        return {
            label: planta,
            data: [
                replaceZeroWithNull(chartDataArea.nota_entrega[planta] || null),
                replaceZeroWithNull(chartDataArea.factura[planta] || null),
                replaceZeroWithNull(chartDataArea.carta_porte[planta] || null),
                replaceZeroWithNull(chartDataArea.complemento_carta[planta] || null)
            ],
            borderColor: `hsl(${Math.random() * 360}, 70%, 50%)`,
            backgroundColor: 'rgba(255,255,255,0.2)',
            tension: 0.1,
            spanGaps: true
        };
    });

    new Chart(ctxPorDocumento, {
        type: 'line',
        data: {
            labels: documentos,
            datasets: datasetsPorDocumento
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    min: 0,
                    title: {
                        display: true,
                        text: 'Porcentaje (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tipo de Documento'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Métricas por Documento'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw === null ?
                                `${context.dataset.label}: Sin dato` :
                                `${context.dataset.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });

});
</script>

@endsection
