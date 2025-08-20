@extends('home', ['activePage' => 'Notificationes', 'menuParent' => 'laravel', 'titlePage' => __('Notificationes')])

@section('contentJunzi')
<div class="bg-gray-50 min-h-screen py-8 mt-5">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-4">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <!-- Header -->
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h4 class="text-xl font-semibold text-white">Notificaciones</h4>
      </div>
      
      <!-- Body -->
      <div class="p-6">
        <!-- Search Bar -->
        <div class="mb-6">
          <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Buscar notificaciones..." 
                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
          </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
          <div class="overflow-x-auto">
            <table id="notificationsTable" class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex items-center space-x-1">
                      <span>{{ __('Titulo') }}</span>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                      </svg>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex items-center space-x-1">
                      <span>{{ __('Fecha') }}</span>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                      </svg>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex items-center space-x-1">
                      <span>{{ __('Estatus') }}</span>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                      </svg>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Acción') }}
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200" id="notificationsBody">
                @foreach($notificaciones as $notificacion)
                <?php
                $abierto = $notificacion->abierto;
                $estatus = 'No leido';
                if ($abierto == 0 || $abierto == 1) { $estatus = 'No leido'; }
                if ($abierto == 2) { $estatus = 'Leido'; }
                ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $estatus == 'No leido' ? 'bg-blue-50' : '' }}">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      @if($estatus == 'No leido')
                        <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                      @else
                        <div class="flex-shrink-0 w-2 h-2 bg-gray-300 rounded-full mr-3"></div>
                      @endif
                      <div class="text-sm font-medium text-gray-900">
                        {{ $notificacion->texto }}
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                      <span class="text-sm text-gray-500">{{ $notificacion->fecha }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($estatus == 'No leido')
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3"/>
                        </svg>
                        No leído
                      </span>
                    @else
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Leído
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <a href="{{ $notificacion->ruta }}" 
                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                      </svg>
                      Ir
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
          <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Mostrar</span>
            <select id="entriesSelect" class="mx-1 block w-20 pl-3 pr-8 py-1 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="-1">Todos</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">entradas</span>
          </div>
          
          <div class="flex items-center space-x-2">
            <button id="prevBtn" class="px-3 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
              Anterior
            </button>
            <div id="pagination" class="flex space-x-1"></div>
            <button id="nextBtn" class="px-3 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
              Siguiente
            </button>
          </div>
        </div>

        <!-- Results Info -->
        <div class="mt-4 text-sm text-gray-500" id="resultsInfo">
          Mostrando <span id="startEntry">1</span> a <span id="endEntry">10</span> de <span id="totalEntries">0</span> resultados
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  let currentPage = 1;
  let entriesPerPage = 10;
  let filteredData = [];
  let allData = [];

  // Initialize data
  function initializeData() {
    allData = [];
    $('#notificationsBody tr').each(function() {
      const row = $(this);
      allData.push({
        element: row,
        title: row.find('td:eq(0) .text-sm').text().toLowerCase(),
        date: row.find('td:eq(1) span').text(),
        status: row.find('td:eq(2) span').text(),
        html: row[0].outerHTML
      });
    });
    filteredData = [...allData];
    updateTable();
  }

  // Search functionality
  $('#searchInput').on('keyup', function() {
    const searchTerm = $(this).val().toLowerCase();
    
    if (searchTerm === '') {
      filteredData = [...allData];
    } else {
      filteredData = allData.filter(item => 
        item.title.includes(searchTerm) || 
        item.date.toLowerCase().includes(searchTerm) ||
        item.status.toLowerCase().includes(searchTerm)
      );
    }
    
    currentPage = 1;
    updateTable();
  });

  // Entries per page change
  $('#entriesSelect').on('change', function() {
    entriesPerPage = parseInt($(this).val());
    currentPage = 1;
    updateTable();
  });

  // Update table display
  function updateTable() {
    const startIndex = (currentPage - 1) * entriesPerPage;
    const endIndex = entriesPerPage === -1 ? filteredData.length : startIndex + entriesPerPage;
    const pageData = entriesPerPage === -1 ? filteredData : filteredData.slice(startIndex, endIndex);

    // Clear and populate table
    $('#notificationsBody').empty();
    pageData.forEach(item => {
      $('#notificationsBody').append(item.html);
    });

    // Update pagination
    updatePagination();
    updateResultsInfo();
  }

  // Update pagination controls
  function updatePagination() {
    if (entriesPerPage === -1) {
      $('#pagination, #prevBtn, #nextBtn').hide();
      return;
    }

    $('#pagination, #prevBtn, #nextBtn').show();
    
    const totalPages = Math.ceil(filteredData.length / entriesPerPage);
    const pagination = $('#pagination');
    pagination.empty();

    // Previous button state
    $('#prevBtn').prop('disabled', currentPage === 1);
    $('#nextBtn').prop('disabled', currentPage === totalPages || totalPages === 0);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
        const isActive = i === currentPage;
        const pageBtn = $(`
          <button class="px-3 py-1 text-sm font-medium border rounded-md transition-colors duration-200 ${
            isActive 
              ? 'bg-blue-600 text-white border-blue-600' 
              : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-50'
          }" data-page="${i}">
            ${i}
          </button>
        `);
        pagination.append(pageBtn);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagination.append('<span class="px-2 py-1 text-gray-500">...</span>');
      }
    }
  }

  // Update results info
  function updateResultsInfo() {
    const startEntry = entriesPerPage === -1 ? 1 : (currentPage - 1) * entriesPerPage + 1;
    const endEntry = entriesPerPage === -1 ? filteredData.length : Math.min(currentPage * entriesPerPage, filteredData.length);
    
    $('#startEntry').text(filteredData.length === 0 ? 0 : startEntry);
    $('#endEntry').text(endEntry);
    $('#totalEntries').text(filteredData.length);
  }

  // Pagination click handlers
  $(document).on('click', '#pagination button', function() {
    currentPage = parseInt($(this).data('page'));
    updateTable();
  });

  $('#prevBtn').on('click', function() {
    if (currentPage > 1) {
      currentPage--;
      updateTable();
    }
  });

  $('#nextBtn').on('click', function() {
    const totalPages = Math.ceil(filteredData.length / entriesPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      updateTable();
    }
  });

  // Table header sorting
  $('th').on('click', function() {
    const columnIndex = $(this).index();
    if (columnIndex === 3) return; // Skip action column
    
    const isAscending = !$(this).hasClass('sort-asc');
    
    // Remove all sort classes
    $('th').removeClass('sort-asc sort-desc');
    
    // Add appropriate class
    $(this).addClass(isAscending ? 'sort-asc' : 'sort-desc');
    
    // Sort data
    filteredData.sort((a, b) => {
      let aVal, bVal;
      
      switch(columnIndex) {
        case 0: // Title
          aVal = a.title;
          bVal = b.title;
          break;
        case 1: // Date
          aVal = new Date(a.date);
          bVal = new Date(b.date);
          break;
        case 2: // Status
          aVal = a.status;
          bVal = b.status;
          break;
      }
      
      if (aVal < bVal) return isAscending ? -1 : 1;
      if (aVal > bVal) return isAscending ? 1 : -1;
      return 0;
    });
    
    currentPage = 1;
    updateTable();
  });

  // Initialize
  initializeData();
});
</script>

<style>
.sort-asc svg {
  transform: rotate(0deg);
  color: #3B82F6;
}

.sort-desc svg {
  transform: rotate(180deg);
  color: #3B82F6;
}

th svg {
  transition: all 0.2s ease;
}
</style>
@endpush