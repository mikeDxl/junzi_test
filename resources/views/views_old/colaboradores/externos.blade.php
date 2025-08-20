@extends('layouts.app', ['activePage' => 'Externos', 'menuParent' => 'forms', 'titlePage' => __('Externos')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Colaboradres externos</h4>
            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-4 mb-3">
                  <a href="/colaboradores" class="btn btn-sm btn-link"> <i class="fa fa-chevron-left"></i> {{ __('Colaboradores') }}</a>
                </div>
                <div class="col-4" >


                </div>

                <div class="col-4 text-right mb-3">
                  <a href="/colaboradores/crear_externos" class="btn btn-sm btn-default">{{ __('Agregar') }}</a>
                </div>
              </div>



              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                    <div class="card-body">
                      <div class="table-responsivem-0 h-100 w-100 overflow-hidden" id="categories-table">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-primary" >
                          <thead class="text-primary">
                            <th>
                                {{ __('Centro de costos') }}
                            </th>
                            <th>
                              {{ __('Empresa') }}
                            </th>
                            <th>
                              {{ __('Presupuesto') }}
                            </th>
                            <th>
                              {{ __('Cantidad') }}
                            </th>
                            @can('manage-items', App\User::class)
                              <th class="text-right">
                                {{ __('Opciones') }}
                              </th>
                            @endcan
                          </thead>
                          <tbody>

                            @foreach($externos as $ext)
                            <tr>
                              <td>
                                {{ nombrecc($ext->area) }}
                              </td>
                              <td>
                                {{ $ext->empresa }}
                              </td>
                              <td>
                                {{ $ext->presupuesto }}
                              </td>
                              <td>{{ $ext->cantidad }}</td>


                                <td class="td-actions text-right">
                                  <form action= method="post">

                                    



                                  </form>
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
      </div>
    </div>
  </div>
</div>
@endsection
