@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Grupos')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <h2>Grupos</h2>
        <a href="{{ route('grupos.create') }}" class="btn btn-primary">Crear Grupo</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->id }}</td>
                        <td>{{ $grupo->nombre }}</td>
                        <td>
                            <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este grupo?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
@endpush
