@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Modificar Información Básica"  }}
@stop
@section("contenido")

        <div class="row">
            @include("perfil.cuadros_informacion")
            <div class="col-md-9">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ "Información Básica"  }}</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::open(array('url' => '/perfil/informacion_basica','class'=>'form-horizontal','method'=>'post')) !!}

                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">{{ "Cédula"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("cedula", $usuario->cedula, array('placeholder'=>"Cédula",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">{{ "Nombre"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("nombre", $usuario->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">{{ "Apellido"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("apellido", $usuario->apellido, array('placeholder'=>"Apellido",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">{{ "Correo"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::email("correo", $usuario->correo, array('placeholder'=>"Correo",'class'=>'form-control','required'=>'required')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">{{ "Conocido como"  }}</label>
                                <div class="col-sm-10">
                                    {!! Form::text("apodo", $usuario->apodo, array('placeholder'=>"Apodo",'class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">{{ "Sexo"  }}</label>
                                <div class="col-sm-10">
                                    {!!  Form::select('sexo', array('M' => 'Masculino', 'F' => 'Femenino', 'O' => 'No Indica'), $usuario->sexo,array("required"=>'required',"class"=>"form-control"))  !!}
                                </div>
                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}
                </div><!-- /.box -->

            </div>
        </div>
    @stop