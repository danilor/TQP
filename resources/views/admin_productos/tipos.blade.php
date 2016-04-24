@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Tipos de Productos" }}
@stop
@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirTipo"><i class="fa fa-plus"></i> {{ "Añadir Tipo de Producto"  }}</button></li>
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
    {!! Form::open(array('url' => '/admin_productos/anadir_tipo_producto','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <div class="row formOverTable nuevoUsuarioFormulario" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Nuevo tipo de Producto"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Código"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("codigo", Input::old("codigo"), array('placeholder'=>"Código",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->
        </div>
    </div>
    {!! Form::close() !!}




    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Tipos de Productos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "CÓDICO"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\tipo_producto::where( "estado" , "1" ) -> get() AS $c)
                        <tr>
                            <td>{{ $c->codigo  }}</td>
                            <td>{{ $c->nombre  }}</td>
                            <td>{{ $c->detalle  }}</td>
                            <td>
                                <a href="/admin_productos/modificar_tipo/{{$c->codigo}}" class="btn btn-block btn-success"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                            </td>
                            <td>
                                {!!  Form::open(array(
                                                        'url'                   =>  '/admin_productos/borrar_tipo/'.$c->id,
                                                        "class"                 =>  'confirmar_accion',
                                                        "method"                =>  "get",
                                                        "confirmacion_titulo"   =>  "Eliminar Tipo",
                                                        "confirmacion_contenido"=>  "¿Está seguro que desea eliminar este tipo de producto? Esta acción no puede ser revertida.",
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
                            <th>{{ "CÓDICO"  }}</th>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $(".anadirTipo").click(function(e){
                $( ".nuevoUsuarioFormulario" ).toggle( "normal", function() {
                    // Animation complete.
                });
                e.preventDefault();
            });
        });
    </script>
@stop