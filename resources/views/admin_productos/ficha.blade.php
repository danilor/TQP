@extends("plantillas.admin")

@section("nombre_pagina")

@stop
@section("extra_cabecera")

@stop
@section("contenido")

    <!--<div class="row formOverTable">
        <div class="col-xs-12">
                <div class="alert alert-block alert-info fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ "" }}
                </div>
        </div>
    </div>-->



    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ficha-producto">
            <center>
                <h1>{{"Ficha de producto"}} <img id="barcode2"/></h1>
            </center>
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ "Fecha de Elaboración/Registro"  }}</th>
                        <th>{{ "Nombre de Producto"  }}</th>
                        <th>{{ "Presentación"  }}</th>
                        <th>{{ "Día"  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ date(config('region.formato_fecha'),strtotime($producto->registrado)) }}</td>
                        <td>{{ $producto->obtener_tipo_producto()->nombre  }}</td>
                        <td>
                            @if((int)$producto->producto_tiqueso == 1)
                                {{ $producto->obtenerPresentacion()->detalle  }}
                            @else
                                {{ $producto->unidades  }} {{ $producto->obtener_tipo_producto()->unidad  }}
                            @endif


                        </td>
                        <td>{{ $producto->dia_juliano  }}</td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
            <br /> <!-- Una separación entre las tablas -->
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ "Materia Prima"  }}</th>
                        <th>{{ "Código"  }}</th>
                        <th>{{ "Lote"  }}</th>
                        <th>{{ "Cantidad"  }}</th>
                        <th>{{ "Observaciones"  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($producto->materias_primas == "")
                            <tr>
                                <td colspan="5"><p>{{ "Sin materias primas que detallar"  }}</p></td>
                            </tr>

                        @else

                            @foreach($producto->obtenerObjetosDeMateriasPrimas() AS $mp)
                                <tr>
                                    <td>{{$mp->obtener_tipo_producto()->nombre}}</td>
                                    <td>{{$mp->codigo_tipo}}</td>
                                    <td><a href="/admin_productos/ficha_producto/{{$mp->codigo}}">{{$mp->codigo}}</a></td>
                                    <td>{{$mp->unidades}}</td>
                                    <td>{{$mp->detalle}}</td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div><!-- /.table-responsive -->


            <br /> <!-- Una separación entre las tablas -->
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ "Detalles"  }}</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            @if($producto->detalle != "")
                                    {{ $producto->detalle }}
                                @else
                                    {{ "Sin detalles"  }}
                            @endif
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div><!-- /.table-responsive -->

        </div><!-- /.row -->

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="box box-info">
                <div class="box-body">
                    <center>
                        <div class="thumbnail" style="width: 190px; height: 190px;">
                            <img id="imagen_tipo_producto" src="{{$producto->obtenerImagenTipoProducto(190,190)}}" alt="" />
                        </div>
                        <div>

                            <img id="barcode"/>
                        </div>
                    </center>
                </div><!-- /.box-body -->

            </div><!-- /.box -->

        </div>
    </div>


@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $(document).ready(function(){
            $("#barcode").JsBarcode('{{Request::segment(3)}}');
            $("#barcode2").JsBarcode('{{Request::segment(3)}}',{
                width:1, height:40, fontSize: 12
            });
        });
    </script>
@stop