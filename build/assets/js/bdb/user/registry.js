'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars

	$( "#birthDate" ).datepicker( {
		dateFormat: "dd/mm/yy"
	});

	//core
	$$.getElementById('btnRegistrar').addEventListener('click', function(e){
		e.preventDefault();

		var form = $('#formRegistry');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var document_id = $$.getElementById('documentID').value;

			var data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				telephone_number: $$.getElementById('telephoneNumber').value
			}

			callNovoCore('POST', 'User', 'registry', data, function(response) {

				if (response.code == 0) {
					$$.location.href = response.data;
				}
			});

		}else{
			console.log('form no paso la validacion');
		}












		var objFields = {};

		this.querySelectorAll('input').forEach(
			function(currentValue, currentIndex, listObj) {
				objFields[currentValue.getAttribute('id')] = currentValue.getAttribute('id');
			}
		);

		objFields.cpo_name = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
		);

		var dataRequest = CryptoJS.AES.encrypt(JSON.stringify(objFields), objFields.cpo_name, {format: CryptoJSAesJson}).toString();

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



