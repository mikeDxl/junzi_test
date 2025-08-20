<div class="navbar-minimize-fixed">
  <button class="minimize-sidebar btn btn-link btn-just-icon">
    <i class="tim-icons icon-align-center visible-on-sidebar-regular text-muted"></i>
    <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini text-muted"></i>
  </button>
</div>
<div class="sidebar" data="blue">
  <div class="sidebar-wrapper">
    <ul class="nav">

        @include('layouts.navbars.partials.general')



        @if(auth()->user()->perfil=='Colaborador')

            @include('layouts.navbars.partials.colaboradores')

        @endif


        @if(auth()->user()->perfil=='Jefatura')

            @include('layouts.navbars.partials.jefatura')

        @endif


        @if(auth()->user()->perfil=='Nomina')

            @include('layouts.navbars.partials.nomina')

        @endif


        @if(auth()->user()->reclutamiento=='1')

            @include('layouts.navbars.partials.reclutamiento')

        @endif

    </ul>
  </div>
</div>
