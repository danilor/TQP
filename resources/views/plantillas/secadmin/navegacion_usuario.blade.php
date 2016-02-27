<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->obtenerFoto()  }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->nombre  }} {{ Auth::user()->apellido  }}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="{{ Auth::user()->obtenerFoto()  }}" class="img-circle" alt="User Image">
                    <p>
                        {{ Auth::user()->nombre  }} {{ Auth::user()->apellido  }}
                        <small>{{ "Miembro desde:"  }} {{ Auth::user()->obtenerFechaCreacion(true)  }}</small>
                    </p>
                </li>
                <!-- Menu Body -->
                <!--<li class="user-body">
                    <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                    </div>
                </li>-->
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="/perfil" class="btn btn-default btn-flat">{{ "Perfil"  }}</a>
                    </div>
                    <div class="pull-right">
                        <a href="/cerrar_sesion" class="btn btn-default btn-flat">{{ "Cerrar sesión"  }}</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
    </ul>
</div>