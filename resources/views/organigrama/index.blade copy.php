@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')

<style media="screen">
.direccion_v {
  writing-mode: vertical-lr!important;
  transform: rotate(180deg)!important;
  width: 50px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
}

td a{ color: #3358f4!important;}
 td { height: 120px; width: 120px; border: none!important;}

.capsulaadd{
    border: 1px dotted #3358f4!important;
    padding: 10px;
    height: 100%; width: 100%;
    background:none!important;
    border-radius: 10px!important;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
  }
.centered-content {
    text-align: center; /* Centrar horizontalmente el contenido */
  }

.capsula1top{
    border: 3px solid #fff!important;
    padding: 10px; background:#1A006B!important;
    border-radius: 10px!important;
    height: 100%; width: 100%;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff!important;
    margin: 5px;
}

.capsula1{
  border: 3px solid #fff!important;
  padding: 10px; background:#3358f4!important;
  border-radius: 10px!important;
  height: 100%; width: 100%;
  text-align: center;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff!important;
  margin: 5px;
}
.capsula1 a{ color:#f5f5f5!important;}
.capsula1 p{ color:#f5f5f5!important;}
.capsula2{ border: 1px solid #900C3F!important; padding: 10px; background:#900C3F!important; border-radius: 10px!important; height: 100px; text-align: center;}
.capsula2 a{ color:#f5f5f5!important;}
.capsula2 p{ color:#f5f5f5!important;}

  [id^="eliminar"] {
    display: none;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
  }

  [id^="elemento"]:hover [id^="eliminar"] {
    display: block;
  }
</style>


<?php
$colspan=3;

if ($count_h>=3) {
  $colspan=$count_h+1;
}else {
  $colspan=3;
}

$rowspan=2;

if ($count_v>=2) {
  $rowspan=$count_v+1;
}else {
  $rowspan=2;
}
 ?>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h2 class="card-title text-center">Organigrama Matricial</h2>
              </div>
              <div class="card-body">

                <div class="row">
                    <div class="col-md-12 table-responsive">
                      <table class="table table-bordered table-stripped">
                        <tbody>
                          <tr>
                            <td>
                              @if($matricial->esquina)
                              <a href="organigrama-lineal/{{ $matricial->esquina }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->esquina) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionE" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionE" data-bs-toggle="modal" data-bs-target="#modalDireccionE" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <td colspan="{{ $colspan }}">
                              @if($matricial->horizontal)
                              <a href="organigrama-lineal/{{ $matricial->horizontal }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->horizontal) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionH" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionH" data-bs-toggle="modal" data-bs-target="#modalDireccionH" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td rowspan="{{ $rowspan }}">
                              @if($matricial->vertical)
                              <a href="organigrama-lineal/{{ $matricial->vertical }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->vertical) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionV" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionV" data-bs-toggle="modal" data-bs-target="#modalDireccionV" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <td>
                              @if($matricial->horizontal || $matricial->vertical)
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="addCC" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="addCC" data-bs-toggle="modal" data-bs-target="#modaladdCC" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <!-- aquí va inicia hacia la derecha -->

                            @foreach($agrupadores_h as $ah)
                            <td>
                              <a href="organigrama-lineal/{{ $ah->agrupador_id }}" class="capsula1">
                                {{ $ah->nombre }}
                              </a>
                            </td>
                            @endforeach
                            <!-- aquí va termina hacia la derecha -->
                          </tr>
                          @if($count_v>=1)
                          @foreach($agrupadores_v as $av)
                          <tr>
                            <td>
                              <a href="organigrama-lineal/{{ $av->agrupador_id }}" class="capsula1">
                                {{ $av->nombre }}
                              </a>
                            </td>
                            <td colspan="{{ $colspan-1 }}"></td>
                          </tr>
                          @endforeach
                          @else
                          <tr>
                            <td></td>
                            <td colspan="{{ $colspan-1 }}"></td>
                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <style>
     
    [data-mdb-theme="dark"] #mdb-sidenav {
      background-color: var(--mdb-body-bg) !important;

      .sidenav-link {
        color: #d3d5db !important;
      }

      #breakdown-link {
        border-bottom: 1px solid var(--mdb-divider-color) !important;
      }

      .active {
        background-color: #fff3;
      }

      :focus {
        background-color: #ffffff1a
      }
    }

    #mdb-sidenav .sidenav-collapse, .sidenav .rotate-icon {
      transition-property: none;
    }

    #mdb-sidenav .fas {
      color: #9FA6B2;
    }
    #mdb-sidenav a {
      color: #4B5563;
    }
    #mdb-sidenav a.active {
      background-color: rgba(18,102,241,.05);
    }
    #mdb-sidenav .sidenav-item {
      margin-left: 5px;
      margin-right: 0.5rem;
    }
    #mdb-sidenav .sidenav-item:first-child {
      margin-top: 4px;
    }
    #mdb-sidenav .sidenav-item:last-child {
      margin-bottom: 4px;
    }

    #mdb-sidenav-toggler {
      display: none;
      background-color: transparent;
    }

    .mdb-docs-layout {
      padding-left: 240px;
    }

    @media (max-width: 1440px) {
      #mdb-sidenav-toggler {
        display: unset;
      }

      #mdb-sidenav {
        transform: translate(-100%);
      }

      .mdb-docs-layout {
        padding-left: 0px;
      }
    }

    .sidenav-icon {
      color: #9fa6b2;
      height: 14px;
    }
  </style>
    <script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/js/dist/mdb5/plugins/standard/organization-chart.min.js"></script>
    <section class="pb-4">
  <div class="border rounded-5">
    
           <section class="p-4 d-flex justify-content-center w-100">
      <div id="advancedChartExample"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td colspan="8">
      <div class="card organization-card">
        <div class="card-header">CIO</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/1.webp" alt="">
          <p class="card-text">Walter White</p>
        </div>
      <a><i class="fas fa-chevron-down"></i></a></div>
    </td></tr>
    <tr class="organization-chart-lines-top"><td colspan="8"><div></div></td></tr>
    <tr class="organization-chart-lines"><td class="organization-chart-line" style="border-top: none;"></td><td class="organization-chart-line" style="border-right-color: transparent;"></td><td class="organization-chart-line"></td><td class="organization-chart-line" style="border-right-color: transparent;"></td><td class="organization-chart-line"></td><td class="organization-chart-line" style="border-right-color: transparent;"></td><td class="organization-chart-line"></td><td class="organization-chart-line" style="border-right-color: transparent; border-top: none;"></td></tr>
    <tr class="organization-chart-children"><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td colspan="2">
      <div class="card organization-card">
        <div class="card-header">Manager</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/2.webp" alt="">
          <p class="card-text">Jon Snow</p>
        </div>
      <a><i class="fas fa-chevron-down"></i></a></div>
    </td></tr>
    <tr class="organization-chart-lines-top"><td colspan="2"><div style="height: 40px;"></div></td></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">SE</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/9.webp" alt="">
          <p class="card-text">Britney Morgan</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td></tr>
  </tbody>
