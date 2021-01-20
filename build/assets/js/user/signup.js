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
			$('#city').prepend('<option value="" selected>Selecciona</option>');
			$('#district').children().remove();
			$('#district').prop('disabled', true).prepend('<option value="" selected>Selecciona</option>');

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

	$('#signUpBtn').on('click', function (e) {
		e.preventDefault()

		if ($('#noPublicOfficeOld').is(':checked')) {
			$('#publicOffice, #publicInst').val('');
		}

		lang.CONF_ACCEPT_MASKED_LANDLINE = 'OFF'
		form = $('#signUpForm');
		ignoreFields(false, form);
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.newPass = cryptoPass(data.newPass);
			data.confirmPass = cryptoPass(data.confirmPass);

			if (longProfile == 'S') {
				data.publicOfficeOld = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
				data.taxesObligated = $('input[name=publicOfficeOld]:checked').val() == 'yes' ? '1' : '0';
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

	$('form.needs-validation').each((idx, form) => {
		$(form).find('button').each((idx, button) => {
			$(button).click(function () {
				// if (!valid($(button))) {
				//   event.preventDefault();
				//   event.stopPropagation();
				// }
			});
		});
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

		if ($(this).attr('id') == 'signUpBtn') {
			return false;
		}

		if (!valid($(thisFs))) {
			return false;
		} else {
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

function getErrorIndexes() {
	var errorElements;
	var indexes = [];
	errorElements = formFile.find('.has-error');
	errorElements.each(function () {
		if (!indexes.includes($(this).closest('fieldset').data('index'))) {
			indexes.push($(this).closest('fieldset').data('index'));
		}
	})

	return indexes;
}

function setTextClass(indexes) {
	var progressIcons = $('div.progress-icon');
	progressIcons.each(function () {
		if (indexes.includes($(this).data('index'))) {
			$(this).find('.progress-text').addClass('danger');
		} else {
			$(this).find('.progress-text').removeClass('danger');
		}
	})
}
