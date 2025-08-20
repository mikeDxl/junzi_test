
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('white') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('white') }}/img/favicon.png">
  <title>
    JUNZI
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Extra details for Live View on GitHub Pages -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>




  <!-- Nucleo Icons -->
  <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  {{-- <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" /> --}}
   <link href="{{ asset('css') }}/white-dashboard.css?v=1.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('white') }}/demo/demo.css" rel="stylesheet" />
  <link href="{{ asset('white') }}/css/bootstrap-tourist.css" rel="stylesheet" />



  <style media="screen">
    .fc-button-primary{
      background: #1A5276!important;
      color: #f5f5f5!important;
    }

    .fc-button-primary:focus{
      background: #1A5276!important;
      color: #f5f5f5!important;
    }
    .fc-button-primary:hover{
      background: #1A5276!important;
      color: #f5f5f5!important;
    }

    nav li{ color:#151515!important;}

    .fc-toolbar-title {
        color: #151515!important;
    }
  </style>

</head>
  <body class="white-content {{ $class ?? '' }}">
  @if (config('app.is_demo'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
  @endif
      <style>
      .fixed-plugin{ display: none;}
        #ofBar {
          display:none;
        }
        .breadcrumb{ background-color: #f5f5f5!important; }
        .pagination .page-item.active>.page-link, .pagination .page-item.active>.page-link:focus, .pagination .page-item.active>.page-link:hover {
    background: #1A5276;
    background-image: linear-gradient(to bottom left,#1A5276,#1A5276,#1A5276);
    background-size: 210% 210%;
    background-position: 100% 0;
    color: #fff;
}
      </style>
        @if (auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock', 'page.error']))
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          @include('layouts.page_templates.auth')

        @else
          @include('layouts.page_templates.guest')
        @endif


        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <!--   Core JS Files   -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>

        <!--   Core JS Files   -->
        <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
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
        <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for White Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('white') }}/js/white-dashboard.min.js?v=1.0.0"></script>
        <!-- White Dashboard DEMO methods, don't include it in your project! -->
        <script src="{{ asset('white') }}/demo/demo.js?v=1.0"></script>

        <script src="{{ asset('white') }}/js/settings.js"></script>
        <script src="{{ asset('white') }}/demo/jquery.sharrre.js"></script>
        <script>
          $(document).ready(function () {
            buscarNotificacion();
            navbarNotificacion();
            setInterval(buscarNotificacion, 1000);
            setInterval(navbarNotificacion, 1000);

          });
          /*
          $.notify({
            icon: "tim-icons icon-bell-55",
            message: "hola" ,
            url: 'http://127.0.0.1:8000/proceso_vacante/2'
          }, {
            type: 'danger',
            timer: 3000,
            placement: {
              from: 'top',
              align: 'right'
            }
          });
          */
        </script>


        <script type="text/javascript">
        function buscarNotificacion(){
          var token = '{{ csrf_token() }}';
          var data = { _token: token };

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
              type: 'POST',
              url: '/notificaciones_show',
              data: data,
              dataType: 'json', // Esperamos recibir JSON como respuesta
              encode: true,
              success: function (notificaciones) {
                  // Itera a través de las notificaciones y muestra cada una
                  $.each(notificaciones, function (index, notificacion) {
                      $.notify({
                          icon: "tim-icons icon-bell-55",
                          message: notificacion.texto,
                          url: notificacion.url,
                      }, {
                          type: notificacion.tipo,
                          timer: 3000,
                          placement: {
                              from: 'top',
                              align: 'right'
                          }
                      });
                  });
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.error('Error en la solicitud AJAX');
              }
          });
      }

        </script>


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
          </script>

        <!--
        // Agrega un evento de cambio a cada select
        select.addEventListener('change', function() {
            // Verifica si el select actual ya tiene la clase 'choices'
            var hasChoicesClass = select.classList.contains('choices');

            // Si el valor del select cambia y no tiene la clase 'choices', añádesela
            if (!hasChoicesClass) {
                select.classList.add('choices');
                // También puedes volver a inicializar Choices para actualizar el select
                choices.destroy();
                new Choices(select, {
                    searchEnabled: true,
                    shouldSort: false
                });
            }
        });
      -->


        <script type="text/javascript">

        function navbarNotificacion() {
              var token = '{{ csrf_token() }}';
              var data = { _token: token };

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $.ajax({
                  type: 'POST',
                  url: '/notificaciones_navbar',
                  data: data,
                  dataType: 'json',
                  encode: true,
                  success: function (notificaciones) {
                      // Limpiamos el menú de notificaciones
                      $('#navbar').empty();

                      // Actualizamos el badge con el número de notificaciones
                      $('#cuantasnotificaciones').text(notificaciones.length);

                      // Iteramos a través de las notificaciones y las agregamos al menú
                      $.each(notificaciones, function (index, notificacion) {
                          var $li = $('<li class="nav-link"></li>');
                          var $a = $('<a href="' + notificacion.ruta + '" class="nav-item dropdown-item">' + notificacion.texto + '</a>');
                          $li.append($a);
                          $('#navbar').append($li);
                      });

                      // Agregamos el elemento "Ver más"
                      var $verMasLi = $('<li class="nav-link"></li>');
                      var $verMasA = $('<a href="/notificaciones" class="nav-item dropdown-item">Ver más</a>');
                      $verMasLi.append($verMasA);
                      $('#navbar').append($verMasLi);
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                      console.error('Error en la solicitud AJAX');
                  }
              });
            }
        </script>
        @stack('js')


        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
