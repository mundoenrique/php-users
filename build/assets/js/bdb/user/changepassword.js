'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnTrigger = $$.getElementById('btnChangePassword');
	var btnShowPwd = document.getElementById('pwd-addon');
	btnTrigger.disabled = true;

	//core
	btnShowPwd.addEventListener("click", function() {
		var x = $(this).closest('.input-group').find('input');
		if (x.prop("type") == 'password') {
			x.prop("type", "text");
		} else {
			x.prop("type", "password");
		}
	});

	btnTrigger.addEventListener('click', function(e){
		e.preventDefault();

		document.getElementById("currentPassword").type = 'password';
		document.getElementById("newPassword").type = 'password';
		var form = $('#formChangePassword');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtBtnTrigger = btnTrigger.innerHTML.trim();
			btnTrigger.innerHTML = msgLoading;
			btnTrigger.disabled = true;

			var data = {};
			$$.getElementById('formChangePassword').querySelectorAll('input').forEach(
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
			callNovoCore('POST', 'User', 'changePassword', data, function(response) {
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			});
		}
	});

	//functions
	$$.getElementById('newPassword').addEventListener('keyup',function() {
		var pswd = $$.getElementById('newPassword').value;
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
		btnTrigger.disabled = !resultValidate;
	})
});


