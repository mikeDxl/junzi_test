@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Detalles del Grupo')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <h2>Detalles del Grupo</h2>

        <p><strong>ID:</strong> {{ $grupo->id }}</p>
        <p><strong>Nombre:</strong> {{ $grupo->nombre }}</p>

        <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
</div>
@endsection

@push('js')
@endpush
