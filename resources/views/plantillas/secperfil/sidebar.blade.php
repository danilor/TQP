<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
@include("plantillas.general.usuario_sidebar")
        @include("plantillas.secadmin.search")
                <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">{{ "MENÚ DE USUARIO"  }}</li>



            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ "Perfil"  }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/perfil/informacion_basica"><i class="fa fa-circle-o"></i> {{ "Editar información Básica"  }}</a></li>
                    <li><a href="/perfil/contrasena"><i class="fa fa-circle-o"></i> {{ "Editar Contraseña"  }}</a></li>
                    <li><a href="/perfil/foto"><i class="fa fa-circle-o"></i> {{ "Editar Foto"  }}</a></li>
                </ul>
            </li>



                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i>
                        <span>{{ "Registros"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-circle-o"></i> {{ "Registro de Ingreso"  }}</a></li>
                    </ul>
                </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>