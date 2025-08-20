@extends('errors.layout', [
  'class' => 'login-page',
  'classPage' => 'login-page',
  'activePage' => 'login',
  'title' => __('Junzi')
])

@section('content')


<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-9 ml-auto mr-auto mb-1 text-center">
          <h2>{{ __('No se ha podido cargar la vista') }}(</h2>
      </div>
    </div>
  </div>
</div>
@endsection
