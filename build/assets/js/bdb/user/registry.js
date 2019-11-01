'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnRegistry = $$.getElementById('btnRegistrar');
	var maxBirthdayDate = new Date();
  maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);
	console.log(maxBirthdayDate);

	//core

	$( "#birthDate" ).datepicker( {
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y"
	});

	btnRegistrar.addEventListener('click', function(e){
		e.preventDefault();

		var form = $('#formRegistry');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtBtnRegistry = btnRegistry.innerHTML.trim();
			btnRegistry.innerHTML = msgLoading;

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

			callNovoCore('POST', 'User', 'registry', data, function(response) {
				notiSystem(response.title, response.msg, response.className, response.data);
				btnRegistry.innerHTML = txtBtnRegistry;
			});
		}
	});

	//functions
	$$.getElementById('userpwd').addEventListener('keyup',function() {
		var pswd = $$.getElementById('userpwd').value;
		var resultValidate = false;
		var validations = {
			length: pswd.length > 8 && pswd.length < 15,
			letter: pswd.match(/[a-z]/),
			capital: pswd.match(/[A-Z]/),
			number: !pswd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pswd.match(/\d{1}/),
			consecutivo: !pswd.match(/(.)\1{2,}/),
			especial: pswd.match(/([!@\*\-\?¡¿+\/.,_#])/)
		}

		Object.keys(validations).forEach(function(rule){
			if ( validations[rule] ) {
				$(`#${rule}`).removeClass('rule-invalid').addClass('rule-valid');
				resultValidate = true;
			} else {
				$(`#${rule}`).removeClass('rule-valid').addClass('rule-invalid');
				resultValidate = false;
			}
		});

		if(resultValidate){
			$('#btnRegistrar').removeAttr("disabled");
		}else{
			$('#btnRegistrar').attr("disabled", true);
		}
	})
});


