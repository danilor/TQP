@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Historial de Seguimiento"  }}
@stop
@section("contenido")

        <!-- row -->
<div class="row">
    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-blue">
                   {{ "Histórico"  }}
                  </span>
            </li>
            <!-- /.timeline-label -->

            <!-- timeline item -->
            @foreach( \Tiqueso\seguimiento::where("unico",Request::segment(3))->orderBy("creado","desc")->get() AS $key => $seguimiento )
            <li>
                <i class="fa fa-comments bg-green"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{ $seguimiento->obtenerFecha()  }}</span>
                    <h3 class="timeline-header"><a href="javascript:void(0);">
                            <a href="javascript:void(0);"><img src="{{ $seguimiento->obtenerUsuarioCreado()->obtenerFotoEspecial(25,25)  }}" width="20" height="20" alt="" title="{{ $seguimiento->obtenerUsuarioCreado()->obtenerNombreCompleto()  }}" />
                            {{ $seguimiento->obtenerUsuarioCreado()->obtenerNombreCompleto()  }}</a>
                            {{ "para" }}
                            <a href="javascript:void(0);">
                                <img src="{{ $seguimiento->obtenerUsuarioAsignado()->obtenerFotoEspecial(25,25)  }}" width="20" height="20" alt="" title="{{ $seguimiento->obtenerUsuarioAsignado()->obtenerNombreCompleto()  }}" />
                                {{ $seguimiento->obtenerUsuarioAsignado()->obtenerNombreCompleto()  }}
                            </a> </h3>
                    <div class="timeline-body">
                        {{ $seguimiento->mensaje  }}
                    </div>
                    <div class="timeline-footer">

                    </div>
                </div>
            </li>
            @endforeach
            <li>
                <i class="fa fa-clock-o bg-gray"></i>
            </li>
        </ul>
    </div><!-- /.col -->
</div><!-- /.row -->


@stop