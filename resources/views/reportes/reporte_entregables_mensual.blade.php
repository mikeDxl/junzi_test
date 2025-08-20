@extends('home', ['activePage' => 'Reporte Mensual', 'menuParent' => 'laravel', 'titlePage' => __('Reporte de Entregables Mensual')])

@section('contentJunzi')
<div class="content">
    <h1>Reporte de Entregables Mensual</h1>

    {{-- Formulario para seleccionar reporte y año --}}
    <form method="GET" action="{{ route('reporte.entregables.mensual') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <label for="reporte" class="form-label">Selecciona un reporte:</label>
                <select id="reporte" name="reporte" class="form-control colabselect" onchange="this.form.submit()">
                    <option value="">-- Todos --</option>
                    @foreach ($reportes as $id => $reporte)
                        <option value="{{ $id }}" {{ $id_reporte == $id ? 'selected' : '' }}>
                            {{ $reporte }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="year" class="form-label">Selecciona un año:</label>
                <select id="year" name="year" class="form-control colabselect" onchange="this.form.submit()">
                    @foreach(range(now()->year - 2, now()->year) as $year)
                        <option value="{{ $year }}" {{ request('year', now()->year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tbody>
                @php
                    // Meses del año
                    $meses = [
                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                        7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                    ];
                    $num = 1;
                @endphp

                @for ($i = 0; $i < 6; $i++) <!-- 6 filas -->
                    <tr>
                        @for ($j = 0; $j < 2; $j++) <!-- 2 columnas -->
                            <td style="width: 200px; height: 60px; position: relative;">
                                @if ($num <= 12) <!-- Solo mostrar 12 meses -->
                                    <span style="position: absolute; top: 5px; left: 5px; font-size: 12px;">{{ $num }}</span>

                                    {{-- Obtener el reporte del mes si existe --}}
                                    <div style="margin-top: 20px; font-weight: bold;">
                                        @php
                                            $reporteMes = $reportesMensuales->where('mes', $num)->first();
                                        @endphp
                                        {{-- Si existe reporte para ese mes, mostrarlo --}}
                                        {{ $reporteMes ? $reporteMes->reporte : 'Sin reporte' }}
                                    </div>

                                    @php $num++; @endphp
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
