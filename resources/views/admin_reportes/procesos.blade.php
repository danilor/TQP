@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Procesos" }}
@stop

@section("contenido")

    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#revenue-chart" data-toggle="tab">{{ "Gráfico lineal"  }}</a></li>
                    <!--<li><a href="#sales-chart" data-toggle="tab">{{ "Gráfico Circular"  }}</a></li>-->
                    <li class="pull-left header"><i class="fa fa-inbox"></i> {{ "Procesos diarios"  }}</li>
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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Registro de Ingresos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "PRODUCTOS"  }}</th>
                            <th>{{ "INICIO"  }}</th>
                            <th>{{ "FIN"  }}</th>
                            <th>{{ "DURACIÓN"  }}</th>
                            <th>{{ "PARTICIPANTES"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($procesos AS $p)
                            <tr>
                               <td>{{$p->id}}</td>
                                <td>
                                    @foreach( $p->obtenerCodigos() AS $c )
                                       <a href="/admin_productos/ficha_producto/{{ $c  }}">{{ $c  }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    {{ date(config('region.formato_fecha_completo'),strtotime($p->iniciado_fecha))  }}
                                    {{$p->usuario_inicial()->obtenerNombreCompleto()}}
                                </td>
                                <td>
                                    {{ date(config('region.formato_fecha_completo'),strtotime($p->finalizado_fecha))  }}
                                    {{$p->usuario_final()->obtenerNombreCompleto()}}
                                </td>
                                <td>
                                    {{  str_pad($p->obtenerDuracion()->h, 2, "0", STR_PAD_LEFT)  }}:{{  str_pad($p->obtenerDuracion()->i, 2, "0", STR_PAD_LEFT)  }}:{{  str_pad($p->obtenerDuracion()->s, 2, "0", STR_PAD_LEFT)  }}
                                </td>
                                <td>
                                    @foreach($p->obtenerParticipantes() AS $participante)
                                        {{$participante->obtenerNombreCompleto()}}<br />
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "PRODUCTOS"  }}</th>
                            <th>{{ "INICIO"  }}</th>
                            <th>{{ "FIN"  }}</th>
                            <th>{{ "DURACIÓN"  }}</th>
                            <th>{{ "PARTICIPANTES"  }}</th>
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
        $( document).ready(function(){
            // Sales chart
            var area = new Morris.Area({
                element: 'revenue-chart',
                resize: true,
                data: [
                    @foreach($grafico AS $key => $g)
                    {y: '{{$key}}', item1: {{$g['ini']}}, item2: {{$g['fin']}}},
                    @endforeach
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Iniciados', 'Finalizados'],
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