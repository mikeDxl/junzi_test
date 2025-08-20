<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codea</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  </head>
  <body>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    p, td, h1, h2, h3, small, i , span, a , button , tr , table , tbody, div , label { font-family: 'Roboto', sans-serif; }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <div style="margin:20px; background:#fff; padding:10px;">
      <div style="text-align:center;">
        <img src="https://codeamx.com/assets/img/logo.png" alt="Codea" style="height:60px;">
      </div>
      <div style="text-align:center;">
        <p>Se han generado las siguientes actualizaciones en el proyecto:</p>
      </div>
      <div style="text-align:center;">
        <h1 style="color:#202A44;">{{ $proyecto }}</h1>
      </div>

      <style media="screen">
        td{ color: #151515; }
      </style>
      @foreach($timeline as $t)
      <div style="border-left: 3px solid #00A3E1; margin-bottom:30px; border-radius:3px;">

        <table>
          <tbody>
            <tr>
              <td style="font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:9pt;"> <i style="text-transform: uppercase;">{{ $t->solicitud }}</i> </td>
            </tr>
            <tr>
              <td style=" font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:9pt;">Actualizado por: {{ $t->nombre }} <span style="font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:9pt; text-decoration:none!important; color:#151515!important;">{{ $t->email }} </span> </td>
            </tr>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td style="font-family: 'Roboto', sans-serif; color:#151515; font-size:12pt;"> {{ $t->titulo }} </td>
            </tr>
            <tr>
              <td style="font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:12pt;">{{ $t->descripcion }}</td>
            </tr>
            <tr>
              <td style="font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:12pt;">{{ $t->fecha }}</td>
            </tr>
            <tr>
              <td style="font-family: 'Roboto', sans-serif; text-decoration:none!important; color:#151515!important; font-size:9pt;"> <a href="{{ $t->url }}">{{ $t->url }}</a> </td>
            </tr>
          </tbody>
        </table>

      </div>
      @endforeach
      <div style="text-align:center;">
        <br><br><br><br>
        <p>Recuerda que los avances del proyecto los puedes consultar en <a href="https://proyecto.codeamx.com/">https://proyecto.codeamx.com/</a>  </p>
      </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
