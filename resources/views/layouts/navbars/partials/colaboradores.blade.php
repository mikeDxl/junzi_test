<li class="{{ $activePage == 'dashboardColaborador' ? ' active' : '' }}">
    <a href="{{ route('home') }}"
        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
        </svg>
        <span class="ml-3" sidebar-toggle-item>{{ __('Dashboard') }}</span>
    </a>
</li>
<li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
    <a href="#"
        class="menu-toggle flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
        data-target="auditorias">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('Auditoria') }}</span>
        <svg class="w-6 h-6 transition-transform duration-200 chevron" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </a>
    <ul id="auditorias"
        class="submenu space-y-2 py-2 {{ $menuParent == 'pages' ? 'max-h-96' : 'max-h-0' }} overflow-hidden transition-all duration-300 ease-in-out">
        <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
            <a href="/auditorias"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path fill-rule="evenodd"
                        d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Auditoria') }}
            </a>
        </li>
        {{-- @if(auth()->user()->auditoria == '1') --}}
        {{-- @include('layouts.navbars.partials.auditor') --}}
        {{-- @else --}}
        {{-- <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
            <a href=" /entregas-auditoria/lista"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Entregables') }}
            </a>
        </li> --}}
        {{-- @endif --}}
    {{-- </ul>
</li> --}}

{{-- <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
    <a href="#"
        class="menu-toggle flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
        data-target="auditorias">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('Auditorias') }}</span>
        <svg class="w-6 h-6 transition-transform duration-200 chevron" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </a>
    <ul id="auditorias"
        class="submenu space-y-2 py-2 {{ $menuParent == 'pages' ? 'max-h-96' : 'max-h-0' }} overflow-hidden transition-all duration-300 ease-in-out">
        <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
            <a href="/auditorias"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path fill-rule="evenodd"
                        d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Auditorias') }}
            </a>
        </li> --}}
        <li class="{{ $activePage == 'Auditorias' ? ' active' : '' }}">
            <a href=" /entregas-auditoria/lista"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Reportes de Control') }}
            </a>
        </li>
    </ul>
</li>

{{-- <li class="{{ $menuParent == 'pages' ? 'active' : '' }}">
    <a href="#"
        class="menu-toggle flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
        data-target="entregables-jefatura">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">
            {{ __('Entregables') }}<br>{{ __('Jefatura') }}
        </span>
        <svg class="w-6 h-6 transition-transform duration-200 chevron" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </a>
    <ul id="entregables-jefatura"
        class="submenu space-y-2 py-2 {{ $menuParent == 'pages' ? 'max-h-96' : 'max-h-0' }} overflow-hidden transition-all duration-300 ease-in-out">
        <li class="{{ $activePage == 'Auditorias' ? 'active' : '' }}">
            <a href="/config-entregas-jefatura"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd"
                        d="M19 5.5a4.5 4.5 0 0 1-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 1 1-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 0 1 5.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 0 0-.11.494 3.01 3.01 0 0 0 1.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382ZM4 17a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd" />
                </svg>

                {{ __('Ajustes') }}
            </a>
        </li>
        <li class="{{ $activePage == 'Entregables' ? ' active' : '' }}">
            <a href=" /entregas_jefatura"
                class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Entregables') }}
            </a>
        </li>
    </ul>
</li> --}}
