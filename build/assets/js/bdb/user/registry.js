'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var inputConfirmEmail = $$.getElementById('confirmEmail');
	var inputConfirmUserpwd = $$.getElementById('confirmUserpwd');
	var btnRegistry = $$.getElementById('btnRegistrar');
	var maxBirthdayDate = new Date();
	var btnShowPwd = $$.getElementById('pwdAddon');
  maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);

	//core
	$( "#birthDate" ).datepicker( {
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y"
	});

	// Mostrar/Ocultar Contraseña
	btnShowPwd.style.cursor = "pointer";
	btnShowPwd.addEventListener("click", function() {
		var inputpwd = this.closest('.input-group').querySelector('input');
		if (inputpwd.type == 'password') {
			inputpwd.type = "text";
		} else {
			inputpwd.type= "password";
		}
	});

	btnRegistrar.addEventListener('click', function(e){
		e.preventDefault();

		document.getElementById("userpwd").type = 'password';
		var form = $('#formRegistry');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtBtnRegistry = btnRegistry.innerHTML.trim();
			btnRegistry.innerHTML = msgLoadingWhite;

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
			data['tipo_id_ext_per'] = dataRegistryFrm.code_tipo_id_ext_per;
			data['pais'] = dataRegistryFrm.paisUser;
			data['otro_telefono'] = $$.getElementById('phoneType').value;
			data['username'] = $$.getElementById('username').value.toUpperCase();
			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'registry', data, function(response) {
				btnRegistry.innerHTML = txtBtnRegistry;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
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
	});

	inputConfirmEmail.oncut = inputConfirmEmail.oncopy = inputConfirmEmail.onpaste = function(e) {
		this.nextSibling.nextSibling.innerText = 'Operación no válida.'
    return false;
	};

	inputConfirmUserpwd.oncut = inputConfirmUserpwd.oncopy = inputConfirmUserpwd.onpaste = function(e) {
		this.nextSibling.nextSibling.innerText = 'Operación no válida.'
    return false;
	};
});


