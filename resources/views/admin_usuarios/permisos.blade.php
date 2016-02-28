@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Permisos" }}
@stop

@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirUsuario"><i class="fa fa-user-plus"></i> {{ "Añadir Permiso"  }}</button></li>
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
    {!! Form::open(array('url' => '/admin_usuarios/salvar_permiso','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
{!! Form::hidden("id_permiso", Input::old("id_permiso"),array("id"=>'id_permiso')) !!}
    <div class="row formOverTable nuevoUsuarioFormulario" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Información de Permiso"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", Input::old("nombre"), array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Alias"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("alias", Input::old("alias"), array('placeholder'=>"Alias",'class'=>'form-control','required'=>'required')) !!}
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
                    <h3 class="box-title">{{ "Permisos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "NOMBRE DE PERMISO"  }}</th>
                            <th>{{ "ALIAS"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\permiso::all() AS $u)
                            <tr>
                                <td class="permisoNombre">{{ $u->nombre  }}</td>
                                <td class="permisoAlias">{{ $u->alias  }}</td>
                                <td>
                                    <a href="#" pid="{{$u->id}}" class="btn btn-block btn-success modificarPermiso"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                                </td>
                                <td>

                                    {!!  Form::open(array(
                                                            'url'                   =>  '/admin_usuarios/borrar_permiso/'.$u->id,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Eliminar Permiso",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea eliminar este Permiso? Los usuarios que cuenta con este permiso lo conservarán hasta que sean actualizados.",
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
                            <th>{{ "NOMBRE DE PERMISO"  }}</th>
                            <th>{{ "ALIAS"  }}</th>
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
            $(".anadirUsuario").click(function(e){
                $( ".nuevoUsuarioFormulario" ).toggle( "normal", function() {
                    // Animation complete.
                    if(!$(".nuevoUsuarioFormulario").is(":visible")  ){
                        $("#id_permiso").val("");
                        $(".nuevoUsuarioFormulario").find("input").val("");
                    }
                });
                e.preventDefault();
            });
            $(".modificarPermiso").click(function(e){
                var id = $(this).attr("pid"); //Id de permiso
                var nombre = $(this).closest("tr").find(".permisoNombre").html();
                var alias = $(this).closest("tr").find(".permisoAlias").html();
                $(".nuevoUsuarioFormulario").fadeIn();
                $("#id_permiso").val(id);
                $("[name=nombre]").val(nombre);
                $("[name=alias]").val(alias);
                e.preventDefault();
            });
        });

    </script>
@stop