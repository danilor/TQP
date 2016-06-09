@extends("plantillas.admin")

@section("nombre_pagina")
    @stop
@section("contenido")

        <!-- =========================================================== -->

<!-- Small boxes (Stat box) -->


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ "Mis Procesos Activos (Mas antiguos)"  }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>INICIADO</th>
                            <th>INICIADO POR</th>
                            <th>PRODUCTOS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\proceso::where('estado',1)->where('iniciado_por',$usuario->id)->orderBy('iniciado_fecha','ASC')->get() AS $p)
                            <tr>
                                <td>
                                    Hace: {{ \App\clases\Comunes::timeElapsedString(strtotime($p->iniciado_fecha))   }}

                                </td>
                                <td>{{ $p->usuario_inicial()->nombre  }} {{ $p->usuario_inicial()->apellido  }}</td>
                                <td>
                                    @foreach($p->obtenerCodigos() AS $c)
                                        <a href="/admin_productos/ficha_producto/{{$c}}">{{$c}}</a>&nbsp;
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="/admin_procesos/iniciar_proceso" class="btn btn-sm btn-info btn-flat pull-left">{{ "Iniciar Proceso Nuevo"  }}</a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->

    </div><!-- /.col -->


    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ "Registros en Proceso"  }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>USUARIO</th>
                            <th>INICIADO</th>
                            <th>PROVEEDOR</th>
                            <th>ACCIÓN</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registros_ingreso AS $p)
                            <tr>
                                <td>{{ $p->obtenerUsuario()->obtenerNombreCompleto()  }}</td>
                                <td>{{ $p->iniciado }}</td>
                                <td>
                                    {{ $p->proveedor_nombre }}
                                </td>
                                <td>
                                    <a href="/admin_productos/registrar_ingreso/{{ $p->id }}" class="btn btn-success">Continuar</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="/admin_productos/registrar_ingreso/" class="btn btn-sm btn-info btn-flat pull-left">{{ "Iniciar Nuevo Registro"  }}</a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->

    </div>


    </div>





<!-- =========================================================== -->

    @stop

@section("extra_js")

    <script type="text/javascript">
        $( document).ready(function(){

        });
    </script>
@stop