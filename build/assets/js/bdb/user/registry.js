'use strict';

document.addEventListener('DOMContentLoaded', function(){

	//vars

	//core
	document.getElementById('btn-validar').addEventListener('click',function(e){
		e.preventDefault();

		var form = $('#form-verify-account');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var document_id = document.getElementById('document-id').val;
			var telephone_number = document.getElementById('telephone-number').val;

			var data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				telephone_number: telephone_number
			}

			callNovoCore('POST', 'User', 'registryValidation', data, function(response) {
				//TODO procesar response
				console.log(response);
			});

		}else{
			console.log('form no valido');
		}
	});

	//functions
	function formatDate_ddmmy(dateToFormat)
	{
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

});



