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
	number: "Por favor, escribe un número válido.",
	digits: "Por favor, escribe sólo dígitos.",
	creditcard: "Por favor, escribe un número de tarjeta válido.",
	equalTo: "Por favor, escribe el mismo valor de nuevo.",
	extension: "Por favor, escribe un valor con una extensión aceptada.",
	maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
	minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
	rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
	range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
	max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
	min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
	nifES: "Por favor, escribe un NIF válido.",
	nieES: "Por favor, escribe un NIE válido.",
	cifES: "Por favor, escribe un CIF válido.",
	spanishAlphabetical: 'Debe contener solo letras.',


	idType: "Debe Seleccionar su Tipo de Identificación.",															//1
	idNumber: "El campo Número de identificación no puede estar vacío y debe contener solo números.",				//2
	digVer: "Dígito verificador inválido.",
	firstName: "El campo Primer Nombre no puede estar vacío y debe contener solo letras.",									//3
	middleName: "El campo Segundo Nombre debe contener solo letras.",														//4
	lastName: "El campo Apellido Paterno no puede estar vacío y debe contener solo letras.",								//5
	secondSurname: "El campo Apellido Materno debe contener solo letras.",													//6
	birthPlace: "El campo Lugar de Nacimiento debe contener solo letras.",													//7
	birthDate: "Por favor ingrese un Año de nacimiento válido.",
	nationality: "El campo Nacionalidad no puede estar vacío.",																//11
	addressType: "El campo Tipo Dirección no puede estar vacío",																	//12
	postalCode: "El campo Código Postal debe contener solo números.",															//13
	country: "El campo País de Residencia no puede estar vacío y debe contener solo letras.",						 //14
	departament: "El campo Departamento no puede estar vacío.",																	//15
	province: "El campo Provincia no puede estar vacío.",																		//16
	district: "El campo Distrito no puede estar vacío.",																			//17
	address: "El campo Dirección no puede estar vacío.",																		//18
	email: "El correo electrónico no puede estar vacío y debe contener formato correcto. (usuario@ejemplo.com).",				//19
	confirmEmail: "El campo confirmar correo electrónico debe coincidir con su correo electrónico.",							//20
	landLine: {																												//21
		number: "El campo Teléfono Fijo debe contener solo números.",
		numberEqual2: "Teléfono Fijo está repetido.",
		minlength: $.validator.format( "El campo Teléfono Fijo debe contener como mínimo {0} caracteres numéricos." ),
		maxlength: $.validator.format( "El campo Teléfono Fijo debe contener como mínimo {0} caracteres numéricos." )
	},
	mobilePhone: {																										//22
		required: "El campo Teléfono Móvil no puede estar vacío.",
		number: "El campo Teléfono Móvil debe contener solo números.",
		numberEqual3: "Teléfono Móvil está repetido.",
		minlength: $.validator.format( "El campo Teléfono Móvil debe contener como mínimo {0} caracteres numéricos." ),
		maxlength: $.validator.format( "El campo Teléfono Móvil debe contener como mínimo {0} caracteres numéricos." )
	},
	otherPhoneNum: {                                           //24
		number: "El campo Otro Teléfono debe contener solo números.",
		numberEqual1: "El campo Otro Teléfono está repetido.",
		minlength: $.validator.format( "El campo Teléfono Móvil debe contener como mínimo {0} caracteres numéricos." ),
		maxlength: $.validator.format( "El campo Teléfono Móvil debe contener como mínimo {0} caracteres numéricos." )
	},
	rucLaboral: "El campo Ruc laboral no puede estar vacío.",																//25
	jobCenter: "El campo Centro Laboral no puede estar vacío.",	//26
	jobOccupation : "El campo Ocupación Laboral no puede estar vacío y debe contener solo letras.",							//29
	jobTitle: "El campo Cargo Laboral debe contener solo letras.",															//30
	income: "El campo Ingreso promedio mensual debe contener solo números.",																												//31
	publicPerformance: "El campo ¿Desempeñó cargo público en últimos 2 años? no puede estar vacío.",									//32
	publicOffice: "El campo Cargo Público no puede estar vacío y debe contener solo letras.",									//33
	institution: "El campo Institución no puede estar vacío.",																	//34
	"uif" : "El campo ¿Es sujeto obligado a informar UIF-Perú, conforme al artículo 3° de la Ley N° 29038? no puede estar vacío.",	//35
	username: {																													//36
		required: "El campo Usuario no puede estar vacío.",
		pattern: "El campo usuario no tiene un formato válido. Permitido alfanumérico y underscore (barra_piso),  min 6, max 16 caracteres"
	},
	userpwd: "El campo Contraseña debe cumplir con los requerimientos",	//37
	confirmUserpwd: "El campo confirmar contraseña debe coincidir con su contraseña.",											//40
	contract: "Debe aceptar el contrato de cuenta dinero electrónico.",
	protection: "Debe aceptar protección de datos personales."

} );
return $;
}));
