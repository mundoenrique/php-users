'use strict'
var longProfile;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide();
	longProfile = $('#longProfile').val();

	$('#birthDate').datepicker({
		yearRange: '-90:' + currentDate.getFullYear(),
		minDate: '-90y',
		maxDate: '-18y',
		changeMonth: true,
		changeYear: true,
		onSelect: function (selectedDate) {
			$(this).focus().blur();
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
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
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
		} else {
			scrollTopPos($('#profileUserForm').offset().top);
		}
	});

	if (lang.CONF_PROFESSION == 'ON') {
		getProfessions();
	}

	if (lang.CONF_CONTAC_DATA == 'ON') {
		getStates();

		$('#state').on('change', function () {
			if ($(this).find('option:first').val() == '') {
				$(this).find('option').get(0).remove()
			}

			$('#city').children().remove();
			$('#city').prepend('<option value="" selected>Selecciona</option>');
			$('#district').children().remove();
			$('#district')
				.prop('disabled', true)
				.prepend('<option value="" selected>Selecciona</option>');

			getCities(this.value);
		});

		$('#city').on('change', function () {
			if ($(this).find('option:first').val() == '') {
				$(this).find('option').get(0).remove()
			}

			if (longProfile == 'S') {
				$('#district').children().remove();
				$('#district').prepend('<option value="" selected>Selecciona</option>');

				getdistrict(this.value)
			}
		});

		$('#district').on('change', function () {
			if ($(this).find('option:first').val() == '') {
				$(this).find('option').get(0).remove()
			}
		});
	} else {
		$('select').find('option').prop('disabled', false);
	}
});

function updateProfile() {
	who = 'User'; where = 'updateProfile';

	callNovoCore(who, where, data, function (response) {
		$('#profileUserBtn').text(btnText);
		insertFormInput(false);
	});
}
