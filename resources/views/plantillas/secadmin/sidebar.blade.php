<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        @include("plantillas.general.usuario_sidebar")
        @include("plantillas.secadmin.search")
                <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">{{ "MENÚ PRINCIPAL"  }}</li>
            @if(Auth::user()->esAdministrador())
            <li><a href="/admin_general"><i class="fa fa-dashboard"></i> <span>{{ "Inicio" }}</span></a></li>
            @endif


            @if( Auth::user()->puede("administrar_usuarios") )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ "Usuarios"  }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin_usuarios/ver_todos"><i class="fa fa-circle-o"></i> {{ "Ver Usuarios"  }}</a></li>
                    <li><a href="/admin_usuarios/directorio"><i class="fa fa-circle-o"></i> {{ "Ver Directorio"  }}</a></li>
                    <li><a href="/admin_usuarios/roles"><i class="fa fa-circle-o"></i> {{ "Roles de Usuario"  }}</a></li>
                    <li><a href="/admin_usuarios/permisos"><i class="fa fa-circle-o"></i> {{ "Administrar Permisos"  }}</a></li>
                </ul>
            </li>
            @endif

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ "Proveedores"  }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin_proveedores/ver_todos"><i class="fa fa-circle-o"></i> {{ "Ver proveedores"  }}</a></li>
                    <li><a href="/admin_proveedores/agregar"><i class="fa fa-circle-o"></i> {{ "Agregar nuevo provedor"  }}</a></li>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ "Clientes"  }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin_clientes/ver"><i class="fa fa-circle-o"></i> {{ "Ver clientes"  }}</a></li>
                </ul>
            </li> 

            @if( Auth::user()->puede("administrar_productos") )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-archive"></i>
                        <span>{{ "Productos"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin_productos/registrar_nuevo"><i class="fa fa-circle-o"></i> {{ "Registrar Producto"  }}</a></li>
                        <li><a href="/admin_productos/ver"><i class="fa fa-circle-o"></i> {{ "Productos"  }}</a></li>
                        <li><a href="/admin_productos/tipos"><i class="fa fa-circle-o"></i> {{ "Tipos de Productos"  }}</a></li>
                        <li><a href="/admin_productos/categorias"><i class="fa fa-circle-o"></i> {{ "Categorías de Productos"  }}</a></li>
                    </ul>
                </li>
            @endif

            @if( Auth::user()->puede("administrar_procesos") )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>{{ "Procesos"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin_procesos/iniciar_proceso"><i class="fa fa-circle-o"></i> {{ "Iniciar Proceso"  }}</a></li>
                        <li><a href="/admin_procesos/ver"><i class="fa fa-circle-o"></i> {{ "Ver procesos Activos"  }}</a></li>
                    </ul>
                </li>
            @endif

            @if( Auth::user()->puede("administrar_almacenaje") )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-building"></i>
                        <span>{{ "Almacenaje"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-circle-o"></i> {{ "Ver centros de almacenaje"  }}</a></li>
                    </ul>
                </li>
            @endif

            @if( Auth::user()->puede("administrar_contenido") )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file"></i>
                        <span>{{ "Contenidos"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin_contenidos/recetas"><i class="fa fa-circle-o"></i> {{ "Recetas"  }}</a></li>
                    </ul>
                </li>
            @endif

            @if( Auth::user()->puede("ver_reportes") )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i>
                        <span>{{ "Reportes"  }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin_reportes/correos"><i class="fa fa-circle-o"></i> {{ "Registros de Correos"  }}</a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> {{ "Historial de Procesos"  }}</a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> {{ "Historial de Ingreso"  }}</a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> {{ "Registro de acciones"  }}</a></li>
                    </ul>
                </li>
            @endif

            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>{{ "Documentación"  }}</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>