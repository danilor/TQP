@extends("plantillas.admin")

@section("nombre_pagina")
        {{ "Subir nuevo Banner" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_contenidos/subir_banner','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
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
                    <h3 class="box-title">{{ "Subir Nuevo Banner"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 600px; height: 150px;">
                            <img src="{{config('archivos.imagen_predeterminado')}}" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 600px; max-height: 150px; line-height: 20px;"></div>
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