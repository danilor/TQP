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

    <div class="map">
        <iframe src="{{config('informacion.gmaps_url')}}">
        </iframe>
    </div>

    <section id="contact-page">
        <div class="container">
            <div class="center">
                <h2>{{ "Déjanos tu mensaje"  }}</h2>
                <p>{{ "Siempre estamos alegres de oir de ustedes"  }}</p>
            </div>
            <div class="row contact-wrap">

                    @foreach ($errors->all() as $message)
                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            {{ $message }}
                        </div>
                    @endforeach
                        @if(Input::get('enviado') == 'y')
                            <div class="status alert alert-success" >
                                {{ "Gracias por contactarnos. Su mensaje ha sido enviado."  }}
                            </div>
                            @endif
                <form id="main-contact-form" class="contact-form requiereValidacion" name="contact-form" method="post" action="/salvar_contacto">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label>{{"Nombre"}} *</label>
                            <input type="text" name="nombre" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>{{"Correo"}} *</label>
                            <input type="email" name="correo" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>{{"Teléfono"}}</label>
                            <input type="number" name="telefono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{"Compañía"}}</label>
                            <input type="text" name="compania" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>{{"Tema"}} *</label>
                            <input type="text" name="tema" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>{{"Mensaje"}} *</label>
                            <textarea name="mensaje" id="mensaje" required="required" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">{{"Enviar"}}</button>
                        </div>
                    </div>
                </form>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->

@stop