@extends("plantillas/control_ingreso")
@section("mainform")
  @if($valido)
  <p class="login-box-msg">{{ "Por favor indique y confirme su nueva contraseña" }}</p>
  @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ $message }}
    </div>
  @endforeach

  {!! Form::open(array('url' => '/recobrar/'.$codigo, 'method' => 'post',"class"=>'requiereValidacion')) !!}
    <div class="form-group has-feedback">
      <input type="password" name="contrasena" class="form-control" placeholder="{{ "Contraseña" }}" required minlength="4">
    </div>
    <div class="form-group has-feedback">
      <input type="password" name="contrasena_confirmation" class="form-control" placeholder="{{ "Confirmación de Contraseña" }}" required minlength="4">
    </div>
    <div class="row">

      <div class="col-xs-4 col-xs-offset-8">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ "Recobrar" }}</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
  <a href="/ingresar">{{ "Ingresar" }}</a><br>
  @else
    <p class="login-box-msg">{{ "El código ingresado es inválido. Puede ser que haya expirado o sea inexistente." }}</p>
    <a href="/ingresar"><center>{{ "Ingresar" }}</center></a><br>
  @endif
@stop