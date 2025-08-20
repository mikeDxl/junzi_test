<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style media="screen">
      td , th{  font-size: 10pt!important;}
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 table-responsive">
              <table id="miTabla" class="table table-stripped table-responsive">
                  <thead>
                      <tr>
                          <th>nombre</th>
                          <th>apellido_paterno</th>
                          <th>apellido_materno</th>
                          <th>empresa</th> <!-- Cambiado a "empresa" en lugar de "razón social" -->
                          <th>centro de costos</th>
                          <th>departamento</th>
                          <th>puesto</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($colaboradores as $colab)
                      <tr>
                          <td>{{ $colab->nombre }}</td>
                          <td>{{ $colab->apellido_paterno }}</td>
                          <td>{{ $colab->apellido_materno }}</td>
                          <td>{{ $colab->company->nombre }}</td> <!-- Mostrar el nombre de la empresa -->
                          <td>{{ $colab->organigrama }}</td>
                          <td>({{ $colab->departamento_id }}){{ $colab->catalogoDepartamentos->first()->departamento }}</td>
                          <td>({{ $colab->puesto }}){{ $colab->catalogoPuestos->first()->puesto }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                "paging": false,
                "searching": true,
                "search": {
                    "smart": false,
                    "regex": true
                }
            });
        });
    </script>
</body>
</html>
