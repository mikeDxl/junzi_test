@php
    $activePage = $activePage ?? 'homejunzi';
    $menuParent = $menuParent ?? 'homejunzi';
    $titlePage = $titlePage ?? __('Home');
    $class = $class ?? 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100';
    $classPage = $classPage ?? 'homejunzi-page';
@endphp

@extends('layouts.app', [
    'class' => $class,
    'classPage' => $classPage,
    'activePage' => $activePage,
    'menuParent' => $menuParent, 
    'titlePage' => $titlePage,
])


@section('content')
<div class="wrapper">
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
      @yield('contentJunzi')
  </div>
</div>
@endsection