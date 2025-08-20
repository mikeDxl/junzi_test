<div class="navbar-minimize-fixed">
  <button class="minimize-sidebar btn btn-link btn-just-icon">
    <i class="tim-icons icon-align-center visible-on-sidebar-regular text-muted"></i>
    <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini text-muted"></i>
  </button>
</div>
<div class="sidebar" data="blue">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
-->
  <div class="sidebar-wrapper">
    <div class="logo">
        <a href="/" class="simple-text logo-mini">
          {{ __('J') }}
        </a>
        <a href="/" class="simple-text logo-normal">
          {{ __('Junzi') }}
        </a>
    </div>
    <ul class="nav">
      <li class="{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a href="{{ route('home') }}">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>{{ __('Inicio') }}</p>
        </a>
      </li>

      <li class="{{ $activePage == 'calendario' ? ' active' : '' }}">
        <a href="{{ route('calendar') }}">
          <i class="tim-icons icon-calendar-60"></i>
          <p>{{ __('Calendario') }}</p>
        </a>
      </li>


      <!-- Colaborador -->
      @if(auth()->user()->rol=='Colaborador')
          <li class="{{ $menuParent == 'Incidencias' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#incidencias">
              <i class="tim-icons icon-image-02"></i>
              <p>
                {{ __('Incidencias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="incidencias">
              <ul class="nav">
                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/incidencias">
                    <span class="sidebar-mini-icon"> IN </span>
                    <span class="sidebar-normal"> {{ __('Incidencias') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/capturar-incidencias">
                    <span class="sidebar-mini-icon"> CP </span>
                    <span class="sidebar-normal"> {{ __('Capturar') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Vacaciones' ? ' active' : '' }}">
                  <a href="/vacaciones">
                    <span class="sidebar-mini-icon"> VC </span>
                    <span class="sidebar-normal"> {{ __('Vacaciones') }} </span>
                  </a>
                </li>

              </ul>
             </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#auditorias">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Auditorias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="auditorias">
              <ul class="nav">
                <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
                  <a href="/auditorias">
                    <span class="sidebar-mini-icon"> AD </span>
                    <span class="sidebar-normal"> {{ __('Auditorias') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#evaluaciones">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Evaluaciones') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="evaluaciones">
              <ul class="nav">
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                  <a href="/evaluaciones">
                    <span class="sidebar-mini-icon"> EV </span>
                    <span class="sidebar-normal"> {{ __('Evaluaciones') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
      @endif


      <!-- Reclutamiento -->
      @if(auth()->user()->rol=='Reclutamiento')
           <li class="{{ $menuParent == 'Incidencias' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#incidencias">
              <i class="tim-icons icon-image-02"></i>
              <p>
                {{ __('Incidencias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="incidencias">
              <ul class="nav">
                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/incidencias">
                    <span class="sidebar-mini-icon"> IN </span>
                    <span class="sidebar-normal"> {{ __('Incidencias') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/capturar-incidencias">
                    <span class="sidebar-mini-icon"> CP </span>
                    <span class="sidebar-normal"> {{ __('Capturar') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Vacaciones' ? ' active' : '' }}">
                  <a href="/vacaciones">
                    <span class="sidebar-mini-icon"> VC </span>
                    <span class="sidebar-normal"> {{ __('Vacaciones') }} </span>
                  </a>
                </li>

              </ul>
             </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#auditorias">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Auditorias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="auditorias">
              <ul class="nav">
                <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
                  <a href="/auditorias">
                    <span class="sidebar-mini-icon"> AD </span>
                    <span class="sidebar-normal"> {{ __('Auditorias') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#evaluaciones">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Evaluaciones') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="evaluaciones">
              <ul class="nav">
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                  <a href="/evaluaciones">
                    <span class="sidebar-mini-icon"> EV </span>
                    <span class="sidebar-normal"> {{ __('Evaluaciones') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
      @endif


      <!-- Jefatura -->
      @if(auth()->user()->rol=='Jefatura')

          <li class="{{ $menuParent == 'Incidencias' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#incidencias">
              <i class="tim-icons icon-image-02"></i>
              <p>
                {{ __('Incidencias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="incidencias">
              <ul class="nav">
                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/incidencias">
                    <span class="sidebar-mini-icon"> IN </span>
                    <span class="sidebar-normal"> {{ __('Incidencias') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
                  <a href="/capturar-incidencias">
                    <span class="sidebar-mini-icon"> CP </span>
                    <span class="sidebar-normal"> {{ __('Capturar') }} </span>
                  </a>
                </li>

                <li class="{{ $activePage == 'Vacaciones' ? ' active' : '' }}">
                  <a href="/vacaciones">
                    <span class="sidebar-mini-icon"> VC </span>
                    <span class="sidebar-normal"> {{ __('Vacaciones') }} </span>
                  </a>
                </li>

              </ul>
             </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#auditorias">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Auditorias') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="auditorias">
              <ul class="nav">
                <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
                  <a href="/auditorias">
                    <span class="sidebar-mini-icon"> AD </span>
                    <span class="sidebar-normal"> {{ __('Auditorias') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
          <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
            <a data-toggle="collapse" href="#evaluaciones">
              <i class="tim-icons icon-zoom-split"></i>
              <p>
                {{ __('Evaluaciones') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="evaluaciones">
              <ul class="nav">
                <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
                  <a href="/evaluaciones">
                    <span class="sidebar-mini-icon"> EV </span>
                    <span class="sidebar-normal"> {{ __('Evaluaciones') }} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="{{ $activePage == 'Organigrama' ? ' active' : '' }}">
            <a href="/organigrama">
              <i class="tim-icons icon-components"></i>
              <span class="sidebar-normal"> {{ __('Organigrama') }} </span>
            </a>
          </li>

          <li class="{{ $activePage == 'Puestos' ? ' active' : '' }}">
            <a href="/puestos">
              <i class="tim-icons icon-components"></i>
              <span class="sidebar-normal"> {{ __('Puestos') }} </span>
            </a>
          </li>

          <li class="{{ $activePage == 'Colaboradores' ? ' active' : '' }}">
            <a href="/colaboradores">
              <i class="tim-icons icon-components"></i>
              <span class="sidebar-normal"> {{ __('Colaboradores') }} </span>
            </a>
          </li>

          <li class="{{ $activePage == 'Colaboradores Externos' ? ' active' : '' }}">
            <a href="/colaboradores/externos">
              <i class="tim-icons icon-components"></i>
              <span class="sidebar-normal"> {{ __('Colaboradores Externos') }} </span>
            </a>
          </li>
      @endif



      <!-- Nómina RH -->
      @if(auth()->user()->rol=='Nómina')
          <li class="{{ $activePage == 'Organigrama' ? ' active' : '' }}">
            <a href="/organigrama">
              <i class="tim-icons icon-components"></i>
              <span class="sidebar-normal"> {{ __('Organigrama') }} </span>
            </a>
          </li>
          <li class="{{ ($menuParent == 'Setup' || $activePage == 'dashboard') ? ' active' : '' }}">
        <a data-toggle="collapse" href="#laravelExamples" >
          <i class="fab fa-laravel"></i>
          <p>
            {{ __('Setup') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($menuParent == 'Setup' || $activePage == 'dashboard') ? ' ' : '' }}" id="laravelExamples">
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
                  <span class="sidebar-normal"> {{ __('Ubicaciones ') }} </span>
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
                  <span class="sidebar-mini-icon"> OG </span>
                  <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
                </a>
              </li>
          </ul>
        </div>
      </li>
      @endif


      @if(auth()->user()->rol!='Reclutamiento' && auth()->user()->rol!='Colaborador')
      <li class="{{ $activePage == 'Organigrama' ? ' active' : '' }}">
        <a href="/organigrama">
          <i class="tim-icons icon-components"></i>
          <span class="sidebar-normal"> {{ __('Organigrama') }} </span>
        </a>
      </li>
      @endif

      @if(auth()->user()->perfil!='Colaborador')
      <li class="{{ ($menuParent == 'Administrativo' || $activePage == 'dashboard') ? ' active' : '' }}">
        <a data-toggle="collapse" href="#laravelExamples" >
          <i class="fab fa-laravel"></i>
          <p>
            {{ __('Administrativo') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($menuParent == 'Administrativo' || $activePage == 'dashboard') ? ' ' : '' }}" id="laravelExamples">
          <ul class="nav">
              @if(auth()->user()->rol=='Nómina')
              <li class="{{ $activePage == 'Razones sociales' ? ' active' : '' }}">
                <a href="/razones_sociales">
                  <span class="sidebar-mini-icon">RS</span>
                  <span class="sidebar-normal"> {{ __('Razones sociales') }} </span>
                </a>
              </li>
              <li class="{{ $activePage == 'role-management' ? ' active' : '' }}">
                <a href="/ubicaciones">
                  <span class="sidebar-mini-icon">UB</span>
                  <span class="sidebar-normal"> {{ __('Ubicaciones ') }} </span>
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
              @endif
              <li class="{{ $activePage == 'Puestos' ? ' active' : '' }}">
                <a href="/puestos">
                  <span class="sidebar-mini-icon">PU</span>
                  <span class="sidebar-normal"> {{ __('Puestos') }} </span>
                </a>
              </li>
              @if(auth()->user()->rol=='Nómina')

              <li class="{{ $activePage == 'Altas' ? ' active' : '' }}">
                <a href="/altas">
                  <span class="sidebar-mini-icon">Al</span>
                  <span class="sidebar-normal"> {{ __('Altas') }} </span>
                </a>
              </li>
              <li class="{{ $activePage == 'Bajas' ? ' active' : '' }}">
                <a href="/bajas">
                  <span class="sidebar-mini-icon">CO</span>
                  <span class="sidebar-normal"> {{ __('Bajas') }} </span>
                </a>
              </li>
              <li class="{{ $activePage == 'Desvinculados' ? ' active' : '' }}">
                <a href="/desvinculados">
                  <span class="sidebar-mini-icon">DV</span>
                  <span class="sidebar-normal"> {{ __('Desvinculados') }} </span>
                </a>
              </li>
              <li class="{{ $activePage == 'Proyectos' ? ' active' : '' }}">
                <a href="/proyectos">
                  <span class="sidebar-mini-icon"> OG </span>
                  <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
                </a>
              </li>
              @endif

              <li class="{{ $activePage == 'Colaboradores' ? ' active' : '' }}">
                <a href="/colaboradores">
                  <span class="sidebar-mini-icon">CO</span>
                  <span class="sidebar-normal"> {{ __('Colaboradores') }} </span>
                </a>
              </li>


              @if(auth()->user()->perfil=='Jefatura' || auth()->user()->rol=='Nómina')



              @endif

              <li class="{{ $activePage == 'Colaboradores Externos' ? ' active' : '' }}">
                <a href="/colaboradores/externos">
                  <span class="sidebar-mini-icon">CO</span>
                  <span class="sidebar-normal"> {{ __('Colaboradores externos') }} </span>
                </a>
              </li>

              @if(auth()->user()->perfil=='Admin')
              <li class="{{ $activePage == 'Usuarios' ? ' active' : '' }}">
                <a href="/usuarios">
                  <span class="sidebar-mini-icon"> OG </span>
                  <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
                </a>
              </li>
              @endif
          </ul>
        </div>
      </li>

      <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
        <a data-toggle="collapse" href="#pagesExamples">
          <i class="tim-icons icon-image-02"></i>
          <p>
            {{ __('Reclutamiento') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="pagesExamples">
          <ul class="nav">
            <li class="{{ $activePage == 'Vacantes' ? ' active' : '' }}">
              <a href="/vacantes">
                <span class="sidebar-mini-icon"> VC </span>
                <span class="sidebar-normal"> {{ __('Vacantes') }} </span>
              </a>
            </li>
            <li class="{{ $activePage == 'Candidatos' ? ' active' : '' }}">
              <a href="/candidatos">
                <span class="sidebar-mini-icon"> VC </span>
                <span class="sidebar-normal"> {{ __('Candidatos') }} </span>
              </a>
            </li>
            @if(auth()->user()->perfil=='Jefatura')
            <li class="{{ $activePage == 'Solcitar Baja' ? ' active' : '' }}">
              <a href="/solicitar">
                <span class="sidebar-mini-icon"> SB </span>
                <span class="sidebar-normal"> {{ __('Solicitar Bajas') }} </span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      @endif







      @if(auth()->user()->perfil=='Jefatura' || auth()->user()->rol=='Nómina')
      <li class="{{ $menuParent == 'Incidencias' ? 'active' : '' }}">
        <a data-toggle="collapse" href="#incidencias">
          <i class="tim-icons icon-image-02"></i>
          <p>
            {{ __('Incidencias') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="incidencias">
          <ul class="nav">


            <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
              <a href="/incidencias">
                <span class="sidebar-mini-icon"> IN </span>
                <span class="sidebar-normal"> {{ __('Incidencias') }} </span>
              </a>
            </li>

            <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
              <a href="/capturar-incidencias">
                <span class="sidebar-mini-icon"> CP </span>
                <span class="sidebar-normal"> {{ __('Capturar') }} </span>
              </a>
            </li>

            <li class="{{ $activePage == 'Vacaciones' ? ' active' : '' }}">
              <a href="/vacaciones">
                <span class="sidebar-mini-icon"> VC </span>
                <span class="sidebar-normal"> {{ __('Vacaciones') }} </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      @endif

      @if(auth()->user()->perfil!='Colaborador')
      <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
        <a data-toggle="collapse" href="#auditorias">
          <i class="tim-icons icon-zoom-split"></i>
          <p>
            {{ __('Auditorias') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="auditorias">
          <ul class="nav">
            <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
              <a href="/auditorias">
                <span class="sidebar-mini-icon"> AD </span>
                <span class="sidebar-normal"> {{ __('Auditorias') }} </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      <li class="{{ $activePage == 'Evaluaciones' ? ' active' : '' }}">
        <a href="/evaluaciones">
          <span class="sidebar-mini-icon"> EV </span>
          <span class="sidebar-normal"> {{ __('Evaluaciones') }} </span>
        </a>
      </li>
      @endif


      @if(auth()->user()->rol=='Colaborador')
      <li class="{{ $menuParent == 'Incidencias' ? 'active' : '' }}">
        <a data-toggle="collapse" href="#incidencias">
          <i class="tim-icons icon-image-02"></i>
          <p>
            {{ __('Incidencias') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $menuParent == 'pages' ? ' show' : '' }}" id="incidencias">
          <ul class="nav">


            <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
              <a href="/incidencias">
                <span class="sidebar-mini-icon"> IN </span>
                <span class="sidebar-normal"> {{ __('Incidencias') }} </span>
              </a>
            </li>

            <li class="{{ $activePage == 'Incidencias' ? ' active' : '' }}">
              <a href="/capturar-incidencias">
                <span class="sidebar-mini-icon"> CP </span>
                <span class="sidebar-normal"> {{ __('Capturar') }} </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      @endif
    </ul>
  </div>
</div>
