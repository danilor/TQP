<?php
    $Usuario = null;
    if(Auth::check()){
        $Usuario = new \App\clases\Usuario(Auth::user());
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                @if(Auth::check())
                    ¡{{ "Bienvenido" }} {{  $Usuario->obtenerNombreCompleto()  }}!
                    @if(Auth::user()->esAdministrador())
                    <br />{{  "El usuario que está siendo usado tiene permisos de administrador" }}
                    @endif
                    @if(Auth::user()->verRoles() != null && count(Auth::user()->verRoles()) > 0)
                        <br />{{  "El usuario posee lo siguiente roles:" }} <br />
                        <i>{{ implode(",",Auth::user()->verRoles())  }}</i>
                    @else
                        <br /> {{ "El usuario no tiene roles asignados actualmente"  }}
                    @endif

                    @if(Auth::user()->verPermisos() != null && count(Auth::user()->verPermisos()) > 0)
                        <br />{{  "El usuario posee lo siguiente permisos:" }} <br />
                        <i>{{ implode(",",Auth::user()->verPermisos())  }}</i>
                    @else
                        <br /> {{ "El usuario no tiene permisos asignados actualmente"  }}
                    @endif
                @endif
            </div>
        </div>
    </body>
</html>
