@extends('layouts.app', ['activePage' => 'TrazabilidadVentas', 'menuParent' => 'ventas', 'titlePage' => __('Editar Trazabilidad Venta')])

@section('content')
<div class="content">
    <div class="container">
        <h2>Editar Trazabilidad Venta</h2>

     <form action="{{ route('trazabilidad_ventas.update', $trazabilidadVenta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="planta">Ubicación</label>
                <select id="planta" name="planta" class="form-control colabselect" required>
                    <option value="">Selecciona:</option>
                    @php
                        $ubicaciones = [
                            'CDC- AGS',
                            'CDC- SLP',
                            'CDC- TZY',
                            'CDC- QRO',
                            'LPQ- QRO',
                            'LPQ- TZY',
                        ];
                        $valorActual = trim($trazabilidadVenta->empresa) . '- ' . trim($trazabilidadVenta->planta);
                    @endphp

                    @foreach ($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion }}" {{ $ubicacion == $valorActual ? 'selected' : '' }}>
                            {{ $ubicacion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select id="anio" name="anio" class="form-control" required>
                            @for($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $trazabilidadVenta->anio == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        @php
                            $months = [
                                '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
                                '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                                '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                                '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                            ];
                        @endphp
                        <select id="mes" name="mes" class="form-control" required>
                            @foreach($months as $value => $name)
                                <option value="{{ $value }}" {{ $trazabilidadVenta->mes == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ([
                    'nota_de_entrega' => 'Nota de Entrega',
                    'factura' => 'Factura',
                    'carta_porte' => 'Carta Porte',
                    'complemento_carta' => 'Complemento Carta'
                ] as $field => $label)
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="{{ $field }}">{{ $label }}</label>
                            <input type="number" id="{{ $field }}" name="{{ $field }}" class="form-control"
                                   value="{{ $trazabilidadVenta->$field }}" min="0" max="100">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary">Actualizar Registro</button>
                <a href="{{ route('trazabilidad_ventas.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
