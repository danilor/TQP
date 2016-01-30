@include("plantillas.secadmin.doctype")
<html>
@include("plantillas.secadmin.head")
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include("plantillas.general.cabecera_nav")

    @include("plantillas.secperfil.sidebar")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @section("nombre_pagina")
                {{  "Perfil de Usuario" }}
                @show
            </h1>
            <ol class="breadcrumb">
                @yield("guia_navegacion")
                <!--<li><a href="#"><i class="fa fa-dashboard"></i> {{ "Inicio" }}</a></li>
                <li class="active">{{ "Tablero Princpal" }}</li>-->
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            @yield("contenido")
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include("plantillas.secadmin.footer")

    @include("plantillas.secadmin.controlsidebar")
</div><!-- ./wrapper -->

@include("plantillas.secadmin.footerjs")
@yield("extra_js")
</body>
</html>
