'use strict'
var longProfile;
var CurrentVerifierCode = '';
var formFile;
var animating = 0;
var skipFields;

$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide();
	longProfile = $('#longProfile').val();
	formFile = $('#profileUserForm');
	skipFields = getIgnoredFields(formFile);

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

	$('#profileUserBtn').on('click', function (e) {
		e.preventDefault();

		if ($('#noPublicOfficeOld').is(':checked')) {
			$('#publicOffice, #publicInst').val('');
		}

		form = formFile;
		ignoreFields(false, form, skipFields);
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
					inputFile.each(function (i, e) {
						filesToUpload.push(
							{ 'name': e.id, 'file': $(`#${e.id}`).prop('files')[0] },
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

			scrollTopPos(formFile.offset().top);
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

	toPositionFieldsetError(formFile);

	// Reset all bars to ensure that all the progress is removed
	$('.multi-step-form > .progress-container > .progress > .progress-bar').each(function (elem) {
		$(this).css({
			'width': '0%',
		});
	});

	$('.multi-step-form > .progress-container .progress-icon').click(function (event) {
		let thisFs = $('.multi-step-form .form-container fieldset.active');

		if (valid(thisFs)) {
			moveTo($(this).closest('.multi-step-form'), +$(this).data('index'));
		}
		return false;
	});

});

function updateProfile() {
	who = 'User'; where = 'updateProfile';
	callNovoCore(who, where, data, function (response) {
		$('#profileUserBtn').text(btnText);
		insertFormInput(false);
	});
}

function valid(button) {
	let fieldset = button.closest('fieldset');
	let form = formFile;
	ignoreFields(true, form, skipFields);
	ignoreFields(false, fieldset, skipFields);
	let valid = true;
	validateForms(form);
	if (!form.valid()) {
		valid = false;
	} else {
	}
	return valid;
}

function moveTo(msContainer, index) {
	if (animating > 0) {
		return;
	}
	let steps = msContainer.find('div.progress-container').find(`div.progress-bar`).length + 1;
	if (index > steps) {
		return;
	}
	let currFs = msContainer.find(`fieldset.active`);
	let currIndex = currFs.data('index');
	if (currIndex == index) {
		return;
	}
	let next = msContainer.find(`fieldset[data-index=${index}]`);
	let formContainer = msContainer.find('.form-container');
	let stagger = 300;
	animating++;
	formContainer.animate({
		opacity: 0.0,
	}, {
		step: function (now, fx) {
			let scaleAmount = 1 - ((1 - now) * ((1 - 0.9) / (1 - 0.0)));
			$(this).css('transform', 'scale(' + scaleAmount + ')');
		},
		duration: 350,
		easing: 'easeInSine',
		complete: function () {
			currFs.removeClass('active');
			currFs.css({
				'display': 'none'
			});
			next.addClass('active');
			next.css({
				'display': 'block'
			});
			formContainer.animate({
				opacity: 1,
			}, {
				step: function (now, fx) {
					let scaleAmount = 1 - ((1 - now) * ((0.9 - 1) / (0 - 1)));
					$(this).css('transform', 'scale(' + scaleAmount + ')');
				},
				duration: 350,
				easing: 'easeInSine',
				complete: function () {
					animating--;
				}
			})
		}
	});
	if (currIndex > index) {
		for (let i = currIndex; i >= index; i--) {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${i}]`);
			if (i === index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					if (i === steps - 1) {
						thisProgress.find('.progress-icon').first().addClass('active');
					} else {
						thisProgress.find('.progress-icon').addClass('active');
					}
					animating--;
				}, (currIndex - i - 1) * stagger);
			} else {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					animating--;
				}, (currIndex - i - 1) * stagger);
			}
		}
	} else {
		for (let i = currIndex; i <= index; i++) {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${i}]`);
			if (i < index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '100%'
					});
					thisProgress.find('.progress-icon').addClass('active');
					animating--;
				}, (i - currIndex) * stagger);
			} else if (i === index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					if (i === steps - 1) {
						thisProgress.find('.progress-icon').first().addClass('active');
					} else {
						thisProgress.find('.progress-icon').addClass('active');
					}
					animating--;
				}, (i - currIndex - 1) * stagger);
			}
		}
	}
	if (index === steps) {
		animating++;
		setTimeout(function () {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${index - 1}]`);
			thisProgress.find('.progress-icon').last().addClass('active');
			animating--;
		}, (steps - currIndex - 1) * stagger);
	}
}

function getResponseServ(currentaction) {
	who = 'User';

	callNovoCore(who, where, data, function (response) {
		if (currentaction == 'ValidNickName') {
			$('#nickName').prop('disabled', false)
			switch (response.code) {
				case 0:
					$('#nickName')
						.removeClass('has-error')
						.addClass('has-success available')
						.parent('.input-group').siblings('.help-block').text('');
					break;
				case 1:
					$('#nickName')
						.addClass('has-error')
						.removeClass('has-success available')
						.parent('.input-group').siblings('.help-block').text(response.msg);
					break;
			}
		}

		if (currentaction == 'SignUpData') {
			$('#signUpBtn').html(btnText);
			insertFormInput(false);
		}
	});
}

function ignoreFields(action, form, skip) {
	form.find('input, select, textarea').each(function() {
		if (!skip.includes($(this).attr('id'))) {
			if (action) {
				$(this).addClass('ignore');
			} else {
				$(this).removeClass('ignore');
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

function toPositionFieldsetError(form) {
	var errorElements, firstIndex;
	var fieldsetsIndex = [];
	var fieldsets = 	$('.multi-step-form .form-container fieldset');
	fieldsets.css({'display': 'none'});
	validateForms(formFile);
	if (formFile.valid()) {
		$(fieldsets[0]).addClass('active');
		$(fieldsets[0]).css({'display': 'block'});
	} else {
		errorElements = form.find('.has-error');
		errorElements.each(function () {
			if (!fieldsetsIndex.includes($(this).closest('fieldset').data('index'))) {
				fieldsetsIndex.push($(this).closest('fieldset').data('index'));
			}
		})
		firstIndex = fieldsetsIndex[0];
		$(fieldsets[firstIndex-1]).addClass('active');
		$(fieldsets[firstIndex-1]).css({'display': 'block'});
		moveTo($(fieldsets[firstIndex-1]).closest('.multi-step-form'), firstIndex);
	}
}
