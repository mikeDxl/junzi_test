@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb">

          <a href="{{ url()->previous() }}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> Ver organigrama lineal</a>
          </div>
          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td>
                          @if($departamentomatricial=='operacion')
                          <h1 style="text-transform:uppercase;">DIRECCIÓN OPERATIVA</h1>
                          @elseif($departamentomatricial=='dirección administrativa')
                          <h1 style="text-transform:uppercase;">DIRECCION ADMINISTRATIVA</h1>
                          @else
                          <h1 style="text-transform:uppercase;">{{ $departamentomatricial }}</h1>
                          @endif
                        </td>
                        <td></td>
                        <td>{{ total_salario($departamentomatricial) }}</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($resultados as $puesto => $company_id)
                      <tr>
                        <td> <b>{{ puesto($puesto , $company_id)  }}</b> </td>
                        <td></td>
                        <td> <b>{{ total_salario_puesto($departamentomatricial, $puesto) }}</b> </td>
                       </tr>
                        @foreach($colaboradores as $colab)
                           @if($colab->puesto==$puesto)
                           <tr>
                             <td style="padding-left:20px; font-size:10pt;">{{ qcolabv($colab->id) }}  </td>
                             <td> {{ depas($colab->departamento_id) }} </td>
                             <td> $<small>{{ number_format($colab->salario_diario*30,2) }}</small>  </td>
                           </tr>
                           @endif
                         @endforeach
                      @endforeach


                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>



@endsection

@push('js')
@endpush
