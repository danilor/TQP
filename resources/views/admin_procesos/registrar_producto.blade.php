@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Registrar Producto de Proceso" }}
@stop

@section("contenido")

    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ "A continuación está registrando un nuevo producto que viene de un proceso" }}
            </div>
        </div>
    </div>

    {!! Form::open(array('url' => '/admin_procesos/salvar_producto','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}
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
                    <h3 class="box-title">{{ "Registrar Producto"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Proveedor"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="proveedor" id="proveedor" required="required" class="form-control">
                                <option value="">{{"Por favor seleccione un proveedor"}}</option>
                                @foreach(\Tiqueso\proveedor::all('codigo','nombre') AS $proveedor )
                                    <option value="{{$proveedor->codigo}}">[{{$proveedor->codigo}}] {{ $proveedor->nombre  }}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Tipo de Producto"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="tipo_producto" id="tipo_producto" required="required" class="form-control">
                                <option value="">{{"Por favor seleccione un tipo de producto"}}</option>
                                @foreach(\Tiqueso\tipo_producto::all('codigo','nombre') AS $producto)
                                    <option value="{{$producto->codigo}}">[{{$producto->codigo}}] {{ $producto->nombre  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Tanda"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::input("number","tanda", old('tanda'), array('placeholder'=>"Tanda",'class'=>'form-control','required'=>'required','id'=>'tanda')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Vencimiento"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("vencimiento", old('vencimiento'), array('placeholder'=>"Vencimiento",'class'=>'form-control datepicker','required'=>'required','id'=>'vencimiento')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Unidades"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::input("number","unidades", old('unidades'), array('placeholder'=>"Unidades",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Humedad"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::input("number","humedad", old('humedad'), array('placeholder'=>"Humedad",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Detalle"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalle", old('detalle'), array('placeholder'=>"Detalle",'class'=>'form-control')) !!}
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
                    <center>
                        <div class="thumbnail" style="width: 190px; height: 190px;">
                            <img id="imagen_tipo_producto" src="{{ Config::get("archivos.imagen_predeterminado")  }}" alt="" />
                        </div>
                        <div>
                            <h3>{{"Código Resultante"}}</h3>
                            <h1 id="codigo_final"></h1>
                            <img id="barcode"/>
                        </div>
                    </center>
                </div><!-- /.box-body -->

            </div><!-- /.box -->

            <!-- About Me Box -->

        </div><!-- /.col -->



    </div>
    {!! Form::close() !!}
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        var tipo_producto_foto_base = '/general/foto_tipo_producto/[CODIGO]?w=190&h=190&type=fit'; // Esta es la URL básica para las imágenes de los tipos de productos
        var imagen_predeteminada = '{{ Config::get("archivos.imagen_predeterminado")  }}';
        var dia_juliano = '{{ str_pad(date('z'),3,'0',STR_PAD_LEFT)  }}';
        //A continuación van todas las fechas de vencimiento dependiendo de cada tipo de producto
        @foreach(\Tiqueso\tipo_producto::all('codigo','vida_util') AS $tipo_producto)
        var vida_util_{{$tipo_producto->codigo}} = {{ $tipo_producto->vida_util  }};
        @endforeach
        $( document).ready(function(){
            $('#tipo_producto').change(function(){
                obtener_informacion_producto();
                cambiar_informacion_codigo();
                establecer_codigo_final();
            });
            $('#tanda').change(function(){
                obtener_informacion_producto();
                cambiar_informacion_codigo();
                establecer_codigo_final();
            });
            $('#proveedor').change(function(){
                cambiar_informacion_codigo();
                establecer_codigo_final();
            });
            establecer_codigo_final();
        });
        function obtener_informacion_producto(){
            //Queremos primero cambiar la fotografía
            var codigo_tipo_producto = $('#tipo_producto').val();
            if(codigo_tipo_producto != ''){
                var aux = tipo_producto_foto_base.replace('[CODIGO]',codigo_tipo_producto); //Si es un código correcto, cambiamos la imagen
                $('#imagen_tipo_producto').attr('src',aux);
            }else{
                $('#imagen_tipo_producto').attr('src',imagen_predeteminada); //Si el codigo no existe, ponemos la imagen predeterminada
            }
        }
        function cambiar_informacion_codigo(){
            //La primera parte es solamente para poner la tanda si es que no existe
            var tanda = $("#tanda").val();
            if(tanda == ''){
                $("#tanda").val(1);
            }
            //Ahora se configura la fecha
            var codigo_tipo_producto = $('#tipo_producto').val();
            try{
                var vencimiento_tentativa = eval('vida_util_' + codigo_tipo_producto);
            }catch (err){
                return; //Todavía no se ha seleccionado un producto para ver la vida útil
            }
            if(vencimiento_tentativa != 'undefined'){
                if(parseInt(vencimiento_tentativa) == -1){
                    vencimiento_tentativa = 0;
                }
                fecha_nueva = new Date();
                fecha_futura = new Date();
                fecha_futura.setDate(fecha_nueva.getDate() + parseInt(vencimiento_tentativa));
                var dd = fecha_futura.getDate();
                var mm = fecha_futura.getMonth() + 1;
                var y = fecha_futura.getFullYear();
                $("#vencimiento").val(padDigits(dd, 2)+'/'+padDigits(mm, 2)+'/'+padDigits(y, 2));
            }
        }
        function establecer_codigo_final(){

            var tipo_producto = $('#tipo_producto').val();
            var proveedor = $('#proveedor').val();
            var tanda = $('#tanda').val();
            if(tipo_producto == "" ){ tipo_producto = "XX"; }
            if(proveedor == "" ){ proveedor = "YY"; }
            if(tanda == "" ){ tanda = "Z"; }

            var codigo = tipo_producto + proveedor + dia_juliano + tanda;
            $("#codigo_final").html(codigo);
            $("#barcode").JsBarcode(codigo);
        }
    </script>
@stop