</table></td><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td colspan="2">
      <div class="card organization-card">
        <div class="card-header">Director</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/3.webp" alt="">
          <p class="card-text">Jimmy McGill</p>
        </div>
      <a><i class="fas fa-chevron-down"></i></a></div>
    </td></tr>
    <tr class="organization-chart-lines-top"><td colspan="2"><div style="height: 40px;"></div></td></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td colspan="4">
      <div class="card organization-card">
        <div class="card-header">PM</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/7.webp" alt="">
          <p class="card-text">Phoebe Buffay</p>
        </div>
      <a><i class="fas fa-chevron-down"></i></a></div>
    </td></tr>
    <tr class="organization-chart-lines-top"><td colspan="4"><div></div></td></tr>
    <tr class="organization-chart-lines"><td class="organization-chart-line" style="border-top: none;"></td><td class="organization-chart-line" style="border-right-color: transparent;"></td><td class="organization-chart-line"></td><td class="organization-chart-line" style="border-right-color: transparent; border-top: none;"></td></tr>
    <tr class="organization-chart-children"><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">Operations</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/4.webp" alt="">
          <p class="card-text">Kim Wexler</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">Development</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/6.webp" alt="">
          <p class="card-text">Rachel Green</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td></tr>
  </tbody>
</table></td></tr>
  </tbody>
