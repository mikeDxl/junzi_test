@extends('home', ['activePage' => 'Hallazgos', 'menuParent' => 'auditoria', 'titlePage' => __('Editar Hallazgo')])

@section('contentJunzi')

<div class="content">
<div class="container">
    <h2>Reporte de Hallazgos por Colaborador</h2>
     <form method="GET" action="{{ route('generarReporteDuplicado') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $fecha_inicio) }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="fecha_fin" class="form-label">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $fecha_fin) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label for="colaborador_id" class="form-label">Colaborador</label>
                <select name="colaborador_id" id="colaborador_id" class="form-control colabselect">
                    <option value="">-- Todos --</option>
                    @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}" {{ (string)$colaborador->id === (string)$colaborador_id ? 'selected' : '' }}>
                            {{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-info w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Colaborador</th>
                <th>Hallazgo</th>
                <th>Veces</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datos as $fila)
                <tr>
                    <td>{{ $fila['colaborador'] }}</td>
                    <td>{{ $fila['hallazgo'] }}</td>
                    <td>{{ $fila['conteo'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay datos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
