@extends('layouts.app', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('content')
<div class="content">
    <div class="container">
        <h1>Editar Área de Auditoría</h1>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('areas_auditoria.update', $area->id) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $area->nombre }}" required>
            </div>
    
            <div class="form-group">
                <label for="clave">Clave</label>
                <input type="text" name="clave" class="form-control" value="{{ $area->clave }}" required>
            </div>
    
            <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
        </form>
    </div>
</div>
@endsection
