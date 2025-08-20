@extends('layouts.app', ['activePage' => 'HorasExtra', 'menuParent' => 'laravel', 'titlePage' => __('HorasExtra')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Capturar Horas Extra</h4>
              </div>
              <form class="" action="{{ route('guardar_horas_extras') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-12 table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Colaborador</th>
                          <th>Fecha</th>
                          <th>Horas</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($colaboradores as $col)
                        <tr>
                          <td> {{ qcolab($col->id) }} <input type="hidden" class="form-control" name="colaborador_id[]" value="{{ $col->id }}"> </td>
                          <td> <input type="date" min="{{ $fechaDosDiasHabilesAtras }}" max="{{ date('Y-m-d') }}" class="form-control" name="fecha[]" value=""> </td>
                          <td> <input type="number" step="0.1" class="form-control" name="horas[]" value=""> </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12 text-center">
                    <br>
                    <div class="form-group">
                      <label for="">Comentarios</label>
                      <textarea name="comentarios" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 text-center">
                    <br> <button type="submit" class="btn btn-info" name="button">Capturar</button>
                  </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
@endpush
