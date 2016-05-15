@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Recetas" }}
@stop
@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirTipo"><i class="fa fa-plus"></i> {{ "Añadir Receta"  }}</button></li>
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
        </div>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Recetas"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "ID"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "CREADA"  }}</th>

                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "BORRAR"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\receta::all() AS $r)
                        <tr>
                            <td><a href="/admin_productos/ficha_producto/{{ $r->id  }}">{{ $r->id  }}</a></td>
                            <td>
                                {{ $r->nombre  }}
                            </td>
                            <td>
                                {{$r->obtenerFechaCreacion()}}
                            </td>

                            <td>
                                <a href="/admin_contenidos/salvar_receta/{{$r->id}}" class="btn btn-block btn-success"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                            </td>
                            <td>

                                    {!!  Form::open(array(
                                                            'url'                   =>  '/admin_contenidos/borrar_receta/'.$r->id,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Eliminar Receta",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea eliminar esta receta? Esta acción no puede ser revertida.",
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
                            <th>{{ "CREADA"  }}</th>

                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "BORRAR"  }}</th>
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
                location.href='/admin_contenidos/salvar_receta';
                e.preventDefault();
            });
        });
    </script>
@stop