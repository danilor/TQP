@extends("plantillas.admin")

@section("nombre_pagina")
        {{ "Modificar Tipo de Producto" }}
        [{{ $pt->nombre  }}]
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_productos/salvar_tipo_producto','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <input type="hidden" name="codigo" value="{{ @$pt->codigo}}" />
    <div class="row">
        <div class="col-md-8 col-xs-12 col-lg-8">

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
                    <h3 class="box-title">{{ "Modificar Tipo"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Código"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("codigo", @$pt->codigo, array('placeholder'=>"Código",'class'=>'form-control tipso','required'=>'required','readonly'=>'readonly','title'=>'Este dato no es modificable')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", @$pt->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Unidad"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("unidad", @$pt->unidad, array('placeholder'=>"Unidad (Refiérase a Kilogramos, gramos, unidades)",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Vida útil (días)"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::input("number","vida_util", @$pt->vida_util, array('placeholder'=>"Vida Útil (días)",'class'=>'form-control tipso','required'=>'required','title'=>'Indique el valor de -1 para casos donde la vida útil está determinada por el proveedor')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Presentación"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::text("presentacion", @$pt->presentacion, array('placeholder'=>"Presentación",'class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Detalle"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalle", @$pt->detalle, array('placeholder'=>"Detalle",'class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Características"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("caracteristicas", @$pt->caracteristicas, array('placeholder'=>"Características",'class'=>'form-control summernote','id'=>'caracteristicas')) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->



                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </div>



        <div class="col-md-4 col-xs-12 col-lg-4">

            <!-- Profile Image -->
            <div class="box box-info">
                <div class="box-body">


                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="{{ @$pt->obtenerFotoEspecial()  }}" alt="" />
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
                        <label for="" class="col-sm-12 ">{{ "Opciones"  }} </label>
                            <div class="col-xs-12">
                                <input value="{{ "y"  }}"  @if(  (int)@$pt->mostrar == 1  ) checked="checked"  @endif id="mostrar" class="checkbox-custom" name="mostrar" type="checkbox">
                                <label for="mostrar" class="checkbox-custom-label">{{"Mostrar Producto en la página principal"}}</label>
                            </div>
                    </div>


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