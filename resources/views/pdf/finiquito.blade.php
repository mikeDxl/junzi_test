<!DOCTYPE html>
<html>
<head>
    <title>Formato Baja</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }

        td , th , p { font-size: 8pt;}
    </style>
<body>
  <table>
      <tr>
        <th>Nombre: {{ qcolabv($datosbaja->colaborador_id) }}</th>
        <th>Puesto: {{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}</th>
        <th>Salario diario: $
            @if($datosbaja->salario_radio=='sd')
            {{ number_format($datosbaja->salario_diario,2) }}
            @elseif($datosbaja->salario_radio=='sdi')
            {{ number_format($datosbaja->salario_diario_integral,2) }}
            @elseif($datosbaja->salario_radio=='sdn')
            {{ number_format($datosbaja->salario_nuevo,2) }}
            @else
            {{ number_format($datosbaja->salario_diario,2) }}
            @endif
        </th>
      </tr>
      <tr>
        <th>Departamento:  {{ buscarDeptoCat($datosbaja->colaborador_id) }}</th>
        <th>RFC: {{ $colaborador->rfc }}</th>
        <th>Nº de afiliación IMSS: {{ $colaborador->nss }}</th>
      </tr>
      <tr>
        <th>Fecha de ingreso: {{ str_replace(' 00:00:00','',$colaborador->fecha_alta) ?? '' }}</th>
        <th>Fecha de baja: {{ $datosbaja->fecha_baja ?? '' }}</th>
        <th>Fecha de elaboración: {{ $datosbaja->fecha_elaboracion ?? '' }}</th>
      </tr>
  </table>
    <table style="margin-top:30px;">
      <thead>
        <tr>
          <th colspan="4">Percepciones</th>
          <th colspan="2">Deducciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Salario normal</td>
          <td colspan="2">{{ $datosbaja->d_salario_normal }}</td>
          <td>${{ number_format($datosbaja->salario_normal,2) }}</td>
          <td>ISR</td>
          <td>${{ number_format($datosbaja->isr,2) }}</td>
        </tr>
        <tr>
          <td>Aguinaldo</td>
          <td>{{ $datosbaja->d_aguinaldo }}</td>
          <td>{{ number_format($datosbaja->d2_aguinaldo,2) }}</td>
          <td>${{ number_format($datosbaja->aguinaldo,2) }}</td>
          <td>IMSS</td>
          <td>${{ number_format($datosbaja->imss,2) }}</td>
        </tr>
        <tr>
          <td>Vacaciones</td>
          <td colspan="2">{{ number_format($datosbaja->d_vacaciones,2) }}</td>
          <td>${{ number_format($datosbaja->vacaciones,2) }}</td>
          <td>Deudores</td>
          <td>${{ number_format($datosbaja->deudores,2) }}</td>
        </tr>
        <tr>
          <td>Vacaciones pendientes</td>
          <td colspan="2">0</td>
          <td>$0.00</td>
          <td>Isr Finiquito</td>
          <td>${{ number_format($datosbaja->isr_finiquito,2) }}</td>
        </tr>
        <tr>
          <td>Prima vacacional</td>
          <td colspan="2">{{ $datosbaja->d_primavacacional }}%</td>
          <td>${{ $datosbaja->prima_vacacional }}</td>
          <td colspan="2" rowspan="6"></td>
        </tr>
        <tr>
          <td>Incentivo</td>
          <td colspan="2">{{ $datosbaja->d_incentivo }}%</td>
          <td>${{ $datosbaja->incentivo }}</td>
        </tr>
        <tr>
          <td>Prima de antiguedad</td>
          <td colspan="2">{{ $datosbaja->d_prima_de_antiguedad }}%</td>
          <td>${{ $datosbaja->prima_de_antiguedad }}</td>
        </tr>
        <tr>
          <td>Gratificación</td>
          <td colspan="2">{{ $datosbaja->d_gratificacion }}</td>
          <td>${{ $datosbaja->gratificacion }}</td>
        </tr>
        <tr>
          <td>20 días por año</td>
          <td colspan="2">{{ $datosbaja->d_veinte_dias }}</td>
          <td>${{ $datosbaja->veinte_dias }}</td>
        </tr>
        <tr>
          <td>Despensa</td>
          <td colspan="2">{{ $datosbaja->d_despensa }}</td>
          <td>${{ $datosbaja->despensa }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
            <th>Total percepciones</th>
            <th colspan="2"></th>
            <th>${{ number_format((float)preg_replace('/[^\d.]/', '', $datosbaja->percepciones), 2) }}</th>
            <th>Total deducciones</th>
            <th>${{ number_format((float)preg_replace('/[^\d.]/', '', $datosbaja->deducciones), 2) }}</th>
        </tr>
        <tr>
            <th>Total</th>
            <th colspan="2"></th>
            <th>${{ number_format((float)preg_replace('/[^\d.]/', '', $datosbaja->total), 2) }}</th>
            <th colspan="2"></th>
        </tr>
    </tfoot>

    </table>
    <br>
    <p>Correspondientes al pago de finiquito. Con la cantidad que recibo, quedan totalmente saldadas y finiquitadas todas las prestaciones a que tuve derecho, derivadas de mi contrato de trabajo dejando constancia en lo que a derecho proceda, que siempre recibí puntualmente los salarios ordinarios y extraordinarios a los que tuve derecho como las prestaciones antes citadas. </p>
    <p>Todo lo anterior se cubrio puntualmente y en la forma establecida por la ley tambien manifiesto que durante este tiempo no sufri riesgo ni enfermedad profesional en la prestacion de mis servicios a la empresa.</p>
    <p>En consecuencia, nada tengo que reclamar a {{ empresars($colaborador->company_id) }} por lo que queda totalmente saldada cualquier cantidad que se me adeudara, por lo tanto, la presente ampara el mas amplio finiquito.</p>
    <br>
    <div style="text-align: center;">
    <p>Atentamente</p>
    <br>
    <br>
    <hr style="width: 50%;">
    <p>{{ qcolabv($datosbaja->colaborador_id) }}</p>
    <br>
    <br>
    <p>Ratifico el contenido y firma del presente escrito</p>
    <br>
    <br>
    <hr style="width: 50%;">
    <p>{{ qcolabv($datosbaja->colaborador_id) }}</p>
    </div>
</body>
</html>
