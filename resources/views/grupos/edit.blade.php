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

            <div class="form-group">
                <label for="colaboradores">Colaboradores</label>
                <select name="colaboradores[]" id="colaborador_name" class="form-control" multiple>
                    @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}" 
                            {{ $grupo->colaboradores->contains($colaborador->id) ? 'selected' : '' }}>
                            {{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
