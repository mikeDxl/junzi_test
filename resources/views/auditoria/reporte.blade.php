@extends('home', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])
@section('contentJunzi')
<div class="content">
    <div class="container-fluid">
        <h1 class="text-center mb-4">Reportes de Auditoría</h1>
        <div class="row">
            <div class="col-md-12">
            <form method="GET" action="{{ route('reportes-auditoria') }}">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="area_id">Área</label>
                            <select name="area_id" id="area_id" class="form-control">
                                <option value="all">Todas las áreas</option>
                                @foreach($todasAreas as $area)
                                    <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ "$area->nombre - ($area->clave)" }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_desde">Desde</label>
                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                value="{{ request('fecha_desde', $fechaDesde) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_hasta">Hasta</label>
                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                value="{{ request('fecha_hasta', $fechaHasta) }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-info w-100">Filtrar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="table-responsive">
        <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Clave</th>
                    <th>Hallazgos con compromiso en rango</th>
                    <th>Días totales de retraso</th>
                    <th>Promedio días de retraso</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $area)
                    <tr>
                        <td>{{ $area['nombre'] }}</td>
                        <td>{{ $area['clave'] }}</td>
                        <td>{{ $area['hallazgos_compromiso'] }}</td>
                        <td>{{ $area['suma_dias_retraso'] }}</td>
                        <td>{{ $area['promedio_retraso'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay datos disponibles</td>
                    </tr>
                @endforelse

                @if($data->isNotEmpty())
                    @php
                        $totalHallazgos = array_sum(array_column($data->toArray(), 'hallazgos_compromiso'));
                        $totalDiasRetraso = array_sum(array_column($data->toArray(), 'suma_dias_retraso'));
                        $promedioGeneral = $totalHallazgos > 0 ? round($totalDiasRetraso / $totalHallazgos, 2) : 0;
                    @endphp
                    <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                        <td colspan="2" class="text-right">TOTALES:</td>
                        <td>{{ $totalHallazgos }}</td>
                        <td>{{ $totalDiasRetraso }}</td>
                        <td>{{ $promedioGeneral }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
