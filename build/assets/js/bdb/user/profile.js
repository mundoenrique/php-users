'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var maxBirthdayDate = new Date();
	var btnTrigger = $$.getElementById('btnActualizar');
	var listStates = $$.getElementById('department');
	var listCity = $$.getElementById('ctrlCity');
	var txtBtnTrigger = btnTrigger.innerHTML.trim();

	maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);
	//core
	$( "#birthDate" ).datepicker( {
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y"
	});

	btnTrigger.addEventListener('click', function(){

		var form = $('#formProfile');
		validateForms(form, {handleMsg: true});
		if(form.valid()) {
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
			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'updateProfile', data, function(response) {
				btnTrigger.innerHTML = txtBtnRegistry;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			});
		}
	});

	listStates.addEventListener('change', function(){
		if (this.value !== '') {
			listCity.classList.remove('none');
			data = {
				codState: this.value,
			}

			callNovoCore('POST', 'User', 'getListCitys', data, function(response) {
				console.log(response.data);
			});

		}else{
			listCity.classList.add('none');
		}
	});
})
