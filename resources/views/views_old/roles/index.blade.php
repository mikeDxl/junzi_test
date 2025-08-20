@extends('layouts.app', ['activePage' => 'role-management', 'menuParent' => 'laravel', 'titlePage' => __('Role Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __('Roles') }}</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive m-0 h-100 w-100 overflow-hidden" id="roles-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Description') }}
                      </th>
                      <th>
                        {{ __('Creation date') }}
                      </th>
                      @can('manage-users', App\User::class)
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>
                      @foreach($roles as $role)
                        <tr>
                          <td>
                            {{ $role->name }}
                          </td>
                          <td>
                            {{ $role->description }}
                          </td>
                          <td>
                            {{ $role->created_at->format('Y-m-d') }}
                          </td>
                          @can('manage-users', App\User::class)
                            <td class="td-actions text-right">
                              @can('update', $role)
                                <a href="{{ route('role.edit', $role) }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                              @endcan
                            </td>
                          @endcan
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
        searchPlaceholder: "Search roles",
      },
      "columnDefs": [
        { "orderable": false, "targets": 4 },
      ],
    });
  });
</script>
@endpush
