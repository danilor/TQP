@extends('plantillas.publico')
@section('titulo')
    - Inicio
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
                        <h2>{{ "Receta" }}</h2>
                        <h3>
                            {{ $receta-> nombre }}
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
                        <!--<h5>{{$receta->obtenerFechaCreacion()}}</h5>-->
                        {!! $receta->contenido  !!}
                    </div>
                </div>


                <div class="content">
                    <div class="grid">
                        <h2>{{ "Productos relacionados"  }}</h2>
                        @foreach($receta->obtenerProductosRelacionados() AS $p)
                            <figure class="effect-zoe">
                                <img src="{{ $p->obtenerFotoEspecial(480,300)  }}" alt="/img27"/>
                                <figcaption>
                                    <h2>{{$p->nombre}}</h2>
                                    <!--<p class="icon-links">
                                        <a href="#"><span class="icon-heart"></span></a>
                                        <a href="#"><span class="icon-eye"></span></a>
                                        <a href="#"><span class="icon-paper-clip"></span></a>
                                    </p>-->
                                    <p class="description">{{$p->detalle}}</p>
                                </figcaption>
                            </figure>
                        @endforeach

                    </div>
                </div>

            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ "Otras Recetas" }}</strong>
                    </div>

                    @foreach(\Tiqueso\receta::orderByRaw("RAND()")->take(4)->where('id','<>',$receta->id)->get() AS $r)
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