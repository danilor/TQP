@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Modificar Información Básica"  }}
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

                    {!! Form::open(array('url' => '/perfil/salvar_informacion_basica','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ "Información Básica"  }}</h3>
                        <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                    </div><!-- /.box-header -->
                    <!-- form start -->


                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Cédula"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text("cedula", $usuario->cedula, array('placeholder'=>"Cédula",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text("nombre", $usuario->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Apellido"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text("apellido", $usuario->apellido, array('placeholder'=>"Apellido",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Correo"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::email("correo", $usuario->correo, array('placeholder'=>"Correo",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Conocido como"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("apodo", $usuario->apodo, array('placeholder'=>"Apodo",'class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Sexo"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!!  Form::select('sexo', array('M' => 'Masculino', 'F' => 'Femenino', 'O' => 'No Indica'), $usuario->sexo,array("required"=>'required',"class"=>"form-control"))  !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Dirección"  }} <span>*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text("direccion", $usuario->direccion, array('placeholder'=>"Dirección",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">{{ "Dirección 2"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("direccion2", $usuario->direccion2, array('placeholder'=>"Dirección",'class'=>'form-control')) !!}
                                </div>
                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                        </div><!-- /.box-footer -->

                </div><!-- /.box -->
                    {!! Form::close() !!}

            </div>
        </div>
    @stop