@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Ingresos" }}
@stop

@section("contenido")
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
                            <th>{{ "FECHA"  }}</th>
                            <th>{{ "USUARIO"  }}</th>
                            <th>{{ "ESTADO"  }}</th>
                            <th>{{ "LOCALIZACIÓN"  }}</th>
                            <th>{{ "IP"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ingresos AS $c)
                            <tr>
                                <td>
                                    {{$c->fecha}}
                                </td>
                                <td>
                                    {{$c->usuario}}
                                </td>
                                <td>
                                    @if((int)$c->estado == 1)
                                        <center><i class="fa fa-check-circle-o fa-2x" style="color:green;"></i></center>
                                    @endif
                                </td>
                                <td>
                                    @if( $c->lat != "" && $c->lon != "")
                                        &nbsp;<a target="_blank" href="{{ \App\clases\Comunes::obtenerURLMapa($c->lat,$c->lon)  }}"><i class="fa fa-map"></i> {{ "Localización"  }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{$c->ip}}<br />
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "FECHA"  }}</th>
                            <th>{{ "USUARIO"  }}</th>
                            <th>{{ "ESTADO"  }}</th>
                            <th>{{ "LOCALIZACIÓN"  }}</th>
                            <th>{{ "IP"  }}</th>
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