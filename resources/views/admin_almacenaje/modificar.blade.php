@extends("plantillas.admin")

@section("nombre_pagina")
        {{ "Modificar Centro de Almacenaje" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_almacenaje/salvar_almacenaje','class'=>'form-horizontal requiereValidacion','method'=>'post',"files"=>true,"file"=>true)) !!}
    <input type="hidden" name="id" value="{{ @$almacenaje->id  }}" />
    <input type="hidden" name="codigo" value="{{ @$almacenaje->codigo}}" />
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
                    <h3 class="box-title">{{ "Centro de Almacenaje"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Nombre"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("nombre", @$almacenaje->nombre, array('placeholder'=>"Nombre",'class'=>'form-control','required'=>'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Ubicación"  }} </label>
                        <div class="col-sm-10">
                            {!! Form::text("ubicacion", @$almacenaje->ubicacion, array('placeholder'=>"Ubicación",'class'=>'form-control',)) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Temperatura"  }} </label>
                        <div class="col-sm-10">
                            {!! Form::input("number","temperatura", @$almacenaje->temperatura, array('placeholder'=>"Temperatura",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Tipo"  }} {{@$almacenaje->tipo}}</label>
                        <div class="col-sm-10">
                            {!! Form::select("tipo", ['0'=>'Estático','1'=>'Vehículo'] , @$almacenaje->tipo, array('placeholder'=>"Tipo",'class'=>'form-control','id'=>'tipo_centro')) !!}
                        </div>
                    </div>

                    <div class="form-group grupoMovil">
                        <label for="" class="col-sm-2 control-label">{{ "Placa"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::text("placa", @$almacenaje->placa, array('placeholder'=>"Placa",'class'=>'form-control')) !!}
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
    <script type="text/javascript">
        $( document).ready(function(){

            $('#tipo_centro').change(function(e){
                cambiarCentroTipo();
            });
            cambiarCentroTipo();
        });

        function cambiarCentroTipo(){

            var tipo = $('#tipo_centro').val();
            if(tipo == "1"){
                $('.grupoMovil').fadeIn();
            }else{
                $('.grupoMovil').fadeOut();
            }
        }
    </script>

@stop