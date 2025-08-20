<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('white') }}/img/favicon.png">
    <title>
        JUNZI
    </title>
    <!-- Implementación de Taildwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.2.1/dist/flowbite.min.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    {{--
  <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" /> --}}
    <link href="{{ asset('css') }}/white-dashboard.css?v=1.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('white') }}/demo/demo.css" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/bootstrap-tourist.css" rel="stylesheet" />


    <style media="screen">
    .fc-button-primary {
        background: #1A5276 !important;
        color: #f5f5f5 !important;
    }

    .fc-button-primary:focus {
        background: #1A5276 !important;
        color: #f5f5f5 !important;
    }

    .fc-button-primary:hover {
        background: #1A5276 !important;
        color: #f5f5f5 !important;
    }

    nav li {
        color: #151515 !important;
    }

    .fc-toolbar-title {
        color: #151515 !important;
    }

    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }

    .submenu.show {
        max-height: 600px;
    }

    .chevron {
        transition: transform 0.2s ease-in-out;
    }

    .sidebar-container {
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
    }
    </style>


    @if (request()->getHost() === 'junzi.mx')
    <style>
    .hola {
        color: #999;
    }
    </style>
    @else
    <style>
    .off-canvas-sidebar[data=blue],
    .sidebar[data=blue] {
        background: #3358f4;
        background: linear-gradient(0deg, #424242, #424242);
    }

    .off-canvas-sidebar,
    .sidebar {
        background: #ba54f5;
        background: linear-gradient(0deg, #424242, #424242);
        height: calc(100vh - 90px);
        width: 230px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
        background-size: cover;
        background-position: 50%;
        display: block;
        box-shadow: 0 0 45px 0 rgba(0, 0, 0, .6);
        margin-top: 82px;
        margin-left: 20px;
        border-radius: 5px;
    }
    </style>
    @endif

</head>

<body class="white-content {{ $class ?? '' }}">
    @if (config('app.is_demo'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    <style>
    .fixed-plugin {
        display: none;
    }

    #ofBar {
        display: none;
    }

    .breadcrumb {
        background-color: #f5f5f5 !important;
    }

    .pagination .page-item.active>.page-link,
    .pagination .page-item.active>.page-link:focus,
    .pagination .page-item.active>.page-link:hover {
        background: #1A5276;
        background-image: linear-gradient(to bottom left, #1A5276, #1A5276, #1A5276);
        background-size: 210% 210%;
        background-position: 100% 0;
        color: #fff;
    }
    </style>


    @yield('content')


    {{-- @unless(isset($noJQuery) && $noJQuery) --}}
        <!-- Scripts normales CON jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" 
                    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
                    crossorigin="anonymous"></script>
        <!--   Core JS Files   -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <!-- <script src="{{ asset('white') }}/js/core/jquery.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
        <!-- Scripts normales CON jQuery -->
        {{-- // Resto --}}
            
            <!--   Core JS Files   -->
            <!-- <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
            <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
            <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script> -->
            <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
            <script src="{{ asset('white') }}/js/plugins/moment.min.js"></script>
            <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-switch.js"></script>
            <!--  Plugin for Sweet Alert -->
            <script src="{{ asset('white') }}/js/plugins/sweetalert2.min.js"></script>
            <!--  Plugin for Sorting Tables -->
            <script src="{{ asset('white') }}/js/plugins/jquery.tablesorter.js"></script>
            <!-- Forms Validations Plugin -->
            <script src="{{ asset('white') }}/js/plugins/jquery.validate.min.js"></script>
            <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
            <script src="{{ asset('white') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
            <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-selectpicker.js"></script>
            <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-datetimepicker.js"></script>
            <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
            <script src="{{ asset('white') }}/js/plugins/jquery.dataTables.min.js"></script>
            <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-tagsinput.js"></script>
            <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
            <script src="{{ asset('white') }}/js/plugins/jasny-bootstrap.min.js"></script>
            <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
            <script src="{{ asset('white') }}/js/plugins/fullcalendar.min.js"></script>
            <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
            <script src="{{ asset('white') }}/js/plugins/jquery-jvectormap.js"></script>
            <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
            <script src="{{ asset('white') }}/js/plugins/nouislider.min.js"></script>
            <!--  Plugin for the Bootstrap Tourist, full documentation here: https://github.com/IGreatlyDislikeJavascript/bootstrap-tourist -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-tourist.js"></script>
            <!--  Google Maps Plugin    -->
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbVUXb1ZCXDbVu5V-0AjxpikPl6jmgpbQ"></script>
            <!-- Chart JS -->
            {{-- <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script> --}}
            <!--  Notifications Plugin    -->
            <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>
            <!-- Control Center for White Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="{{ asset('white') }}/js/white-dashboard.min.js?v=1.0.0"></script>
            <!-- White Dashboard DEMO methods, don't include it in your project! -->
            <script src="{{ asset('white') }}/demo/demo.js?v=1.0"></script>

            <script src="{{ asset('white') }}/js/settings.js"></script>
            <script src="{{ asset('white') }}/demo/jquery.sharrre.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/flowbite@2.2.1/dist/flowbite.min.js"></script>
    {{-- @else
    @endunless --}}


    @stack('scripts')

    <script type="text/javascript">
    if (document.getElementById('colaborador_name')) {
        var element = document.getElementById('colaborador_name');
        const example = new Choices(element, {
            searchEnabled: true
        });
    };

    if (document.getElementById('colaborador_name2')) {
        var element = document.getElementById('colaborador_name2');
        const example = new Choices(element, {
            searchEnabled: true
        });
    };

    if (document.getElementsByClassName('colabselect').length > 0) {
        var elements = document.getElementsByClassName('colabselect');
        for (var i = 0; i < elements.length; i++) {
            new Choices(elements[i], {
                searchEnabled: true
            });
        }
    }

    class NotificacionesManager 
    {
        constructor() {
            this.config = {
                endpoints: {
                    navbar: '/notificaciones_navbar',
                    archivadas: '/notificaciones_archivadas',
                    archivar: '/notificaciones/archivar',
                    eliminar: '/notificaciones/eliminar'
                },
                selectors: {
                    activasContainer: '#notificacionesActivas',
                    archivadasContainer: '#notificacionesArchivadas',
                    badgeCount: '#cuantasnotificaciones',
                    toggleArchivadas: '#toggleArchivadas',
                    dropdownContainer: '#notificationDropdown',
                    notificationButton: '#notificationButton'
                },
                autoRefresh: 30000,
                maxRetries: 3
            };

            this.isLoading = false;
            this.archivadasVisible = false;
            this.retryCount = 0;
            this.notificaciones = [];
            this.archivadas = [];
            this.refreshInterval = null;

            this.init();
        }

        init() {
            this.setupCSRF();
            this.setupEventListeners();
            this.loadNotifications();
            this.startAutoRefresh();
        }

        setupCSRF() {
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        }

        setupEventListeners() {
            //console.log('🔧 Configurando event listeners...');

            // Limpiar eventos previos
            $(document).off('.notifications');

            // Event listeners con prevención de propagación mejorada
            $(document).on('click.notifications', '.archivar-notificacion', (e) => {
                //console.log('Click en archivar detectado');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                const id = $(e.currentTarget).data('id');
                //console.log('ID a archivar:', id);

                if (id) {
                    this.archivarNotificacion(id);
                } else {
                    console.error('No se pudo obtener el ID de la notificación');
                }

                return false;
            });

            $(document).on('click.notifications', '.eliminar-notificacion', (e) => {
                //console.log('Click en eliminar detectado');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                const id = $(e.currentTarget).data('id');
                //console.log('ID a eliminar:', id);

                if (id) {
                    this.eliminarNotificacion(id);
                } else {
                    console.error('No se pudo obtener el ID de la notificación');
                }

                return false;
            });

            $(document).on('click.notifications', this.config.selectors.toggleArchivadas, (e) => {
                //console.log('Toggle archivadas clicked');
                e.preventDefault();
                e.stopPropagation();
                this.toggleArchivadas();
            });

            // Manejar click del botón de notificaciones
            $(document).on('click.notifications', this.config.selectors.notificationButton, (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggleDropdown();
            });

            // Cerrar dropdown al hacer click fuera
            $(document).on('click.notifications', (e) => {
                const $dropdown = $(this.config.selectors.dropdownContainer);
                const $button = $(this.config.selectors.notificationButton);

                if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0 &&
                    !$button.is(e.target) && $button.has(e.target).length === 0) {
                    this.hideDropdown();
                }
            });

            // Manejar visibilidad de la página
            $(document).on('visibilitychange', () => {
                if (document.hidden) {
                    this.stopAutoRefresh();
                } else {
                    this.startAutoRefresh();
                    this.loadNotifications(false);
                }
            });

            //console.log('Event listeners configurados correctamente');
        }

        async loadNotifications(showLoading = true) {
            if (this.isLoading) return;

            try {
                this.isLoading = true;

                if (showLoading) {
                    this.showLoadingState();
                }

                const response = await this.makeRequest('POST', this.config.endpoints.navbar);

                this.notificaciones = response;
                this.renderNotifications();
                this.updateBadgeCount(response.length);
                this.retryCount = 0;

            } catch (error) {
                this.handleError('Error al cargar notificaciones', error);
                this.retryWithBackoff();
            } finally {
                this.isLoading = false;
            }
        }

        async cargarArchivadas() {
            try {
                //console.log('Cargando notificaciones archivadas...');

                const response = await this.makeRequest('POST', this.config.endpoints.archivadas);

                //console.log('Respuesta archivadas:', response);

                if (Array.isArray(response)) {
                    this.archivadas = response;
                } else if (response.data && Array.isArray(response.data)) {
                    this.archivadas = response.data;
                } else {
                    this.archivadas = [];
                }

                //console.log('Archivadas procesadas:', this.archivadas.length);

                this.renderArchivadas();

            } catch (error) {
                console.error('Error al cargar archivadas:', error);
                this.handleError('Error al cargar notificaciones archivadas', error);
            }
        }

        async archivarNotificacion(id) {
            //console.log('Iniciando archivado de notificación:', id);

            if (!id) {
                console.error('ID de notificación no válido:', id);
                return;
            }

            try {
                this.showButtonLoading(`.archivar-notificacion[data-id="${id}"]`);

                //console.log('📤 Enviando request para archivar...');

                const response = await this.makeRequest('POST', this.config.endpoints.archivar, {
                    id
                });

                //console.log('📥 Respuesta del servidor:', response);

                this.showToast('Notificación archivada correctamente', 'success');
                await this.loadNotifications();

                if (this.archivadasVisible) {
                    await this.cargarArchivadas();
                }

            } catch (error) {
                console.error('Error al archivar:', error);
                this.handleError('Error al archivar la notificación', error);
            }
        }

        async eliminarNotificacion(id) {
            //console.log('Iniciando eliminación de notificación:', id);

            if (!id) {
                console.error('ID de notificación no válido:', id);
                return;
            }

            try {
                this.showButtonLoading(`.eliminar-notificacion[data-id="${id}"]`);

                //console.log('📤 Enviando request para eliminar...');

                const response = await this.makeRequest('POST', this.config.endpoints.eliminar, {
                    id
                });

                //console.log('📥 Respuesta del servidor:', response);

                this.showToast('Notificación marcada como vista', 'success');
                await this.loadNotifications();

            } catch (error) {
                console.error('Error al eliminar:', error);
                this.handleError('Error al eliminar la notificación', error);
            }
        }

        async toggleArchivadas() {
            const $container = $(this.config.selectors.archivadasContainer);
            const $toggle = $(this.config.selectors.toggleArchivadas);

            if (this.archivadasVisible) {
                this.hideArchivadas($container, $toggle);
            } else {
                await this.showArchivadas($container, $toggle);
            }
        }

        hideArchivadas($container, $toggle) {
            $container.slideUp(300, () => {
                $container.addClass('hidden');
            });
            $toggle.html('<i class="fas fa-archive mr-2"></i>Ver Archivadas');
            this.archivadasVisible = false;
        }

        async showArchivadas($container, $toggle) {
            $toggle.html('<i class="fas fa-spinner fa-spin mr-2"></i>Cargando...');

            try {
                await this.cargarArchivadas();
                $container.removeClass('hidden').hide().slideDown(300);
                $toggle.html('<i class="fas fa-archive mr-2"></i>Ocultar Archivadas');
                this.archivadasVisible = true;

                //console.log('Archivadas cargadas:', this.archivadas.length);

            } catch (error) {
                $toggle.html('<i class="fas fa-archive mr-2"></i>Ver Archivadas');
                this.handleError('Error al cargar archivadas', error);
            }
        }

        renderNotifications() {
            const $container = $(this.config.selectors.activasContainer);
            $container.empty();

            //console.log('🎨 Renderizando notificaciones:', this.notificaciones.length);

            if (this.notificaciones.length === 0) {
                $container.html(this.getEmptyStateTemplate());
                return;
            }

            this.notificaciones.forEach((notificacion, index) => {
                //console.log('Renderizando notificación:', notificacion.id, notificacion.texto);

                const $notification = $(this.getNotificationTemplate(notificacion));
                $notification.css('opacity', '0').css('transform', 'translateY(10px)');
                $container.append($notification);

                const $botones = $notification.find('.archivar-notificacion, .eliminar-notificacion');
                //console.log('Botones encontrados en notificación:', $botones.length);

                setTimeout(() => {
                    $notification.animate({
                        opacity: 1
                    }, 200).css('transform', 'translateY(0)');
                }, index * 50);
            });

            this.addActionButtons($container);

            const $todosLosBotones = $container.find('.archivar-notificacion, .eliminar-notificacion');
            //console.log('Total de botones en el contenedor:', $todosLosBotones.length);
        }

        renderArchivadas() {
            const $container = $(this.config.selectors.archivadasContainer);

            //console.log('Contenedor archivadas encontrado:', $container.length);

            $container.empty();

            if (this.archivadas.length === 0) {
                $container.html(`
                <div class="text-center py-4">
                    <i class="fas fa-archive text-gray-400 text-2xl mb-2"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400">No hay notificaciones archivadas</p>
                </div>
            `);
                return;
            }

            $container.append(`
            <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-600">
                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Archivadas</h4>
                <div class="space-y-2" id="archivadasContent"></div>
            </div>
        `);

            const $content = $container.find('#archivadasContent');
            this.archivadas.forEach((notificacion, index) => {
                const $notification = $(this.getArchivedNotificationTemplate(notificacion));

                $notification.css('opacity', '0').css('transform', 'translateY(5px)');
                $content.append($notification);

                setTimeout(() => {
                    $notification.animate({
                        opacity: 1
                    }, 150).css('transform', 'translateY(0)');
                }, index * 30);
            });
        }

        updateBadgeCount(count) {
            const $badge = $(this.config.selectors.badgeCount);

            if (count > 0) {
                const displayCount = count > 99 ? '99+' : count;
                $badge.text(displayCount).removeClass('hidden');

                if (count > (this.lastCount || 0)) {
                    $badge.addClass('animate-pulse');
                    setTimeout(() => $badge.removeClass('animate-pulse'), 2000);
                }
            } else {
                $badge.addClass('hidden');
            }

            this.lastCount = count;
        }

        getNotificationTemplate(notificacion) {
            const escapedTexto = this.escapeHtml(notificacion.texto);
            const timeAgo = this.getTimeAgo(notificacion.created_at);

            // Función para construir URL correcta
            const buildUrl = (ruta) => {
                if (!ruta) return '#';

                // Si ya es una URL completa, devolverla tal como está
                if (ruta.startsWith('http://') || ruta.startsWith('https://')) {
                    return ruta;
                }

                if (ruta.startsWith('/')) {
                    return ruta;
                }

                return '/' + ruta;
            };

            const finalUrl = buildUrl(notificacion.ruta);

            return `
            <div class="flex px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 group transition-colors duration-200">
                <div class="flex-1 min-w-0">
                    <a href="${finalUrl}" class="block group-link">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            ${escapedTexto}
                        </p>
                        ${notificacion.descripcion ? `
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                ${this.escapeHtml(notificacion.descripcion)}
                            </p>
                        ` : ''}
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                            ${timeAgo}
                        </p>
                    </a>
                </div>
                <div class="flex items-center space-x-2 ml-3 opacity-100 transition-opacity duration-200">
                    <button title="Archivar"
                            class="archivar-notificacion text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 border border-transparent hover:border-blue-200"
                            data-id="${notificacion.id}"
                            type="button">
                        <i class="fas fa-archive text-sm"></i>
                    </button>
                    <button title="Marcar como vista"
                            class="eliminar-notificacion text-gray-400 hover:text-red-600 dark:hover:text-red-400 p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 border border-transparent hover:border-red-200"
                            data-id="${notificacion.id}"
                            type="button">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        `;
        }

        getArchivedNotificationTemplate(notificacion) {
            const escapedTexto = this.escapeHtml(notificacion.texto);
            const timeAgo = this.getTimeAgo(notificacion.created_at);

            // Función para construir URL correcta
            const buildUrl = (ruta) => {
                if (!ruta) return '#';

                if (ruta.startsWith('http://') || ruta.startsWith('https://')) {
                    return ruta;
                }

                if (ruta.startsWith('/')) {
                    return ruta;
                }

                return '/' + ruta;
            };

            const finalUrl = buildUrl(notificacion.ruta);

            return `
            <div class="flex px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 opacity-60 hover:opacity-80 transition-all duration-200">
                <div class="flex-1 min-w-0">
                    <a href="${finalUrl}" class="block">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                            ${escapedTexto}
                        </p>
                        ${notificacion.descripcion ? `
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">
                                ${this.escapeHtml(notificacion.descripcion)}
                            </p>
                        ` : ''}
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            ${timeAgo} • Archivada
                        </p>
                    </a>
                </div>
                <div class="flex items-center ml-3">
                    <i class="fas fa-archive text-gray-400 text-sm"></i>
                </div>
            </div>
        `;
        }

        getEmptyStateTemplate() {
            return `
            <div class="flex px-4 py-8 justify-center items-center">
                <div class="text-center">
                    <i class="fas fa-bell-slash text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">No tienes notificaciones nuevas</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">¡Estás al día! 🎉</p>
                </div>
            </div>
        `;
        }

        addActionButtons($container) {
            const actionsHtml = `
            <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                <div class="flex justify-between items-center px-4">
                    <a href="/notificaciones" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                        Ver todas <i class="fas fa-external-link-alt ml-1"></i>
                    </a>
                </div>
            </div>
        `;
            $container.append(actionsHtml);
        }

        // Métodos para manejar el dropdown
        toggleDropdown() {
            const $dropdown = $(this.config.selectors.dropdownContainer);

            if ($dropdown.hasClass('hidden')) {
                this.showDropdown();
            } else {
                this.hideDropdown();
            }
        }

        showDropdown() {
            const $dropdown = $(this.config.selectors.dropdownContainer);
            $dropdown.removeClass('hidden');
        }

        hideDropdown() {
            const $dropdown = $(this.config.selectors.dropdownContainer);
            $dropdown.addClass('hidden');

            if (this.archivadasVisible) {
                this.hideArchivadas($(this.config.selectors.archivadasContainer), $(this.config.selectors
                    .toggleArchivadas));
            }
        }

        // Request
        async makeRequest(method, url, data = {}) {
            const token = $('meta[name="csrf-token"]').attr('content');

            return new Promise((resolve, reject) => {
                $.ajax({
                    type: method,
                    url: url,
                    data: {
                        ...data,
                        _token: token
                    },
                    dataType: 'json',
                    timeout: 10000,
                    success: resolve,
                    error: (xhr, status, error) => {
                        reject({
                            xhr,
                            status,
                            error,
                            response: xhr.responseJSON
                        });
                    }
                });
            });
        }

        showLoadingState() {
            const $container = $(this.config.selectors.activasContainer);
            $container.html(`
            <div class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-2"></div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Cargando notificaciones...</p>
            </div>
        `);
        }

        showButtonLoading(selector) {
            const $button = $(selector);
            const originalHtml = $button.html();

            $button.data('original-html', originalHtml)
                .html('<i class="fas fa-spinner fa-spin text-xs"></i>')
                .prop('disabled', true);

            setTimeout(() => {
                $button.html($button.data('original-html') || originalHtml)
                    .prop('disabled', false)
                    .removeData('original-html');
            }, 1500);
        }

        showToast(message, type = 'info') {
            const toastClass = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            } [type] || 'bg-blue-500';

            const $toast = $(`
            <div class="fixed top-4 right-4 ${toastClass} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300">
                <div class="flex items-center space-x-2">
                    <span class="text-sm">${message}</span>
                    <button class="ml-2 text-white hover:text-gray-200" onclick="$(this).parent().parent().remove()">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        `);

            $('body').append($toast);

            setTimeout(() => $toast.removeClass('translate-x-full'), 100);
            setTimeout(() => {
                $toast.addClass('translate-x-full');
                setTimeout(() => $toast.remove(), 300);
            }, 3000);
        }

        handleError(message, error) {
            console.error(message, error);

            let errorMessage = message;
            if (error.response && error.response.message) {
                errorMessage += ': ' + error.response.message;
            }

            this.showToast(errorMessage, 'error');
        }

        retryWithBackoff() {
            if (this.retryCount < this.config.maxRetries) {
                this.retryCount++;
                const delay = Math.pow(2, this.retryCount) * 1000;

                setTimeout(() => {
                    this.loadNotifications(false);
                }, delay);
            }
        }

        startAutoRefresh() {
            this.stopAutoRefresh();

            this.refreshInterval = setInterval(() => {
                if (!document.hidden) {
                    this.loadNotifications(false);
                }
            }, this.config.autoRefresh);
        }

        stopAutoRefresh() {
            if (this.refreshInterval) {
                clearInterval(this.refreshInterval);
                this.refreshInterval = null;
            }
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        getTimeAgo(dateString) {
            if (!dateString) return 'Hace un momento';

            const now = new Date();
            const date = new Date(dateString);
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);

            if (minutes < 1) return 'Hace un momento';
            if (minutes < 60) return `Hace ${minutes} minuto${minutes !== 1 ? 's' : ''}`;
            if (hours < 24) return `Hace ${hours} hora${hours !== 1 ? 's' : ''}`;
            if (days < 7) return `Hace ${days} día${days !== 1 ? 's' : ''}`;

            return date.toLocaleDateString();
        }

        refresh() {
            this.loadNotifications();
        }

        destroy() {
            this.stopAutoRefresh();
            $(document).off('.notifications');
        }
    }

    // Limpiar recursos al salir de la página
    $(window).on('beforeunload', function() {
        if (window.notificacionesManager) {
            window.notificacionesManager.destroy();
        }
    });


    class ToastNotificacionesManager 
    {
        constructor() {
            this.config = {
                endpoints: {
                    toast: '/notificaciones_toast',
                    marcarLeida: '/notificaciones/marcar_leida',
                    navbar: '/notificaciones_navbar' // 
                },
                selectors: {
                    toastContainer: '#toastContainer'
                },
                autoRefresh: 8000, // Verificar cada 8 segundos
                toastDuration: 12000, // Duración de 12 segundos para dar tiempo a leer
                maxToasts: 4
            };

            this.activeToasts = new Map();
            this.lastNotificationId = 0;
            this.refreshInterval = null;
            this.soundEnabled = true;
            this.isVisible = !document.hidden;

            this.init();
        }

        init() {
            this.createToastContainer();
            this.setupCSRF();
            this.loadInitialLastId();
            this.startAutoRefresh();
            this.setupVisibilityHandling();
            this.setupEventListeners();
        }

        createToastContainer() {
            if (!$(this.config.selectors.toastContainer).length) {
                $('body').append(`
                    <div id="toastContainer" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none max-w-sm mt-4">
                    </div>
                `);
            }
        }

        setupCSRF() {
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        }

        async loadInitialLastId() {
            try {
                // Obtener el ID de la última notificación para establecer baseline
                const response = await this.makeRequest('POST', this.config.endpoints.navbar);
                if (response && response.length > 0) {
                    this.lastNotificationId = Math.max(...response.map(n => n.id));
                }
            } catch (error) {
                console.log('Estableciendo baseline de notificaciones...');
            }
        }

        setupVisibilityHandling() {
            $(document).on('visibilitychange', () => {
                this.isVisible = !document.hidden;
                if (this.isVisible) {
                    // Cuando regresa el usuario, verificar inmediatamente
                    this.checkForNewNotifications();
                }
            });
        }

        setupEventListeners() {
            $(document).off('.toasts');

            $(document).on('click.toasts', '.toast-close', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const toastId = $(e.currentTarget).data('toast-id');
                this.removeToast(toastId);
            });

            $(document).on('click.toasts', '.toast-mark-read', async (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const notificationId = $(e.currentTarget).data('notification-id');
                const toastId = $(e.currentTarget).data('toast-id');
                
                await this.marcarComoLeida(notificationId, toastId);
            });

            $(document).on('click.toasts', '.toast-action', (e) => {
                const toastId = $(e.currentTarget).data('toast-id');
                const notificationId = $(e.currentTarget).data('notification-id');
                
                // Marcar como leída cuando hace click en la acción
                this.marcarComoLeida(notificationId, toastId);
            });

            // Pausar progreso al hacer hover
            $(document).on('mouseenter.toasts', '.toast-notification', function() {
                $(this).find('.toast-progress').css('animation-play-state', 'paused');
            });

            $(document).on('mouseleave.toasts', '.toast-notification', function() {
                $(this).find('.toast-progress').css('animation-play-state', 'running');
            });
        }

        async checkForNewNotifications() {
            if (!this.isVisible) return;

            try {
                const response = await this.makeRequest('POST', this.config.endpoints.toast, {
                    last_id: this.lastNotificationId
                });

                if (response && Array.isArray(response) && response.length > 0) {
                    this.processNewNotifications(response);
                }

            } catch (error) {
                console.error('Error al verificar nuevas notificaciones:', error);
            }
        }

        processNewNotifications(notifications) {
            notifications.forEach(notification => {
                if (notification.id > this.lastNotificationId) {
                    this.showToastNotification(notification);
                    this.lastNotificationId = Math.max(this.lastNotificationId, notification.id);
                }
            });

            // Actualizar el manager principal de la navbar
            if (window.notificacionesManager) {
                setTimeout(() => {
                    window.notificacionesManager.refresh();
                }, 1000);
            }
        }

        showToastNotification(notification) {
            this.cleanOldToasts();

            const toastId = `toast-${notification.id}-${Date.now()}`;
            const toast = this.createToastElement(notification, toastId);
            
            const $container = $(this.config.selectors.toastContainer);
            $container.append(toast);

            this.animateToastIn(toastId);

            const autoRemoveTimeout = setTimeout(() => {
                this.removeToast(toastId);
            }, this.config.toastDuration);

            this.activeToasts.set(toastId, {
                notification,
                timeout: autoRemoveTimeout,
                element: $(`#${toastId}`)
            });

            if (this.soundEnabled && this.isVisible) {
                this.playNotificationSound();
            }
        }

        createToastElement(notification, toastId) {
            const timeAgo = this.getTimeAgo(notification.created_at || notification.fecha);
            const escapedTexto = this.escapeHtml(notification.texto);
            
            // Usar tu sistema de tipos existente
            const typeConfig = this.getTypeConfig(notification.tipo);
            const finalUrl = this.buildUrl(notification.ruta);

            // Extraer descripción del texto si es muy largo
            let textoCorto = escapedTexto;
            let descripcion = '';
            
            if (escapedTexto.length > 60) {
                const palabras = escapedTexto.split(' ');
                if (palabras.length > 8) {
                    textoCorto = palabras.slice(0, 8).join(' ') + '...';
                    descripcion = escapedTexto;
                }
            }

            return `
                <div id="${toastId}" 
                    class="toast-notification pointer-events-auto transform translate-x-full transition-all duration-500 ease-out">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border-l-4 ${typeConfig.borderColor} overflow-hidden backdrop-blur-sm">
                        <div class="p-4">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="${typeConfig.bgColor} rounded-full p-2">
                                            <i class="${typeConfig.icon} ${typeConfig.iconColor} text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">
                                            ${textoCorto}
                                        </p>
                                    </div>
                                </div>
                                <button class="toast-close flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors ml-2 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                        data-toast-id="${toastId}"
                                        title="Cerrar">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>

                            <!-- Descripción completa si es necesaria -->
                            ${descripcion && descripcion !== textoCorto ? `
                                <div class="mb-3 ml-11">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                        ${descripcion}
                                    </p>
                                </div>
                            ` : ''}

                            <!-- Footer con acciones -->
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-11">
                                    ${timeAgo}
                                </span>
                                <div class="flex items-center space-x-2">
                                    ${finalUrl && finalUrl !== '#' ? `
                                        <a href="${finalUrl}" 
                                        class="toast-action text-xs px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-full transition-colors font-medium"
                                        data-toast-id="${toastId}"
                                        data-notification-id="${notification.id}">
                                            Ver <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    ` : ''}
                                    <button class="toast-mark-read text-xs px-2 py-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors"
                                            data-notification-id="${notification.id}"
                                            data-toast-id="${toastId}"
                                            title="Marcar como leída">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Barra de progreso -->
                            <div class="mt-3 bg-gray-200 dark:bg-gray-700 rounded-full h-1 overflow-hidden">
                                <div class="toast-progress bg-gradient-to-r ${typeConfig.progressColor} h-full rounded-full transition-all duration-100 ease-linear"
                                    style="width: 100%; animation: progressCountdown ${this.config.toastDuration}ms linear forwards;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        getTypeConfig(tipo) {
            const configs = {
                success: {
                    borderColor: 'border-green-500',
                    bgColor: 'bg-green-100 dark:bg-green-900/30',
                    icon: 'fas fa-check-circle',
                    iconColor: 'text-green-600 dark:text-green-400',
                    progressColor: 'from-green-400 to-green-600'
                },
                danger: {
                    borderColor: 'border-red-500',
                    bgColor: 'bg-red-100 dark:bg-red-900/30',
                    icon: 'fas fa-exclamation-triangle',
                    iconColor: 'text-red-600 dark:text-red-400',
                    progressColor: 'from-red-400 to-red-600'
                },
                warning: {
                    borderColor: 'border-yellow-500',
                    bgColor: 'bg-yellow-100 dark:bg-yellow-900/30',
                    icon: 'fas fa-exclamation-triangle',
                    iconColor: 'text-yellow-600 dark:text-yellow-400',
                    progressColor: 'from-yellow-400 to-yellow-600'
                },
                info: {
                    borderColor: 'border-blue-500',
                    bgColor: 'bg-blue-100 dark:bg-blue-900/30',
                    icon: 'fas fa-info-circle',
                    iconColor: 'text-blue-600 dark:text-blue-400',
                    progressColor: 'from-blue-400 to-blue-600'
                }
            };

            return configs[tipo] || configs.info;
        }

        animateToastIn(toastId) {
            const $toast = $(`#${toastId}`);
            
            setTimeout(() => {
                $toast.removeClass('translate-x-full');
            }, 50);

            // Efecto bounce sutil
            setTimeout(() => {
                $toast.addClass('transform-none');
            }, 300);
        }

        removeToast(toastId, immediate = false) {
            const toastData = this.activeToasts.get(toastId);
            if (!toastData) return;

            const $toast = toastData.element;

            if (immediate) {
                $toast.remove();
            } else {
                $toast.addClass('translate-x-full opacity-0 scale-95');
                setTimeout(() => $toast.remove(), 500);
            }

            if (toastData.timeout) {
                clearTimeout(toastData.timeout);
            }

            this.activeToasts.delete(toastId);
        }

        cleanOldToasts() {
            const toastCount = this.activeToasts.size;
            
            if (toastCount >= this.config.maxToasts) {
                const toastsArray = Array.from(this.activeToasts.keys());
                const toastsToRemove = toastsArray.slice(0, toastCount - this.config.maxToasts + 1);
                
                toastsToRemove.forEach(toastId => {
                    this.removeToast(toastId, true);
                });
            }
        }

        async marcarComoLeida(notificationId, toastId) {
            try {
                await this.makeRequest('POST', this.config.endpoints.marcarLeida, {
                    id: notificationId
                });

                this.removeToast(toastId);

                // Actualizar navbar
                if (window.notificacionesManager) {
                    setTimeout(() => {
                        window.notificacionesManager.refresh();
                    }, 500);
                }

            } catch (error) {
                console.error('Error al marcar como leída:', error);
                this.showSimpleToast('Error al marcar como leída', 'danger');
            }
        }

        // API para mostrar toasts simples desde JavaScript
        showSimpleToast(message, type = 'info', duration = 6000) {
            const toastId = `simple-toast-${Date.now()}`;
            const typeConfig = this.getTypeConfig(type);

            const toast = `
                <div id="${toastId}" 
                    class="toast-notification pointer-events-auto transform translate-x-full transition-all duration-500 ease-out">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border-l-4 ${typeConfig.borderColor} overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="${typeConfig.bgColor} rounded-full p-2">
                                        <i class="${typeConfig.icon} ${typeConfig.iconColor} text-sm"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        ${this.escapeHtml(message)}
                                    </p>
                                </div>
                                <button class="toast-close text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                        data-toast-id="${toastId}">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <div class="mt-3 bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                <div class="toast-progress bg-gradient-to-r ${typeConfig.progressColor} h-full rounded-full"
                                    style="animation: progressCountdown ${duration}ms linear forwards;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const $container = $(this.config.selectors.toastContainer);
            $container.append(toast);

            this.animateToastIn(toastId);

            const timeout = setTimeout(() => {
                this.removeToast(toastId);
            }, duration);

            this.activeToasts.set(toastId, {
                timeout,
                element: $(`#${toastId}`)
            });
        }

        playNotificationSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();

                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);

                // Sonido más agradable
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);

                gainNode.gain.setValueAtTime(0.05, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
            } catch (error) {
                // Silenciar errores de audio
            }
        }

        startAutoRefresh() {
            this.stopAutoRefresh();

            this.refreshInterval = setInterval(() => {
                if (this.isVisible) {
                    this.checkForNewNotifications();
                }
            }, this.config.autoRefresh);
        }

        stopAutoRefresh() {
            if (this.refreshInterval) {
                clearInterval(this.refreshInterval);
                this.refreshInterval = null;
            }
        }

        // Utilidades
        buildUrl(ruta) {
            if (!ruta) return '#';
            if (ruta.startsWith('http://') || ruta.startsWith('https://')) return ruta;
            if (ruta.startsWith('/')) return ruta;
            return '/' + ruta;
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }

        getTimeAgo(dateString) {
            if (!dateString) return 'Ahora';

            const now = new Date();
            const date = new Date(dateString);
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);

            if (minutes < 1) return 'Ahora';
            if (minutes < 60) return `${minutes}m`;
            
            const hours = Math.floor(diff / 3600000);
            if (hours < 24) return `${hours}h`;
            
            const days = Math.floor(diff / 86400000);
            return `${days}d`;
        }

        async makeRequest(method, url, data = {}) {
            const token = $('meta[name="csrf-token"]').attr('content');

            return new Promise((resolve, reject) => {
                $.ajax({
                    type: method,
                    url: url,
                    data: { ...data, _token: token },
                    dataType: 'json',
                    timeout: 10000,
                    success: resolve,
                    error: (xhr, status, error) => {
                        reject({ xhr, status, error, response: xhr.responseJSON });
                    }
                });
            });
        }

        // API pública
        toggleSound() {
            this.soundEnabled = !this.soundEnabled;
            this.showSimpleToast(
                `Sonido ${this.soundEnabled ? 'activado' : 'desactivado'}`, 
                'info', 
                3000
            );
            return this.soundEnabled;
        }

        clearAllToasts() {
            this.activeToasts.forEach((_, toastId) => {
                this.removeToast(toastId, true);
            });
        }

        destroy() {
            this.stopAutoRefresh();
            this.clearAllToasts();
            $(document).off('.toasts');
        }
    }

    // =============================================================================
    // ESTILOS CSS MEJORADOS
    // =============================================================================

    const toastStyles = `
    <style id="toast-styles">
    @keyframes progressCountdown {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%) scale(0.95);
            opacity: 0;
        }
        to {
            transform: translateX(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes bounceIn {
        0% { transform: translateX(100%) scale(0.3); opacity: 0; }
        50% { transform: translateX(-10px) scale(1.05); }
        70% { transform: translateX(5px) scale(0.95); }
        100% { transform: translateX(0) scale(1); opacity: 1; }
    }

    .toast-notification {
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        max-width: 380px;
        width: 100%;
        z-index: 99999;
        position: relative;
    }

    .toast-notification:hover {
        transform: scale(1.02) translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .toast-close:hover,
    .toast-mark-read:hover,
    .toast-action:hover {
        transform: scale(1.1);
        transition: transform 0.2s ease-out;
    }

    .toast-action:hover {
        transform: scale(1.05) translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Efectos de hover en progreso */
    .toast-notification:hover .toast-progress {
        animation-play-state: paused;
        opacity: 0.7;
    }

    /* Asegurar que esté por encima de todo */
    #toastContainer {
        z-index: 99999 !important;
        position: fixed !important;
        pointer-events: none;
    }

    #toastContainer .toast-notification {
        pointer-events: auto;
    }

    /* Responsive design */
    @media (max-width: 640px) {
        #toastContainer {
            left: 1rem !important;
            right: 1rem !important;
            top: 5rem !important; /* Más espacio en móvil para evitar navbar */
            max-width: none;
        }
        
        .toast-notification {
            max-width: none;
            width: 100%;
        }
    }

    @media (max-width: 1024px) {
        #toastContainer {
            top: 5rem !important; /* En tablets también dar más espacio */
        }
    }

    /* Dark mode improvements */
    @media (prefers-color-scheme: dark) {
        .toast-notification {
            backdrop-filter: blur(16px);
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        .toast-notification {
            animation: none;
            transition: none;
        }
        
        .toast-progress {
            animation: none !important;
        }
    }

    /* Scroll behavior when many toasts */
    #toastContainer {
        max-height: calc(100vh - 6rem); /* Dejar espacio para navbar */
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    #toastContainer::-webkit-scrollbar {
        display: none;
    }

    /* Asegurar que los toasts no interfieran con elementos de la navbar */
    .navbar, 
    .sidebar, 
    .main-header,
    .fixed-top {
        z-index: 9998 !important;
    }

    /* Específico para tu sistema */
    .off-canvas-sidebar,
    .sidebar[data=blue] {
        z-index: 9998 !important;
    }
    </style>
    `;

