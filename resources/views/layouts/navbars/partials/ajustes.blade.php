<li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
        <a data-toggle="collapse" href="#evaluaciones">
            <i class="tim-icons icon-zoom-split"></i>
            <p>
                {{ __('Ajustes') }}
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="evaluaciones">
            <ul class="nav">
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                    <a href="/tabla-isr/create">
                        <span class="sidebar-mini-icon">IS</span>
                        <span class="sidebar-normal"> {{ __('Tabla ISR') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                    <a href="/dias-vacaciones/create">
                        <span class="sidebar-mini-icon">DV</span>
                        <span class="sidebar-normal"> {{ __('Dias Vacaciones') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                    <a href="/valores/create">
                        <span class="sidebar-mini-icon">VA</span>
                        <span class="sidebar-normal"> {{ __('Valores') }} </span>
                    </a>
                </li>
                <li class="{{ $activePage == 'Organigrama' ? ' active' : '' }}">
                    <a href="/organigrama-create">
                        <span class="sidebar-mini-icon">VA</span>
                        <span class="sidebar-normal"> {{ __('Organigrama') }} </span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
