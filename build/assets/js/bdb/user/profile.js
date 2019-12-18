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
			$$.getElementById('formProfile').querySelectorAll('input').forEach(
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
			data['profession'] = $$.getElementById('profession').value;
			data['department'] = $$.getElementById('department').value;
			data['city'] = $$.getElementById('city').value;
			data['addressType'] = $$.getElementById('addressType').value;
			data['address'] = $$.getElementById('address').value;

			var elPhoneType = $$.getElementById('phoneType');
			data['phoneType'] = elPhoneType.value;
			data['descriptionPhoneType'] = elPhoneType.options[elPhoneType.selectedIndex].innerHTML;

			data['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'updateProfile', data, function(response) {
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
