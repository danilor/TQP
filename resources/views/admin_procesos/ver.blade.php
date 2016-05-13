@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Procesos" }}
@stop

@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirUsuario"><i class="fa fa-user-plus"></i> {{ "Añadir Proceso"  }}</button></li>
    </ol>
    @stop

@section("contenido")

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Procesos Activos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "INICIADO"  }}</th>
                            <th>{{ "INICIADO POR"  }}</th>
                            <th>{{ "PRODUCTOS"  }}</th>
                            <th>{{ "ACCIÓN"  }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($procesos AS $p)
                            <tr>
                                <td>
                                    {{ date(config('region.formato_fecha_completo'),strtotime($p->iniciado_fecha))  }}
                                    <br />
                                    Hace: {{ \App\clases\Comunes::timeElapsedString(strtotime($p->iniciado_fecha))   }}

                                </td>
                                <td>{{ $p->usuario_inicial()->nombre  }} {{ $p->usuario_inicial()->apellido  }}</td>
                                <td>
                                    @foreach($p->obtenerCodigos() AS $c)
                                        <a href="/admin_productos/ficha_producto/{{$c}}">{{$c}}</a>&nbsp;
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-info" href="/admin_procesos/registrar_de_proceso/{{ $p->id  }}">{{"Concluir Proceso"}}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "INICIADO"  }}</th>
                            <th>{{ "INICIADO POR"  }}</th>
                            <th>{{ "PRODUCTOS"  }}</th>
                            <th>{{ "ACCIÓN"  }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div><!-- /.row -->
    </div>
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $(document).ready(function(){
            $(".anadirUsuario").click(function(e){
                location.href='/admin_procesos/iniciar_proceso';
                e.preventDefault();
            });
        });

    </script>
@stop