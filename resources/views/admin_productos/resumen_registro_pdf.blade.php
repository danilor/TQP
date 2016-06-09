<html>
    <head>

    </head>
    <body>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ficha-producto">
            <center>
                <h1>{{"Resumen de Registro"}} </h1>
            </center>
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped" width="100%"  border="1">
                    <thead>
                    <tr>
                        <th>{{ "Encargado"  }}</th>
                        <th>{{ "Proveedor"  }}</th>
                        <th>{{ "Fecha y Hora de Inicio"  }}</th>
                        <th>{{ "Fecha y Hora de Finalización"  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ @$producto_registro->obtenerUsuario()->obtenerNombreCompleto()  }}</td>
                        <td>[{{ @$producto_registro->proveedor  }}] {{ @$producto_registro->proveedor_nombre  }}</td>
                        <td>{{ date(config("region.formato_fecha_completo"),strtotime(@$producto_registro->iniciado))  }}</td>
                        <td>{{ date(config("region.formato_fecha_completo"),strtotime(@$producto_registro->finalizado))  }}</td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
            <br /> <!-- Una separación entre las tablas -->
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped"  width="100%" border="1">
                    <thead>
                    <tr>
                        <th>{{ "Tipo Producto"  }}</th>
                        <th>{{ "Lote"  }}</th>
                        <th>{{ "Unidades"  }}</th>
                        <th>{{ "Vencimiento"  }}</th>
                        <th>{{ "Código"  }}</th>
                        <!--<th>{{ "Imágen"  }}</th>-->
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( unserialize($producto_registro->formulario) AS $key => $value )
                            <tr>
                                <td>{{ $value["tipo"]  }}</td>
                                <td>{{ $value["lote"]  }}</td>
                                <td>{{ (float)$value["unidades"]  }}</td>
                                <td>{{ $value["vencimiento"]  }}</td>
                                <td>{{ $key  }}</td>
                                <!--<td><img id="codigo{{ $key  }}" /></td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
<br />
            <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped"  width="100%"  border="1">
                    <thead>
                    <tr>
                        <th>{{ "Detalle"  }}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $producto_registro->detalle  }}</td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->

        </div>
    </div>

    </body>
</html>