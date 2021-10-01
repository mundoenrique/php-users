'use strict'
var longProfile;
var CurrentVerifierCode = '';
var formFile;
var animating = 0;
var skipFields;
var ErrorIndexes;

$(function () {
	if ((lang.CONF_INTERNATIONAL_ADDRESS == 'ON' && $('#addresInput').val() === '1') || lang.CONF_CONTAC_DATA == 'ON') {
		changeInputselect($('#internationalCode').attr('iso') || 'all');
	}

	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide();
	longProfile = $('#longProfile').val();
	formFile = $('#profileUserForm');
	skipFields = getIgnoredFields(formFile);
	ErrorIndexes = getErrorIndexes();
	setTextClass(ErrorIndexes);
	toPositionFieldsetError(ErrorIndexes);

	$('#profileUserForm').on('change', function () {
		$('#btn-cancel').attr('href', baseURL + lang.CONF_LINK_USER_PROFILE)
	});

	$('#birthDate').datepicker({
		yearRange: '-90:' + currentDate.getFullYear(),
		minDate: '-90y',
		maxDate: '-18y',
		changeMonth: true,
		changeYear: true,
		onSelect: function () {
			$(this).focus().blur();
		}
	});

	$('#landLine').on('change', function () {
		$(this).rules('add', {
			pattern: new RegExp(lang.CONF_REGEX_PHONE, 'i')
		});
	});


	if (lang.CONF_PROFESSION == 'ON') {
		getProfessions();
	}

	if (lang.CONF_CONTAC_DATA == 'ON') {
		getStates();

		$('#state').on('change', function () {
			$('#stateInput').attr('state-code', '').val('');
			$('#cityInput').attr('city-code', '').val('');
			$('#districtInput').attr('district-code', '').val('');
			$('#city option:first').prop('disabled', false);
			$('#city').children().not(':first').remove();
			$('#city option:first').prop('disabled', true);
			$('#district option:first').prop('disabled', false);
			$('#district').children().not(':first').remove();
			$('#district option:first').prop('disabled', true);

			getCities(this.value);
		});

		$('#city').on('change', function () {
			if (longProfile == 'S' || lang.CONF_INTERNATIONAL_ADDRESS == 'ON') {
				$('#district').children().not(':first').remove();
				getdistrict(this.value)
			}
		});
	} else {
		$('select').find('option').prop('disabled', false);
	}

	// Reset all bars to ensure that all the progress is removed
	$('.multi-step-form > .progress-container > .progress > .progress-bar').each(function (elem) {
		$(this).css({
			'width': '0%',
		});
	});

	$('.multi-step-form > .progress-container .progress-icon').click(function (event) {
		var thisFs = $('.multi-step-form .form-container fieldset.active');

		if (valid(thisFs)) {
			moveTo($(this).closest('.multi-step-form'), +$(this).data('index'));
		}
		return false;
	});

	$('#profileUserBtn').on('click', function (e) {
		var valid;
		e.preventDefault();

		if ($('#noPublicOfficeOld').is(':checked')) {
			$('#publicOffice, #publicInst').val('');
		}

		form = formFile;
		ignoreFields(false, form, skipFields);
		validateForms(form);
		valid = form.valid();
		ErrorIndexes = getErrorIndexes();
		setTextClass(ErrorIndexes);

		if (valid) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			data.gender = $('input[name=gender]:checked').val();
			data.notEmail = $('#notEmail').is(':checked') ? '1' : '0';
			data.notSms = $('#notSms').is(':checked') ? '1' : '0';
			delete data.genderMale;
			delete data.genderFemale;

			if (longProfile == 'S') {
				data.publicOfficeOld = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
				data.taxesObligated = $('input[name=taxesObligated]:checked').val() == 'yes' ? '1' : '0';
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
					inputFile.each(function (i, e) {
						filesToUpload.push({
							'name': e.id,
							'file': $(`#${e.id}`).prop('files')[0]
						});
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

			scrollTopPos(formFile.offset().top);
		}
	});

});

function updateProfile() {
	who = 'User';
	where = 'updateProfile';
	callNovoCore(who, where, data, function (response) {
		$('#profileUserBtn').text(btnText);
		insertFormInput(false);
	});
}

function valid(button) {
	let fieldset = button.closest('fieldset');
	let form = formFile;
	let valid = true;
	ignoreFields(true, form, skipFields);
	ignoreFields(false, fieldset, skipFields);
	validateForms(form);
	valid = form.valid();
	ErrorIndexes = getErrorIndexes();
	setTextClass(ErrorIndexes);
	if (!(valid)) {
		valid = false;
	}
	return valid;
}

function ignoreFields(action, form, skip) {
	form.find('input, select, textarea').each(function () {
		if (!skip.includes($(this).attr('id'))) {
			if (action) {
				$(this).addClass('ignore');
			} else {
				$(this).not('.skip').removeClass('ignore');
			}
		}
	});
}

function getIgnoredFields(form) {
	var ignoredFields = [];
	form.find('input, select, textarea').each(function () {
		if ($(this).hasClass('ignore')) {
			ignoredFields.push($(this).attr('id'));
		}
	})

	return ignoredFields
}

function toPositionFieldsetError(indexes) {
	var firstIndex = indexes[0];
	var fieldsets = $('.multi-step-form .form-container fieldset');
	fieldsets.css({
		'display': 'none'
	});
	if (formFile.valid()) {
		$(fieldsets[0]).addClass('active');
		$(fieldsets[0]).css({
			'display': 'block'
		});
	} else {
		$(fieldsets[firstIndex - 1]).addClass('active');
		$(fieldsets[firstIndex - 1]).css({
			'display': 'block'
		});
		moveTo($(fieldsets[firstIndex - 1]).closest('.multi-step-form'), firstIndex);
	}
}
