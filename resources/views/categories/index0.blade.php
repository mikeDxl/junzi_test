@extends('layouts.app', ['activePage' => 'Departamentos', 'menuParent' => 'laravel', 'titlePage' => __('Departamentos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Departamentos</h4>
              </div>
              <div class="card-body">
                @can('create', App\Category::class)
                  <div class="row">
                    <div class="col-12 text-right mb-3">
                      <a href="{{ route('category.create') }}" class="btn btn-sm btn-info">{{ __('Agregar') }}</a>
                    </div>
                  </div>
                @endcan
                <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Departamento') }}
                      </th>
                      <th>
                        {{ __('Puestos') }}
                      </th>
                      <th>
                        {{ __('Colaboradores') }}
                      </th>
                      @can('manage-items', App\User::class)
                        <th class="text-right">
                          {{ __('Opciones') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>

                        <tr>
                          <td>
                            ADMINISTRATIVO
                          </td>
                          <td>
                            6
                          </td>
                          <td>
                            25
                          </td>

                            <td class="td-actions text-right">
                              <form action= method="post">

                                  <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                              </form>
                            </td>

                        </tr>


                        <tr>
                          <td>
                            SISTEMAS
                          </td>
                          <td>
                            5
                          </td>
                          <td>
                            35
                          </td>

                            <td class="td-actions text-right">
                              <form action= method="post">

                                  <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                              </form>
                            </td>

                        </tr>


                        <tr>
                          <td>
                            RECURSOS HUMANOS
                          </td>
                          <td>
                            4
                          </td>
                          <td>
                            20
                          </td>

                            <td class="td-actions text-right">
                              <form action= method="post">

                                  <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                              </form>
                            </td>

                        </tr>

                        <tr>
                          <td>
                            FINANCIERA
                          </td>
                          <td>
                            3
                          </td>
                          <td>
                            14
                          </td>

                            <td class="td-actions text-right">
                              <form action= method="post">

                                  <a href="" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                  <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this category?") }}') ? this.parentElement.submit() : ''">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                              </form>
                            </td>

                        </tr>
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
