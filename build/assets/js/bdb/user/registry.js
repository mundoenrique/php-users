'use strict';
document.addEventListener('DOMContentLoaded', function(){
	//vars

	//core
	document.getElementById('btnValidar').addEventListener('click',function(e){
		e.preventDefault();

		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var document_id = document.getElementById('documentID').value;

			var data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				telephone_number: document.getElementById('telephoneNumber').value
			}

			callNovoCore('POST', 'User', 'registryValidation', data, function(response) {
				//TODO procesar response
				console.log(response.data);
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



