@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Historial de Seguimientos" }}
@stop

@section("contenido")
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Historial de Seguimientos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "IDENTIFICADOR"  }}</th>
                            <th>{{ "PARTICIPANTES"  }}</th>
                            <th>{{ "FECHA DE INICIO"  }}</th>
                            <th>{{ "VER"  }}</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach( \Tiqueso\seguimiento::groupBy("unico")->get() AS $seguimiento )
                                <tr>
                                    <td><span title="{{ $seguimiento->unico }}">{{ str_limit($seguimiento->unico,20,'...') }}</span> </td>
                                    <td>
                                        @if( $seguimiento->asignado_a == $seguimiento->creado_por )
                                            {{ $usuarios[$seguimiento->creado_por]  }}
                                        @else
                                            {{ $usuarios[$seguimiento->creado_por]  }}<br />
                                            {{ $usuarios[$seguimiento->asignado_a]  }}
                                        @endif


                                    </td>
                                    <td>{{ $seguimiento->creado  }}</td>
                                    <td>
                                        <center>
                                        <a class="btn btn-success" href="/seguimientos/historial/{{ $seguimiento->unico  }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>{{ "IDENTIFICADOR"  }}</th>
                            <th>{{ "PARTICIPANTES"  }}</th>
                            <th>{{ "FECHA DE INICIO"  }}</th>
                            <th>{{ "VER"  }}</th>
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