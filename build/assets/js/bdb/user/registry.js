'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnRegistry = $$.getElementById('btnRegistrar');
	var maxBirthdayDate = new Date();
  maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);

	//core

	$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
	$.datepicker.setDefaults($.datepicker.regional['es']);

	$( "#birthDate" ).datepicker( {
    changeMonth: true,
		changeYear: true,
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y",
		showAnim: "slideDown",
	});

	btnRegistrar.addEventListener('click', function(e){
		e.preventDefault();

		var form = $('#formRegistry');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtBtnRegistry = btnRegistry.innerHTML.trim();
			btnRegistry.innerHTML = msgLoading;

			var data = {};

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
			data['aplicaPerfil'] = aplicaPerfil;
			data['tipo_id_ext_per'] = tipo_id_ext_per;
			data['pais'] = paisUser;
			data['otro_telefono'] = $$.getElementById('phoneType').value;
			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'registry', data, function(response) {
				notiSystem(response.title, response.msg, response.className, response.data);
				btnRegistry.innerHTML = txtBtnRegistry;
			});
		}
	});

	//functions
	$$.getElementById('userpwd').addEventListener('keyup',function() {
		var pswd = $$.getElementById('userpwd').value;
		var resultValidate = false;
		var validations = {
			length: pswd.length > 8 && pswd.length < 15,
			letter: pswd.match(/[a-z]/),
			capital: pswd.match(/[A-Z]/),
			number: !pswd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pswd.match(/\d{1}/),
			consecutivo: !pswd.match(/(.)\1{2,}/),
			especial: pswd.match(/([!@\*\-\?¡¿+\/.,_#])/)
		}

		Object.keys(validations).forEach(function(rule){
			if ( validations[rule] ) {
				$(`#${rule}`).removeClass('rule-invalid').addClass('rule-valid');
				resultValidate = true;
			} else {
				$(`#${rule}`).removeClass('rule-valid').addClass('rule-invalid');
				resultValidate = false;
			}
		});

		if(resultValidate){
			$('#btnRegistrar').removeAttr("disabled");
		}else{
			$('#btnRegistrar').attr("disabled", true);
		}
	})
});


