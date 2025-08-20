@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')

<style media="screen">
.direccion_v {
  writing-mode: vertical-lr;
  transform: rotate(180deg);
  width: 50px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
}


</style>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Organigrama</h4>
              </div>
              <div class="card-body">

                <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-striPped">
                <tbody><tr>
                    <td style="background:#fff; border-left:none; border-top:none;"> <a href="/organigrama-departamento/15">PROJECT MANAGER</a> </td>
                    <td colspan="6" class="direccion_h text-center">

                      <a href="/organigrama-departamento/13" id="direccion_h" required="">Dirección operativa</a>


                    </td>
                </tr>
                <tr>
                    <td rowspan="8" class="direccion_v">

                      <a href="/organigrama-departamento/14" id="direccion_v" required="">DIRECCIÓN ADMINISTRATIVA</a>

                    </td>
                        <td style="width:90px; background:#eee;"></td>
                              <td class="text-center"><a href="/organigrama-departamento/1">kkk </a>
                              <br>
                              <p>$31,302.92</p>
                            </td>
                              <td class="text-center"><a href="/organigrama-departamento/2">COMPRAS </a>
                              <br>
                              <p>$136,014.60</p>
                            </td>
                              <td class="text-center"><a href="/organigrama-departamento/3">GASOLINERAS </a>
                              <br>
                              <p>$62,200.20</p>
                            </td>
                            <td class="text-center"><a href="/organigrama-departamento/7">DISTRIBUIDORAS Y COMERCIALIZADORAS </a>
                              <br>
                              <p>$28,609.50</p>
                            </td>
                            <td class="text-center"><a href="/organigrama-departamento/8">SASISOPAS </a>
                              <br>
                              <p>$18,109.50</p>
                            </td>

                    </tr>

                    <tr>
                            <td><a href="/organigrama-departamento/4">SERVICIOS GENERALES</a>
                              <br>
                              <p>$0.00</p>
                            </td>
                            <td colspan="5"></td>
                            </tr>
                            <tr>
                            <td><a href="/organigrama-departamento/5">FINANCIERA</a>
                              <br>
                              <p>$0.00</p>
                            </td>
                            <td colspan="5"></td>
                            </tr>
                                                      <tr>
                            <td><a href="/organigrama-departamento/6">LEGAL</a>
                              <br>
                              <p>$0.00</p>
                            </td>
                            <td colspan="5"></td>
                            </tr>
                                                      <tr>
                            <td><a href="/organigrama-departamento/9">AUDITORIA</a>
                              <br>
                              <p>$86,509.80</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>
                                                      <tr>
                            <td><a href="/organigrama-departamento/10">COMERCIAL</a>
                              <br>
                              <p>$10,682.70</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>
                                                      <tr>
                            <td><a href="/organigrama-departamento/11">RECURSOS HUMANOS</a>
                              <br>
                              <p>$107,757.90</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>
                                                      <tr>
                            <td><a href="/organigrama-departamento/12">SISTEMAS</a>
                              <br>
                              <p>$137,588.70</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>

            </tbody></table>
        </div>
    </div>



              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
@endpush
