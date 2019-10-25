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
		var data = {};

			$$.getElementById('formRegistry').querySelectorAll('input').forEach(
				function(currentValue) {
					data[currentValue.getAttribute('id')] = currentValue.value;
				}
			);
			data['aplicaPerfil'] = aplicaPerfil;
			data['tipo_id_ext_per'] = tipo_id_ext_per;
			data['pais'] = paisUser;
			data['otro_telefono'] = $$.getElementById('phoneType').value;
			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
			//data['sexo'] = $$.getElementById('phoneType').value

			callNovoCore('POST', 'User', 'registry', data, function(response) {
				if (response.code == 0) {
					console.log('form PASO la validacion y envié datos al servidor');
					//$$.location.href = response.data;
				}
			});
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



