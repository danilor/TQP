@extends("plantillas.admin")

@section("nombre_pagina")
    @stop
@section("contenido")

        <!-- =========================================================== -->

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>0</h3>
                <p>{{ "Pedidos en curso"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>0   </h3>
                <p>{{ "Seguimientos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-hand-o-right"></i>
            </div>
            <a href="#" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3> {{ number_format(\Tiqueso\usuario::where("activo",1)->count())   }}  </h3>
                <p>{{ "Usuarios Activos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="/admin_usuarios/ver_todos/" class="small-box-footer">{{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>0</h3>
                <p>{{ "Productos Activos"  }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-archive"></i>
            </div>
            <a href="#" class="small-box-footer">
                {{ "Más Información"  }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<!-- =========================================================== -->

    @stop