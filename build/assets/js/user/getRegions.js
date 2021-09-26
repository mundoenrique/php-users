'use strcit'
$(function() {
	$('#averageIncome').mask('#' + lang.CONF_THOUSANDS + '##0' + lang.CONF_DECIMAL + '00', { reverse: true });
	$('#averageIncome').on('keyup', function () {
		$(this).val(function (index, value) {

			if (value.indexOf('0') != -1 && value.indexOf('0') == 0) {
				value = value.replace(0, '');
			}

			if (value.length == 1 && /^[0-9,.]+$/.test(value)) {
				value = '00' + lang.CONF_DECIMAL + value
			}

			return value
		})
	});

	$('input:radio[name=publicOfficeOld]').on('change', function() {
		switch (this.value) {
			case 'yes':
				$('#publicOffice, #publicInst').removeClass('ignore');
			break;
			case 'no':
				$('#publicOffice, #publicInst')
					.addClass('ignore').val('').removeAttr('aria-describedby').removeClass('has-error').parent('.form-group').find('.help-block').text('');
			break;
		}

	});
});

function getProfessions() {
	$('#profession').prop('disabled', true)
	var currentProf = $('#profession').val();

	$('#profession').find('option').get(0).remove();
	$('#profession').append('<option value="" selected disabled>' + lang.GEN_WAITING_PROFESSIONS + '</option>');

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
				$('#profession').prepend('<option value="" selected disabled>' + lang.GEN_SELECTION + '</option>');
			}
		}

		$('#profession').prop('disabled', false);
	});
}

function getStates() {
	var currentState = $('#state').val();
	$('#state').prop('disabled', true);

	if (currentState != '') {
		$('#state').find('option').get(0).remove();
	}

	$('#state').prepend('<option value="" selected disabled>' + lang.GEN_WAITING_STATES + '</option>');

	who = 'Assets'; where = 'StatesList';
	data = {
		state: 'All'
	};

	if (longProfile == 'S' || lang.CONF_UPDATE_COUNTRY == 'ON') {
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
				$('#state')
					.find('option:selected')
					.prop('disabled', true);
			} else {
				getCities(currentState);
			}
		}

		$('#state').prop('disabled', false);
	});
}

function getCities(currentState) {
	var currentCity = $('#city').val();

	if (currentCity != '') {
		$('#city').find('option').get(0).remove()
	}

	$('#city')
		.prop('disabled', true)
		.prepend('<option value="" selected disabled>' + lang.GEN_WAITING_CITIES + '</option>');

	who = 'Assets'; where = 'CityList';
	data = {
		stateCode: currentState
	};

	if (longProfile == 'S' || lang.CONF_UPDATE_COUNTRY == 'ON') {
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

			if (currentCity == '') {
				$('#city').find('option:selected').prop('disabled', true);
			}
		}

		if ((longProfile == 'S' || lang.CONF_UPDATE_COUNTRY == 'ON') && currentCity != '') {
			getdistrict(currentCity)
		}

		$('#city').prop('disabled', false);
	});
}

function getdistrict(currentCity) {
	var currentDistrict = $('#district').val();

	if (currentDistrict != '') {
		$('#district').find('option').get(0).remove();
	}

	$('#district')
		.prop('disabled', true)
		.prepend('<option value="" selected disabled>' + lang.GEN_WAITING_DISTRICTS + '</option>');

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

			if (currentDistrict == '') {
				$('#district')
					.find('option:selected')
					.prop('disabled', true);
			}
		}

		$('#district').prop('disabled', false);
	});
}