// Inyectar estilos solo si no existen
if (!document.getElementById('toast-styles')) {
    $('head').append(toastStyles);
}


    // Inicializar cuando el documento esté listo
    $(document).ready(function() {
        if ($('#logout-form').length > 0) {

            window.notificacionesManager = new NotificacionesManager();

            window.toastNotificacionesManager = new ToastNotificacionesManager();
            
            // API global simplificada
            window.showToast = function(message, type = 'info', duration = 6000) {
                if (window.toastNotificacionesManager) {
                    window.toastNotificacionesManager.showSimpleToast(message, type, duration);
                }
            };

            window.clearAllToasts = function() {
                if (window.toastNotificacionesManager) {
                    window.toastNotificacionesManager.clearAllToasts();
                }
            };

            window.toggleToastSound = function() {
                if (window.toastNotificacionesManager) {
                    return window.toastNotificacionesManager.toggleSound();
                }
                return false;
            };

            // API específica para tu sistema
            window.notificarExito = function(mensaje, ruta = null) {
                showToast(mensaje, 'success');
            };

            window.notificarError = function(mensaje) {
                showToast(mensaje, 'danger');
            };

            window.notificarAdvertencia = function(mensaje) {
                showToast(mensaje, 'warning');
            };

            window.notificarInfo = function(mensaje) {
                showToast(mensaje, 'info');
            };
        }
    });

    // Limpiar recursos al salir de la página
    $(window).on('beforeunload', function() {
        if (window.notificacionesManager) {
            window.notificacionesManager.destroy();
        }
    });



    document.addEventListener('DOMContentLoaded', function() 
    {
        const menuToggles = document.querySelectorAll('.menu-toggle');

        menuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-target');
                const submenu = document.getElementById(targetId);
                const chevron = this.querySelector('.chevron');

                if (!submenu) {
                    console.error('Submenu no encontrado:', targetId);
                    return;
                }

                // Cerrar otros submenús
                document.querySelectorAll('.submenu.show').forEach(menu => {
                    if (menu !== submenu) {
                        menu.classList.remove('show');
                        const parentToggle = menu.closest('.menu-item').querySelector(
                            '.chevron');
                        if (parentToggle) {
                            parentToggle.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                // Toggle submenu actual
                if (submenu.classList.contains('show')) {
                    submenu.classList.remove('show');
                    chevron.style.transform = 'rotate(0deg)';
                } else {
                    submenu.classList.add('show');
                    chevron.style.transform = 'rotate(180deg)';
                }
            });
        });

        const $toggleButton = $('#toggleSidebarMobile');
        const $sidebar = $('#sidebar');
        const $backdrop = $('#sidebarBackdrop');
        const $hamburger = $('#toggleSidebarMobileHamburger');
        const $close = $('#toggleSidebarMobileClose');

        $toggleButton.on('click', function(e) {
            e.preventDefault();

            if ($sidebar.hasClass('hidden')) {
                // Abrir
                $sidebar.removeClass('hidden').addClass('flex');
                $backdrop.removeClass('hidden');
                $hamburger.addClass('hidden');
                $close.removeClass('hidden');
                $(this).attr('aria-expanded', 'true');
                $('body').css('overflow', 'hidden');
            } else {
                // Cerrar
                $sidebar.addClass('hidden').removeClass('flex');
                $backdrop.addClass('hidden');
                $hamburger.removeClass('hidden');
                $close.addClass('hidden');
                $(this).attr('aria-expanded', 'false');
                $('body').css('overflow', '');
            }
        });

        // Click en backdrop para cerrar
        $backdrop.on('click', function() {
            $toggleButton.trigger('click');
        });

        // ESC para cerrar
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$sidebar.hasClass('hidden') && $(window).width() < 1024) {
                $toggleButton.trigger('click');
            }
        });
    });

    </script>

    <!-- Para graficas choca con Tailwind-->
    {{-- @stack('js') --}}


</body>

</html>
