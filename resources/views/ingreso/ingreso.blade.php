@extends("plantillas/control_ingreso")
@section("mainform")
  <p class="login-box-msg">{{ "Por favor ingrese sus datos" }}</p>
  @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ $message }}
    </div>
  @endforeach
  @if( isset($_GET["e"]) )
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ "Credenciales inválidas" }}
    </div>
  @endif
  @if( isset($_GET["snd"]) )
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ "Si el correo corresponde a un usuario activo pronto se le estará enviando un mensaje con los pasos a seguir para recuperar y reiniciar su contraseña" }}
    </div>
  @endif
  {!! Form::open(array('url' => '/ingresar', 'method' => 'post',"class"=>'requiereValidacion')) !!}

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="{{ "Usuario" }}" minlength="3" name="{{ "usuario" }}" id="{{ "usuario" }}" required>
      <!--<span class="fa fa-key form-control-feedback"></span>-->
    </div>
    <div class="form-group has-feedback">
      <input type="password" name="contrasena" class="form-control" placeholder="{{ "Contraseña" }}" required minlength="4">
      <!--<span class="fa fa-lock form-control-feedback"></span>-->
    </div>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <input name="recordar" type="checkbox"> {{ "Recordarme" }}
          </label>
        </div>
      </div><!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ "Ingresar" }}</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
  <a href="/recordar">{{ "¿Olvidó su contraseña?" }}</a><br>
@stop