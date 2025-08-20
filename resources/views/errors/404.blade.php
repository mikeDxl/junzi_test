@extends('layouts.app', ['activePage' => 'Errores', 'menuParent' => 'laravel', 'titlePage' => __('Junzi')])

@section('title', 'Página no encontrada - 404')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4 py-5 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center mt-4">
        <div>
            <!-- Icono de error -->
            <div class="mx-auto h-32 w-32 text-indigo-400 mb-8">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33l-.147-.15A7.97 7.97 0 013.239 9M12 3C7.02 3 3 7.02 3 12s4.02 9 9 9 9-4.02 9-9-4.02-9-9-9z"></path>
                </svg>
            </div>

            <!-- Código de error -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>

            <!-- Mensaje principal -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                ¡Oops! Página no encontrada
            </h2>

            <!-- Descripción -->
            <p class="text-gray-600 mb-8">
                {{ $message ?? 'La página que buscas no existe o ha sido movida.' }}
            </p>

            @if(isset($requested_url))
                <div class="bg-gray-100 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">URL solicitada:</span><br>
                        <code class="text-red-600 break-all">{{ $requested_url }}</code>
                    </p>
                </div>
            @endif
        </div>

        <!-- Acciones -->
        <div class="space-y-4">
            <!-- Botón principal -->
            <a href="{{ route('welcome') }}"
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Volver al inicio
            </a>

            <!-- Botón secundario -->
            <!-- <button onclick="history.back()"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                </svg>
                Página anterior
            </button> -->
        </div>

        <!-- Enlaces útiles -->
        {{-- <div class="border-t border-gray-200 pt-6">
            <p class="text-sm text-gray-500 mb-4">¿Necesitas ayuda? Prueba estos enlaces:</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <a href="{{ route('welcome') }}" class="text-indigo-600 hover:text-indigo-500">Inicio</a>
                @if(Route::has('contact'))
                    <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-500">Contacto</a>
                @endif
                @if(Route::has('help'))
                    <a href="{{ route('help') }}" class="text-indigo-600 hover:text-indigo-500">Ayuda</a>
                @endif
            </div>
        </div> --}}
    </div>
</div>

@push('scripts')
<script>
    // Auto-redirect después de 30 segundos (opcional)
    setTimeout(function() {
        if (confirm('¿Deseas regresar al inicio automáticamente?')) {
            window.location.href = '{{ route("welcome") }}';
        }
    }, 30000);
</script>
@endpush
@endsection
