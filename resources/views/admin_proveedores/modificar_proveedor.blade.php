@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Modificar Proveedor" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_proveedores/salvar_informacion_de_proveedor','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}

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
                    <h3 class="box-title">{{ "Información de Proveedor"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::hidden("codigo_original", $p->codigo, array('placeholder'=>"Código",'class'=>'form-control','required'=>'required','maxlength'=>'2')) !!}

                <div class="box-body">
                    <div class="form-group">
                        <label for="codigo" class="col-sm-2 control-label">{{ "Código"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("codigo", $p->codigo, array('placeholder'=>"Código",'class'=>'form-control','required'=>'required','maxlength'=>'2','id'=>'codigo')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", $p->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required','maxlength'=>'255','id'=>'nombre')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Correo"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::email("correo", $p->correo, array('placeholder'=>"Correo",'class'=>'form-control')) !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Dirección"  }} </label>
                        <div class="col-sm-10">
                            {!! Form::textarea("direccion", $p->direccion, array('placeholder'=>"Dirección",'class'=>'form-control','maxlength'=>'500')) !!}
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Detalle"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalle", $p->detalle, array('placeholder'=>"Detalle",'class'=>'form-control','maxlength'=>'255')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Teléfono"  }} </label>
                        <div class="col-sm-10">
                            {!! Form::text("telefono", $p->telefono, array('placeholder'=>"Teléfono",'class'=>'form-control','maxlength'=>'10')) !!}
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