@extends('plantillas.publico')
@section('titulo')
    - Productos
@stop

@section('contenido')
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="blogs">
                        <div class="text-center">
                            <h2>{{ "Nuestros Productos" }}</h2>
                            <p>
                                Siempre frescos en su mesa
                            </p>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
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