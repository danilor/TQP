@extends("plantillas.admin")

@section("nombre_pagina")

    @if(@$pc->nombre != "")
        {{ "Modificar Categoría de Producto" }}
        [{{ $pc->nombre  }}]
        @else
        {{ "Añadir Categoría de Producto" }}
    @endif
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_productos/salvar_categoria_producto','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <input type="hidden" name="id" value="{{ @$pc->id}}" />
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
                    <h3 class="box-title">{{ "Modificar Categoría"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", @$pc->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Detalles"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalles", @$pc->detalles, array('placeholder'=>"Detalles",'class'=>'form-control')) !!}
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