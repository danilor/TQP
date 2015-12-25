@extends("plantillas/control_ingreso")

@section("mainform")
  <p class="login-box-msg">{{ "Por favor ingrese sus datos" }}</p>
  {!! Form::open(array('url' => '', 'method' => 'post',"class"=>'requiereValidacion')) !!}

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="{{ "Usuario" }}" minlength="3" name="{{ "usuario" }}" id="{{ "usuario" }}" required>
      <!--<span class="fa fa-key form-control-feedback"></span>-->
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="{{ "Contraseña" }}" required minlength="4">
      <!--<span class="fa fa-lock form-control-feedback"></span>-->
    </div>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox"> {{ "Recordarme" }}
          </label>
        </div>
      </div><!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ "Ingresar" }}</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}

  <a href="/recordar">{{ "¿Olvidó su contraseña?" }}</a><br>
  <!-- Se elimina el registro dado que solamente los administradores podrán crear los usuarios nuevos -->
  <!--<a href="register.html" class="text-center">{{ "Registrarse" }}</a>-->
@stop