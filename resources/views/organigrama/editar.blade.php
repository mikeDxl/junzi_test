@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
<div class="container">
    <style>
        td, th { font-size:9pt; }
        ul {
    list-style-type: none;
    padding-left: 0; /* Elimina el espaciado por defecto del lado izquierdo */
}
    </style>

    <div class="row">
        <div class="col-md-12 table-responsive">
            <h1>{{ qcolab($colaborador->colaborador_id) }}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('organigrama.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Nivel</label>
                    <input type="text" name="nivel" class="form-control" value="{{ $colaborador->jerarquia }}">
                </div>
                <div class="form-group">
                    <label for="">Jefe directo</label>
                    <select name="jefe_directo_id" id="jefe_directo_id" class="form-control colabselect">
                        <option value="{{ $colaborador->jefe_directo_id }}">{{ qcolab($colaborador->jefe_directo_id) }}</option>
                        @foreach($colaboradores as $elemento)
                            <option value="{{ $elemento->id }}">{{ qcolab($elemento->id) }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <input type="hidden" name="colaborador_id" value="{{ $colaborador->colaborador_id }}">
                <input type="hidden" name="elemento_id" value="{{ $colaborador->id }}">
                <button class="submit" class="btn btn-info">Actualizar</button>
            </form>
        </div>
    </div>
</div>

</div>
@endsection
