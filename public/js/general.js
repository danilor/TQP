
var error_formulario = "Ha ocurrido un error desconocido. Por favor intentarlo más tarde. Si el error persiste por favor comuníquese con su adminsitrador";//variable para errores desconocidos en los envíos ajax (por ejemplo errores 500)

/*Función para desplegar mensajes de consola. Además de acortar la forma, se asegura de que ciertos navegadores con problemas de consola no causen error*/
function logM(t){
	try{
		console.log(t);
	}
	catch (err){}
}

function nuevoSeguimientoSubmit(){
	$("#nuevoSeguimientoFormulario").submit(function(e){
		var url = $(this).attr("action");
		var data = $(this).serialize();
		var formulario = $(this);
		if(	!$( this ).valid()	) {
			logM("Nuevo seguimiento aún contiene errores");
			return;
		}
		logM("Listo para enviar nuevo seguimiento");
		$.ajax({
			type: "POST",
			url: url,
			data: data,
		}).done(function(res) {
			if( parseInt(res.error.id)  == 0 ){ //No hay errores
				formulario.closest(".modal").modal("hide");
				notification("Seguimiento Enviado");
				formulario.trigger("reset");
			}else{
				error("Existen errores en el formulario. Por favor revisar y enviar de nuevo");
			}
		}).fail(function() {
				error(error_formulario);
		}).always(function() {

		});
		e.preventDefault();
		return false;
	});
}

function modificarSeguimientoSubmit(){
	$(".modificarSeguimientoFormulario").submit(function(e){
		var url = $(this).attr("action");
		var data = $(this).serialize();
		var formulario = $(this);
		if(	!$( this ).valid()	) {
			logM("Nuevo seguimiento aún contiene errores");
			return;
		}
		logM("Listo para enviar nuevo seguimiento");
		$.ajax({
			type: "POST",
			url: url,
			data: data,
		}).done(function(res) {
			if( parseInt(res.error.id)  == 0 ){ //No hay errores
				formulario.closest(".post").fadeOut("normal",function(){
					$(this).remove();
				});
				notification("Seguimiento Enviado");

			}else{
				error("Existen errores en el formulario. Por favor revisar y enviar de nuevo");
			}
		}).fail(function() {
			error(error_formulario);
		}).always(function() {

		});
		e.preventDefault();
		return false;
	});
}
/*Función para configurar las diferentes validaciones de los formularios*/
function validacaionDeFormulario(){
	$(".requiereValidacion").each(function(index,value){
		$(this).validate({
			lang: lang, //El idioma a usar tiene que ser español
			submitHandler: function(form) {
				$(form).unbind("submit");
				$(form).submit();
			}
		});
	});
	$(".requiereValidacionAjax").each(function(index,value){
		$(this).validate({
			lang: lang, //El idioma a usar tiene que ser español
			submitHandler: function(form) {}
		});
	});
}

function notification(t){
	var n = noty({
		text: t ,
		layout: 'top',
		theme: 'defaultTheme',
		timeout: 3000,
		/*
		 timeout: 3000,
		 maxVisible: 5,
		 closeWith: ['click'],
		 animation: {
		 open: 'animated bounceInLeft', // Animate.css class names
		 close: 'animated bounceOutLeft', // Animate.css class names
		 easing: 'swing', // unavailable - no need
		 speed: 500 // unavailable - no need
		 },
		 callback: {
		 onShow: function() {},
		 afterShow: function() {},
		 onClose: function() {},
		 afterClose: function() {},
		 onCloseClick: function() {},
		 },*/
	});
}
function error(t){
	var n = noty({
		text: t ,
		layout: 'top',
		theme: 'defaultTheme',
		timeout: 3000,
		type:'error',
		/*
		 timeout: 3000,
		 maxVisible: 5,
		 closeWith: ['click'],
		 animation: {
		 open: 'animated bounceInLeft', // Animate.css class names
		 close: 'animated bounceOutLeft', // Animate.css class names
		 easing: 'swing', // unavailable - no need
		 speed: 500 // unavailable - no need
		 },
		 callback: {
		 onShow: function() {},
		 afterShow: function() {},
		 onClose: function() {},
		 afterClose: function() {},
		 onCloseClick: function() {},
		 },*/
	});
}
function revisionDeSeguimientos(){
	var selector = ".totalSeguimientos";
	window.setInterval(function(){ // cada 5 segundos va a revisar para ver si hay más seguimientos activos
		var actual = parseInt($(selector).html());
		$.ajax({
			url: "/seguimientos/seguimientos_de_usuario",
		}).done(function( data ) {
				var nuevo = parseInt(data.datos.total);
				$(selector).html(nuevo);
				if(  actual < nuevo ){
					logM("Es mayor el nuevo");
					llamarAtencion(".seguimientosIconoNotificacion");
				}
			});
	}, 5000);
}
function llamarAtencion(selector){
	$(selector).effect( "pulsate", {times:3}, 2000 );
}
$( document ).ready(function(){
	validacaionDeFormulario();
	nuevoSeguimientoSubmit();
	modificarSeguimientoSubmit();
	revisionDeSeguimientos();
});
