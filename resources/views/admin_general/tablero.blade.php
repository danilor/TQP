@extends("plantillas.admin")

@section("nombre_pagina")
    @stop
@section("contenido")

        <!-- =========================================================== -->

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ number_format(\Tiqueso\proceso::where("estado",1)->count())   }}</h3>
                <p>{{ "Procesos en curso"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-gears"></i>
            </div>
            <a href="/admin_procesos/ver" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>0   </h3>
                <p>{{ "Seguimientos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-hand-o-right"></i>
            </div>
            <a href="#" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3> {{ number_format(\Tiqueso\usuario::where("activo",1)->count())   }}  </h3>
                <p>{{ "Usuarios Activos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="/admin_usuarios/ver_todos/" class="small-box-footer">{{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ \Tiqueso\producto::where('estado',1)->where('borrado',0)->count()  }}</h3>
                <p>{{ "Productos Activos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-archive"></i>
            </div>
            <a href="/admin_productos/ver" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ "Últimos Procesos Activos (Mas antiguos)"  }}</h3>
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
                        @foreach(\Tiqueso\proceso::where('estado',1)->orderBy('iniciado_fecha','ASC')->take(10)->get() AS $p)
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
                <a href="/admin_procesos/ver" class="btn btn-sm btn-default btn-flat pull-right">{{ "Ver todos los procesos activos"  }}</a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->





    </div><!-- /.col -->




    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ "Productos próximos a vencer"  }}</h3>
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
                        <th>CÓDICO</th>
                        <th>PROVEEDOR</th>
                        <th>VENCE</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\Tiqueso\producto::where('estado',1)->orderBy('vencimiento','ASC')->take(10)->get() AS $p)
                        <tr>
                            <td><a href="/admin_productos/ficha_producto/{{ $p->codigo  }}">{{ $p->codigo  }}</a> </td>
                            <td>{{ $p->nombre_proveedor }}</td>
                            <td>
                                {{ date(config('region.formato_fecha'),strtotime($p->vencimiento))  }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="/admin_productos/registrar_nuevo" class="btn btn-sm btn-info btn-flat pull-left">{{ "Registrar Producto Nuevo"  }}</a>
            <a href="/admin_productos/ver" class="btn btn-sm btn-default btn-flat pull-right">{{ "Ver todos los productos activos"  }}</a>
        </div><!-- /.box-footer -->
    </div><!-- /.box -->

    </div>



    </div>

</div>

<!-- =========================================================== -->

    @stop