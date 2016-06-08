@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Iniciar Proceso" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_procesos/salvar_proceso','class'=>'form-horizontal requiereValidacion','method'=>'post')) !!}
    <div class="row">

        <div class="col-xs-12">
            <div class="alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ "Por favor seleccione los productos que va a introducir al proceso. Puede realizar búsquedas por código de producto si lo necesita." }}
            </div>

            <div class="alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ "Cualquiera de los botones de 'Salvar' almacenan el mismo proceso." }}
            </div>
        </div>

        <div class="col-md-9 col-xs-12 col-lg-9">

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
                    <h3 class="box-title">{{ "Iniciar Proceso"  }}</h3>  <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button> <button type="submit" style="margin-right:10px;" class="reiniciar btn btn-warning pull-right">{{ "Reiniciar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">


                        <label class="col-sm-2 control-label">
                            {{ "Selección de productos"  }}
                        </label>
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped tabla_completa">
                                    <thead>
                                    <tr>
                                        <th>{{ "CÓDIGO"  }}</th>
                                        <th>{{ "TIPO" }}</th>
                                        <th>{{ "UNIDADES DISPONIBLES" }}</th>
                                        <th>{{ "PROVEEDOR"  }}</th>
                                        <th>{{ "VENCIMIENTO"  }}</th>
                                        <th>{{ "ACCIÓN"  }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productos AS $c)
                                        <tr class="producto_{{$c->codigo}}" codigo="{{$c->codigo}}" nombre="{{$c->nombre_tipo}}">
                                            <td>{{ $c->codigo  }}</td>
                                            <td>{{ $c->nombre_tipo }}</td>
                                            <td>{{ number_format((float)$c->unidades,2) }}</td>
                                            <td>
                                                {{$c->nombre_proveedor}}
                                            </td>
                                            <td>
                                                {{ date(config('region.formato_fecha'),strtotime($c->vencimiento))  }}
                                            </td>
                                            <td>
                                                <input type="number" class="form-control cantidad_anadir" value="{{ (float)$c->unidades  }}" max="{{ (float)$c->unidades  }}" min="0" style="width: 80px;"   />

                                                <button class="btn btn-success anadir_producto"><i class="fa fa-plus-circle"></i> {{ "Añadir" }}</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>{{ "CÓDIGO"  }}</th>
                                        <th>{{ "TIPO" }}</th>
                                        <th>{{ "UNIDADES DISPONIBLES" }}</th>
                                        <th>{{ "PROVEEDOR"  }}</th>
                                        <th>{{ "VENCIMIENTO"  }}</th>
                                        <th>{{ "ACCIÓN"  }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
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

        <div class="col-md-3 col-xs-12 col-lg-3">
            <!-- Profile Image -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Productos Asignados"  }}</h3><button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <div class="box-body">


                    <table id="asignados" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{"Código"}}</th>
                                <th>{{"Tipo"}}</th>
                                <th>{{"Cantidad"}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->


            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ "Usuarios Participantes"  }}</h3><button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-header -->
                <div class="box-body">


                    <table id="asignados" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{"Usuario"}}</th>
                            <th>{{"Correo"}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach(\Tiqueso\usuario::where('activo',1)->orderBy('nombre','ASC')->get() AS $usuario)
                                <tr>
                                    <td>
                                        <input value="{{ $usuario->id  }}"  id="checkbox-{{ $usuario->id }}" class="checkbox-custom" name="usuarios[]" type="checkbox">
                                        <label for="checkbox-{{ $usuario->id }}" class="checkbox-custom-label"></label>
                                    </td>
                                    <td>
                                        {{ $usuario->obtenerNombreCompleto() }}
                                    </td>
                                    <td>
                                        {{$usuario->correo}}
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->


            <!-- About Me Box -->

        </div><!-- /.col -->



    </div>
    {!! Form::close() !!}
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $( document).ready(function(){
            anadir_producto_bind();
        });

        function anadir_producto_bind(){
            var table = $('#example1').DataTable();
            $(".anadir_producto").click(function(e){
                var codigo = $(this).closest('tr').attr('codigo');
                var nombre = $(this).closest('tr').attr('nombre');
                var cantidad = $(this).closest('tr').find(".cantidad_anadir").val();
                table.row( $(this).parents('tr') ).remove().draw();
                asignar_producto(codigo,nombre,cantidad);
                e.preventDefault();
            });

            $('.reiniciar').click(function(e){
                location.href='?';
                e.preventDefault();
            });
        }

        function asignar_producto(codigo,nombre,cantidad){
            $("#asignados").find('tbody')
                    .append($('<tr>')
                            .append($('<td>')
                                    .text(codigo).append($('<input>').attr('value',codigo).attr('name','productos[]').attr('type','hidden')).append($('<input>').attr('value',cantidad).attr('name','cantidades[]').attr('type','hidden'))
                            )
                            .append($('<td>')
                                    .text(nombre)
                            )
                            .append($('<td>')
                                    .text(cantidad)
                            )
                    );
        }

    </script>
@stop