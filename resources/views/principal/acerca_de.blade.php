@extends('plantillas.publico')
@section('titulo')
    - Acerca de
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
                        <h2>{{ "Acerca de" }}</h2>
                        <h3>

                        </h3>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <div class="blog">

                        <p>COPROLAC S.A. bajo la marca Tiqueso, se dedica a la producción y comercialización de productos lácteos. Esta página está enfocada en el valor nutritivo, características y formas de uso de los productos</p>
                        <p>El Ing. Denis Fabián Toruño Sánchez es el fundador de COPROLAC S.A. y DIPROLAC S.A.</p>
                        <p>La marca Tiqueso pertenece a COPROLAC S.A., la cual se dedicada a la producción y comercialización de productos lácteos, con proveedores nacionales para la mayoría de sus productos y una línea de queso tipo Chontaleño, de la región de Nicaragua.</p>
                        <p>DIPROLAC S.A. también tiene la marca de American Slices y Casa Real.</p>
                        <p>Nuestros productos se venden supermercados y además somos proveedores de pizzerías, panaderías y servicios de alimentación institucionales</p>
                        <p>
                            <iframe src="{{config('informacion.gmaps_url')}}" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop