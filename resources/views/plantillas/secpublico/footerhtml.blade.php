<footer>
    <div class="inner-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 f-about">
                    <a href="javascript:void(0);"><h1>{{"Nuestro Objetivo"}}</h1></a>
                    <p> {{ config('informacion.objetivo_general')  }} </p>
                </div>
                <div class="col-md-4 l-posts">
                    <h3 class="widgetheading">{{ "Recetas"  }}</h3>
                    <ul>
                        @foreach(\Tiqueso\receta::orderByRaw("RAND()")->take(4)->get() AS $receta)
                            <li><a href="/recetas/{{$receta->id}}">{{ $receta->nombre  }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4 f-contact">
                    <h3 class="widgetheading">{{ "Contacto"  }}</h3>
                    <a href="mailto:{{config('informacion.correo_contacto')}}"><p><i class="fa fa-envelope"></i> {{config('informacion.correo_contacto')}}</p></a>
                    <p><i class="fa fa-phone"></i>  {{config('informacion.telefono_contacto')}}</p>
                    <p><i class="fa fa-home"></i> {{config('informacion.direccion_contacto')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="last-div">
        <div class="container">
            <div class="row">
                <div class="copyright">
                    {{ "© ".date("Y")." Tiqueso Coprolac"  }} | {{ "San José, Costa Rica"  }}
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <ul class="social-network">
                    <li><a href="{{config('informacion.facebook')}}" target="_blank" data-placement="top" title="Facebook"><i class="fa fa-facebook fa-1x"></i></a></li>
                    <!--<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter fa-1x"></i></a></li>
                    <li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin fa-1x"></i></a></li>
                    <li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest fa-1x"></i></a></li>
                    <li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus fa-1x"></i></a></li>-->
                </ul>
            </div>
        </div>

        <a href="" class="scrollup"><i class="fa fa-chevron-up"></i></a>


    </div>
</footer>