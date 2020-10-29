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

	var urlImage = $('#backImg').val();

	convertImg(urlImage, function( base64_data ) {
		var previewImages = ['INE_A', 'INE_R'];
		var idSrc;

		$.each(previewImages, function(i, element){
			idSrc = element;
			if ($('#loadImage').val() == 'true') {
				$(`.${idSrc}`).append(`<img id="backImg-${idSrc}" class="drop-zone-thumb" style="object-fit: cover;" src="${base64_data}">`)
				.find(`.section-${idSrc} span, .section-${idSrc} i`)
				.hide();

				$(`#${idSrc}`).addClass('ignore');
			}else{
				$(`.${idSrc}`).find(`.section-${idSrc} span, .section-${idSrc} i`).show();
			}
			$(`.${idSrc}`).on('click', function (e) {
				$(`#backImg-${e.target.id}`).remove();
				$(`.${e.target.id}`).find(`.section-${e.target.id} span, .section-${e.target.id} i`).show();

				if ($(`#${e.target.id}`).hasClass('ignore')) {
					$(`#${e.target.id}`).removeClass('ignore');
				}
			});
		});
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

			if (lang.CONF_LOAD_DOCS == 'ON') {
				var inputFile = $('input[type="file"]');
				var filesToUpload = [];

				if (inputFile.length) {
					inputFile.each(function(i,e){
						filesToUpload.push(
							{'name': e.id, 'file': $(`#${e.id}`).prop('files')[0]},
						);
					})
				}
				data.files = filesToUpload;
			}

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

	$('#district').prepend('<option value="" selected disabled>Esperando Distritos</option>');

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

function convertImg(url, callback) {
	var img = new Image();
	img.crossOrigin = 'Anonymous';

	img.onload = function() {
		var canvas = document.createElement('CANVAS');
		var ctx = canvas.getContext('2d');
		var dataURL;
		canvas.height = this.height;
		canvas.width = this.width;
		ctx.drawImage(this, 0, 0);
		dataURL = canvas.toDataURL();
		callback(dataURL);
		canvas = null;
	};

	img.src = url;
};
