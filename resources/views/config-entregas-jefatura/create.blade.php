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

    <h1>Crear Config Entrega Jefatura</h1>

    <form action="{{ route('config-entregas-jefatura.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="reporte" class="form-label">Reporte</label>
            <input type="text" name="reporte" id="reporte" class="form-control" value="{{ old('reporte') }}" required>
        </div>

        <div class="mb-3">
            <label for="periodo" class="form-label">Periodo</label>
            <select name="periodo" id="periodo" class="form-control" required>
                <option value="Semanal">Semanal</option>
                <option value="Mensual">Mensual</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('config-entregas-jefatura.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
