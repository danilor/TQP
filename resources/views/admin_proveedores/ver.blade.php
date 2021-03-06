@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Proveedores" }}
@stop

@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirProveedor"><i class="fa fa-user-plus"></i> {{ "Añadir Proveedor"  }}</button></li>
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
    {!! Form::open(array('url' => '/admin_proveedores/salvar_informacion_de_proveedor','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <div class="row formOverTable nuevoUsuarioFormulario" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Información de Proveedor"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    
                    <div class="form-group">
                        <label for="codigo" class="col-sm-2 control-label">{{ "Código"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("codigo", Input::old("codigo"), array('placeholder'=>"Código",'class'=>'form-control','required'=>'required','maxlength'=>'2','id'=>'codigo')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", Input::old("nombre"), array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required','maxlength'=>'255','id'=>'nombre')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detalle" class="col-sm-2 control-label">{{ "Detalle"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalle", Input::old("detalle"), array('placeholder'=>"Detalle",'class'=>'form-control','maxlength'=>'255','id'=>'detalle')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-sm-2 control-label">{{ "Teléfono"  }} <span></span></label>
                        <div class="col-sm-10">
                            {!! Form::text("telefono", Input::old("telefono"), array('placeholder'=>"Teléfono",'class'=>'form-control','maxlength'=>'10','id'=>'telefono')) !!}
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="correo" class="col-sm-2 control-label">{{ "Correo"  }} <span></span></label>
                        <div class="col-sm-10">
                            {!! Form::email("correo", Input::old("correo"), array('placeholder'=>"Correo",'class'=>'form-control','maxlength'=>'50','id'=>'correo')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-sm-2 control-label">{{ "Dirección"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("direccion", Input::old("direccion"), array('placeholder'=>"Dirección",'class'=>'form-control','maxlength'=>'500','id'=>'direccion')) !!}
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
                    <h3 class="box-title">{{ "Usuarios"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "CÓDIGO"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                            <th>{{ "CREADO"  }}</th>
                            <th>{{ "ACTUALIZADO"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\proveedor::all()  AS $p)
                            <tr>
                                <td>{{ $p->codigo }}</td>
                                <td>{{ $p->nombre  }}</td>
                                <td>{{ $p->detalle  }}</td>
                                <td>{{ $p->created_at  }}</td>
                                <td>{{ $p->updated_at  }}</td>
                                <td>
                                    <a href="/admin_proveedores/modificar_proveedor/{{$p->codigo}}" class="btn btn-block btn-success"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                                </td>
                                <td>
                                    {!!  Form::open(array(
                                                            'url'                   =>  '/admin_proveedores/borrar_proveedor/'.$p->codigo,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Eliminar Proveedor",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea eliminar el provedor {{$p->codigo}} ? Esta acción no puede ser revertida.",
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
                            <th>{{ "CÓDIGO"  }}</th>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "DETALLE"  }}</th>
                            <th>{{ "CREADO"  }}</th>
                            <th>{{ "ACTUALIZADO"  }}</th>
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
            $(".anadirProveedor").click(function(e){
                $( ".nuevoUsuarioFormulario" ).toggle( "normal", function() {
                    // Animation complete.
                });
                e.preventDefault();
            });
        });

    </script>
@stop