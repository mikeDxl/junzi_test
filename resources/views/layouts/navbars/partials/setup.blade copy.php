
<li class="{{ ($menuParent == 'Setup' || $activePage == 'dashboard') ? ' active' : '' }}">
        <a data-toggle="collapse" href="#laravelExamples">
            <i class="fab fa-laravel"></i>
            <p>
                {{ __('Setup') }}
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse {{ ($menuParent == 'Setup' || $activePage == 'dashboard') ? ' show' : '' }}" id="laravelExamples">
            <ul class="nav">
                <li class="{{ $activePage == 'Razones sociales' ? ' active' : '' }}">
                    <a href="/razones_sociales">
                        <span class="sidebar-mini-icon">RS</span>
                        <span class="sidebar-normal"> {{ __('Razones sociales') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'role-management' ? ' active' : '' }}">
                    <a href="/ubicaciones">
                        <span class="sidebar-mini-icon">UB</span>
                        <span class="sidebar-normal"> {{ __('Ubicaciones') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Centro de costos' ? ' active' : '' }}">
                    <a href="/centro_de_costos">
                        <span class="sidebar-mini-icon">CC</span>
                        <span class="sidebar-normal"> {{ __('Centro de costos') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Departamentos' ? ' active' : '' }}">
                    <a href="/departamentos">
                        <span class="sidebar-mini-icon">DE</span>
                        <span class="sidebar-normal"> {{ __('Departamentos') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Puestos' ? ' active' : '' }}">
                    <a href="/puestos">
                        <span class="sidebar-mini-icon">PU</span>
                        <span class="sidebar-normal"> {{ __('Puestos') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Proyectos' ? ' active' : '' }}">
                    <a href="/proyectos">
                        <span class="sidebar-mini-icon">OG</span>
                        <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Grupos' ? ' active' : '' }}">
                    <a href="/grupos">
                        <span class="sidebar-mini-icon">GP</span>
                        <span class="sidebar-normal"> {{ __('Grupos') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Mensajes' ? ' active' : '' }}">
                    <a href="/mensajes">
                        <span class="sidebar-mini-icon">MS</span>
                        <span class="sidebar-normal"> {{ __('Mensajes') }} </span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
