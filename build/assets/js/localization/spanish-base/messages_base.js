(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

$.extend( $.validator.messages, {

	required: "Este campo es obligatorio.",
	remote: "Por favor, rellena este campo.",
	email: "Por favor, escribe una dirección de correo válida.",
	url: "Por favor, escribe una URL válida.",
	date: "Por favor, escribe una fecha válida.",
	dateISO: "Por favor, escribe una fecha (ISO) válida.",
	number: "Debe contener solo números.",
	digits: "Por favor, escribe sólo dígitos.",
	creditcard: "Por favor, escribe un número de tarjeta válido.",
	equalTo: "Por favor, escribe el mismo valor de nuevo.",
	extension: "Por favor, escribe un valor con una extensión aceptada.",
	maxlength: $.validator.format( "Debe contener máximo {0} caracteres." ),
	minlength: $.validator.format( "Debe contener mínimo {0} caracteres." ),
	rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
	exactlength: $.validator.format( "Debe contener exactamente {0} caracteres." ),
	range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
	max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
	min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
	nifES: "Por favor, escribe un NIF válido.",
	nieES: "Por favor, escribe un NIE válido.",
	cifES: "Por favor, escribe un CIF válido.",
	spanishAlphabetical: "Debe contener solo letras.",
	fechaInvalida: "Por favor, escribe una fecha válida.",
	validatePassword: "El campo debe tener mínimo 1 y máximo 3 números consecutivos.",
	username: "Solo letras, números y guiones.",
	nowhitespace: "Sin espacio en blanco.",
	emailValid: "Por favor, escribe una dirección de correo válida."

} );
return $;
}));
