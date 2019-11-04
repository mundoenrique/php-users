'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	// vars
	var btnTrigger = $$.getElementById('btnContinuar');

	// core
	btnTrigger.addEventListener('click', function(e){
		e.preventDefault();

		var form = $('#formRecoveryAccess');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtbtnTrigger = btnTrigger.innerHTML.trim();
			btnTrigger.innerHTML = msgLoading;

			var data = {};

			$$.getElementById('formRecoveryAccess').querySelectorAll('input').forEach(
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

			callNovoCore('POST', 'User', 'recoveryAccess', data, function(response) {
				btnTrigger.innerHTML = txtbtnTrigger;
				notiSystem(response.title, response.msg, response.data);
			});
		}
	});

	//functions

});


