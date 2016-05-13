@extends("plantillas.admin")

@section("nombre_pagina")
@stop
@section("extra_cabecera")

@stop
@section("contenido")


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <center>
               <h3>{{ "Proceso no encontrado"  }}</h3>
           </center>
        </div><!-- /.row -->
    </div>
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@stop