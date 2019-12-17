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
			btnTriggerOTP.disabled = true;
			console.log("todo bien");

		} else {
			console.log("campos no válidos");
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
