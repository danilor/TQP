@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Correo" }}
@stop

@section("contenido")




    <div class="row">

        <div class="alert alert-block alert-info fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
            </button>
            {{ "El siguiente reporte comprende los últimos 5000 movimientos de inventarios." }}
        </div>

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Registro de Inventarios"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "USUARIO"  }}</th>
                            <th>{{ "TIPO"  }}</th>
                            <th>{{ "CANTIDAD"  }}</th>
                            <th>{{ "FECHA"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inventarios AS $i)
                            <tr>
                                <td>{{$i->id}}</td>
                                <td>{{$i->usuario_nombre}}</td>
                                <td>{{$i->codigo}}</td>
                                <td>{{ number_format((float)$i->cantidad,2) }}</td>
                                <td>{{ date(config('region.formato_fecha_completo'),strtotime($i->creado))  }}</td>
                                <td>{{$i->detalle}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "USUARIO"  }}</th>
                            <th>{{ "TIPO"  }}</th>
                            <th>{{ "CANTIDAD"  }}</th>
                            <th>{{ "FECHA"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
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

        });
    </script>
@stop