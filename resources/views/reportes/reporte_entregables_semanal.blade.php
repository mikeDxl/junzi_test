@extends('home', ['activePage' => 'Reporte Semanal', 'menuParent' => 'laravel', 'titlePage' => __('Reporte de Entregables')])

@section('contentJunzi')
<div class="content">
    <h1>Reporte de Entregables Semanal</h1>

    {{-- Formulario para seleccionar reporte y año --}}
    <form method="GET" action="{{ route('reporte.entregables.semanal') }}" class="mb-4">
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
                @php $num = 1; @endphp
                @for ($i = 0; $i < 8; $i++)
                    <tr>
                        @for ($j = 0; $j < 7; $j++)
                            <td style="width: 60px; height: 60px; position: relative;">
                                @if ($num <= 52)
                                    <span style="position: absolute; top: 5px; right: 5px; font-size: 12px;">{{ $num }}</span>
                                    <div style="margin-top: 20px; font-weight: bold;">
                                        {{ $semanas[$num] ?? '' }}
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
