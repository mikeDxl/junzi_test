@extends('layouts.app', ['activePage' => 'Costos', 'menuParent' => 'laravel', 'titlePage' => __('Costos')])


@section('content')
    <style>

        .card-body h5 {
            margin-top: 3px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .card{ margin-bottom:0px!important; margin-top:0px!important;  padding-bottom:0px!important;  padding-top:0px!important;  }
        .card-body{ margin-bottom:0px!important; margin-top:0px!important;  padding-bottom:0px!important;  padding-top:0px!important;  }
        .card-header{ margin-bottom:0px!important; margin-top:0px!important;  padding-bottom:0px!important;  padding-top:0px!important; }
        table{ margin-bottom:0px!important; margin-top:0px!important;  padding-bottom:0px!important;  padding-top:0px!important; }
        td{ font-size:11pt!important; }
    </style>

@foreach ($centrosDeCosto as $centroDeCosto)
    <tr>
        <td>
            <!-- Mostrar el nombre del centro de costo -->
            <div class="accordion" id="accordion{{$centroDeCosto->id}}">
                <div class="card">
                    <div class="card-header" id="heading{{$centroDeCosto->id}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$centroDeCosto->id}}" aria-expanded="true" aria-controls="collapse{{$centroDeCosto->id}}">
                                <i class="fa fa-plus"></i> {{ $centroDeCosto->centro_de_costo }}
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{$centroDeCosto->id}}" class="collapse" aria-labelledby="heading{{$centroDeCosto->id}}" data-parent="#accordion{{$centroDeCosto->id}}">
                        <div class="card-body">
                            @foreach ($centroDeCosto->puestos as $puesto)
                                <div class="accordion" id="accordionPuesto{{$puesto->id}}">
                                    <div class="card">
                                        <div class="card-header" id="headingPuesto{{$puesto->id}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsePuesto{{$puesto->id}}" aria-expanded="true" aria-controls="collapsePuesto{{$puesto->id}}">
                                                    <i class="fa fa-plus"></i> {{ $puesto->catalogoPuesto->puesto }}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapsePuesto{{$puesto->id}}" class="collapse" aria-labelledby="headingPuesto{{$puesto->id}}" data-parent="#accordionPuesto{{$puesto->id}}">
                                            <div class="card-body">
                                                @foreach ($puesto->catalogoPuesto->colaboradores as $colaborador)
                                                    <tr>
                                                        <td>{{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }}</td>
                                                        <!-- Puedes agregar más columnas aquí según los detalles del colaborador -->
                                                    </tr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach

@endsection

