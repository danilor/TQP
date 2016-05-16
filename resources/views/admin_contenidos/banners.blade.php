@extends("plantillas.admin")

@section("nombre_pagina")
    {{ "Banners" }}
@stop
@section("extra_cabecera")
    <ol class="breadcrumb">
        <li><button class="btn btn-block btn-primary anadirTipo"><i class="fa fa-plus"></i> {{ "Añadir Banner"  }}</button></li>
    </ol>
@stop
@section("contenido")
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
        #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
        html>body #sortable li { line-height: 1.2em; }
        .ui-state-highlight { line-height: 1.2em; }
        .banneritem{
           /* border-bottom: 1px solid black;*/
           height:200px!important;
            margin-bottom: 10px;
            margin-top:10px;
        }

    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ "Para modificar el orden es necesario arrastrar cada imagen a la posición deseada." }}
            </div>

            <div class="box">

                <ul id="sortable">
                    @foreach( \Tiqueso\banner::all() AS $b )

                        <li class="ui-state-default banneritem">
                                    <input type="hidden" class="banner_id_class" value="{{$b->id}}" />
                                    <div class="row">
                                        <div class="col-xs-7">
                                            <img height="150" src="{{ $b -> obtenerRutaImagen() }}" alt="{{$b->nombre}}" />
                                        </div>
                                        <div class="col-xs-5">
                                            <table class="table table-bordered table-striped">
                                                <tbody>

                                                    <tr>
                                                        <td><strong>Creado</strong></td>
                                                        <td>{{$b->creado}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Creado por</strong></td>
                                                        <td>{{@$b->obtenerUsuario()->obtenerNombreCompleto()}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Activo</strong></td>
                                                        <td>
                                                            @if( (int) $b->activo == 1)
                                                                <center>
                                                                    <i style="color:green;" class="fa fa-check fa-lg"></i>
                                                                </center>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{"Acción"}}</td>
                                                        <td>

                                                            {!!  Form::open(array(
                                                                                    'url'                   =>  '/admin_contenidos/borrar_banner/'.$b->id,
                                                                                    "class"                 =>  'confirmar_accion_borrar_banner eliminar_banner',
                                                                                    "method"                =>  "POST",
                                                                                    "confirmacion_titulo"   =>  "Eliminar Banner",
                                                                                    "confirmacion_contenido"=>  "¿Está seguro que desea eliminar este banner? Esta acción no puede ser revertida.",
                                                                                    "id"                    =>  $b->id,
                                                                            )) !!}
                                                            {!! Form::token() !!}
                                                                <button type="submit" class="btn btn-block btn-danger"><span class="fa fa-pencil"></span> {{ "Eliminar"  }}</button>
                                                            {!!  Form::close() !!}

                                                        </td>
                                                    </tr>


                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                        </li>
                    @endforeach
                </ul>


            </div><!-- /.box -->
        </div><!-- /.row -->
    </div>
@stop

@section("extra_js")
    @include("componentes.datatable")
    <script type="text/javascript">
        $(document).ready(function(){
            $(".anadirTipo").click(function(e){
                location.href='/admin_contenidos/subir_banner';
                e.preventDefault();
            });

            $( "#sortable" ).sortable({
                placeholder: "ui-state-highlight",

                update: function( event, ui ) {
                    var orden = [];
                    $(".banner_id_class").each(function(key,value){
                        orden.push($(this).val());
                    });
                    var orden_enviar = orden.join(',');
                    $.ajax({
                        url: "/admin_contenidos/actualizar_orden_banner/?orden="+orden_enviar,
                    }).done(function() {});
                }

            });
            $( "#sortable" ).disableSelection();


            $("form.confirmar_accion_borrar_banner").submit(function(e){
                logM("Formulario Sumitido");
                var formulario = $(this);
                //Los siguientes son campos predeterminados
                var titulo = "{{"Confirmar acción"}}";
                var contenido = "{{ '¿Está seguro de que desea realizar esta acción?' }}";
                //Si encontramos el campo en el formulario lo modificamos.
                if(     formulario.attr("confirmacion_titulo") != ""     ){     titulo = formulario.attr("confirmacion_titulo");      }
                if(     formulario.attr("confirmacion_contenido") != ""     ){       contenido = formulario.attr("confirmacion_contenido");       }
                $.confirm({
                    text: contenido,
                    title: titulo,
                    confirm: function(button) {

                        // Aquí es necesario el realizar una llamada ajax para poder elminar el banner
                        var id = formulario.attr('id');
                        $.ajax({
                            url: "/admin_contenidos/borrar_banner/"+id,
                        }).done(function() {});
                        formulario.closest('li').remove();

                    },
                    cancel: function(button) {
                        e.preventDefault(); //Cancelamos el formulario
                    },
                    confirmButton: "{{"Confirmar"}}",
                    cancelButton: "{{"Cancelar"}}",
                    post: true,
                    /*confirmButtonClass: "btn-danger",
                     cancelButtonClass: "btn-default",*/
                    confirmButtonClass: "btn-success",
                    cancelButtonClass: "btn-danger",
                    dialogClass: "modal-dialog modal-md" // Bootstrap classes for large modal
                });
                e.preventDefault();
            });

        });
    </script>
@stop