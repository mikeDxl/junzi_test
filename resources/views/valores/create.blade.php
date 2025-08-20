@extends('layouts.app', ['activePage' => 'Valores', 'menuParent' => 'laravel', 'titlePage' => __('Valores')])

@section('content')
<div class="content">
<div class="container mt-5">
    <h2>Agregar Valor (UMA, UMI, etc.)</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('valores.store') }}" method="POST">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                   id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: UMA">
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Año -->
        <div class="mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control @error('anio') is-invalid @enderror"
                   id="anio" name="anio" value="{{ old('anio') }}" placeholder="Ej: 2025">
            @error('anio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Valor -->
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control @error('valor') is-invalid @enderror"
                   id="valor" name="valor" value="{{ old('valor') }}" placeholder="Ej: 103.74">
            @error('valor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <br>
    <br>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Dato</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $dato)
                            <tr>
                                <td>{{$dato->anio }}</td>
                                <td>{{$dato->nombre }}</td>
                                <td>{{$dato->valor }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
