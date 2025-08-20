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
    @php $idcolab=$colaborador->colaborador_id; @endphp

    <div class="row">
        <div class="col-md-12 table-responsive">
            <h1>{{ qcolab($idcolab) }} <span> <a class="btn btn-link text-info" href="/organigrama-editar/{{$idcolab}}"> <i class="fa fa-edit"></i> </a> </span> </h1>
        </div>
    </div>
</div>
<form action="{{ route('organigrama.moverUbicacion') }}" method="POST">
@csrf
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h3>Enviar a Ubicación:</h3>
                <select name="ubicacion" id="ubicacion" class="form-control">
                    <option value="">Selecciona</option>
                    @foreach($ubicaciones as $ubicacion)
                        @if($ubicacion->ubicacion!="")
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->ubicacion }}</option>
                        @endif
                    @endforeach
                </select>
                <input type="text" name="nueva_ubicacion" value="" class="form-control" placeholder="Nueva Ubicación">
                <button type="submit" class="btn btn-info btn-sm">Enviar</button>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <input type="checkbox" id="colab_selec" name="colab_selec[]" value="{{ $idcolab }}"> {{ qcolab($idcolab) }}
        <ul>
            @foreach ($niveles as $colaborador)
                @php $left = 20 * $colaborador->jerarquia; $gestion=gestiona($colaborador->colaborador_id); @endphp
                <li style="margin-left: {{ $left }}px; border-left:1px solid #ccc;" class="codigo-{{ $colaborador->jefe_directo_id }} org nivel-{{ $colaborador->nivel }}">
                    <div class="row" style="border-top : 1px solid #ccc; padding:10px;">
                        <div class="col-1"> <span> @if($colaborador->colaborador_id>0)<input type="checkbox" name="colab_selec[]" class="colab_selec" value="{{ $colaborador->colaborador_id }}"> @endif</span> </div>
                        <div class="col-4">
                            @if($colaborador->colaborador_id==0 && $colaborador->nivel>1)
                                Vacante  - N{{ $colaborador->jerarquia }}
                            @else
                                <small>{{ qcolab($colaborador->colaborador_id) }} - N{{ $colaborador->jerarquia }}</small>
                            @endif
                        </div>
                        <div class="col-2"><small>{{ catalogopuesto($colaborador->puesto) }}</small> <br> <small> <i>{{ $colaborador->codigo }}</i> </small> </div>
                        <div class="col-2"><small>{{ nombrecc($colaborador->cc) }}</small></div>
                        <div class="col-2"> <small>{{ qubi($colaborador->colaborador_id) }}</small> </div>
                        <div class="col-1">
                            @if($colaborador->colaborador_id>0)
                                <span><a class="btn btn-link" href="/organigrama-editar/{{ $colaborador->colaborador_id }}"> <i class="fa fa-edit"></i> </a> </span>
                                @if($gestion>0) <span><a class="btn btn-link" href="/organigrama-custom/{{ $colaborador->colaborador_id }}"> {{ $gestion }} <i class="fa fa-chevron-right"></i> </a> </span> @endif
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        </div>
    </div>
</div>
</form>
<form action="{{ route('organigrama.store') }}" method="POST">
        @csrf


        <div class="form-group">
            <label for="colaborador_id">Colaborador</label>
            <select name="colaborador_id" id="colaborador_id" class="form-control colabselect" required>
                <option value="">Selecciona un Colaborador</option>
                <option value="0">Vacante</option>
                @foreach($colaboradores as $colab)
                    <option value="{{ $colab->id }}">{{ qcolab($colab->id) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jefe_directo_id">Jefe Directo</label>
            <input type="text" value="{{ qcolab($idcolab) }}" class="form-control" readonly>
            <input type="hidden" value="{{ $idcolab }}" name="jefe_directo_id" id="jefe_directo_id" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-info btn-sm">Guardar</button>
    </form>

</div>
<script>
document.getElementById("colab_selec").addEventListener("change", function() {
    let checkboxes = document.querySelectorAll(".colab_selec");
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection
