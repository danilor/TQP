@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Registro de Ingresos de Productos" }}
@stop

@section("contenido")
    <div class="row">
        <div class="col-xs-12">

            @if( $max < 10000000 )
             <div class="alert alert-block alert-info fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <p>{{ "Se muestran los últimos " . $max .  " registros. Si lo desea puede utilizar el formulario de búsqueda para refinar los registros a obtener." }}</p>
                    <p>{{ "Además, puede realiza realizar clic " }}<a href="?max=999999999">{{"aquí"}}</a>{{" para obtener todos los registros existentes (puede llevar más tiempo en cargar la página)."}}</p>
                </div>

            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Registro de Ingresos de Productos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "INICIO"  }}</th>
                            <th>{{ "FIN"  }}</th>
                            <th>{{ "PROVEEDOR"  }}</th>
                            <th>{{ "VER"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $registros  AS $c)
                            <tr>
                              <td> {{ $c->id  }} </td>
                              <td> {{ $c->iniciado  }} </td>
                              <td> {{ $c->finalizado  }} </td>
                              <td> {{ $c->proveedor  }} {{ $c->proveedor_nombre  }} </td>
                              <td>
                              <center>
                                  <a title="{{ "Ver" }}" class="btn btn-success" href="/admin_productos/resumen_registro/{{ $c->id  }}"><i class="fa fa-eye"></i></a
                                  </center>
                              </td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "INICIO"  }}</th>
                            <th>{{ "FIN"  }}</th>
                            <th>{{ "PROVEEDOR"  }}</th>
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