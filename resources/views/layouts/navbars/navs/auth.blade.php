@php
use App\Models\RazonesSociales;
$razones = RazonesSociales::all();
@endphp

<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <!-- Mobile menu button -->
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>

                <!-- Logo -->
                <!-- <a href="#" class="flex ml-2 md:mr-24">
                    <img src="/images/logo.svg" class="h-8 mr-3" alt="Logo" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">{{ config('app.name', 'Laravel') }}</span>
                    </a> -->

                <!-- Company Selector -->
                <div class="pl-3.5">
                    <form id="fijar_rs" action="{{ route('fijar_rs') }}" method="post" class="flex items-center">
                        @csrf
                        <select id="company_id" name="company_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            style="text-transform: capitalize;">
                            @if(session('company_active_id'))
                            <option selected value="{{ session('company_active_id') }}">
                                {{ session('company_active_name') }}
                            </option>
                            @else
                            <option value="0">Todas las razones sociales</option>
                            @endif

                            @foreach($razones as $rs)
                            <option value="{{ $rs->id }}">{{ $rs->razon_social }}</option>
                            @endforeach
                            <option value="0">Todas las razones sociales</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="flex items-center">
                <!-- User info for mobile -->
                <div class="hidden mr-3 text-sm text-gray-500 dark:text-gray-400 sm:block">
                    {{ auth()->user()->name }} - {{ auth()->user()->perfil }}
                </div>

                <!-- Search mobile button -->
                <button id="toggleSidebarMobileSearch" type="button"
                    class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Search</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Notifications -->
                <button type="button" id="notificationButton"
                    class="relative p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="sr-only">Ver notificaciones</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                    <!-- Badge de notificaciones -->
                    <span id="cuantasnotificaciones"
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                    </span>
                </button>
                <!-- Dropdown de notificaciones -->
                <div id="notificationDropdown"
                    class="hidden fixed right-8 z-40 top-20 w-[43rem] bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600">
                    <!-- Header -->
                    <div
                        class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                        Notificaciones
                    </div>
                    <!-- Contenido con scroll -->
                    <div class="max-h-[30rem] overflow-y-auto">
                        <!-- Notificaciones activas -->
                        <div id="notificacionesActivas" class="text-sm divide-y divide-gray-100 dark:divide-gray-600">
                        </div>
                        <!-- Separador y botón para archivadas -->
                        <div class="border-t border-gray-100 dark:border-gray-600">
                            <button id="toggleArchivadas"
                                class="w-full py-3 text-sm font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors duration-200">
                                Ver Archivadas
                            </button>
                        </div>
                        <!-- Notificaciones archivadas -->
                        <div id="notificacionesArchivadas" class="hidden divide-y divide-gray-100 dark:divide-gray-600">
                            <div id="archivadasContent"
                                class="flex px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 opacity-60">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme toggle -->
                <!-- <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
                </button>
                <div id="tooltip-toggle" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                Toggle dark mode
                <div class="tooltip-arrow" data-popper-arrow></div>
                </div> -->

                <!-- Profile dropdown -->
                <div class="flex items-center ml-3">
                    <div class="relative">
                        <!-- User menu button -->
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-all duration-200"
                            id="user-menu-button-2" data-dropdown-toggle="dropdown-2"
                            data-dropdown-placement="bottom-end" data-dropdown-offset-distance="10"
                            aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ auth()->user()->profilePicture() }}"
                                alt="user photo">
                        </button>

                        <!-- Dropdown menu -->
                        <div class="z-50 hidden my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 border border-gray-200 dark:border-gray-600 min-w-[12rem]"
                            id="dropdown-2">

                            <!-- User info section -->
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white font-medium" role="none">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-300" role="none">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <!-- Menu items -->
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="/"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white transition-colors duration-200"
                                        role="menuitem">
                                        <i class="fas fa-user mr-3 text-gray-400 w-4 text-center"></i>
                                        {{ __('Perfil') }}
                                    </a>
                                </li>

                                @include('layouts.navbars.partials.setup')

                                <li class="border-t border-gray-100 dark:border-gray-600">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors duration-200"
                                        role="menuitem">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500 w-4 text-center"></i>
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
</nav>

<!-- Form de logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<!-- Scripts -->
@push('scripts')
// Company selector change handler
<script>
    $(document).ready(function() {
        $('#company_id').change(function() {
            $('#fijar_rs').submit();
        });
    });
</script>
<script>
// Funcionalidad del dropdown
const notificationButton = document.getElementById('notificationButton');
const notificationDropdown = document.getElementById('notificationDropdown');
const toggleArchivadas = document.getElementById('toggleArchivadas');
const notificacionesArchivadas = document.getElementById('notificacionesArchivadas');

// Toggle dropdown
notificationButton.addEventListener('click', function(e) {
    e.stopPropagation();
    notificationDropdown.classList.toggle('hidden');
});

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
        notificationDropdown.classList.add('hidden');
    }
});

// Toggle notificaciones archivadas
toggleArchivadas.addEventListener('click', function(e) {
    e.preventDefault();
    const isHidden = notificacionesArchivadas.classList.contains('hidden');

    if (isHidden) {
        notificacionesArchivadas.classList.remove('hidden');
        toggleArchivadas.textContent = 'Ocultar Archivadas';
    } else {
        notificacionesArchivadas.classList.add('hidden');
        toggleArchivadas.textContent = 'Ver Archivadas';
    }
});

// Cerrar dropdown con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        notificationDropdown.classList.add('hidden');
    }
});
</script>
@endpush
