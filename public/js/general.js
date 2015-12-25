$( document ).ready(function(){
	//Validaci�n de Formularios que tienen la clase de requiereValidacion
		 $(".requiereValidacion").validate({
				  lang: 'es', //El idioma a usar tiene que ser español
				  submitHandler: function(form) {
					form.submit();
				  }
		 });
});