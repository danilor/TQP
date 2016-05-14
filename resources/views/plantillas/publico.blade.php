<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
@include('plantillas.secpublico.header')
<body>
@include('plantillas.secpublico.nav')


@yield('contenido')




@include('plantillas.secpublico.footerhtml')

@include('plantillas.secpublico.footerjs')
</body>
</html>