'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	var fechaPrueba;//vars

	$( "#birthDate" ).datepicker( {
		dateFormat: "dd/mm/yy"
	});
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
				notiSystem(response.title, response.msg, response.className, response.data);
				//if (response.code == 0) {}
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


	$$.getElementById('userpwd').addEventListener('keyup',function() {
		var resultValidate = false;
		var pswd = $$.getElementById('userpwd').value;
		//validate the length
		if ( pswd.length < 8 || pswd.length > 15 ) {
			$('#length').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = true;
		} else {
			$('#length').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = false;
		}

		//validate letter
		if ( pswd.match(/[a-z]/) ) {
			$('#letter').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = true;
		} else {
			$('#letter').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = false;
		}

		//validate capital letter
		if ( pswd.match(/[A-Z]/) ) {
			$('#capital').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = true;
		} else {
			$('#capital').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = false;
		}

		//validate number
		if (!pswd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pswd.match(/\d{1}/) ) {
			$('#number').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = true;
		} else {
			$('#number').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = false;
		}

		if (! pswd.match(/(.)\1{2,}/) ) {
			$('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = true;
		} else {
			$('#consecutivo').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = false;
		}

		if ( pswd.match(/([!@\*\-\?¡¿+\/.,_#])/ )) {
			$('#especial').removeClass('rule-invalid').addClass('rule-valid');
			resultValidate = true;
		} else {
			$('#especial').removeClass('rule-valid').addClass('rule-invalid');
			resultValidate = false;
		}

		if(resultValidate){
			$('#btnRegistrar').removeAttr("disabled");
		}else{
			$('#btnRegistrar').attr("disabled", true);
		}

	})

});


