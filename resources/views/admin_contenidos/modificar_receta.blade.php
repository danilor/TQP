@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Modificar Receta" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_contenidos/salvar_receta','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <input type="hidden" name="id" value="{{@$r->id}}" />
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
                    <h3 class="box-title">{{ "Receta"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", @$r->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Receta"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("receta", @$r->contenido, array('placeholder'=>"Receta",'class'=>'form-control summernote','cols'=>'800','rows'=>'100')) !!}
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
                    <div class="form-group">
                        <label for="" class="col-sm-12 ">{{ "Productos Relacionados"  }} </label>
                        @foreach( \Tiqueso\tipo_producto::where('mostrar',1)->get() AS $value )
                            <div class="col-xs-12">
                                <input value="{{ $value->codigo  }}" @if(isset($$r) && $r->tieneProducto($value->codigo)) checked="checked" @endif id="checkbox-{{ $value->codigo }}" class="checkbox-custom" name="productos_asignados[]" type="checkbox">
                                <label for="checkbox-{{ $value->codigo }}" class="checkbox-custom-label">[{{$value->codigo}}] {{$value->nombre}}</label>
                            </div>
                        @endforeach

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