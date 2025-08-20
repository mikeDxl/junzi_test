@extends('layouts.app', ['activePage' => 'Errores', 'menuParent' => 'laravel', 'titlePage' => __('Junzi')])


@section('title', 'Error interno del servidor - 500')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-100 flex items-center justify-center px-4 py-5 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center mt-4">
        <div>
            <!-- Icono de error -->
            <div class="mx-auto h-32 w-32 text-red-400 mb-8">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Código de error -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>

            <!-- Mensaje principal -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Error interno del servidor
            </h2>

            <!-- Descripción -->
            <p class="text-gray-600 mb-8">
                {{ $message ?? 'Algo salió mal en nuestro servidor. Por favor, intenta de nuevo más tarde.' }}
            </p>
        </div>

        <!-- Acciones -->
        <div class="space-y-4">
            <a href="{{ route('welcome') }}"
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                Volver al inicio
            </a>

            <button onclick="window.location.reload()"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                Reintentar
            </button>
        </div>
    </div>
</div>
@endsection
