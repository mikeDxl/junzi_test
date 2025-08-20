<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Junzi</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    {{-- <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" /> --}}
     <link href="{{ asset('css') }}/white-dashboard.css?v=1.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('white') }}/demo/demo.css" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/bootstrap-tourist.css" rel="stylesheet" />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.9/index.global.min.js "></script>
    <script src='fullcalendar/lang/es.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <script>

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var eventos = @json($eventos); // Convierte el array PHP en un objeto JavaScript

    var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: eventos, // Utiliza el arreglo de eventos aquí
    locale: 'es', // Establece el idioma en español
    headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridDay,timeGridWeek' // Puedes agregar más vistas si lo deseas
    },
      dayMaxEventRows: 3, // Límite de filas de eventos por día
      dayMaxEvents: true, // Habilita el límite de eventos por día
      eventLimitText: 'más', // Puedes ajustar esto para mostrar un popover u otras opciones
  });

    calendar.render();

    // Configura un manejador de eventos para cambiar a la vista de lista



});



    </script>


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
<body>


    <div id="app">
      @include('layouts.navbars.navs.auth')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

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
          var $a = $('<a href="' + notificacion.url + '" class="nav-item dropdown-item">' + notificacion.texto + '</a>');
          $li.append($a);
          $('#navbar').append($li);
      });
  },
  error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud AJAX');
  }
});
}
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
