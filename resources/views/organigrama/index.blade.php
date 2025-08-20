@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')
    <!-- Incluyendo OrgChart.js con la clave API -->
    <script src="https://balkan.app/js/OrgChart.js?api_key=ak_S0qkUMMGb6UEVeNgT85B2QD75cZJBt"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<div class="content">
    <div class="row">
        <div class="col-md-12">
        <ul>
            @foreach ($niveles as $colaborador)
                @php $left = 20 * $colaborador->nivel; @endphp  {{-- Aumenta el espaciado por nivel --}}
                <li style="margin-left: {{ $left }}px; border-left:1px solid #ccc;" class="codigo-{{ $colaborador->jefe_directo_id }} org nivel-{{ $colaborador->nivel }}">
                    <div class="row" style="border-top : 1px solid #ccc; padding:10px;">
                        <div class="col">
                            <!--<span> <button class="btn btn-link" id="codigo-{{ $colaborador->colaborador_id }}"> <i class="fa fa-chevron-down"></i> </button> </span> -->
                            @if($colaborador->colaborador_id==0 && $colaborador->nivel>1)
                                Vacante
                            @else
                                <small>{{ qcolab($colaborador->colaborador_id) }}</small>
                            @endif
                        </div>
                        <div class="col"><small>{{ catalogopuesto($colaborador->puesto) }}</small> </div>
                        <div class="col"><small>{{ nombrecc($colaborador->cc) }}</small></div>
                        <div class="col"><small>{{ $colaborador->codigo }}</small></div>
                    </div>
                </li>
            @endforeach
        </ul>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
