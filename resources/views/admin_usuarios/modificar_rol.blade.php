@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Modificar Rol" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_usuarios/salvar_rol','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}
    <input type="hidden" name="id" value="{{$r->id}}" />
    <div class="row">
        <div class="col-md-8">

            @foreach ($errors->all() as $message)
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ $message }}
                </div>
            @endforeach


            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Información del Rol"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", $r->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Permisos"  }}</label>
                        <div class="col-sm-10">
                            @foreach( \App\clases\Comunes::getListaPermisosSelect() AS $key => $value )
                                <div>
                                    <input value="{{ $key  }}"  @if( in_array($key,$r->obtenerPermisos_Array()) ) checked="checked"  @endif id="checkbox-{{ $key }}" class="checkbox-custom" name="permisos[]" type="checkbox">
                                    <label for="checkbox-{{ $key }}" class="checkbox-custom-label">{{$value}}</label>
                                </div>
                            @endforeach

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
@stop

@section("extra_js")
    @include("componentes.selectpicker")
    <link href="/js/assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
    <script type="text/javascript" src="/js/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript">
        $( document).ready(function(){

        });
    </script>
@stop