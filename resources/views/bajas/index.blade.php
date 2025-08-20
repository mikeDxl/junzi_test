@extends('layouts.app', ['activePage' => 'Bajas', 'menuParent' => 'laravel', 'titlePage' => __('Bajas')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          {{-- Verificar si hay un mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Verificar si hay un mensaje de error --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

        </div>
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Bajas</h4>
              </div>
              <div class="card-body">
                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Colaborador') }}
                      </th>
                      <th>
                        {{ __('Centro de costos') }}
                      </th>
                      <th>
                        {{ __('Motivo') }}
                      </th>
                      <th>
                        {{ __('Monto') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                        @foreach($bajas as $baj)
                        <tr>
                          <td>
                            {{ qcolab($baj->colaborador_id) }}
                          </td>
                          <td>
                            {{ $baj->area }}
                          </td>
                          <td>
                              {{ $baj->motivo }}
                          </td>
                          <td>
                            @if($baj->monto=="")
                            Pendiente
                            @else
                            ${{ number_format($baj->monto,2) }}
                            @endif
                          </td>

                            <td class="td-actions text-right">
                              <a href="/baja/{{ $baj->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                            </td>

                        </tr>
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
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Buscar",
        },
        "columnDefs": [
          { "orderable": false, "targets": 4 },
        ],
      });
    });
  </script>
@endpush
