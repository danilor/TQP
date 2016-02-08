@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Categorías de Productos" }}
@stop

@section("contenido")

    <div class="row">

        <div class="col-xs-12">


            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Categorías de Productos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\categoria_producto::all() AS $c)
                        <tr>
                            <td>{{ $c->id  }}</td>
                            <td>{{ $c->nombre  }}</td>
                            <td>{{ $c->detalle  }}</td>
                            <td>
                                <a href="/productos/modificar_categoria/{{$c->id}}" class="btn btn-block btn-success"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                            </td>
                            <td>
                                {!!  Form::open(array(
                                                        'url'                   =>  '/productos/borrar_categoria/'.$c->id,
                                                        "class"                 =>  'confirmar_accion',
                                                        "method"                =>  "get",
                                                        "confirmacion_titulo"   =>  "Eliminar Categoría",
                                                        "confirmacion_contenido"=>  "¿Está seguro que desea eliminar esta categoría? Esta acción no puede ser revertida.",
                                                )) !!}
                                {!! Form::token() !!}
                                <button type="submit" class="btn btn-block btn-danger"><span class="fa fa-pencil"></span> {{ "Eliminar"  }}</button>
                                {!!  Form::close() !!}

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
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
@stop