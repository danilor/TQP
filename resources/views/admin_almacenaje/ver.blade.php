@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Centros de Almacenaje" }}
@stop
@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirTipo"><i class="fa fa-plus"></i> {{ "Añadir un centro de Almacenaje"  }}</button></li>
    </ol>
@stop
@section("contenido")

    <div class="row formOverTable">
        <div class="col-xs-12">
            @foreach ($errors->all() as $message)
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ $message }}
                </div>
            @endforeach
            <div class="alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ "La temperatura en los centros de almacenaje es solo por referencia" }}
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ "Centros de Almacenaje"  }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped tabla_completa">
                        <thead>
                        <tr>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "UBICACIÓN"  }}</th>
                            <th>{{ "VEHÍCULO"  }}</th>
                            <th>{{ "PLACA"  }}</th>
                            <th>{{ "TEMPERATURA"  }}</th>
                            <th>{{ "PRINCIPAL"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "BORRAR"  }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\Tiqueso\almacenaje::where('estado',1)->where('borrado',0)->get() AS $a)
                            <tr>
                                <td><a href="/admin_almacenaje/salvar_almacenaje/{{ $a->id  }}">{{ $a->nombre  }}</a></td>
                                <td>
                                    {{ $a->ubicacion  }}
                                </td>
                                <td>
                                    @if((int)$a->tipo == 1)
                                        <center>
                                        <i style="color:green;" class="fa fa-check fa-xl"></i>
                                        </center>
                                    @endif
                                </td>
                                <td>
                                    {{$a->placa}}
                                </td>
                                <td>{{ $a->temperatura  }}</td>
                                <td>
                                    @if( (bool)$a->principal )
                                        <center>
                                            <i class="fa fa-check fa-x1" style="color:green;" ></i>
                                        </center>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success" href="/admin_almacenaje/salvar_almacenaje/{{ $a->id  }}">{{ "Modificar"  }}</a>
                                </td>
                                <td>
                                    {!!  Form::open(array(
                                                            'url'                   =>  '/admin_almacenaje/borrar_almacenaje/'.$a->id,
                                                            "class"                 =>  'confirmar_accion',
                                                            "method"                =>  "get",
                                                            "confirmacion_titulo"   =>  "Borrar Almacenaje",
                                                            "confirmacion_contenido"=>  "¿Está seguro que desea borrar este centro de almacenaje? Esta acción no puede ser revertida",
                                                    )) !!}
                                    {!! Form::token() !!}
                                    <button type="submit" class="btn btn-block btn-danger"><span class="fa fa-trash"></span> {{ "Borrar"  }}</button>
                                    {!!  Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ "NOMBRE"  }}</th>
                            <th>{{ "UBICACIÓN"  }}</th>
                            <th>{{ "VEHÍCULO"  }}</th>
                            <th>{{ "PLACA"  }}</th>
                            <th>{{ "TEMPERATURA"  }}</th>
                            <th>{{ "PRINCIPAL"  }}</th>
                            <th>{{ "MODIFICAR"  }}</th>
                            <th>{{ "BORRAR"  }}</th>
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
        $(document).ready(function(){
            $(".anadirTipo").click(function(e){
                location.href='/admin_almacenaje/salvar_almacenaje';
                e.preventDefault();
            });
        });
    </script>
@stop