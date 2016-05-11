
var error_formulario = "Ha ocurrido un error desconocido. Por favor intentarlo más tarde. Si el error persiste por favor comuníquese con su adminsitrador";//variable para errores desconocidos en los envíos ajax (por ejemplo errores 500)
var lang = 'es'; //El idioma de la aplicación. Se declara como una variable común

/*Variables globales de latitud y longitud*/
var latitude;
var longitude;

/*Función para desplegar mensajes de consola. Además de acortar la forma, se asegura de que ciertos navegadores con problemas de consola no causen error*/
function logM(t){
	try{
		console.log(t);
	}
	catch (err){}
}

function isset ( strVariableName ) { //Equivalente a la función de ISSET de PHP
	if(typeof(variable) != "undefined" && variable !== null) {
		return true;
	}
	return false;
}

/*Función para añadir ceros a los números*/
function padDigits(number, digits) {
	return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
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
function validacionDeFormulario(){
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

/*
	Tipos para NOTY
 	alert - success - error - warning - information - confirmation
 */
function notification(t){
	var n = noty({
		text: t ,
		layout: 'top',
		theme: 'defaultTheme',
		timeout: 3000,
		type:'success'
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
				try{
					var nuevo = parseInt(data.datos.total);
					$(selector).html(nuevo);
					if(  actual < nuevo ){
						logM("Es mayor el nuevo");
						llamarAtencion(".seguimientosIconoNotificacion");
					}
				}catch(error){
					logM(error);
				}


			});
	}, 5000);
}
function llamarAtencion(selector){
	$(selector).effect( "pulsate", {times:3}, 2000 );
}

function inicializarWYSIWYG(){
	try{
		$('.summernote').summernote({
			height: 300,                 // el tamaño (alto)
			minHeight: null,             // tamaño minimo para el editor
			maxHeight: null,             // tamaño máximo para el editor
			focus: false,                // no se quiere que obtenga foco justo despues de inicializar
			lang: 'es-ES' 				 // Establecemos el idioma
		});
	}catch(err){
		//Existen página donde no se carga el summer note. Este try catch es para evitar que de errores en dichas páginas
	}

}

function geo_success(position) {
	latitude  = position.coords.latitude; //Obtenemos la latitud
	longitude = position.coords.longitude; //Obtenemos la longitud

	logM("Localización: LAT:" + latitude + ' | LON:' + longitude);
	actualizar_campos_localizacion( latitude , longitude );
};

function geo_error() {
	logM("Localización negada.");
};

function obtenerLocalizacion(){
	if ("geolocation" in navigator) {
		navigator.geolocation.getCurrentPosition(geo_success, geo_error); // Obtenemos la pocisión actual
	} else {
		logM("Locación no disponible");
	}
}

/*
* Esta función va a obtener los datos de latitud y longitud y los va a poner en todos y cada uno de los inputs que lo requieran.
* Dado que estos datos son opcionales puede que algunos formularios no los tengan.
* Poco a poco se deben de ir implementando.
* */
function actualizar_campos_localizacion(lat,lon){
	logM("Actualizando los campos de ubicación");
	$( "input[name='geo_lat']").val(lat);
	$( "input[name='geo_lon']").val(lon);
}




$( document ).ready(function(){
	validacionDeFormulario();
	nuevoSeguimientoSubmit();
	modificarSeguimientoSubmit();
	revisionDeSeguimientos();
	inicializarWYSIWYG();
	inicializarCalendar();
	/*La función de geolocalización siempre tiene que llamarse al final.*/
	obtenerLocalizacion();
});
