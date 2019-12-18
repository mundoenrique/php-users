'use strict';
var $$ = document;
var maxBirthdayDate = new Date();
var btnTrigger = $$.getElementById('btnActualizar');

$$.addEventListener('DOMContentLoaded', function(){
	//vars
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

			disableInputsForm(true, msgLoadingWhite);

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

			var elPhoneType = $$.getElementById('phoneType');
			dataForm['descriptionPhoneType'] = elPhoneType.options[elPhoneType.selectedIndex].innerHTML;
			dataForm['address'] = $$.getElementById('address').value;

			dataForm['cpo_name'] = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			callNovoCore('POST', 'User', 'updateProfile', dataForm, function(response) {
				disableInputsForm(false, txtBtnTrigger);
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

function disableInputsForm(status, txtButton) {
	$$.getElementById('idType').disabled = status;
	$$.getElementById('idNumber').disabled = status;
	$$.getElementById('firstName').disabled = status;
	$$.getElementById('middleName').disabled = status;
	$$.getElementById('lastName').disabled = status;
	$$.getElementById('secondSurname').disabled = status;
	$$.getElementById('birthDate').disabled = status;
	$$.getElementById('genderMale').disabled = status;
	$$.getElementById('genderFemale').disabled = status;
	$$.getElementById('profession').disabled = status;
	$$.getElementById('addressType').disabled = status;
	$$.getElementById('postalCode').disabled = status;
	$$.getElementById('department').disabled = status;
	$$.getElementById('city').disabled = status;
	$$.getElementById('address').disabled = status;
	$$.getElementById('landLine').disabled = status;
	$$.getElementById('mobilePhone').disabled = status;
	$$.getElementById('phoneType').disabled = status;
	$$.getElementById('otherPhoneNum').disabled = status;
	$$.getElementById('email').disabled = status;
	$$.getElementById('username').disabled = status;
	$$.getElementById('creationDate').disabled = status;
	$$.getElementById('notificationsEmail').disabled = status;
	$$.getElementById('notificationsSms').disabled = status;

	btnTrigger.innerHTML = txtButton;
	btnTrigger.disabled = status;
}
