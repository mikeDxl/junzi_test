<style media="screen">
  .icon-container {
    position: relative;
    display: inline-block;
  }

  .icon-container .badge {
    position: absolute;
    top: -5px;
    right: -20px;
    background-color: rgba(255, 0, 0, 0.5);
    color: white;
    /* Color del texto del número */
    border-radius: 50%;
    /* Para hacer el número redondo */
    padding: 4px 8px;
    /* Ajusta el espacio alrededor del número */
  }
</style>
<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent" style="background:#f5f5f5!important;">
  <div class="container-fluid">
    <div class="navbar-wrapper" style="background:#f5f5f5!important;">
      <div class="navbar-minimize d-inline">
        <button class="minimize-sidebar btn btn-link btn-just-icon" rel="tooltip" data-original-title="Sidebar toggle"
          data-placement="right">
          <i class="tim-icons icon-align-center visible-on-sidebar-regular"></i>
          <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini"></i>
        </button>
      </div>
      <div class="navbar-toggle d-inline">
        <button type="button" class="navbar-toggler">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>
    <div class="collapse navbar-collapse" id="navigation">
      <?php
use App\Models\RazonesSociales;
$razones = RazonesSociales::all();
       ?>
      <form id="fijar_rs" action="{{ route('fijar_rs') }}" method="post">
        @csrf
        <select id="company_id" class="form-control" style="text-transform: capitzalize!important;" name="company_id">
          @if(session('company_active_id'))
        <option selected value="{{ session('company_active_id') }}" style="text-transform: capitzalize!important;">
        {{ session('company_active_name') }}
        </option>
      @else
        <option value="0" style="text-transform: capitzalize!important;">Todas las razones sociales</option>
      @endif
          @foreach($razones as $rs)
        <option value="{{ $rs->id }}" style="text-transform: capitzalize!important;">{{ $rs->razon_social }}</option>
      @endforeach
          <option value="0" style="text-transform: capitzalize!important;">Todas las razones sociales</option>
        </select>
      </form>
      <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
      <script>
        // Agrega un listener para el evento de cambio en el select
        $(document).ready(function () {
          $('#company_id').change(function () {
            // Envía el formulario cuando cambie la selección
            $('#fijar_rs').submit();
          });
        });
      </script>

      <ul class="navbar-nav ml-auto" style="background:#f5f5f5!important;">

        <li class="search-bar input-group">
          {{ auth()->user()->name }} <br> {{ auth()->user()->perfil }}
        </li>

        <li class="dropdown nav-item">
          <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <div class="notification d-none d-lg-block d-xl-block"></div>
            <div class="icon-container">
              <i class="tim-icons icon-bell-55"></i>
              <span class="badge" id="cuantasnotificaciones"></span>
            </div>
            <p class="d-lg-none">
              {{ __('Notificaciones') }}
            </p>
          </a>
          <ul class="dropdown-menu dropdown-menu-right dropdown-navbar" id="navbar">
            <ul id="notificacionesActivas" class="p-2"></ul>
            <li class="dropdown-divider"></li>
            <li class="nav-link text-center">
              <a href="#" id="toggleArchivadas" class="text-primary">Ver Archivadas</a>
            </li>
            <ul id="notificacionesArchivadas" class="p-2" style="display: none;"></ul>
          </ul>
        </li>

        <li class="dropdown nav-item" id="logout">
          <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <div class="photo">
              <img src="{{ auth()->user()->profilePicture() }}" alt="Profile Photo">
            </div>
            <b class="caret d-none d-lg-block d-xl-block"></b>
            <p class="d-lg-none">
              <a href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
            </p>
          </a>
          <ul class="dropdown-menu dropdown-navbar">
            <li class="nav-link">
              <a href="/" class="nav-item dropdown-item">{{ __('Perfil') }}</a>
            </li>
            @include('layouts.navbars.partials.setup')
            <li class="dropdown-divider"></li>
            <li class="nav-link" id="logout-btn">
              <a href="{{ route('logout') }}" class="nav-item dropdown-item"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Cerrar sesión') }}</a>
            </li>
          </ul>
        </li>
        <li class="separator d-lg-none"></li>
      </ul>
    </div>
  </div>
</nav>
<div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal"
  aria-hidden="true" style="background:#f5f5f5!important;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="{{ __('Buscar') }}">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
      </div>
    </div>
  </div>
</div>



<!-- End Navbar -->
