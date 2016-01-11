@include("plantillas.secadmin.doctype")
<html>
@include("plantillas.secadmin.head")
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ Config::get("app.nombre_app_abreviada")  }}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ Config::get("app.nombre_app") }}</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">{{ "Cambiar tipo de navegación"  }}</span>
            </a>
            @include("plantillas.secadmin.navegacion_usuario")
        </nav>
    </header>

    @include("plantillas.secadmin.sidebar")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{  "TABLERO PRINCIPAL" }}
                <small>{{ "Panel de Control"  }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> {{ "Inicio" }}</a></li>
                <li class="active">{{ "Tablero Princpal" }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include("plantillas.secadmin.footer")

    @include("plantillas.secadmin.controlsidebar")
</div><!-- ./wrapper -->

@include("plantillas.secadmin.footerjs")
</body>
</html>
