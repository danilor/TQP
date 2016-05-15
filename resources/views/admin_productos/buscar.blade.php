@extends("plantillas.admin")

@section("nombre_pagina")
        {{ "Buscar Producto" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_productos/buscar','class'=>'form-horizontal requiereValidacion','method'=>'get')) !!}

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
                    <h3 class="box-title">{{ "Buscar producto por código"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Buscar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Código"  }} <span>*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text("codigo", Input::get('codigo'), array('placeholder'=>"Código",'class'=>'form-control tipso','required'=>'required','title'=>'Introduzca un código o parte de él para buscar. Esto incluirá productos borrados, inactivos y en el historial.')) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->



                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Buscar"  }}</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </div>

        @if(Input::get('codigo') != "")
        <div class="col-md-12 col-xs-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Resultados"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                        <tbody>
                        @if(count($productos)>0)
                            <table id="example1" class="table table-bordered table-striped tabla_completa">
                                <thead>
                                <tr>
                                    <th>{{ "CÓDIGO"  }}</th>
                                    <th>{{ "PROVEEDOR"  }}</th>
                                    <th>{{ "VENCIMIENTO"  }}</th>
                                    <th>{{ "ACTIVO"  }}</th>
                                    <th>{{ "BORRADO"  }}</th>
                                    <th>{{ "PRODUCTO TIQUESO"  }}</th>
                                </tr>
                                </thead>
                            @foreach($productos AS $c)
                                <tr>
                                    <td><a href="/admin_productos/ficha_producto/{{ $c->codigo  }}">{{ $c->codigo  }}</a></td>

                                    <td>
                                        {{$c->nombre_proveedor}}
                                    </td>
                                    <td>
                                        {{ date(config('region.formato_fecha'),strtotime($c->vencimiento))  }}
                                    </td>
                                    <td>
                                        @if((int)$c->estado == 1)
                                                <center>
                                                    <i style="color:green;" class="fa fa-check fa-lg"></i>
                                                </center>
                                        @endif
                                    </td>
                                    <td>
                                        @if((int)$c->borrado == 1)
                                            <center>
                                                <i style="color:green;" class="fa fa-check fa-lg"></i>
                                            </center>
                                        @endif
                                    </td>
                                    <td>
                                        @if((int)$c->producto_tiqueso == 1)
                                            <center>
                                                <i style="color:green;" class="fa fa-check fa-lg"></i>
                                            </center>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>{{ "CÓDIGO"  }}</th>
                                        <th>{{ "PROVEEDOR"  }}</th>
                                        <th>{{ "VENCIMIENTO"  }}</th>
                                        <th>{{ "ACTIVO"  }}</th>
                                        <th>{{ "BORRADO"  }}</th>
                                        <th>{{ "PRODUCTO TIQUESO"  }}</th>
                                    </tr>
                                    </tfoot>
                            </table>
                        @else
                            <center>
                               {{"Sin resultados"}}
                            </center>
                        @endif

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        @endif


    </div>
    {!! Form::close() !!}
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $( document).ready(function(){

        });
    </script>
@stop