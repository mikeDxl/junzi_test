@extends('layouts.app', [
  'class' => 'login-page',
  'classPage' => 'login-page',
  'activePage' => 'login',
  'title' => __(''),
])

@section('content')
<div class="content">
  <div class="container">
    <div class="col-lg-4 col-md-6 ml-auto mr-auto">
      <form class="form" id ="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card card-login card-white">
          <div class="card-header">
            <img src="{{ asset("white") }}/img/card-info.png" alt="">
            <h1 class="card-title" style="text-transform:capitalize;">{{ __('Acceso') }}</h1>
          </div>
          <div class="card-body">
            <div class="form-group mb-0 {{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-email-85"></i>
                  </div>
                </div>
                <input type="email" class="form-control" id="exampleEmails" name="email" placeholder="{{ __('Email...') }}" value="" required>
              </div>
                @include('alerts.feedback', ['field' => 'email'])
            </div>
            <div class="form-group mb-0 {{ $errors->has('password') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-lock-circle"></i>
                  </div>
                </div>
                <input type="password" class="form-control" id="examplePassword" name="password" placeholder="{{ __('Contraseña...') }}" value="" required>
              </div>
              @include('alerts.feedback', ['field' => 'password'])
            </div>
          </div>
          <div class="card-footer" id="login">
            <button class="btn btn-info btn-lg btn-block mb-3" type="submit" name="button">{{ __('Iniciar') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      demo.checkFullPageBackgroundImage();
    });
  </script>
@endpush
