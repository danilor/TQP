<div class="user-panel">
    <div class="pull-left image">
        <img src="{{ Auth::user()->obtenerFoto()  }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>{{ Auth::user()->nombre  }} {{ Auth::user()->apellido  }}</p>
        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
    </div>
</div>