@push('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Alternar el ícono cuando se expande o colapsa
  $(document).ready(function() {
    // Cambiar íconos cuando se muestra el collapse
    $('.collapse').on('show.bs.collapse', function () {
      // Selecciona el botón hermano y cambia el ícono a 'fa-minus'
      $(this).siblings('.card-header').find('button').find('i').removeClass('fa-plus').addClass('fa-minus');
    })
    // Cambiar íconos cuando se oculta el collapse
    .on('hide.bs.collapse', function () {
      // Selecciona el botón hermano y cambia el ícono a 'fa-plus'
      $(this).siblings('.card-header').find('button').find('i').removeClass('fa-minus').addClass('fa-plus');
    });
  });
</script>


<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var salarioMensualTotal = 0;
        var salarioAnualTotal = 0;

        // Recorremos cada centro de costo
        @foreach ($centrosDeCosto as $centroDeCosto)
          @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

            // Inicializamos las variables de totales dentro del ciclo
            salarioMensualTotal = 0;
            salarioAnualTotal = 0;

            // Recorremos los colaboradores y sumamos los salarios
            @foreach ($colaboradores as $colaborador)
              var salarioMensual = parseFloat($('.salario_menual_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text().replace(',', ''));
              var salarioAnual = parseFloat($('.salario_diario_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text().replace(',', ''));

              if (!isNaN(salarioMensual)) {
                salarioMensualTotal += salarioMensual;  // Sumar salario mensual
              }
              if (!isNaN(salarioAnual)) {
                salarioAnualTotal += salarioAnual;  // Sumar salario anual
              }
            @endforeach

            // Formatear los valores en formato moneda
            var salarioMensualFormateado = '$' + salarioMensualTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            var salarioAnualFormateado = '$' + salarioAnualTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Actualizamos los th con los valores calculados en formato moneda
            $('#salario_mensual_{{$puesto}}_{{$centroDeCosto->id}}').fadeIn().text(salarioMensualFormateado);
            $('#salario_anual_{{$puesto}}_{{$centroDeCosto->id}}').fadeIn().text(salarioAnualFormateado);

          @endforeach
        @endforeach

    }, 1000); // Tiempo de espera para asegurar que el DOM esté listo
  });
</script>


<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var edadTotal = 0;
        var cantidadColaboradores = 0;
      
        // Recorremos cada centro de costo
        @foreach ($centrosDeCosto as $centroDeCosto)
          @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

            // Inicializamos la variable para la suma de edades
            edadTotal = 0;
            cantidadColaboradores = 0;

            // Recorremos los colaboradores y sumamos sus edades
            @foreach ($colaboradores as $colaborador)
              // Tomamos la edad directamente desde el td usando la clase única
              var edad = parseInt($('.edad_{{$puesto}}_{{$centroDeCosto->id}}').eq(cantidadColaboradores).text());
              if (!isNaN(edad)) {
                edadTotal += edad;  // Sumar la edad
                cantidadColaboradores++;  // Contar los colaboradores
              }
            @endforeach

            // Calculamos el promedio de edad
            var promedioEdad = (cantidadColaboradores > 0) ? edadTotal / cantidadColaboradores : 0;

            // Actualizamos el th con el promedio de edad calculado
            $('#promedio_edad_{{$puesto}}_{{$centroDeCosto->id}}').fadeIn().text(promedioEdad.toFixed(2));

          @endforeach
        @endforeach

    }, 1000); // Tiempo de espera para asegurar que el DOM esté listo

  });
</script>


<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var antiguedadTotal = 0;
        var cantidadColaboradores = 0;
      
      // Recorremos cada centro de costo
      @foreach ($centrosDeCosto as $centroDeCosto)
        @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

          // Inicializamos la variable de antigüedad total dentro del ciclo
          antiguedadTotal = 0;
          cantidadColaboradores = 0;

          // Recorremos los colaboradores y sumamos la antigüedad
          @foreach ($colaboradores as $colaborador)
            // Usamos el selector único con puesto y centroDeCosto->id
            var antiguedad = parseInt($('.antiguedad_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text()); // Tomamos la antigüedad desde el td
            if (!isNaN(antiguedad)) {
              antiguedadTotal += antiguedad;  // Sumamos antigüedad
              cantidadColaboradores++; // Aumentamos el contador de colaboradores
            }
          @endforeach

          // Calculamos el promedio de antigüedad
          var promedioAntiguedad = cantidadColaboradores > 0 ? antiguedadTotal / cantidadColaboradores : 0;

          // Actualizamos el th con el promedio de antigüedad y mostramos el total
          $('#promedio_antiguedad_{{$puesto}}_{{$centroDeCosto->id}}').fadeIn().text(promedioAntiguedad.toFixed(2));

        @endforeach
      @endforeach

    }, 1000); // Tiempo de espera para asegurar que el DOM esté listo
  });
</script>




<!-- Calculando los centros de costo -->

