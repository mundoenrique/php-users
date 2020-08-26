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
			var typeDocumentUser = $$.getElementById('typeDocumentUser');
			var typeDocumentBussines = $$.getElementById('typeDocumentBussines');
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

			var codeTypeDocumentUser = typeDocumentUser.options[typeDocumentUser.selectedIndex].value;
			var codeTypeDocumentBussines = typeDocumentBussines.options[typeDocumentBussines.selectedIndex].value;
			var abbrTypeDocumentUser = dataForm.typeDocument.find(function (e) {
				return e['id'] == codeTypeDocumentUser
			}).abreviatura;
			var abbrTypeDocumentBussines = dataForm.typeDocument.find(function (e) {
				return e['id'] == codeTypeDocumentBussines
			}).abreviatura;

			data['codeTypeDocumentUser'] = codeTypeDocumentUser;
			data['abbrTypeDocumentUser'] = abbrTypeDocumentUser;
			data['codeTypeDocumentBussines'] = codeTypeDocumentBussines;
			data['abbrTypeDocumentBussines'] = abbrTypeDocumentBussines;

			callNovoCore('POST', 'User', 'recoveryAccess', data, function(response) {
				btnTrigger.innerHTML = txtbtnTrigger;
				btnTrigger.disabled = false;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			});
		}
	});

	//functions

});


