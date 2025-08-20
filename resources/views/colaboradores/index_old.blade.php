@extends('layouts.app', ['activePage' => 'Colaboradores', 'menuParent' => 'laravel', 'titlePage' => __('Colaboradores')])

@section('content')

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Colaboradores</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-4" >
                    <button style="display:none;" class="btn btn-info btn-block" onclick="demo.showNotification('top','right','morrison')">Bottom Left</button>

                  </div>
                  <div class="col-4 text-right mb-3">
                    <a href="/alta_externos" class="btn btn-sm btn-default">{{ __('Alta externos') }}</a>
                  </div>
                  <div class="col-4 text-right mb-3">
                    <a href="/alta_colaboradores" class="btn btn-sm btn-default">{{ __('Agregar colaborador') }}</a>
                  </div>
                </div>

                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Nombre') }}
                      </th>
                      <th>
                        {{ __('Apellido Paterno') }}
                      </th>
                      <th>
                        {{ __('Apellido Materno') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($colaboradores as $col)
                      <tr>
                        <td>
                          {{ $col->nombre }}
                        </td>
                        <td>
                          {{ $col->apellido_paterno }}
                        </td>
                        <td>
                          {{ $col->apellido_materno }}
                        </td>

                          <td class="td-actions text-right">
                            <form action= method="post">

                                <a href="/vista-colaborador/{{$col->id}}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                <button style="display:none;" type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''">
                                  <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                          </td>

                      </tr>
                      @endforeach


                    </tbody>
                  </table>
                  {{ $colaboradores->links('pagination') }}
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
