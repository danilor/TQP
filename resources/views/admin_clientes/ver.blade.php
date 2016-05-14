<?php 
/*$mensaje ="saludo=>'hola'";
$arreglo =array($mensaje);
var_dump($arreglo);*/
?>
@extends("plantillas.admin")
<?php $variable ="'id'=>'5'"; ?>
@section("nombre_pagina")
    {{ $nombre_objeto_plural_primero_mayus }}
@stop

@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadir_{{ $nombre_objeto }}"><i class="fa fa-user-plus"></i> {{ "Añadir $nombre_objeto"  }}</button></li>
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
    {!! Form::open(array('url' => "/admin_$nombre_objeto_plural/salvar_informacion",'class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <div class="row formOverTable nuevoUsuarioFormulario" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Información de $nombre_objeto_primero_mayus"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                @foreach( $columnas_escructura as $nombre_columna => $columna)
                    @if( $columna->getType() != "DateTime" AND $nombre_columna != "id" AND "codigo"    )
                        <?php 
                        $notNull = $columna->getNotnull(); $max_length = $columna->getLength(); 
                        ?> 
                        <div class="form-group">
                            <label for={{"$nombre_columna"}} class="col-sm-2 control-label">{{ "$nombre_columna"  }} @if( $notNull )<span>*</span>@endif</label>
                            <div class="col-sm-10">
                                @if( $notNull )
                                    {!! Form::text($nombre_columna, Input::old("$nombre_columna"), array('placeholder'=>"$nombre_columna",'class'=>'form-control','required'=>"required",'maxlength'=>$max_length,'id'=>$nombre_columna )) !!}
                                @else
                                    {!! Form::text($nombre_columna, Input::old("$nombre_columna"), array('placeholder'=>"$nombre_columna",'class'=>'form-control','maxlength'=>$max_length,'id'=>$nombre_columna )) !!}
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach


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
                    <h3 class="box-title">{{ $nombre_objeto_plural_primero_mayus  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            @foreach( $columnas_escructura as $nombre_columna => $columna)
                                <th>{{ strtoupper("$nombre_columna") }}</th>
                            @endforeach
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "ELIMINAR"  }}</th>
                         </tr>
                        </thead>
                        <tbody>
                        @foreach( $arreglo_principal_objetos AS $objeto)
                        <tr>
                            @foreach( $objeto as $valor ) 
                                <td>{{ $valor }}</td>
                            @endforeach
                                <td>
                                    <a href="/admin_{{$nombre_objeto_plural}}/modificar/{{$objeto->id}}" class="btn btn-block btn-success"><span class="fa fa-pencil"></span> {{ "Modificar"  }}</a>
                                </td>
                                <td>
                                    {!!  Form::open(array(
                                                            'url'                   =>  "/admin_$nombre_objeto_plural/borrar/".$objeto->id,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Eliminar $nombre_objeto_primero_mayus",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea eliminar el $nombre_objeto $objeto->id ? Esta acción no puede ser revertida.",
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
                            @foreach( $columnas_escructura as $nombre_columna => $columna)
                                <th>{{ strtoupper("$nombre_columna")  }}</th>
                            @endforeach
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
            $(".anadir_{{ $nombre_objeto }}").click(function(e){
                $( ".nuevoUsuarioFormulario" ).toggle( "normal", function() {
                    // Animation complete.
                });
                e.preventDefault();
            });
        });

    </script>
@stop