@extends('plantillas.publico')
@section('titulo')
    - Recetas
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
                        <h2>{{ "Recetas" }}</h2>
                        <p>
                            {{ "Las mejores recetas con los quesos más deliciosos" }}
                        </p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
@foreach($recetas AS $receta)
                <div class="page-header">
                    <div class="blog">
                        <h3><a href="/recetas/{{$receta->id}}">{{$receta->nombre}}</a></h3>
                        {!! str_limit(strip_tags($receta->contenido),600)  !!}
                    </div>
                </div>
    @endforeach
    <div class="paginacion">
        <center>
            {!!  $recetas->appends(['producto' => $producto])->render() !!}
        </center>
    </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ "Buscar recetas por producto" }}</strong>
                    </div>
                    <div class="row">
                    @foreach(\Tiqueso\tipo_producto::orderBy('nombre','ASC')->where('mostrar',1)->get() AS $tp)
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <a href="?producto={{$tp->codigo}}"><div class="producto_completo_lista">
                                    <img width="100%" src="{{$tp->obtenerFotoEspecial(200,200)}}" />
                                    <p><center>
                                        {{$tp->nombre}}
                                    </center></p>
                                </div></a>
                            </div>
                        <!--<div class="panel-body">
                            <div class="media">

                                <div class="media-body">
                                    <h4 class="media-heading"><i class="fa fa-book"></i> {{ $tp->nombre  }}</h4>
                                    <p>
                                        {{ str_limit(strip_tags("NADA",200))  }}
                                    </p>
                                    <div class="ficon">
                                        <a href="?producto={{$tp->codigo}}" alt="">{{ "Leer más"  }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    @endforeach
                    </div>
                </div>
            </div>


        </div>



    </div>
@stop