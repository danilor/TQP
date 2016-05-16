@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Productos" }}
@stop
@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirTipo"><i class="fa fa-plus"></i> {{ "Registrar Producto"  }}</button></li>
    </ol>
@stop
@section("contenido")

    <div class="row formOverTable">
        <div class="col-xs-12">
            @foreach ($errors->all() as $message)
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ $message }}
                </div>
            @endforeach
                <div class="alert alert-block alert-info fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ "La lista de productos a continuación solamente contempla los productos que se encuentran en actividad. Para una búsqueda más detallada puede usar la herramienta de búsqueda de productos." }}
                </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Productos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "CÓDIGO"  }}</th>
                            <th>{{ "TIPO"  }}</th>
                            <th>{{ "PROVEEDOR"  }}</th>
                            <th>{{ "UNIDADES"  }}</th>
                            <th>{{ "REGISTRADO POR"  }}</th>
                            <th>{{ "VENCIMIENTO"  }}</th>
                            <th>
                                {{ "ACCIÓN"  }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productos AS $c)
                        <tr>
                            <td><a href="/admin_productos/ficha_producto/{{ $c->codigo  }}">{{ $c->codigo  }}</a></td>
                            <td>
                                {{ $c->nombre_tipo  }}
                            </td>
                            <td>
                                {{$c->nombre_proveedor}}
                            </td>
                            <td>
                                {{$c->unidades}}
                            </td>
                            <td>{{ $c->usuario_nombre  }} {{ $c->usuario_apellido  }}</td>
                            <td>
                                {{ date(config('region.formato_fecha'),strtotime($c->vencimiento))  }}
                            </td>
                            <td>
                                    {!!  Form::open(array(
                                                            'url'                   =>  '/admin_productos/sacar_producto/'.$c->id,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Sacar Producto",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea sacar este producto de la planta? Esto marcará el producto como enviado y distribuido, aunque seguirá apareciendo en el historial de productos para efectos de reportes y búsquedas.",
                                                    )) !!}
                                    {!! Form::token() !!}
                                        <button type="submit" class="btn btn-block btn-success"><span class="fa fa-truck"></span> {{ "Despachar"  }}</button>
                                    {!!  Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "CÓDIGO"  }}</th>
                            <th>{{ "PROVEEDOR"  }}</th>
                            <th>{{ "TIPO"  }}</th>
                            <th>{{ "UNIDADES"  }}</th>
                            <th>{{ "REGISTRADO POR"  }}</th>
                            <th>{{ "VENCIMIENTO"  }}</th>
                            <th>
                                {{ "ACCIÓN" }}
                            </th>
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
            $(".anadirTipo").click(function(e){
                location.href='/admin_productos/registrar_nuevo';
                e.preventDefault();
            });
        });
    </script>
@stop