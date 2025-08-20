<!-- resources/views/trazabilidad_venta/create.blade.php -->

@extends('layouts.app', ['activePage' => 'TrazabilidadVentas', 'menuParent' => 'ventas', 'titlePage' => __('Crear Trazabilidad Venta')])

@section('content')

<div class="content">
    <div class="container">
        <h2>Crear Trazabilidad Venta</h2>

        <form action="{{ route('trazabilidad_ventas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="planta">Ubicación</label>
                <select id="planta" name="planta" class="form-control colabselect" required>
                    <option value="">Selecciona:</option>
                    <option value="CDC- AGS">CDC- AGS</option>
                    <option value="CDC- SLP">CDC- SLP</option>
                    <option value="CDC- TZY">CDC- TZY</option>
                    <option value="CDC- QRO">CDC- QRO</option>
                    <option value="LPQ- QRO">LPQ- QRO</option>
                    <option value="LPQ- AGS">LPQ- TZY</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nota_de_entrega">Nota de Entrega</label>
                <input type="number" id="nota_de_entrega" name="nota_de_entrega" class="form-control">
            </div>

            <div class="form-group">
                <label for="factura">Factura</label>
                <input type="number" id="factura" name="factura" class="form-control">
            </div>

            <div class="form-group">
                <label for="carta_porte">Carta Porte</label>
                <input type="number" id="carta_porte" name="carta_porte" class="form-control">
            </div>

            <div class="form-group">
                <label for="complemento_carta">Complemento Carta</label>
                <input type="number" id="complemento_carta" name="complemento_carta" class="form-control">
            </div>

            <!-- Campos Año y Mes -->
            <div class="form-group">
                <label for="anio">Año</label>
                <input type="number" id="anio" name="anio" class="form-control" value="{{ date('Y') }}" required>
            </div>

            <div class="form-group">
                <label for="mes">Mes</label>
                <select id="mes" name="mes" class="form-control" required>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-info">Crear Registro</button>
            </div>
        </form>
    </div>
</div>

@endsection
