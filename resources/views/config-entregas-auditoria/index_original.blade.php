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

    <h1>Config Entregas Auditoría</h1>

<a href="{{ route('config-entregas-auditoria.create') }}" class="btn btn-primary">Crear Nuevo</a>

<table class="table mt-4">
    <thead>
        <tr>
            <th>Reporte</th>
            <th>Periodo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($configEntregas as $config)
            <tr>
                <td>{{ $config->reporte }}</td>
                <td>{{ $config->periodo }}</td>
                <td>
                    <form action="{{ route('config-entregas-auditoria.destroy', $config->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
@endsection
