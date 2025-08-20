@extends('layouts.app', ['activePage' => 'Tabla Isr', 'menuParent' => 'laravel', 'titlePage' => __('Tabla Isr')])

@section('content')
<div class="content">
<div class="container mt-5">
    <h2>Agregar Registros a Tabla ISR</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tabla-isr.store') }}" method="POST">
        @csrf

        <!-- Año y Periodo -->
        <div class="mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control @error('anio') is-invalid @enderror"
                   id="anio" name="anio" value="{{ old('anio') }}">
            @error('anio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="periodo" class="form-label">Periodo</label>

            <input type="text" class="form-control @error('periodo') is-invalid @enderror"
                   id="periodo" name="periodo" value="mensual">
            @error('periodo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tabla para registros masivos -->
        <h4>Detalles de Límites y Cuotas</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Límite Inferior</th>
                    <th>Límite Superior</th>
                    <th>Cuota Fija</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 11; $i++)
                <tr>
                    <td>
                        <input type="number" step="0.01" class="form-control"
                               name="limite_inferior[]" placeholder="Límite Inferior">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control"
                               name="limite_superior[]" placeholder="Límite Superior">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control"
                               name="cuota_fija[]" placeholder="Cuota Fija">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control"
                               name="porcentaje[]" placeholder="Porcentaje">
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <br>
    <br>
    <hr>
    <style>
            /* Estilo para las Tabs */
.nav-tabs .nav-link {
    background-color: #495057!important;
    border: 1px solid #dee2e6!important;
    color: #dee2e6!important;
    margin-right: 5px;
    border-radius: 0.25rem;
}

.nav-tabs .nav-link.active {
    background-color: #007bff!important;
    color: #fff!important;
    border-color: #007bff!important;
}

.nav-tabs .nav-link:hover {
    background-color: #007bff!important;
    color: #007bff1!important;
}

.tab-content {
    border: 1px solid #dee2e6!important;
    border-top: none!important;
    background-color: #ffffff!important;
    padding: 20px;
    border-radius: 0 0 0.25rem 0.25rem;
}

        </style>

    <div class="container">
    <h2>Tabla ISR</h2>

    <!-- Nav Tabs -->
<ul class="nav nav-tabs" id="anioTabs" role="tablist">
    @foreach($datos as $anio => $registros)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->last ? 'active' : '' }}"
                    id="tab-{{ $anio }}"
                    data-bs-toggle="tab"
                    data-bs-target="#contenido-{{ $anio }}"
                    type="button"
                    role="tab"
                    aria-controls="contenido-{{ $anio }}"
                    aria-selected="{{ $loop->last ? 'true' : 'false' }}">
                Año {{ $anio }}
            </button>
        </li>
    @endforeach
</ul>

    <!-- Tab Content -->
    <!-- Tab Content -->
<div class="tab-content" id="anioTabsContent">
    @foreach($datos as $anio => $registros)
        <div class="tab-pane fade {{ $loop->last ? 'show active' : '' }}"
             id="contenido-{{ $anio }}"
             role="tabpanel"
             aria-labelledby="tab-{{ $anio }}">

            <h4>Año {{ $anio }}</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Limite Inferior</th>
                        <th>Limite Superior</th>
                        <th>Cuota Fija</th>
                        <th>Porcentaje</th>
                        <th>Periodo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                    <tr>
                        <td>{{ $registro->limite_inferior }}</td>
                        <td>{{ $registro->limite_superior }}</td>
                        <td>{{ $registro->cuota_fija }}</td>
                        <td>{{ $registro->porcentaje }}%</td>
                        <td>{{ $registro->periodo }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

</div>

</div>
</div>
@endsection
