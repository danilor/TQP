@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Modificar Contraseña"  }}
@stop
@section("contenido")

        <div class="row">
            @include("perfil.cuadros_informacion")
            <div class="col-md-9">

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
                        <h3 class="box-title">{{ "Contraseña"  }}</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(array('url' => '/perfil/salvar_contrasena','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}

                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Contraseña"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::password("contrasena",  array('id'=>"contrasena",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Confirmar"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::password("contrasena_confirmation", array('id'=>"contrasena_confirmation",'class'=>'form-control','required'=>'required',"equalTo"=>'#contrasena')) !!}
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">{{ "Cambiar Contraseña"  }}</button>
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}
                </div><!-- /.box -->

            </div>
        </div>
    @stop