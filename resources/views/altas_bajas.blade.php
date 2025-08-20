@extends('layouts.app', ['activePage' => 'Altas y Bajas', 'menuParent' => 'laravel', 'titlePage' => __('Altas y Bajas')])

@section('content')
<div class="content">
    <h1>Altas y Bajas</h1>

    <div class="row">
        <!-- Altas -->
        <div class="col-md-6">
            <h3>Altas Recientes</h3>
            @if(count($altas) > 0)
                @foreach($altas as $alta)
                    <h4>Empresa: {{ $alta['empresa'] }}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>ID</th>
                                <th>Fecha de Alta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alta['altas'] as $empleado)
                                <tr>
                                    <td>{{ $empleado->nombre_completo }}</td>
                                    <td>{{ $empleado->idempleado }}</td>
                                    <td>{{ $empleado->fecha_alta }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @else
                <p>No se encontraron altas recientes.</p>
            @endif
        </div>

        <!-- Bajas -->
        <div class="col-md-6">
            <h3>Bajas Recientes</h3>
            @if(count($bajas) > 0)
                @foreach($bajas as $baja)
                    <h4>Empresa: {{ $baja['empresa'] }}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>ID</th>
                                <th>Fecha de Baja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($baja['bajas'] as $empleado)
                                <tr>
                                    <td>{{ $empleado->nombre_completo }}</td>
                                    <td>{{ $empleado->idempleado }}</td>
                                    <td>{{ $empleado->fecha_baja }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @else
                <p>No se encontraron bajas recientes.</p>
            @endif
        </div>
    </div>
</div>
@endsection
