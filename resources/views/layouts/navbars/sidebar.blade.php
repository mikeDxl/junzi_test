
<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <!-- Validaciones Submenú -->
                    @include('layouts.navbars.partials.general')
                    @if(auth()->user()->perfil=='Colaborador')
                    @include('layouts.navbars.partials.colaboradores')
                    @endif
                    @if(auth()->user()->perfil=='Jefatura')
                    @include('layouts.navbars.partials.jefatura')
                    @endif
                    {{-- @if(auth()->user()->perfil=='Nomina')
                    @include('layouts.navbars.partials.nomina')
                    @endif--}}
                    @if(auth()->user()->reclutamiento=='1')
                    @include('layouts.navbars.partials.reclutamiento')
                    @endif 
                </ul>
            </div>
        </div>

        <!-- Toggle Button DENTRO del sidebar -->
        <div class="flex-shrink-0 p-3 border-t border-gray-200 dark:border-gray-700">
            <button onclick="hideSidebar()"
                class="flex items-center justify-center w-full p-2 text-sm font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-200"
                aria-label="Ocultar sidebar">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Ocultar menú
            </button>
        </div>
    </div>
</aside>

<!-- BOTÓN FLOTANTE QUE REEMPLAZA AL SIDEBAR -->
<div id="showSidebarBtn" class="fixed top-0 left-0 z-20 w-16 h-full pt-16 hidden"
    style="background: rgba(255, 255, 255, 0.95); border-right: 1px solid #e5e7eb;">

    <!-- Botón principal centrado verticalmente -->
    <div class="flex items-center justify-center h-full">
        <button onclick="showSidebar()"
            class="flex flex-col items-center justify-center p-4 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200 group"
            aria-label="Mostrar menú">

            <!-- Icono de menú -->
            <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>

            <!-- Texto vertical -->
            <div class="text-xs font-medium transform -rotate-90 whitespace-nowrap">
                MENÚ
            </div>
        </button>
    </div>

    <!-- Indicador visual opcional -->
    <div class="absolute top-1/2 right-0 w-1 h-12 bg-blue-500 rounded-l-full transform -translate-y-1/2 opacity-70">
    </div>
</div>

<!-- BACKDROP -->
<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

<script>
function hideSidebar() {
    const sidebar = document.getElementById('sidebar');
    const showBtn = document.getElementById('showSidebarBtn');

    //console.log('Ocultando sidebar...');

    if (sidebar && showBtn) {
        // Ocultar sidebar
        sidebar.style.display = 'none';
        sidebar.classList.add('hidden');

        // Mostrar botón flotante en la misma posición
        showBtn.classList.remove('hidden');
        showBtn.style.display = 'block';

        //console.log('Sidebar ocultado, botón flotante mostrado');
        localStorage.setItem('sidebarHidden', 'true');
    }
}

// Función para mostrar sidebar y ocultar botón flotante
function showSidebar() {
    const sidebar = document.getElementById('sidebar');
    const showBtn = document.getElementById('showSidebarBtn');

    //console.log('Mostrando sidebar...');

    if (sidebar && showBtn) {
        // Mostrar sidebar
        sidebar.style.display = 'flex';
        sidebar.classList.remove('hidden');
        sidebar.classList.add('lg:flex');

        // Ocultar botón flotante
        showBtn.classList.add('hidden');
        showBtn.style.display = 'none';

        //console.log('Sidebar mostrado, botón flotante ocultado');
        localStorage.setItem('sidebarHidden', 'false');
    }
}

// Restaurar estado al cargar
document.addEventListener('DOMContentLoaded', function() {
    const savedState = localStorage.getItem('sidebarHidden');

    if (savedState === 'true') {
        setTimeout(hideSidebar, 100); // Pequeño delay para asegurar que los elementos estén listos
    }
});

// Opcional: cerrar sidebar con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && !sidebar.classList.contains('hidden')) {
            hideSidebar();
        }
    }
});
</script>
