@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Crear Grupo')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <h2>Crear Grupo</h2>

        <div class="row">
            <div class="col-md-6">
            <form action="{{ route('grupos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-info btn-sm">Guardar</button>
        </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
