@extends('layouts.app2')

@section('content')

<?php

$activePage="";
$menuParent="";
 ?>

 <style media="screen">
 .fc-toolbar-title{ color: #151515!important; }

 h2{ color: #f5f5f5!important;  }
 </style>
<div class="container">
    <div class="row">
      <div class="col-md-3">
        @include('layouts.navbars.sidebar')
      </div>
        <div class="col-md-9">
            <h1>Mi Calendario</h1>
            <div id='calendar'></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')


@endpush
