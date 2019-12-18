'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var maxBirthdayDate = new Date();
	var btnTrigger = $$.getElementById('btnActualizar');
	var listStates = $$.getElementById('department');
	var listCity = $$.getElementById('city');
	var txtBtnTrigger = btnTrigger.innerHTML.trim();
	var loadingOption = createElement('option', {value: ''});
	var selectOption = createElement('option', {value: ''});

	//core
	maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);
	loadingOption.textContent = 'Cargando...';
	selectOption.textContent = 'Seleccione';

	$( "#birthDate" ).datepicker( {
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y"
	});

	btnTrigger.addEventListener('click', function(){

		var form = $('#formProfile');
		validateForms(form, {handleMsg: true});
		if(form.valid()) {
			var dataForm = {};
			$$.getElementById('formProfile').querySelectorAll('input').forEach(
				function(currentValue) {
					switch (currentValue.type) {
						case 'radio':
							if (currentValue.checked) {
								dataForm[currentValue.getAttribute('name')] = currentValue.value;
							}
							break;

						case 'checkbox':
							dataForm[currentValue.getAttribute('name')] = currentValue.checked? '1': '0';
							break;

						default:
							dataForm[currentValue.getAttribute('name')] = currentValue.value;
							break;
					}
				}
			);

			$$.getElementById('formProfile').querySelectorAll('select').forEach(
				function(currentValue) {
						dataForm[currentValue.getAttribute('name')] = currentValue.value;
				}
			);

			// var elPhoneType = $$.getElementById('phoneType');
			// dataForm['descriptionPhoneType'] = elPhoneType.options[elPhoneType.selectedIndex].innerHTML;

			dataForm['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'updateProfile', dataForm, function(response) {
				btnTrigger.innerHTML = txtBtnTrigger;
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			});
		}
	});

	listStates.addEventListener('change', function(){
		if (this.value !== '') {

			while (listCity.firstChild) {
				listCity.removeChild(listCity.firstChild);
			}
			listCity.appendChild(loadingOption);
			data = {
				codState: this.value,
			}
			listCity.disabled = true;

			callNovoCore('POST', 'User', 'getListCitys', data, function(response) {

				listCity.removeChild(listCity.firstChild);
				if (response.code === 0) {
					listCity.appendChild(selectOption);
					response.data.forEach(function callback(currentValue) {
						var city = createElement('option', {value: currentValue.codCiudad});
						city.textContent = currentValue.ciudad;
						listCity.appendChild(city);
					});
					listCity.disabled = false;
				} else {
					var noResponse = createElement('option', {value: ''});
					noResponse.textContent = response.data.descripcion;
					listCity.appendChild(noResponse);
				}
			});
		}
	});
})

var createElement = function (tagName, attrs) {

	var el = document.createElement(tagName);
	Object.keys(attrs).forEach((key) => {
		if (attrs [key] !== undefined) {
			el.setAttribute(key, attrs [key]);
		}
	});

	return el;
}
