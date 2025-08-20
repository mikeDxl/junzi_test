@extends('layouts.app', ['activePage' => 'Mensajes', 'menuParent' => 'laravel', 'titlePage' => __('Mensajes')])

@section('content')

<div class="content">
    <h2>Mensajes</h2>
    <a href="{{ route('mensajes.create') }}" class="btn btn-info btn-sm">Crear Mensaje</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mensajes as $mensaje)
                <tr>
                    <td>{{ $mensaje->grupo->nombre ?? '' }}</td>
                    <td>{{ $mensaje->fecha_inicio }}</td>
                    <td>{{ $mensaje->fecha_fin ?? 'Sin Fecha' }}</td>
                    <td>
                        <a href="{{ route('mensajes.edit', $mensaje) }}" class="btn btn-info btn-sm">Editar</a>
                        <form action="{{ route('mensajes.destroy', $mensaje) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
