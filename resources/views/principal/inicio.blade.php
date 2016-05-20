@extends('plantillas.publico')
@section('titulo')
    - Inicio
@stop

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="slider">
                <div class="/img-responsive">
                    <ul class="bxslider">
                        @foreach(\Tiqueso\banner::where('activo',1)->orderBy('orden','ASC')->get() AS $b )
                            <li><img src="{{ $b->obtenerRutaImagen()  }}" alt=""/></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="text-center">
                    <h2>{{"El verdadero sabor del queso"}}</h2>
                    <p>{{ config('informacion.descripcion_general') }}</p>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-md-4">
                    <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.4s">
                        <h4>{{ "Saludable"  }}</h4>
                        <div class="icon">
                            <i class="fa fa-heart-o fa-3x"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Cras suscipit arcu libero</p>
                        <!--<div class="ficon">
                            <a href="#" class="btn btn-default" role="button">Read more</a>
                        </div>-->
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.0s">
                        <h4>{{"Fresco"}}</h4>
                        <div class="icon">
                            <i class="fa fa-check fa-3x"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Cras suscipit arcu libero</p>
                        <!--<div class="ficon">
                            <a href="#" class="btn btn-default" role="button">Read more</a>
                        </div>-->
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.6s">
                        <h4>{{"Variado"}}</h4>
                        <div class="icon">
                            <i class="fa fa-shopping-basket fa-3x"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Cras suscipit arcu libero</p>
                        <!--<div class="ficon">
                            <a href="#" class="btn btn-default" role="button">Read more</a>
                        </div>-->
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="text-center">
                    <h2>{{ "Productos"  }}</h2>
                    <p>
                        {{ "Nuestros productos están hechos de las mejores materias primas, de la más alta calidad."  }}
                        <br>
                    </p>
                </div>
                <hr>
            </div>
        </div>
    </div>



    <div class="content">
    <div class="row">
        <div class="grid">
            @foreach($productos AS $p)
                <a href="/producto/{{$p->codigo}}"><figure class="effect-zoe">
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
                </figure></a>
            @endforeach

        </div>
        </div>
    </div>
@stop