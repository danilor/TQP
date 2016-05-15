@extends('plantillas.publico')
@section('titulo')
    - Producto - {{ $producto-> nombre }}
@stop

@section('extra_css')
    <style>
    .media-heading{
        margin-bottom: 10px!important;
    }
    .blog h3, p {
        color: #000!important;
        padding: 0px!important;
    }
    .ficon{
        margin-top:0px!important;
    }
        .blog{
            padding: 13px!important;
        }
    </style>
@stop
@section('contenido')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="blogs">
                    <div class="text-center">
                        <h2>{{ "Producto" }}</h2>
                        <h3>
                            {{ $producto-> nombre }}
                        </h3>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header">
                    <div class="blog">
                        <!--<h5></h5>-->
                        @if($producto->foto != "")
                            <div>
                                <center>
                                    <img src="{{$producto->obtenerFotoEspecial(200,200)}}" />
                                </center>
                            </div>
                            @endif
                        {!! $producto->caracteristicas  !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ "Recetas con este producto" }}</strong>
                    </div>
                    @foreach(\Tiqueso\receta::orderByRaw("RAND()")->where('productos_relacionados','LIKE',"%$producto->codigo%")->take(4)->get() AS $r)
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><i class="fa fa-book"></i> {{ $r->nombre  }}</h4>
                                <p>
                                    {{ str_limit(strip_tags($r->contenido),200)  }}
                                </p>
                                <div class="ficon">
                                    <a href="/recetas/{{$r->id}}" alt="">{{ "Leer más"  }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop