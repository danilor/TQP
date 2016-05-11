@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Registrar Producto" }}
@stop
@section("contenido")
    {!! Form::open(array('url' => '/admin_productos/salvar_producto','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}
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
                        <label for="" class="col-sm-2 control-label">{{ "Tipo de Producto"  }} <span>*</span></label>
                        <script> var tipos_productos_vida = [];</script>
                        <div class="col-sm-10">
                            <select name="tipo_producto" id="tipo_producto" required="required" class="form-control">
                                <option value="">{{"Por favor seleccione un tipo de producto"}}</option>
                                @foreach( $tipos_productos AS $codigo => $tipo_producto )
                                    <option value="{{$codigo }}">[{{$codigo}}] {{ $tipo_producto["nombre"]  }}</option>
                                    <script>tipos_productos_vida["<?php echo $codigo; ?>"] = "<?php echo $tipo_producto["vida_util"]; ?>"; </script>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Proveedor"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="proveedor" id="proveedor" required="required" class="form-control">
                                <option value="">{{"Por favor seleccione un proveedor"}}</option>
                                @foreach( $proveedores AS $proveedor )
                                    <option value="{{$proveedor->codigo}}">[{{$proveedor->codigo}}] {{ $proveedor->nombre  }}</option>
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
                            {!! Form::textarea("detalle", @$pt->detalle, array('placeholder'=>"Detalle",'class'=>'form-control')) !!}
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
        //Inicio Codigo Marvin
        var dia_juliano = '{{ str_pad(date('z'),3,'0',STR_PAD_LEFT)  }}';
        var tipo_producto_foto_base = '/general/foto_tipo_producto/[CODIGO]?w=190&h=190&type=fit'; // Esta es la URL básica para las imágenes de los tipos de productos
        var imagen_predeteminada = '{{ Config::get("archivos.imagen_predeterminado")  }}';
        
        function establecer_codigo_final(){ 
            var tipo_producto;
            var proveedor;
            var tanda ;
            if( $("#tipo_producto").val() !== ""){
                tipo_producto = $('#tipo_producto').val();
            }
            else{
                tipo_producto ="XX";
            }            
            if( $("#proveedor").val() !== ""){
                proveedor = $('#proveedor').val();
            }
            else{
                proveedor ="YY";
            }            
            if( $("#tanda").val() !== ""){
                tanda=$("#tanda").val();
            }
            else{
                tanda = "W";
            }
            
            var codigo = tipo_producto + proveedor + dia_juliano + tanda;
            $("#codigo_final").html(codigo);// Coloca el nuevo codigo
            $("#barcode").JsBarcode(codigo);// Cambia la barra
        }
        
        function cambiar_fecha_vencimiento_futuro( codigo){
            var vencimiento = sumar_fecha( tipos_productos_vida[ codigo] )  ;
            $("#vencimiento").val( vencimiento );
        }
        
        function sumar_fecha(d, fecha) // suma al dia de hoy los dias especificados
        {
         var Fecha = new Date();
         var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
         var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
         var aFecha = sFecha.split(sep);
         var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
         fecha= new Date(fecha);
         fecha.setDate(fecha.getDate()+parseInt(d));
         var anno=fecha.getFullYear();
         var mes= fecha.getMonth()+1;
         var dia= fecha.getDate();
         mes = (mes < 10) ? ("0" + mes) : mes;
         dia = (dia < 10) ? ("0" + dia) : dia;
         var fechaFinal = dia+sep+mes+sep+anno;
         return (fechaFinal);
         }
        
        $( document).ready(function(){
            
            establecer_codigo_final();
            $('#tipo_producto').change( function(){ // Cuando el evento cambio ocurra  establecer codigo final
                establecer_codigo_final();
                if( $(this).val() !== ""){ // Asignar fecha de vencimiento si  tipo de producto tiene  un valor
                    cambiar_fecha_vencimiento_futuro(  $(this).val() );
                    var aux = tipo_producto_foto_base.replace('[CODIGO]',$(this).val() ); //Si es un código correcto, cambiamos la imagen
                    $('#imagen_tipo_producto').attr('src',aux); 
                }else{
                    $("#vencimiento").val();
                    $('#imagen_tipo_producto').attr('src',imagen_predeteminada);
                }
   
            });
            $('#proveedor').change(function(){ // Cuando el evento "cambio" ocurra  establecer codigo final
                establecer_codigo_final();
            });
            
            $('#tanda').change(function(){ // Cuando el evento "cambio" ocurra  establecer codigo final
                establecer_codigo_final();
            });
            
        }); // final de función de documento listo
        //Fin codigo Marvin*/
        //Inicio Danilo codigo
        /*
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

            // Ahora modificamos el dato de la vida útil

        }

        function cambiar_informacion_codigo(){
            //La primera parte es solamente para poner la tanda si es que no existe
            var tanda = $("#tanda").val();
            if(tanda == ''){
                $("#tanda").val(1);
            }
            //Ahora se configura la fecha
            var codigo_tipo_producto = $('#tipo_producto').val();
            var vencimiento_tentativa = eval('vida_util_' + codigo_tipo_producto);
            if(vencimiento_tentativa != 'undefined'){
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
            var codigo = $('#tipo_producto').val() + $('#proveedor').val() + dia_juliano + $("#tanda").val();
            $("#codigo_final").html(codigo);
            $("#barcode").JsBarcode(codigo);

        }
*/
    </script>
@stop