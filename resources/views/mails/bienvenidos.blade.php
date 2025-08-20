<html>
    <body>
        <div style="margin: 30px; padding:10px;">
            <div style="text-align: center;">
                <h1> <b>JUNZI</b> </h1>
                <br>
            </div>
            <div style="background: #202A44; color:#f5f5f5; border-radius:0px 0px 25px 25px; padding:20px;">
                <div style="text-align: center;">
                    <br>
                    <h2 style="color:#f5f5f5;">Cambio de posición</h2>
                    <h1 style="color:#3CDBC0; font-size:32pt;"><b>{{ $jefe }}</b></h1>
                    <br>
                </div>
                <br>
                <table>
                  <tr>
                    <td>Empresa</td>
                    <td>{{ $empresa }}</td>
                  </tr>
                  <tr>
                    <td>Departamento</td>
                    <td>{{ $departamento }}</td>
                  </tr>
                  <tr>
                    <td>Puesto</td>
                    <td>{{ $puesto }}</td>
                  </tr>
                  <tr>
                    <td>Colaborador</td>
                    <td>{{ $motivo }}</td>
                  </tr>
                </table>
                <br>
                <a href="http://127.0.0.1:8000/vacantes" style="font-weight: 700; font-size:22pt;">Ver más</a>
            </div>
        </div>
    </body>
</html>