<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var salarioMensualTotal = 0;
        var salarioAnualTotal = 0;

        // Recorremos cada centro de costo
        @foreach ($centrosDeCosto as $centroDeCosto)
            // Inicializamos las variables de totales para cada centro de costo
            salarioMensualTotal = 0;
            salarioAnualTotal = 0;

            // Recorremos los colaboradores por puesto
            @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

                // Recorremos los colaboradores y sumamos los salarios
                @foreach ($colaboradores as $colaborador)
                    var salarioMensual = parseFloat($('.salario_menual_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text().replace(',', ''));
                    var salarioAnual = parseFloat($('.salario_diario_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text().replace(',', ''));
                    
                    if (!isNaN(salarioMensual)) {
                      salarioMensualTotal += salarioMensual;  // Sumar salario mensual
                    }
                    if (!isNaN(salarioAnual)) {
                      salarioAnualTotal += salarioAnual;  // Sumar salario anual
                    }
                @endforeach

            @endforeach

            // Formatear los valores en formato moneda
            var salarioMensualFormateado = '$' + salarioMensualTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            var salarioAnualFormateado = '$' + salarioAnualTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Actualizamos los th con los valores calculados en formato moneda
            $('#salario_mensual_{{$centroDeCosto->id}}').fadeIn().text(salarioMensualFormateado);
            $('#salario_anual_{{$centroDeCosto->id}}').fadeIn().text(salarioAnualFormateado);

        @endforeach

    }, 1500); // Tiempo de espera para asegurar que el DOM esté listo
  });
</script>
<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var edadTotal = 0;
        var cantidadColaboradores = 0;

        // Recorremos cada centro de costo
        @foreach ($centrosDeCosto as $centroDeCosto)
            // Inicializamos las variables para la suma de edades y el conteo de colaboradores
            edadTotal = 0;
            cantidadColaboradores = 0;

            // Recorremos los colaboradores por puesto
            @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

                // Recorremos los colaboradores y sumamos sus edades
                @foreach ($colaboradores as $colaborador)
                    var edad = parseInt($('.edad_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text());
                    
                    if (!isNaN(edad)) {
                      edadTotal += edad;  // Sumar la edad
                      cantidadColaboradores++;  // Contar el número de colaboradores
                    }
                @endforeach

            @endforeach

            // Calculamos el promedio de edad, si hay colaboradores
            var promedioEdad = (cantidadColaboradores > 0) ? edadTotal / cantidadColaboradores : 0;

            // Actualizamos el th con el promedio de edad calculado
            $('#promedio_edad_{{$centroDeCosto->id}}').fadeIn().text(promedioEdad.toFixed(2));

        @endforeach

    }, 1500); // Tiempo de espera para asegurar que el DOM esté listo
  });
</script>

<script>
  $(document).ready(function() {
    // Esperamos a que el DOM esté completamente cargado
    setTimeout(function() {

        var antiguedadTotal = 0;
        var cantidadColaboradores = 0;

        // Recorremos cada centro de costo
        @foreach ($centrosDeCosto as $centroDeCosto)
            // Inicializamos las variables para la suma de antigüedades y el conteo de colaboradores
            antiguedadTotal = 0;
            cantidadColaboradores = 0;

            // Recorremos los colaboradores por puesto
            @foreach ($centroDeCosto->colaboradoresPorPuesto as $puesto => $colaboradores)

                // Recorremos los colaboradores y sumamos sus antigüedades
                @foreach ($colaboradores as $colaborador)
                    var antiguedad = parseFloat($('.antiguedad_{{$puesto}}_{{$centroDeCosto->id}}').eq({{ $loop->index }}).text());
                    
                    if (!isNaN(antiguedad)) {
                      antiguedadTotal += antiguedad;  // Sumar la antigüedad
                      cantidadColaboradores++;  // Contar el número de colaboradores
                    }
                @endforeach

            @endforeach

            // Calculamos el promedio de antigüedad, si hay colaboradores
            var promedioAntiguedad = (cantidadColaboradores > 0) ? antiguedadTotal / cantidadColaboradores : 0;

            // Actualizamos el th con el promedio de antigüedad calculado
            $('#promedio_antiguedad_{{$centroDeCosto->id}}').fadeIn().text(promedioAntiguedad.toFixed(2));

        @endforeach

    }, 1500); // Tiempo de espera para asegurar que el DOM esté listo
  });
</script>

@endpush