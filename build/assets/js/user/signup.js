'use strict'
var longProfile;
var CurrentVerifierCode;
var formFile;

$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	longProfile = $('#longProfile').val();
	CurrentVerifierCode = $('#CurrentVerifierCode').val();
	formFile = $('#signUpForm');

	if (longProfile == 'S') {
		getProfessions();
		getStates();

		$('#state').on('change', function () {
			$('#city').children().remove();
			$('#city').prepend('<option value="" selected>' + lang.GEN_SELECTION + '</option>');
			$('#district').children().remove();
			$('#district').prop('disabled', true).prepend('<option value="" selected>' + lang.GEN_SELECTION + '</option>');

			getCities(this.value);
		});

		$('#city').on('change', function () {
			getdistrict(this.value)
		});
	}

	$('#nickName').on('blur', function () {
		$(this).addClass('available');
		form = $('#signUpForm');
		validateForms(form);
		$(this).removeClass('ignore');

		if ($(this).valid()) {
			where = 'ValidNickName'
			data = {
				nickName: $(this).val().trim()
			}
			$(this).prop('disabled', true);
			getResponseServ(where);
		} else {
			$(this).focus();
		}

		$(this).addClass('ignore');
	});

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	});

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

	$('#landLine').on('change', function () {
		$(this).rules('add', {
			pattern: new RegExp(lang.CONF_REGEX_PHONE, 'i')
		});
	})

	$('#signUpBtn').on('click', function (e) {
		e.preventDefault()

		if ($('#noPublicOfficeOld').is(':checked')) {
			$('#publicOffice, #publicInst').val('');
		}

		form = $('#signUpForm');
		ignoreFields(false, form);
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.newPass = cryptography.encrypt(data.newPass);
			data.confirmPass = cryptography.encrypt(data.confirmPass);

			if (longProfile == 'S') {
				data.publicOfficeOld = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
				data.taxesObligated = $('input[name=taxesObligated]:checked').val() == 'yes' ? '1' : '0';
			}

			if (lang.CONF_LOAD_DOCS == 'ON') {
				var inputFile = $('input[type="file"]');
				var filesToUpload = [];

				if (inputFile.length) {
					inputFile.each(function (i, e) {
						filesToUpload.push({
							'name': e.id,
							'file': $(`#${e.id}`).prop('files')[0]
						}, );
					})
				}
				data.files = filesToUpload;
			}

			$(this).html(loader);
			insertFormInput(true);
			where = 'SignUpData';
			getResponseServ(where);
		} else {
			$('.drop-zone-input').each(function (index, element) {
				if ($(element).hasClass('has-error')) {
					$(element).parent('.drop-zone').addClass('has-error-file');
				}
			});

			scrollTopPos($('#signUpForm').offset().top);
		}
	});

	$('.multi-step-form  .form-container fieldset:not(:first-child)').css({
		'display': 'none',
	});

	// Reset all bars to ensure that all the progress is removed
	$('.multi-step-form > .progress-container > .progress > .progress-bar').each(function (elem) {
		$(this).css({
			'width': '0%',
		});
	});

	$('.multi-step-form > .progress-container .progress-icon').click(function (event) {
		let lastActive = $('.multi-step-form > .progress-container .progress-icon.active').last().data('index');
		let thisFs = $('.multi-step-form .form-container fieldset.active');
		let lastSeen = +$(this).closest('.multi-step-form').find(`fieldset.seen`).last().data('index');

		if (+$(this).data('index') > lastActive) {
			if (!valid(thisFs)) {
				removeViewedFieldsets(lastActive);
				return false;
			}
			if (+$(this).data('index') - 1 == +thisFs.data('index')) {
				$(`.multi-step-form fieldset[data-index=${$(this).data('index')}]`).addClass('seen');
				moveTo($(this).closest('.multi-step-form'), +$(this).data('index'));
			}
		}

		if (+$(this).data('index') <= lastSeen) {
			moveTo($(this).closest('.multi-step-form'), +$(this).data('index'));
		}
		return false;
	});

	$('.multi-step-form .form-container fieldset .multi-step-button button.next').click(function (event) {
		let thisFs = $(this).closest('fieldset');
		let index = +thisFs.data('index');
		let msContainer = thisFs.closest('.multi-step-form');

		if (!valid($(thisFs))) {
			if ($('#internationalCode').hasClass('has-error')) {
				$('.container-flags').addClass('has-error-file');
			}

			return false;
		} else {
			if ($('#internationalCode').hasClass('has-success')) {
				$('.container-flags').removeClass('has-error-file');
			}

			msContainer.find(`fieldset[data-index=${index + 1}]`)
				.addClass('seen');
			msContainer.find(`div.progress-container > div.progress > div.progress-bar[data-index=${index}]`).parent()
				.addClass('seen');
		}
		moveTo(msContainer, index + 1);
		return false;
	});

	$('.multi-step-form .form-container fieldset .multi-step-button button.back').click(function (event) {
		let thisFs = $(this).closest('fieldset');
		let index = +thisFs.data('index');
		let msContainer = thisFs.closest('.multi-step-form');
		moveTo(msContainer, index - 1);
		return false;
	});

});

function valid(button) {
	let fieldset = button.closest('fieldset');
	let form = $('#signUpForm');
	let valid = true;

	var seenFieldsets = $('.multi-step-form fieldset:not(.seen)');
	var ErrorIndexes;
	ignoreFields(false, formFile);
	seenFieldsets.each(function (index, element) {
		ignoreFields(true, $(element));
	})
	validateForms(formFile);
	formFile.valid();
	ErrorIndexes = getErrorIndexes();
	setTextClass(ErrorIndexes);


	ignoreFields(true, form);
	ignoreFields(false, fieldset);
	validateForms(form);

	if (!form.valid()) {
		fieldset.removeClass('valid');
		var currentIndex = Number(fieldset.attr("data-index"));
		removeViewedFieldsets(currentIndex);
		valid = false;
	} else {
		fieldset.addClass('valid');
	}
	fieldset.addClass('was-validated');
	return valid;
}
let animating = 0;

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

function ignoreFields(action, form) {
	if (action) {
		form.find('input, select, textarea').addClass('ignore');
	} else {
		form.find('input, select, textarea').removeClass('ignore');
	}
}

function removeViewedFieldsets(index) {
	var total = $('fieldset').length;

	for (let i = index + 1; i < total + 1; i++) {
		$('fieldset[data-index=' + i + ']').removeClass('seen');
	}
}
