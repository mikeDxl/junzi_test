@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Editar Grupo')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <h2>Editar Grupo</h2>

        <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $grupo->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
