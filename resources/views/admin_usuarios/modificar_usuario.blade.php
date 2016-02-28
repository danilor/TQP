@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Modificar Usuario" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_usuarios/salvar_informacion_de_usuario','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <input type="hidden" name="id" value="{{$u->id}}" />
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
                    <h3 class="box-title">{{ "Información de Usuario"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Cédula"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("cedula", $u->cedula, array('placeholder'=>"Cédula",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", $u->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Apellido"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("apellido", $u->apellido, array('placeholder'=>"Apellido",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Correo"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::email("correo", $u->correo, array('placeholder'=>"Correo",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Conocido como"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::text("apodo", $u->apodo, array('placeholder'=>"Apodo",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Sexo"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!!  Form::select('sexo', array('M' => 'Masculino', 'F' => 'Femenino', 'O' => 'No Indica'), $u->sexo,array("required"=>'required',"class"=>"form-control"))  !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Dirección"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("direccion", $u->direccion, array('placeholder'=>"Dirección",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Dirección 2"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::text("direccion2", $u->direccion2, array('placeholder'=>"Dirección",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Características"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("caracteristicas", $u->caracteristicas, array('placeholder'=>"Características",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Notas"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("notas", $u->notas, array('placeholder'=>"Notas",'class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Educación"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("educacion", $u->educacion, array('placeholder'=>"Educación",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Certificaciones"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("certificaciones", $u->certificaciones, array('placeholder'=>"Certificaciones",'class'=>'form-control')) !!}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </div>




        <div class="col-md-4">

            <!-- Profile Image -->
            <div class="box box-info">
                <div class="box-body">
                    <!--<p class="text-muted text-center">Software Engineer</p>-->

                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="{{ $u->obtenerFoto()  }}" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ "Seleccionar Imagen"  }}</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> {{ "Cambiar"  }}</span>
                                                   <input type="file" class="default" name="image" />
                                                   </span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> {{ "Remover"  }}</a>
                        </div>
                    </div>  <span class="label label-danger">{{ "Nota!"  }}</span>
                                             <span>
                                             {{ config("mensajes.maximo_foto")  }}
                                             </span>
                    <br />
                    <br />
                    <div class="form-group">
                        <label for="" class="col-sm-12 ">{{ "Roles"  }} </label>

                        @foreach( \App\clases\Comunes::getListaRolesSelect() AS $key => $value )
                            <div class="col-xs-12">
                                <input value="{{ $key  }}"  @if(  $u->estaAsignadoARol($key)  ) checked="checked"  @endif id="checkbox-{{ $key }}" class="checkbox-custom" name="roles[]" type="checkbox">
                                <label for="checkbox-{{ $key }}" class="checkbox-custom-label">{{$value}}</label>
                            </div>
                        @endforeach

                    </div>

                    @if(Auth::user()->esAdministrador())
                    <div class="form-group">
                        <label for="" class="col-sm-12 ">{{ "Administrador"  }} </label>
                            <div class="col-xs-12">
                                <input value="y"  @if(  $u->esAdministrador()  ) checked="checked"  @endif id="checkbox-{{ "administrador" }}" class="checkbox-custom" name="administrador" type="checkbox">                                <label for="checkbox-{{ "administrador" }}" class="checkbox-custom-label">{{ "Administrador del Sitio"  }}</label>
                            </div>

                    </div>
                        @endif
                </div><!-- /.box-body -->

            </div><!-- /.box -->

            <!-- About Me Box -->

        </div><!-- /.col -->
        
        
        
        
    </div>
    {!! Form::close() !!}
@stop

@section("extra_js")
    @include("componentes.datatable")
    <link href="/js/assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
    <script type="text/javascript" src="/js/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript">
        $( document).ready(function(){
            $(".thumbnail").click(function(){
                //$(".fileupload-new").trigger("click");
                $('input[type=file]').trigger('click');
            });
        });
    </script>


    <script type="text/javascript">
        $( document).ready(function(){
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imagen').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function(){
                readURL(this);
            });
        });
    </script>
@stop