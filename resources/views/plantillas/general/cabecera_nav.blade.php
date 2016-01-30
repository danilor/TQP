<header class="main-header">
    <!-- Logo -->
    <a href="/perfil" class="logo">
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