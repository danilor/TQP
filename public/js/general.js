$( document ).ready(function(){
	//Validaci�n de Formularios que tienen la clase de requiereValidacion
	logM("Documento listo.");

	logM("Validación de Formulario");
		 $(".requiereValidacion").validate({
				  lang: 'es', //El idioma a usar tiene que ser español
				  submitHandler: function(form) {
					form.submit();
				  }
		 });

});

/*Función para desplegar mensajes en la consola del navegador*/
function logM(t){
	try{
		console.log(t);
	}
	catch (err){}
}