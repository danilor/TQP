@extends("plantillas/control_ingreso")

@section("mainform")
  <p class="login-box-msg">{{ "Por favor ingrese su correo para así recuperar su contraseña" }}</p>
  {!! Form::open(array('url' => '', 'method' => 'post',"class"=>'requiereValidacion')) !!}

    <div class="form-group has-feedback">
      <input type="email" class="form-control" placeholder="{{ "Correo" }}" minlength="3" name="{{ "correo" }}" id="{{ "correo" }}" required>
      <!--<span class="fa fa-key form-control-feedback"></span>-->
    </div>
  <p><i>Si el correo ingresado se encuentra en nuestro sistema pronto estaría recibiendo un correo con las instrucciones para recuperar y reestablecer su correo.</i></p>
    <div class="row">
      <div class=" col-xs-offset-8 col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ "Recordar" }}</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}

  <a href="/ingresar">{{ "Ingresar" }}</a><br>
@stop