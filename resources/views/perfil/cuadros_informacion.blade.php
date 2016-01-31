<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ $usuario->obtenerFoto()  }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $usuario->nombre  }} {{ $usuario->apellido  }}</h3>
            <!--<p class="text-muted text-center">Software Engineer</p>-->

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>{{ "Seguimientos"  }}</b> <a class="pull-right">{{ number_format(0)  }}</a>
                </li>

            </ul>

            <a href="/perfil/informacion_basica" class="btn btn-primary btn-block"><b>{{ "Modificar Perfil"  }}</b></a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ "Acerca de mi"  }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i>  {{ "Educación"  }}</strong>
            <p class="text-muted">
                {{ "Ninguna Registrada"  }}
            </p>

            <hr>

            <strong><i class="fa fa-map-marker margin-r-5"></i> {{ "Dirección"  }}</strong>
            <p class="text-muted">{{ $usuario->direccion  }}</p>
            <p class="text-muted">{{ $usuario->direccion2  }}</p>

            <hr>

            <strong><i class="fa fa-phone margin-r-5"></i> {{ "Teléfonos"  }}</strong>
            <p>
                <!--<span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>-->
            <p class="text-muted">{{ $usuario->telefono  }}</p>
            <p class="text-muted">{{ $usuario->celular  }}</p>
            </p>

            <strong><i class="fa fa-clock-o margin-r-5"></i> {{ "Último Ingreso"  }}</strong>
            <p>
                <!--<span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>-->
            <p class="text-muted">{{ $usuario->obtenerFechaCreacion(true)  }}</p>
            </p>

            <hr>

            <strong><i class="fa fa-file-text-o margin-r-5"></i> {{ "Notas"  }}</strong>
            <p>
                {{ $usuario->notas  }}
            </p>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->