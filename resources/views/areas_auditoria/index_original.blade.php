@extends('layouts.app', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('content')
<div class="content">
    <div class="container">
        <h1>Áreas de Auditoría</h1>
    
        <a href="{{ route('areas_auditoria.create') }}" class="btn btn-info btn-sm mb-3">Nueva Área</a>
    
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Clave</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                    <tr>
                        <td>{{ $area->id }}</td>
                        <td>{{ $area->nombre }}</td>
                        <td>{{ $area->clave }}</td>
                        <td>
                            <a href="{{ route('areas_auditoria.edit', $area->id) }}" class="btn btn-link btn-sm"><i class="fa fa-edit"></i></a>
    
                            <form action="{{ route('areas_auditoria.destroy', $area->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta área?')"> <i class="fa fa-trash"></i> </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