</table></td><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td colspan="4">
      <div class="card organization-card">
        <div class="card-header">Manager</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/8.webp" alt="">
          <p class="card-text">Michael Scott</p>
        </div>
      <a><i class="fas fa-chevron-down"></i></a></div>
    </td></tr>
    <tr class="organization-chart-lines-top"><td colspan="4"><div></div></td></tr>
    <tr class="organization-chart-lines"><td class="organization-chart-line" style="border-top: none;"></td><td class="organization-chart-line" style="border-right-color: transparent;"></td><td class="organization-chart-line"></td><td class="organization-chart-line" style="border-right-color: transparent; border-top: none;"></td></tr>
    <tr class="organization-chart-children"><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">SA</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/5.webp" alt="">
          <p class="card-text">Pam Beasly</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">SP</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/14.webp" alt="">
          <p class="card-text">Alex Morgan</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td></tr>
  </tbody>
</table></td><td colspan="2"><table class="organization-chart-table">
  <tbody>
    <tr class="organization-chart-content"><td>
      <div class="card organization-card">
        <div class="card-header">R&amp;D</div>
        <div class="card-body">
          <img src="https://mdbootstrap.com/img/new/avatars/10.webp" alt="">
          <p class="card-text">Fran Kirby</p>
        </div>
      </div>
    </td></tr>
    <tr class="organization-chart-lines-top"></tr>
    <tr class="organization-chart-lines"></tr>
    <tr class="organization-chart-children"></tr>
  </tbody>
</table></td></tr>
  </tbody>
</table></div>
    </section>
   
    
    
    <div class="p-4 text-center border-top mobile-hidden">
      <a class="btn btn-link px-3 collapsed" role="button" aria-expanded="false" aria-controls="example2" data-ripple-color="hsl(0, 0%, 67%)" data-mdb-modal-init="" data-mdb-target="#apiRestrictedModal" type="button">
        <i class="fas fa-code me-md-2"></i>
        <span class="d-none d-md-inline-block">
          Show code
        </span>
      </a>
      
      
        <a class="btn btn-link px-3 " data-ripple-color="hsl(0, 0%, 67%)">
          <i class="fas fa-file-code me-md-2 pe-none"></i>
          <span class="d-none d-md-inline-block export-to-snippet pe-none">
            Edit in sandbox
          </span>
        </a>
      
    </div>
    
    
  </div>
</section>
  </div>

  <div class="modal fade" id="modalDireccionH" tabindex="-1" aria-labelledby="modalDireccionHLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="{{ route('matricialh') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                  <h4>Agrega un centro de costo para la parte superior del organigrama</h4>
                  <br>

                  <div class="form-group">
                    <label for="">Centro de costo</label>
                    <select class="form-control" name="cc" required>
                      <option value="">Selecciona una opción</option>
                      @foreach($centros_de_costos as $cc)
                       @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                      @endforeach
                    </select>
                  </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="modalDireccionV" tabindex="-1" aria-labelledby="modalDireccionVLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-dialog modal-sm">
        <form action="{{ route('matricialv') }}" method="post">
          @csrf
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 text-center">

                    <h4>Agrega un centro de costo para la parte lateral del organigrama</h4>
                    <br>
                    <div class="form-group">
                      <label for="">Centro de costo</label>
                      <select class="form-control" name="cc" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($centros_de_costos as $cc)
                           @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                        @endforeach
                      </select>
                    </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalDireccionE" tabindex="-1" aria-labelledby="modalDireccionELabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-dialog modal-sm">
        <form action="{{ route('matriciale') }}" method="post">
          @csrf
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Agrega un centro de costo para la esquina del organigrama</h4>
                    <br>
                    <div class="form-group">
                      <label for="">Centro de costo</label>
                      <select class="form-control" name="cc" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($centros_de_costos as $cc)
                         @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                        @endforeach
                      </select>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modaladdCC" tabindex="-1" aria-labelledby="modaladdCC" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="{{ route('matricial') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <h4>Agrega un centro de costo al organigrama</h4>
                <br>
                <div class="form-group">
                  <label for="">Dirección:</label>
                  <select class="form-control" name="orientacion" required>
                    <option value="">Selecciona una opción</option>
                    @if($matricial->horizontal)
                    <option value="horizontal">{{ nombrecc($matricial->horizontal) }}</option>
                    @endif
                    @if($matricial->vertical)
                    <option value="vertical">{{ nombrecc($matricial->vertical) }}</option>
                    @endif
                  </select>
                </div>
                <br>
                <div class="form-group">
                  <label for="">Centro de costo</label>
                  <select class="form-control" name="cc" required>
                    <option value="">Selecciona una opción</option>
                    @foreach($centros_de_costos as $cc)
                     @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="modaldelCC" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('js')
@endpush
