'use strict'
var longProfile;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide();
	var cityCod = $('#city').val();
	longProfile = $('#longProfile').val();

	$('#birthDate').datepicker({
		yearRange: '-90:' + currentDate.getFullYear(),
		minDate: '-90y',
		maxDate: '-18y',
		changeMonth: true,
		changeYear: true,
		onSelect: function (selectedDate) {
			$(this)
				.focus()
				.blur();
		}
	});

	$('#phoneType').change(function () {
		var selectedOption = $(this).children('option:selected').val();
		var disableInput = false;

		if (selectedOption == '') {
			$('#otherPhoneNum').val('');
			disableInput = true;
		}

		$('#otherPhoneNum').prop('disabled', disableInput);
	});

	$('#profileUserBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#profileUserForm');
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.address = $('#address').val();
			data.notEmail = $('#notEmail').is(':checked') ? '1' : '0';
			data.notSms = $('#notSms').is(':checked') ? '1' : '0';
			$(this).html(loader);
			insertFormInput(true);
			updateProfile();
		}
	});

	if (lang.CONF_PROFESSION == 'ON') {
		getProfessions();
	}

	if (lang.CONF_CONTAC_DATA == 'ON') {
		if (cityCod == '') {
			$('#city')
				.prop('disabled', true)
				.find('option:selected')
				.text('Selecciona');
		}

		$('#state').on('change', function () {
			getCities(this.value)
		});

		if (longProfile == 'S') {
			$('#district')
				.prop('disabled', true)
				.find('option:selected')
				.prop('disabled', true)
				.text('Selecciona');

			$('#city').on('change', function () {
				getdistrict(this.value)
			});
		}

		getStates();
	} else {
		$('select').find('option').prop('disabled', false)
	}
});

function updateProfile() {
	who = 'User'; where = 'updateProfile';

	callNovoCore(who, where, data, function (response) {
		$('#profileUserBtn').text(btnText);
		insertFormInput(false);
	});
}

function getProfessions() {
	$('#profession').prop('disabled', true)
	var currentProf = $('#profession').val();

	$('#profession').find('option').get(0).remove();
	$('#profession').append('<option value="" selected disabled>Esperando Profesiones</option>');

	who = 'Assets'; where = 'ProfessionsList';
	data = {
		prof: 'All'
	};

	callNovoCore(who, where, data, function (response) {
		if (response.code == 0) {
			$.each(response.data, function (pos, prof) {
				var selected = currentProf == prof.profId ? 'selected' : ''
				$('#profession').append('<option value="' + prof.profId + '" ' + selected + '>' + prof.profDesc + '</option>');
			});

			$('#profession').find('option').get(0).remove();

			if (currentProf == '') {
				$('#profession').prepend('<option value="" selected disabled>Selecciona</option>');
			}
		}

		$('#profession').prop('disabled', false);
	});
}

function getStates() {
	$('#state').prop('disabled', true)
	var currentState = $('#state').val();

	$('#state').find('option').get(0).remove();
	$('#state').append('<option value="" selected disabled>Esperando Estados</option>');

	who = 'Assets'; where = 'StatesList';
	data = {
		state: 'All'
	};

	if (longProfile == 'S') {
		where = 'Regions';
		data = {
			groupCode: 1
		};
	}

	callNovoCore(who, where, data, function (response) {
		if (response.code == 0) {
			$.each(response.data, function (pos, state) {
				var selected = currentState == state.regId ? 'selected' : ''
				$('#state').append('<option value="' + state.regId + '" ' + selected + '>' + state.regDesc + '</option>');
			});

			$('#state').find('option').get(0).remove();

			if (currentState == '') {
				$('#state').prepend('<option value="" selected disabled>Selecciona</option>');
			} else {
				getCities(currentState);
			}
		}

		$('#state').prop('disabled', false);
	});
}

function getCities(currentState) {
	var currentCity = $('#city').val();
	var cityName = $('#city').find('option:selected').text()

	if (cityName != 'Selecciona') {
		$('#city').find('option').get(0).remove();
	}

	$('#city').prepend('<option value="" selected disabled>Esperando Ciudades</option>');

	who = 'Assets'; where = 'CityList';
	data = {
		stateCode: currentState
	};

	if (longProfile == 'S') {
		where = 'Regions';
		data = {
			groupCode: currentState
		};
	}

	callNovoCore(who, where, data, function (response) {
		if (response.code == 0) {
			$.each(response.data, function (pos, city) {
				var selected = currentCity == city.regId ? 'selected' : ''
				$('#city').append('<option value="' + city.regId + '" ' + selected + '>' + city.regDesc + '</option>');
			});

			$('#city').find('option').get(0).remove();
			if (cityName == 'Selecciona') {
				$('#city').find('option:selected').prop('disabled', true);
			}
		}

		$('#city').prop('disabled', false);

		if (longProfile == 'S' && currentCity != '') {
			getdistrict(currentCity)
		}
	});
}

function getdistrict(currentCity) {
	var currentDistrict = $('#district').val();

	$('#district').prepend('<option value="" selected disabled>Esperando Distrtos</option>');

	where = 'Regions';
	data = {
		groupCode: currentCity
	};


	callNovoCore(who, where, data, function (response) {
		if (response.code == 0) {
			$.each(response.data, function (pos, district) {
				var selected = currentDistrict == district.regId ? 'selected' : ''
				$('#district').append('<option value="' + district.regId + '" ' + selected + '>' + district.regDesc + '</option>');
			});

			$('#district').find('option').get(0).remove();
			$('#district').prop('disabled', false)
		}

		$('#district').prop('disabled', false);
	});
}
