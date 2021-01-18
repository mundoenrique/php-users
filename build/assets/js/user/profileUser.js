'use strict'
var longProfile;
var CurrentVerifierCode = '';
var formFile;

$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide();
	longProfile = $('#longProfile').val();
	formFile = $('#profileUserForm');

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

	$('#landLine').on('change', function () {
		console.log('cambio');
		if (lang.CONF_ACCEPT_MASKED_LANDLINE == 'ON') {
			console.log('apagar');
			lang.CONF_ACCEPT_MASKED_LANDLINE = 'OFF';
		}
	});

	$('#profileUserBtn').on('click', function(e) {
		e.preventDefault();

		if ($('#noPublicOfficeOld').is(':checked')) {
			$('#publicOffice, #publicInst').val('');
		}

		form = $('#profileUserForm');
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			data.gender = $('input[name=gender]:checked').val();
			data.notEmail = $('#notEmail').is(':checked') ? '1' : '0';
			data.notSms = $('#notSms').is(':checked') ? '1' : '0';
			delete data.genderMale;
			delete data.genderFemale;

			if (longProfile == 'S') {
				data.publicOfficeOld = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
				data.taxesObligated = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
				data.protection = $('#protection').is(':checked') ? '1' : '0';
				data.contract = $('#contract').is(':checked') ? '1' : '0';
				delete data.yesTaxesObligated;
				delete data.noTaxesObligated;
				delete data.acceptTerms;
			}

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
			$('.drop-zone-input').each(function (index, element) {
				if ($(element).hasClass('has-error')) {
					$(element).parent('.drop-zone').addClass('has-error-file');
				}
			});

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
