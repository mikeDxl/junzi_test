<style>
    .has-submenu {
    position: relative;
}

.submenu-left {
    position: absolute;
    top: 0;
    left: auto;
    right: 100%; /* Hace que el submenú se abra a la izquierda */
    background: #ffffff; /* Ajusta el color de fondo si es necesario */
    color: #424242;
    padding: 10px;
    display: none;
    min-width: 200px;
    border-radius: 5px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.has-submenu:hover .submenu-left {
    display: block;
}

</style>

@if(auth()->user()->nomina == '1')


<li class="{{ ($menuParent == 'Setup' || $activePage == 'dashboard') ? ' active' : '' }} has-submenu">
    <a data-toggle="collapse" href="#laravelExamples">
        {{ __('Setup') }}
    </a>
    <ul class="nav submenu-left"> <!-- Nueva clase para submenús alineados a la izquierda -->
        <li class="{{ $activePage == 'Razones sociales' ? ' active' : '' }}">
            <a href="/razones_sociales">
                <span class="sidebar-normal"> {{ __('Razones sociales') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'role-management' ? ' active' : '' }}">
            <a href="/ubicaciones">
                <span class="sidebar-normal"> {{ __('Ubicaciones') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Centro de costos' ? ' active' : '' }}">
            <a href="/centro_de_costos">
                <span class="sidebar-normal"> {{ __('Centro de costos') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Departamentos' ? ' active' : '' }}">
            <a href="/departamentos">
                <span class="sidebar-normal"> {{ __('Departamentos') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Puestos' ? ' active' : '' }}">
            <a href="/puestos">
                <span class="sidebar-normal"> {{ __('Puestos') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Proyectos' ? ' active' : '' }}">
            <a href="/proyectos">
                <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Grupos' ? ' active' : '' }}">
            <a href="/grupos">
                <span class="sidebar-normal"> {{ __('Grupos') }} </span>
            </a>
        </li>
        <li class="{{ $activePage == 'Mensajes' ? ' active' : '' }}">
            <a href="/mensajes">
                <span class="sidebar-normal"> {{ __('Mensajes') }} </span>
            </a>
        </li>
    </ul>
</li>


@endif
