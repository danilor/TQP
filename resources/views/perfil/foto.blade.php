@extends("plantillas.perfil")
@section("nombre_pagina")
    {{ "Modificar Fotografía"  }}
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
                    {!! Form::open(array('url' => '/perfil/salvar_fotografia','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}

                        <div class="box-body">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="/img/noimage.png" alt="" />
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
                            </div>
                            <span class="label label-danger">{{ "Nota!"  }}</span>
                                             <span>
                                             {{ "Máximo de tamaño 3Mb. Se aceptan imágenes con formato JPG, JPEG, GIF y PNG"  }}
                                             </span>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">{{ "Actualizar Fotografía"  }}</button>
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}
                </div><!-- /.box -->

            </div>
        </div>

</div>
    @stop

@section("extra_js")

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