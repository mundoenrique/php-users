'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

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
	})

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	})

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
	})

	$('#signUpBtn').on('click', function (e) {
		e.preventDefault()
		form = $('#signUpForm');
		console.log('confirmar click');
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
			scrollTopPos($('#signUpForm').offset().top);
		}
	})
})

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
	// if (!valid($(thisFs)`fieldset.active`)) {
	//   return false;
	// }
	let lastSeen = +$(this).closest('.multi-step-form').find(`fieldset.seen`).last().data('index');
	console.log($(this).closest('.multi-step-form').find(`fieldset.seen`));
	if (+$(this).data('index') <= lastSeen) {
		moveTo($(this).closest('.multi-step-form'), +$(this).data('index'));
	}
	return false;
});

$('.multi-step-form .form-container fieldset > .multi-step-button button.next').click(function (event) {
	let thisFs = $(this).closest('fieldset');
	let index = +thisFs.data('index');
	let msContainer = thisFs.closest('.multi-step-form');

	if ($(this).attr('id') == 'signUpBtn') {
		console.log('sal');
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
	// msContainer.find(`fieldset[data-index=${index + 1}]`)
	//   .addClass('seen');
	return false;
});

$('.multi-step-form .form-container fieldset > .multi-step-button button.back').click(function (event) {
	let thisFs = $(this).closest('fieldset');
	let index = +thisFs.data('index');
	let msContainer = thisFs.closest('.multi-step-form');
	moveTo(msContainer, index - 1);
	// msContainer.find(`fieldset[data-index=${index + 1}]`)
	//   .addClass('seen');
	return false;
});

function valid(button) {
	let fieldset = button.closest('fieldset');
	let form = $('#signUpForm');
	ignoreFields(true, form);
	ignoreFields(false, fieldset);
	let valid = true;
	validateForms(form);
	if (!form.valid()) {
		fieldset.removeClass('valid');
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
					//thisProgress.find('.progress-icon').removeClass('active');
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
			$('#signUpBtn').html(btnText)
			insertFormInput(false)
		}
	})
}

function ignoreFields(action, form) {
	if (action) {
		form.find('input, select, textarea').addClass('ignore');
	} else {
		form.find('input, select, textarea').removeClass('ignore');
	}
}
