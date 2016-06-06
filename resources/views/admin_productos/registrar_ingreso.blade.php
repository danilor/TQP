@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Registrar Ingreso de Productos" }}
@stop

@section("contenido")


    <div class="" id="contenido_row_table_dinamico" style="display: none;">
        <table id="tabla_oculta">
            <tr>
                <td>
                    <select name="tipo_producto[]" id="tipo_producto[]" required="required" class="form-control tipo_producto">
                        <option value="">{{"Por favor seleccione un tipo de producto"}}</option>
                        @foreach(\Tiqueso\tipo_producto::all('codigo','nombre') AS $producto)
                            <option value="{{$producto->codigo}}">[{{$producto->codigo}}] {{ $producto->nombre  }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    {!! Form::input("number","lote[]", null, array('placeholder'=>"Lote",'class'=>'form-control lote','required'=>'required')) !!}
                </td>
                <td>
                    {!! Form::text("vencimiento[]", null, array('placeholder'=>"Vencimiento",'class'=>'form-control datepicker vencimiento','required'=>'required')) !!}
                </td>
                <td>
                    {!! Form::input("number","unidades[]", null, array('placeholder'=>"Unidades",'class'=>'form-control unidades')) !!}
                </td>
                <td>
                    <a href="" class="borrar_linea_producto"><i class="fa fa-times icono_borrar"></i></a>
                </td>
            </tr>
        </table>
    </div>


    @if(count($registro->obtenerCampos()) > 0)
<?php
        // \App\clases\Comunes::pre_var_dump($registro->obtenerCampos())

        ?>
    @endif

    {!! Form::open(array('url' => '/admin_productos/salvar_ingreso','class'=>'form-horizontal requiereValidacion','method'=>'post','id'=>'registro_formulario')) !!}
    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12">

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
                    <h3 class="box-title">{{ "Registrar Ingreso de Proveedor"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Proveedor"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="proveedor" id="proveedor" required="required" class="form-control">
                                <option value="">{{"Por favor seleccione un proveedor"}}</option>
                                @foreach(\Tiqueso\proveedor::all('codigo','nombre') AS $proveedor )
                                    <option @if((int)$proveedor->codigo == (int)@$registro->proveedor) selected="selected"  @endif value="{{$proveedor->codigo}}">[{{$proveedor->codigo}}] {{ $proveedor->nombre  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"> <a title="{{ "Agregar nueva linea" }}" href="javascript:void(0);" class="" id="agregar_linea_producto"><i class="fa fa-plus"></i></a> {{ "Productos"  }} <span>*</span>

                        </label>
                        <div class="col-sm-10">

                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th>{{"Tipo de Producto"}}</th>
                                        <th>{{"Lote de Producto"}}</th>
                                        <th>{{"Vencimiento"}}</th>
                                        <th>{{"Unidades (Kg)"}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_productos_cuerpo">

                                </tbody>
                            </table>

                        </div>
                    </div>



                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Detalle"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::textarea("detalle", @$registro->detalle, array('placeholder'=>"Detalle",'class'=>'form-control','id'=>'detalle')) !!}
                        </div>
                    </div>
                </div>
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
    <script type="text/javascript">
        var tipo_producto_foto_base = '/general/foto_tipo_producto/[CODIGO]?w=190&h=190&type=fit'; // Esta es la URL básica para las imágenes de los tipos de productos
        var imagen_predeteminada = '{{ Config::get("archivos.imagen_predeterminado")  }}';
        var dia_juliano = '{{ str_pad(date('z'),3,'0',STR_PAD_LEFT)  }}';
        //A continuación van todas las fechas de vencimiento dependiendo de cada tipo de producto
        @foreach(\Tiqueso\tipo_producto::all('codigo','vida_util') AS $tipo_producto)
        var vida_util_{{$tipo_producto->codigo}} = {{ $tipo_producto->vida_util  }};
        @endforeach
        $( document).ready(function(){
            /*$('#tipo_producto').change(function(){
                enviarFormularioAutoSalvado();
                //obtener_informacion_producto();
                //cambiar_informacion_codigo();
                //establecer_codigo_final();
            });*/
            /*$('#tanda').change(function(){
                obtener_informacion_producto();
                cambiar_informacion_codigo();
                establecer_codigo_final();
            });
            $('#proveedor').change(function(){
                cambiar_informacion_codigo();
                establecer_codigo_final();
            });*/
            //establecer_codigo_final();
            $("#agregar_linea_producto").click(function(){
                agregar_linea_nueva();
            });

            $('#proveedor').change(function(){
                enviarFormularioAutoSalvado();
            });

            bind_borrar_linea();
            @if($registro->formulario == "")
                    agregar_linea_nueva();
            @endif

            @if(count($registro->obtenerCampos()) > 0)
                @if(count($registro->obtenerCampos()["tipo_producto"]) > 0 )
                    @foreach($registro->obtenerCampos()["tipo_producto"] AS $key => $value)
                        agregar_linea_nueva_sin_salvar();
                        $("#tabla_productos_cuerpo .tipo_producto").last().val('{{ $registro->obtenerCampos()["tipo_producto"][$key]  }}');
                        $("#tabla_productos_cuerpo .lote").last().val('{{ $registro->obtenerCampos()["lote"][$key]  }}');
                        $("#tabla_productos_cuerpo .vencimiento").last().val('{{ $registro->obtenerCampos()["vencimiento"][$key]  }}');
                        $("#tabla_productos_cuerpo .unidades").last().val('{{ $registro->obtenerCampos()["unidades"][$key]  }}');
                        //alert( $("#tabla_productos_cuerpo .tipo_producto").last().html() );
                    @endforeach
                @endif
            @endif
        });

        function bind_borrar_linea(){
            $(".borrar_linea_producto").click(function(e){
                $(this).closest("tr").remove();
                e.preventDefault();
                enviarFormularioAutoSalvado();
            });
        }

        function enviarFormularioAutoSalvado(){
            var url = '/admin_productos/registrar_ingreso_ajax/{{ $registro->id }}';
            $.post( url, $( "#registro_formulario" ).serialize() );

        }

        function agregar_linea_nueva(salvar){
            salvar = salvar || true;
            var contenido = $("#contenido_row_table_dinamico").find("#tabla_oculta").find("tbody").html();
            $("#tabla_productos_cuerpo").append(contenido);
            bind_borrar_linea();
            inicializarCalendar();
            if(salvar)enviarFormularioAutoSalvado();
        }
        function agregar_linea_nueva_sin_salvar(salvar){
            var contenido = $("#contenido_row_table_dinamico").find("#tabla_oculta").find("tbody").html();
            $("#tabla_productos_cuerpo").append(contenido);
            bind_borrar_linea();
            inicializarCalendar();
        }
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