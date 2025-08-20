@extends('home', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('contentJunzi')
<style>
/* Estilos adicionales para los selects */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Animaciones suaves */
.transition-all {
    transition: all 0.3s ease;
}

/* Hover effects */
button:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
}

/* Focus states mejorados */
select:focus, button:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
</style>
<!-- Versión mejorada con mejor UX -->
<div class="bg-gray-50 min-h-screen py-5">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 py-5 mt-4">
            <div class="w-full">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden ">
                    <!-- Header con gradiente -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3">
                        <h4 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear auditoría
                        </h4>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-12">
                                <div class="bg-white h-full w-full overflow-hidden border border-gray-200 rounded-lg" id="categories-table">
                                    <div class="p-6">
                                        <form action="{{ route('crear_auditoria') }}" method="post" class="space-y-6">
                                            @csrf
                                            
                                            <!-- Tipo -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    Tipo
                                                </label>
                                                <div class="relative">
                                                    <select class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" name="tipo">
                                                        <option value="Programada">📅 Programada</option>
                                                        <option value="Especial">⭐ Especial</option>
                                                        <option value="Extraordinaria">🚨 Extraordinaria</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Empresa -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                    Empresa
                                                </label>
                                                <div class="relative">
                                                    <select class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" name="area">
                                                        <option value="" disabled selected>Seleccionar</option>
                                                        @foreach($claves as $clave)
                                                            <option value="{{ $clave->clave }}">{{ $clave->nombre }} ['{{ $clave->clave }}']</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Botón -->
                                            <div class="text-center">
                                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:scale-105" name="button">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    Crear
                                                </button>
                                            </div>
                                        </form>
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

@push('scripts')
<script>
        $(document).ready(function () {
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

    document.addEventListener('DOMContentLoaded', function() {
        // Agregar efectos visuales al cambiar el tipo
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const form = document.querySelector('form');
        
        if (tipoSelect) {
            tipoSelect.addEventListener('change', function() {
                const value = this.value;
                this.classList.remove('border-green-300', 'border-yellow-300', 'border-red-300');
                
                switch(value) {
                    case 'Programada':
                        this.classList.add('border-green-300');
                        break;
                    case 'Especial':
                        this.classList.add('border-yellow-300');
                        break;
                    case 'Extraordinaria':
                        this.classList.add('border-red-300');
                        break;
                }
            });
        }
        
        // Efecto de carga en el botón
        if (form) {
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                if (button) {
                    button.disabled = true;
                    button.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creando...
                    `;
                }
            });
        }
});
</script>
@endpush