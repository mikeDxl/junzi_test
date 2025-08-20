@extends('layouts.app', [
  'class' => 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100',
  'classPage' => 'login-page',
  'activePage' => 'login',
  'title' => __(''),
])

<div class="min-h-screen flex items-center justify-center px-4 py-12">
  <div class="w-full max-w-md">
    <form class="space-y-6" id="login-form" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="relative">
          @if (request()->getHost() === 'junzi.mx')
            <div class="relative w-full h-40">
              <img src="{{ asset('white/img/card-info.png') }}" alt="Junzi" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <h1 class="text-3xl font-bold text-white capitalize drop-shadow-lg">{{ __('Junzi') }}</h1>
              </div>
            </div>
          @else
            <div class="relative w-full h-40">
              <img src="{{ asset('white/img/card-success.png') }}" alt="Junzi Pruebas" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <h1 class="text-3xl font-bold text-white capitalize drop-shadow-lg">{{ __('Junzi Pruebas') }}</h1>
              </div>
            </div>
          @endif
        </div>

        {{-- Body --}}
        <div class="px-6 py-6 space-y-4">
          {{-- Email Field --}}
          <div class="space-y-2">
            <div class="relative {{ $errors->has('email') ? 'text-red-600' : '' }}">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <input 
                type="email" 
                class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('email') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }} rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-0 sm:text-sm transition-colors duration-200" 
                id="exampleEmails" 
                name="email" 
                placeholder="{{ __('Email...') }}" 
                value="{{ old('email') }}" 
                required
                autocomplete="email"
              >
            </div>
            @include('alerts.feedback', ['field' => 'email'])
          </div>

          {{-- Password Field --}}
          <div class="space-y-2">
            <div class="relative {{ $errors->has('password') ? 'text-red-600' : '' }}">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input 
                type="password" 
                class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('password') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }} rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-0 sm:text-sm transition-colors duration-200" 
                id="examplePassword" 
                name="password" 
                placeholder="{{ __('Contraseña...') }}" 
                required
                autocomplete="current-password"
              >
            </div>
            @include('alerts.feedback', ['field' => 'password'])
          </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50" id="login">
          <button 
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]" 
            type="submit" 
            name="button"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
              </svg>
            </span>
            {{ __('Iniciar') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#login-form');
    if (form) {
      form.classList.add('opacity-0', 'transform', 'translate-y-4');
      setTimeout(() => {
        form.classList.remove('opacity-0', 'translate-y-4');
        form.classList.add('opacity-100', 'translate-y-0', 'transition-all', 'duration-500');
      }, 100);
    }
  });
</script>
@endpush