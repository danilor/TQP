
@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Modificar $nombre_objeto_primero_mayus" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => "/admin_$nombre_objeto_plural/salvar_informacion",'class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}

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
                    <h3 class="box-title">{{ "Información de $nombre_objeto_primero_mayus"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                @foreach( $columnas_escructura as $nombre_columna => $columna)
                        <?php 
                        $notNull = $columna->getNotnull(); $max_length = $columna->getLength(); 
                        ?> 
                    @if( $nombre_columna == $objeto->getKeyName() )   
                        <div class="form-group">
                            <label for={{"$nombre_columna"}} class="col-sm-2 control-label">{{ "$nombre_columna"  }}<span>*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text($nombre_columna, $objeto->$nombre_columna, array('placeholder'=>"$nombre_columna",'class'=>'form-control','maxlength'=>$max_length,'id'=>$nombre_columna,"readonly" )) !!}
                            </div>
                        </div>
                    @endif
                    @if( $columna->getType() != "DateTime"  and   ($nombre_columna != "id" and "codigo") )
                        <div class="form-group">
                            <label for={{"$nombre_columna"}} class="col-sm-2 control-label">{{ "$nombre_columna"  }} @if( $notNull )<span>*</span>@endif</label>
                            <div class="col-sm-10">
                                @if( $notNull )
                                    {!! Form::text($nombre_columna, $objeto->$nombre_columna, array('placeholder'=>"$nombre_columna",'class'=>'form-control','required'=>"required",'maxlength'=>$max_length,'id'=>$nombre_columna )) !!}
                                @else
                                    {!! Form::text($nombre_columna, $objeto->$nombre_columna, array('placeholder'=>"$nombre_columna",'class'=>'form-control','maxlength'=>$max_length,'id'=>$nombre_columna )) !!}
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
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