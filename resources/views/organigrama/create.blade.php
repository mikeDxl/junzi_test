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
.nivel-3{ display:none;}
.nivel-4{ display:none;}
.nivel-5{ display:none;}
.nivel-6{ display:none;}
.nivel-7{ display:none;}
.nivel-8{ display:none;}
    </style>

    <h2>Agregar colaborador al organigrama</h2>

    <form action="{{ route('organigrama.store') }}" method="POST">
        @csrf


        <div class="form-group">
            <label for="colaborador_id">Colaborador</label>
            <select name="colaborador_id" id="colaborador_id" class="form-control colabselect" required>
                <option value="">Selecciona un Colaborador</option>
                <option value="0">Vacante</option>
                @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ qcolab($colaborador->id) }}</option>
                @endforeach
            </select>
            @error('colaborador_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jefe_directo_id">Jefe Directo</label>
            <select name="jefe_directo_id" id="jefe_directo_id" class="form-control colabselect" required>
                @if($last == NULL)
                    <option value="0">Sin jefe directo</option>
                @else
                    <option value="{{ $last->jefe_directo_id }}">{{ qcolab($last->jefe_directo_id) }}</option>
                @endif

                @foreach($jefes as $jefe)
                    @if($jefe->jefe_directo_id=='0')
                    <option value="{{ $jefe->id }}">VACANTE</option>
                    @else
                    <option value="{{ $jefe->id }}">{{ qcolab($jefe->id) }}</option>
                    @endif
                @endforeach
            </select>
            @error('jefe_directo_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="puesto">Puesto</label>
            <input type="text" class="form-control" name="puesto" id="puesto" readonly>
            <div id="id_puesto" style="display:none!important;">
                <select name="id_puesto" class="form-control colabselect">
                    <option value="">Selecciona un puesto</option>
                    @foreach($catalogo_puestos as $puesto)
                        <option value="{{ $puesto->id }}">{{ $puesto->puesto }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-info btn-sm">Guardar</button>
    </form>

    <br>
    <div class="row">
        <div class="col-md-12">
        <form id="organigramaForm" action="" method="GET">
            @csrf
            <p>Buscar colaborador:</p>
            <select name="colaborador_id" id="colaborador_id_buscar" class="form-control colabselect" required>
                <option value="">Selecciona un Colaborador</option>
                @foreach($colabbuscar as $col)
                    <option value="{{ $col->colaborador_id }}">{{ qcolab($col->colaborador_id) }}</option>
                @endforeach
            </select>
        </form>

        <script>
            document.getElementById('colaborador_id_buscar').addEventListener('change', function() {
                let colaboradorId = this.value;
                if (colaboradorId) {
                    let url = "{{ url('organigrama-custom') }}/" + colaboradorId;
                    window.location.href = url; // Redirecciona a la URL generada
                }
            });
        </script>


        </div>
    </div>
</div>

<br>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <ul>
            @foreach ($niveles as $colaborador)
                @php $left = 20 * $colaborador->jerarquia;  $gestion=gestiona($colaborador->colaborador_id); @endphp
                <li style="margin-left: {{ $left }}px; border-left:1px solid #ccc;" class="codigo-{{ $colaborador->jefe_directo_id }} org nivel-{{ $colaborador->nivel }}">
                    <div class="row" style="border-top : 1px solid #ccc; padding:10px;">
                        <div class="col-1"> <span> <input type="checkbox"> </span>
                            @if($gestion>0)<span> <button class="btn btn-link boton-{{ $colaborador->jefe_directo_id }}" id="codigo-{{ $colaborador->colaborador_id }}"> <i class="fa fa-chevron-down"></i>   </button> </span>@endif
                        </div>
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
                            <span><a class="btn btn-link" href="/organigrama-editar/{{ $colaborador->colaborador_id }}"> <i class="fa fa-edit"></i> </a> </span>
                            @if($gestion>0)<span><a class="btn btn-link" href="/organigrama-custom/{{ $colaborador->colaborador_id }}"> {{ $gestion }} <i class="fa fa-chevron-right"></i> </a> </span>@endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    // Al hacer clic en el botón
    $('button[id^="codigo-"]').on('click', function() {
        // Obtener el ID del botón y extraer el colaborador_id
        let id = $(this).attr('id').split('-')[1];

        // Alternar la visibilidad de los elementos con la clase correspondiente
        $('.codigo-' + id).toggle();

        // Alternar el icono
        let icon = $(this).find('i');
        if (icon.hasClass('fa-chevron-down')) {
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
    });
});

</script>
<script>
    $(document).ready(function(){
        $('#colaborador_id').change(function(){
            if ($(this).val() == "0") {
                $('#puesto').hide(); // Oculta el input de puesto
                $('#id_puesto').show(); // Muestra el select de puestos
            } else {
                $('#puesto').show(); // Muestra el input de puesto
                $('#id_puesto').hide(); // Oculta el select de puestos
            }
        });
    });
</script>
@endsection
