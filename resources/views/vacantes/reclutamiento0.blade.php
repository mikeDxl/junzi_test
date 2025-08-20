@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>Vacantes</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <style>
        .candidato{ text-transform: uppercase; }
        .nav-link{ text-transform: uppercase; }
        .mayus{ text-transform: uppercase;  }
    </style>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-start">
                    <div class="card-body">

                        <div class="card text-start">

                            <div class="card-body">
                                <h4 class="card-title mb-3">Reclutamiento</h4>
                                <p></p>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Candidatos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Vacantes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">Entrevistas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="proceso-basic-tab" data-toggle="tab" href="#procesoBasic" role="tab" aria-controls="procesoBasic" aria-selected="false">Procesos de reclutamiento</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Apellido Paterno</th>
                                                        <th>Apellido Materno</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($candidatos as $can)
                                                        <tr>
                                                            <td>{{ $can->nombre }}</td>
                                                            <td>{{ $can->apellido_paterno }}</td>
                                                            <td>{{ $can->apellido_materno }}</td>
                                                            <td>{{ $can->estatus }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <form>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Nombre</label>
                                                        <input type="text" name="nombre" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Apellido Paterno</label>
                                                        <input type="text" name="apellido_paterno" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Apellido Materno</label>
                                                        <input type="text" name="apellido_materno" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Fecha nacimiento</label>
                                                        <input type="date" name="fecha_nacimiento" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Curriculum</label>
                                                        <input type="file" name="cv" class="form-control">
                                                    </div>
                                                    <br>
                                                    <button class="btn btn-primary">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                                        <div class="row">
                                            <div class="col-md 12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td>Departamento</td>
                                                        <td>Puesto</td>
                                                        <td>Libres</td>
                                                        <td>Completadas</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($vacantes as $vac)
                                                        <tr>
                                                            <td>{{ depa($vac->departamento_id) }}</td>
                                                            <td>{{ puesto($vac->puesto_id) }}</td>
                                                            <td>{{ $vac->solicitadas }}</td>
                                                            <td>{{ $vac->completadas }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Tipo</th>
                                                        <th>Pregunta</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($formularios as $form)
                                                        <tr>
                                                            <td>{{ nombre_encuesta2($form->encuesta_id) }}</td>
                                                            <td>{{ $form->tipo_de_campo }}</td>
                                                            <td>{{ $form->pregunta }}</td>
                                                            <td>{{ $form->opciones }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <form action="">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Proceso</label>
                                                        <select name="tipo" id="" class="form-control">
                                                            <option value="texto">Perfil operativo</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Nombre</label>
                                                        <input type="text" class="form-control" name="nombre">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Tipo</label>
                                                        <select name="tipo" id="" class="form-control">
                                                            <option value="texto">texto</option>
                                                            <option value="opciones">opciones</option>
                                                            <option value="multiple">multiple</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Opciones</label>
                                                        <textarea class="form-control" style="resize:none;">

                                                        </textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="procesoBasic" role="tabpanel" aria-labelledby="proceso-basic-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Proceso</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Perfil Operativo</td>
                                                        <td class="mayus">{{ proceso(1) }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
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
    </section>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection
