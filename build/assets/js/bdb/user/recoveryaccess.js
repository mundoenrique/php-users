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
			var typeDocument = $$.getElementById('typeDocument');
			var data = {};

			btnTrigger.innerHTML = msgLoadingWhite;
			btnTrigger.disabled = true;

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

			var codeTypeDocument = typeDocument.options[typeDocument.selectedIndex].value;
			var abbrTypeDocument = dataForm.typeDocument.find(function(e){return e['id'] == codeTypeDocument}).abreviatura

			data['codeTypeDocument'] = codeTypeDocument;
			data['abbrTypeDocument'] = abbrTypeDocument;

			callNovoCore('POST', 'User', 'recoveryAccess', data, function(response) {
				btnTrigger.innerHTML = txtbtnTrigger;
				btnTrigger.disabled = false;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			});
		}
	});

	//functions

});


