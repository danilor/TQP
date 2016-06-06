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
                <h3> {{ \Tiqueso\seguimiento::where("estado",1)->count()  }}</h3>
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

<!-- Gráficos -->
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">{{ "Gráfico lineal"  }}</a></li>
                <!--<li><a href="#sales-chart" data-toggle="tab">{{ "Gráfico Circular"  }}</a></li>-->
                <li class="pull-left header"><i class="fa fa-inbox"></i> {{ "Entrada y Salida de Productos"  }}</li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                <!--<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>-->
            </div>
        </div><!-- /.nav-tabs-custom -->
    </div>
</div>

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


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                            <th>CÓDIGO</th>
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









<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ "Últimos Mensajes de Contacto (10 últimos)"  }}</h3>
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
                            <th>DE</th>
                            <th>FECHA</th>
                            <th>TEMA</th>
                            <th>MENSAJE</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\mensaje::orderBy('id','DESC')->take(10)->get() AS $m)
                            <tr>
                                <td>
                                    {{$m->nombre}}<br />
                                    {{$m->correo}}
                                </td>
                                <td>
                                    {{ date(config("region.formato_fecha"),strtotime($m->creado))  }}
                                </td>
                                <td>
                                    {{$m->tema}}
                                </td>
                                <td>
                                    {{$m->mensaje}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div><!-- /.col -->
</div>




<!-- =========================================================== -->

    @stop

@section("extra_js")

    <script type="text/javascript">
        $( document).ready(function(){
            // Sales chart
            var area = new Morris.Area({
                element: 'revenue-chart',
                resize: true,
                data: [
                    @foreach($grafico AS $key => $g)
                        {y: '{{$key}}', item1: {{$g['entradas']}}, item2: {{$g['salidas']}}},
                    @endforeach
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Ingresos', 'Salidas'],
                lineColors: ['#a0d0e0', '#3c8dbc'],
                hideHover: 'auto'
            });

            //Donut Chart
            /*var donut = new Morris.Donut({
                element: 'sales-chart',
                resize: true,
                colors: ["#3c8dbc", "#f56954", "#00a65a"],
                data: [
                    {label: "Download Sales", value: 12},
                    {label: "In-Store Sales", value: 30},
                    {label: "Mail-Order Sales", value: 20}
                ],
                hideHover: 'auto'
            });*/
        });
    </script>
@stop