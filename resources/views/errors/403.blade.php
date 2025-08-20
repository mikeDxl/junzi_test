@extends('layouts.app', ['activePage' => 'Errores', 'menuParent' => 'laravel', 'titlePage' => __('Junzi')])

@section('title', 'Acceso denegado - 403')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-orange-100 flex items-center justify-center px-4 py-5 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center mt-4">
        <div>
            <!-- Icono de error -->
            <div class="mx-auto h-32 w-32 text-yellow-400 mb-8">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Código de error -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">403</h1>

            <!-- Mensaje principal -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Acceso denegado
            </h2>

            <!-- Descripción -->
            <p class="text-gray-600 mb-8">
                {{ $message ?? 'No tienes permisos para acceder a esta página.' }}
            </p>
        </div>

        <!-- Acciones -->
        <div class="space-y-4">
            <a href="{{ route('welcome') }}"
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                Volver al inicio
            </a>

            @guest
                <a href="{{ route('login') }}"
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                    Iniciar sesión
                </a>
            @endguest
        </div>
    </div>
</div>
@endsection
