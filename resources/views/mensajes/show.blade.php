@extends('layouts.app', ['activePage' => 'Mensajes', 'menuParent' => 'laravel', 'titlePage' => __('Mostrar Mensaje')])

@section('content')

<div class="content">
    <h2>Mensaje Detalle</h2>
    <p><strong>Mensaje:</strong> {{ $mensaje->mensaje }}</p>
    <p><strong>Grupo:</strong> {{ $mensaje->grupo->nombre }}</p>
    <p><strong>Fecha de Inicio:</strong> {{ $mensaje->fecha_inicio }}</p>
    <p><strong>Fecha de Fin:</strong> {{ $mensaje->fecha_fin ?? 'Sin Fecha' }}</p>

    <a href="{{ route('mensajes.index') }}" class="btn btn-secondary">Regresar</a>
</div>

@endsection
