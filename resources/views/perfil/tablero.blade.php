@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Perfil de Usuario"  }}
@stop
@section("contenido")

        <div class="row">
@include("perfil.cuadros_informacion")
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">{{ "Seguimientos"  }}</a></li>

                    </ul>

                    @if( (int)$usuario->totalSeguimientos() > 0 )

                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!-- Post -->
                            @foreach( $usuario -> obtenerSeguimientos() AS $key => $seguimiento )
                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{ $seguimiento->obtenerUsuarioCreado()->obtenerFotoEspecial(100,100)  }}" alt="user image">
                        <span class="username">
                          <a href="javascript:void(0);">{{ $seguimiento->obtenerUsuarioCreado()->obtenerNombreCompleto()  }}</a>
                        </span>
                                    <span class="description">{{ $seguimiento->obtenerFecha()  }} <a href="/seguimientos/historial/{{ $seguimiento->unico  }}">{{ "Historial"  }}</a></span>
                                </div><!-- /.user-block -->
                                {!! Form::open(array('url' => '/seguimientos/nuevo_seguimiento','id'=>'','class'=>'requiereValidacionAjax modificarSeguimientoFormulario','method'=>'post')) !!}
                                <input type="hidden" value="{{ $seguimiento->creado_por  }}" name="usuario" />
                                <input type="hidden" value="{{ $seguimiento->unico  }}" name="unico" />
                                <div class="col-xs-12">
                                <p>
                                    {{ $seguimiento->mensaje  }}
                                </p>
                                </div>

                                    <div class="form-group margin-bottom-none">
                                        <div class="col-sm-9">
                                            <input class="form-control input-sm" name="detalle" placeholder="{{ "Respuesta"  }}" required="required" />
                                            <br /><input value="{{ "cerrar"  }}" id="checkbox-{{ "cerrar" }}_{{$seguimiento->id}}" class="checkbox-custom" name="cerrar" type="checkbox" />
                                            <label for="checkbox-{{ "cerrar" }}_{{$seguimiento->id}}" class="checkbox-custom-label">{{"Cerrar Seguimiento"}}</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">{{ "Responder"  }}</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div><!-- /.post -->

                            @endforeach
                        </div><!-- /.tab-pane -->

                </div><!-- /.nav-tabs-custom -->

                @else
                        <center>
                            <p><br /> {{ "Sin seguimientos"  }}<br /></p>
                        </center>

                @endif


            </div><!-- /.col -->
        </div><!-- /.row -->
</div>
    @stop