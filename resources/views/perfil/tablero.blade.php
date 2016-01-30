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
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="/img/user.png" alt="user image">
                        <span class="username">
                          <a href="#">[USUARIO QUE MANDO EL SEGUIMIENTO]</a>
                        </span>
                                    <span class="description">{{ "Marzo 20, 2016"  }}</span>
                                </div><!-- /.user-block -->
                                <p>
                                    {{ "[MENSAJE DE EJEMPLO]"  }}
                                </p>
                                <p>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> {{ "Cerrar este seguimiento"  }}
                                    </label>
                                </div>
                                </p>
                                <form class="form-horizontal">
                                    <div class="form-group margin-bottom-none">
                                        <div class="col-sm-9">
                                            <input class="form-control input-sm" placeholder="{{ "Respuesta"  }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-danger pull-right btn-block btn-sm">{{ "Responder"  }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.post -->


                        </div><!-- /.tab-pane -->

                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    @stop