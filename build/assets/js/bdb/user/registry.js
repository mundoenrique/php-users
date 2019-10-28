'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	var fechaPrueba;//vars

	$( "#birthDate" ).datepicker( {
		dateFormat: "dd/mm/yy"
	});


	fechaPrueba = moment("20111031", "YYYYMMDD"); // hace 8 años
	console.log("fecha: " + fechaPrueba);
	fechaPrueba = moment("20111031", "YYYYMMDD").fromNow(); // hace 8 años
	console.log(fechaPrueba);
	fechaPrueba = moment("20120620", "YYYYMMDD").fromNow(); // hace 7 años
	console.log(fechaPrueba);
	fechaPrueba = moment().startOf('day').fromNow();        // hace 10 horas
	console.log(fechaPrueba);
	fechaPrueba = moment().endOf('day').fromNow();          // en 14 horas
	console.log(fechaPrueba);
	fechaPrueba = moment().startOf('hour').fromNow();
	console.log(fechaPrueba);

	//core
	$$.getElementById('btnRegistrar').addEventListener('click', function(e){
		e.preventDefault();

 		var form = $('#formRegistry');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {
		var data = {};

			$$.getElementById('formRegistry').querySelectorAll('input').forEach(
				function(currentValue) {
					if (currentValue.type == 'radio') {
						if (currentValue.checked) {
							data[currentValue.getAttribute('name')] = currentValue.value;
						}
					} else {
						data[currentValue.getAttribute('name')] = currentValue.value;
					}
				}
			);
			data['aplicaPerfil'] = aplicaPerfil;
			data['tipo_id_ext_per'] = tipo_id_ext_per;
			data['pais'] = paisUser;
			data['otro_telefono'] = $$.getElementById('phoneType').value;
			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
			//data['sexo'] = $$.getElementById('phoneType').value

			callNovoCore('POST', 'User', 'registry', data, function(response) {
				if (response.code == 0) {
					console.log('form PASO la validacion y envié datos al servidor');
					//$$.location.href = response.data;
				}
			});
		}















	});

	//functions
	function formatDate_ddmmy(dateToFormat) {
		var month = dateToFormat.getMonth();
		var day = dateToFormat.getDate().toString();
		var year = dateToFormat.getFullYear();

		year = year.toString().substr(-2);
		month = (month + 1).toString();

		if (month.length === 1)
		{
				month = '0' + month;
		}

		if (day.length === 1)
		{
				day = '0' + day;
		}
		return month + day + year;
	}

	$('#userpwd').keyup(function() {
		var longitud, mt, cap, car, cons, esp;
		// set password variable
		var pswd = $(this).val();
		//validate the length
		if ( pswd.length < 8 || pswd.length > 15 ) {
			$('#length').removeClass('rule-valid').addClass('rule-invalid');
			longitud = false;
		} else {
			$('#length').removeClass('rule-invalid').addClass('rule-valid');
			longitud = true;
		}

		//validate letter
		if ( pswd.match(/[a-z]/) ) {
			$('#letter').removeClass('rule-invalid').addClass('rule-valid');
			mt = true;
		} else {
			$('#letter').removeClass('rule-valid').addClass('rule-invalid');
			mt = false;
		}

		//validate capital letter
		if ( pswd.match(/[A-Z]/) ) {
			$('#capital').removeClass('rule-invalid').addClass('rule-valid');
			cap = true;
		} else {
			$('#capital').removeClass('rule-valid').addClass('rule-invalid');
			cap = false;
		}

		//validate number

		if (!pswd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pswd.match(/\d{1}/) ) {
			$('#number').removeClass('rule-invalid').addClass('rule-valid');
			car = true;
		} else {
			$('#number').removeClass('rule-valid').addClass('rule-invalid');
			car = false;
		}

		if (! pswd.match(/(.)\1{2,}/) ) {
			$('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');
			cons = true;
		} else {
			$('#consecutivo').removeClass('rule-valid').addClass('rule-invalid');
			cons = false;
		}

		if ( pswd.match(/([!@\*\-\?¡¿+\/.,_#])/ )) {
			$('#especial').removeClass('rule-invalid').addClass('rule-valid');
			esp = true;
		} else {
			$('#especial').removeClass('rule-valid').addClass('rule-invalid');
			esp = false;
		}
		if((longitud == true)&& (mt == true) && (cap == true) && (car == true) &&  (cons == true) && (esp == true)){
			$('#btnRegistrar').removeAttr("disabled");
		}else{
			$('#btnRegistrar').attr("disabled", true);
		}

	})

});


