@include("componentes.doctype")
<html>
@include("componentes.ingreso_head")
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>{{Config::get("app.nombre_app")}}</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        @yield("mainform")
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@include("componentes.ingreso_js")
@yield("extra_js")
</body>
</html>
