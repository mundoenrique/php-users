'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var maxBirthdayDate = new Date();
	maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);
	var btnTrigger = $$.getElementById('btnActualizar');
	var txtBtnTrigger = btnTrigger.innerHTML.trim();

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

})
