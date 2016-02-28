@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Directorio de Usuarios" }}
@stop

@section("extra_cabecera")

    @stop

@section("contenido")
<div class="row">
    <div class="col-xs-12">
        <ul class="directory-list">
            @foreach (range('A', 'Z') as $char)
            <li>
                <a href="/admin_usuarios/directorio/{{ $char  }}">
                    {{ $char  }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="directory-info-row">
    <div class="row">

        @foreach($lista_usuarios AS $u)
        <div class="col-md-6 col-sm-6">
            <div class="panel">
                <div class="panel-body">
                    <div class="media">
                        <a class="pull-left" href="/admin_usuarios/modificar_usuario/{{ $u->id  }}">
                            <div class="widget-user-image">
                                <img width="150" class="img-circle" src="{{ $u->obtenerFotoEspecial(150,150)  }}" alt="User Avatar">
                            </div><!-- /.widget-user-image -->
                        </a>
                        <div class="media-body">
                            <h4>{{ $u->obtenerNombreCompleto()  }}<span class="text-muted small"> - <a href='mailto:{{ $u->correo  }}'>{{ $u->correo  }}</a></span></h4>
                            <!--<ul class="social-links">
                                <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                                <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a></li>
                            </ul>-->
                            <address>
                                @if($u->cedula != "") <strong>{{ $u->cedula }}</strong><br> @endif
                                @if($u->apodo != "") <strong>{{ $u->apodo  }}</strong><br> @endif
                                {{ $u->direccion  }}<br>
                                @if($u->telefono != "") <abbr title="{{ "Teléfono"  }}">{{ "Tel"  }}:</abbr> {{ $u->telefono  }}<br /> @endif
                                @if($u->celular != "") <abbr title="{{ "Celular"  }}">{{ "Cel"  }}:</abbr> {{ $u->celular  }}<br /> @endif

                            </address>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">

        $(document).ready(function(){
            $(".anadirUsuario").click(function(e){
                $( ".nuevoUsuarioFormulario" ).toggle( "normal", function() {
                    // Animation complete.
                });
                e.preventDefault();
            });
        });

    </script>
@stop