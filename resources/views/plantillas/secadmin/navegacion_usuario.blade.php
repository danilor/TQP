<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li class="dropdown messages-menu">
            <a href="#" class="" data-toggle="modal" title="{{ "Crear nuevo seguimiento"  }}" data-target="#nuevoSeguimientoModal">
                <i class="fa fa-hand-o-right"></i>
                <span class="label label-success ">{{"+"}}</span>
            </a>
        </li>
        <li class="dropdown messages-menu seguimientosIconoNotificacion">
            <a title="{{ "Seguimientos asignados" }}" href="/perfil" class="">
                <i class="fa fa-hand-stop-o"></i>
                <span class="label label-warning totalSeguimientos">{{number_format(Auth::user()->totalSeguimientos())}}</span>
            </a>
        </li>
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
<div id="nuevoSeguimientoModal" class="modal fade" role="dialog">
    {!! Form::open(array('url' => '/seguimientos/nuevo_seguimiento','id'=>'nuevoSeguimientoFormulario','class'=>'form-horizontal requiereValidacionAjax','method'=>'post')) !!}
    <input type="hidden" name="geo_lat" value="" />
    <input type="hidden" name="geo_lon" value="" />
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ "Nuevo Seguimiento"  }}</h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">{{ "Usuario"  }} <span>*</span></label>
                            <div class="col-sm-10">
                                {!!  Form::select('usuario', [""=>"Seleccionar Usuario"] + \App\clases\Comunes::getUsuariosSelect(null), $usuario->sexo,array("required"=>'required',"class"=>"form-control"))  !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">{{ "Detalle"  }} <span>*</span></label>
                            <div class="col-sm-10">
                                {!! Form::textarea("detalle", null, array('placeholder'=>"Detalle",'class'=>'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info pull-right">{{ "Salvar"  }}</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>