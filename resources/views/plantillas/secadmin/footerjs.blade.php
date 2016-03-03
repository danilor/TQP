<!-- jQuery 2.1.4 -->
<script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/plugins/morris/morris.min.js"></script>-->
<!-- Sparkline -->
<script src="/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>-->
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>

<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/localization/messages_es.js"></script>
<script src="/js/jquery.noty.js"></script>
<script src="/js/jquery.confirm.js"></script>
<script src="/js/general.js"></script>

<script type="text/javascript">
    var lang = "{{ \App::getLocale()  }}"; //Variable de lenguaje

    function preparar_dialogo_confirmacion(){
        logM("Preparando los diálogos de confirmación");
        $("form.confirmar_accion").submit(function(e){
            logM("Formulario Sumitido");
            var formulario = $(this);
            //Los siguientes son campos predeterminados
            var titulo = "{{"Confirmar acción"}}";
            var contenido = "{{ '¿Está seguro de que desea realizar esta acción?' }}";
            //Si encontramos el campo en el formulario lo modificamos.
            if(     formulario.attr("confirmacion_titulo") != ""     ){     titulo = formulario.attr("confirmacion_titulo");      }
            if(     formulario.attr("confirmacion_contenido") != ""     ){       contenido = formulario.attr("confirmacion_contenido");       }
            $.confirm({
                text: contenido,
                title: titulo,
                confirm: function(button) {
                    formulario.unbind().submit(); //Si confirma, le quitamos los "binds" al formulario y lo sumiteamos
                },
                cancel: function(button) {
                    e.preventDefault(); //Cancelamos el formulario
                },
                confirmButton: "{{"Confirmar"}}",
                cancelButton: "{{"Cancelar"}}",
                post: true,
                /*confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-default",*/
                confirmButtonClass: "btn-success",
                cancelButtonClass: "btn-danger",
                dialogClass: "modal-dialog modal-md" // Bootstrap classes for large modal
            });
            e.preventDefault();
        });
    }
    $( document).ready(function(){
        @if(Input::get("salvado") === "y")
                notification('{{  "Información Salvada" }}')
        @endif
        preparar_dialogo_confirmacion();
    });
</script>
