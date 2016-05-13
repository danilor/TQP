@extends("plantillas.admin")
@section("nombre_pagina")
    {{ "Reportes - Correo" }}
@stop

@section("contenido")
    {!! Form::open(array('url' => '/admin_reportes/correos','class'=>'form-horizontal requiereValidacion','method'=>'get')) !!}
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
                    <h3 class="box-title">{{ "Reporte - Correo"  }}</h3> <button type="submit" class="btn btn-info pull-right">{{ "Buscar"  }}</button>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">


                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Término a buscar"  }}</label>
                        <div class="col-sm-10">
                            {!! Form::text("termino", $termino, array('placeholder'=>"Término",'class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ "Fechas"  }}</label>
                        <div class="col-sm-5">
                            {!! Form::text("fechainicio", $fecha_inicial->format(config('region.formato_fecha')), array('placeholder'=>"Fecha Inicio",'class'=>'form-control datepicker','id'=>'fechainicio')) !!}
                        </div>

                        <div class="col-sm-5">
                            {!! Form::text("fechafin", $fecha_final->format(config('region.formato_fecha')), array('placeholder'=>"Fecha Fin",'class'=>'form-control datepicker','id'=>'fechafin')) !!}
                        </div>
                    </div>



                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{ "Buscar"  }}</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->
        </div>



    </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Registro de Correos"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "TEMA"  }}</th>
                            <th>{{ "PLANTILLA"  }}</th>
                            <th>{{ "PARA"  }}</th>
                            <th>{{ "CREADO"  }}</th>
                            <th>{{ "ENVIADO"  }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($correos AS $c)
                            <tr>
                                <td>
                                    {{$c->tema}}
                                </td>
                                <td>
                                    {{$c->plantilla}}
                                </td>
                                <td>
                                    {{$c->para_nombre}}<br />
                                    {{$c->para_correo}}
                                </td>
                                <td>
                                    {{$c->created_at}}
                                </td>
                                <td>
                                    @if((int)$c->estado == 1)
                                        <center><i class="fa fa-check-circle-o fa-2x" style="color:green;"></i></center>
                                        @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "TEMA"  }}</th>
                            <th>{{ "PLANTILLA"  }}</th>
                            <th>{{ "PARA"  }}</th>
                            <th>{{ "CREADO"  }}</th>
                            <th>{{ "ENVIADO"  }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div><!-- /.row -->
    </div>
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $( document).ready(function(){

        });
    </script>
@stop