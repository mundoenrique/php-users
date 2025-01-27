'use strict'
$(function () {
	var ulOptions = $('.nav-item-config');
	var pinManagement = $('input[type=radio][name="recovery"]');
	var virtual = $('#operation').find('input[type=hidden][name="virtual"]').val();
	var thisAction;
	var action;

	if (virtual) {
		$('#replaceMotSol').val(lang.CUST_STOLEN_CARD);
		$('#selectReplacementCard').addClass('none');
		$('#msgReplacementCard').removeClass('none');
	}

	if ($('#operation').find('input[type=hidden][name="status"]').val() == '' && lang.SETT_TEMPORARY_LOCK_REASON == 'ON') {
		$('#temporaryLockReason').removeClass('ignore');
		$('#selectTempLockReason').removeClass('none');
		$('#msgTemporaryLock').addClass('none');
	} else {
		$('#temporaryLockReason').addClass('ignore');
		$('#selectTempLockReason').addClass('none');
		$('#msgTemporaryLock').removeClass('none');
	}

	$('input[type=hidden][name="expireDate"]').each(function(pos, element) {
		var cypher = cryptography.encrypt($(element).val());
		$(element).val(cypher)
	});

	$.each(ulOptions, function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$(ulOptions).removeClass('active');
			$('.option-service').hide();
			$(this).addClass('active');
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		});
	});

	if (ulOptions.length == 1) {
		$(ulOptions).addClass('active');
	}

	$('.slide-slow').click(function (e) {
		if (!$(this).siblings('.section').hasClass('current')) {
			$('.section').fadeOut(400, 'linear');
		}

		$(this).next('.section').slideToggle('slow');
		$('.section').removeClass('current');
		$(this).siblings('.section').addClass('current');
	})

	$('#pinManagementForm').find('input').addClass('ignore');
	pinManagement.first().prop('checked', true);
	$('#' + pinManagement.first().attr('id') + 'Input').removeClass('hide');
	$('#pinManagementBtn').attr('action', pinManagement.first().attr('id'));
	$('#' + pinManagement.first().attr('id') + 'Input').find('input').removeClass('ignore');

	pinManagement.on('change', function (e) {
		var currentActions
		currentActions = e.currentTarget.id;
		$('#pinManagementForm').find('.row').addClass('hide');
		$('#pinManagementForm').find('input').addClass('ignore');
		$('#' + currentActions + 'Input').removeClass('hide');
		$('#' + currentActions + 'Input').find('input').removeClass('ignore')
		$('#pinManagementBtn').attr('action', currentActions);
	})

	$('#system-info').on('click', '.dashboard-item', function (e) {
		var optionCheck = false;
		var event = e.currentTarget;
		var expireDate = $(event).find('input[type=hidden][name="expireDate"]').val();
		var services = JSON.parse($(event).find('input[type=hidden][name="services"]').val());
		var statusCard = $(event).find('input[type=hidden][name="status"]').val();
		var statusText = statusCard == '' ? lang.CUST_TEMPORARY_LOCK : lang.CUST_UNLOCK_CARD;
		var statustextCard = statusCard == '' ? lang.CUST_TEMPORARILY_LOCK : lang.CUST_UNLOCK;

		if (statusCard != '' && statusCard != 'PB') {
			return true;
		}

		$('.status-text1').text(statusText);
		$('.status-text2').text(statustextCard.toLowerCase());
		$('.nav-config-box').removeClass('no-pointer');
		$('.nav-config-box > li').removeClass('active');
		$('#expireDate').val(expireDate);

		$('.nav-config-box > li').each(function(key, element) {
			$(element).hide();
			$('#'+element.id+'View').hide();
			$.each(services, function(pos, value) {
				if ((lang.CUST_SERVICES[element.id]).indexOf(value, 0) != -1) {
					$(element).show();
				}
			})
		})

		pinManagement.each(function(key, element) {
			$(element).parent().hide();
			$('#'+element.id+'Input').addClass('hide');
			$.each(services, function(pos, value) {
				if ((lang.CUS_MANAGE_PIN[element.id]).indexOf(value, 0) != -1) {
					$(element).parent().show();

					if (!optionCheck) {
						optionCheck = true;
						$(element).prop('checked', true);
						$('#' + element.id + 'Input').removeClass('hide');
					}
				}
			})
		})

		if (services.length == 1) {
			if (('130, 217').indexOf(services, 0) == -1) {
				$('.nav-config-box').addClass('no-pointer');
			}

			$('#activeServices > div').each(function(pos, element) {
				$(element).hide();
				$.each(services, function (pos, value) {
					var currentServ = (element.id).slice(0, -4)
					if ((lang.CUST_SERVICES[currentServ]).indexOf(value, 0) != -1) {
						$('#' + currentServ).addClass('active')
						$(element).show();
					}
				})
			})
		}

		if (services.length == 0) {
			modalBtn = {
				btn1: {
					text: lang.GEN_BTN_ACCEPT,
					link: redirectLink,
					action: 'redirect'
				}
			}
			appMessages(lang.GEN_MENU_CUSTOMER_SUPPORT, lang.CUST_PERMANENT_LOCK, lang.SETT_ICON_DANGER, modalBtn);
		}
	});

	$('.send').on('click', function(e) {
		e.preventDefault();
		thisAction = $(this);
		action = thisAction.attr('action');
		var validForm = true;
		var dataFormAction = {};
		$('#action').val(action);

		switch (action) {
			case 'temporaryLock':
				form = $('#temporaryLockForm');
				dataFormAction.reasonText = $('#temporaryLockReason').val();
				break;

			case 'replacement':
				form = $('#replacementForm');
				dataFormAction.status = $('#replaceMotSol').val();
				break;

			case 'changePin':
			case 'generatePin':
				form = $('#pinManagementForm');
				dataFormAction = getDataForm(form);
				break;
		}

		if (action == 'replacement' || action == 'changePin' || action == 'generatePin' || action == 'temporaryLock') {
			validateForms(form);
			validForm = form.valid();
		}

		if (validForm) {
			form = $('#operation');
			data = getDataForm(form);
			$('.nav-config-box').addClass('no-pointer');

			if (action == 'changePin') {
				delete dataFormAction.confirmPin;
				delete dataFormAction.generateNewPin;
				delete dataFormAction.generateConfirmPin;
				dataFormAction.currentPin = cryptography.encrypt(dataFormAction.currentPin);
				dataFormAction.newPin = cryptography.encrypt(dataFormAction.newPin);
			}

			if (action == 'generatePin') {
				delete dataFormAction.newPin;
				delete dataFormAction.currentPin;
				delete dataFormAction.confirmPin;
				delete dataFormAction.generateConfirmPin;
				dataFormAction.generateNewPin = cryptography.encrypt(dataFormAction.generateNewPin);
			}

			if (thisAction.hasClass('btn')) {
				insertFormInput(true);
				btnText = thisAction.text().trim()
				thisAction.html(loader);

				Object.assign(data, dataFormAction);
			} else {
				$('#pre-loader-twins, #pre-loader-limit').removeClass('hide');
				$('.hide-out').addClass('hide');
			}

			requestSupport(thisAction);
		}
	});

	$('#system-info').on('click', '.send-otp', function(e) {
		e.preventDefault();
		thisAction = $(this);
		form = $('#OTPcodeForm');
		validateForms(form);

		if (form.valid()) {
			data.otpCode = $('#otpCode').val();
			insertFormInput(true);
			thisAction
				.html(loader)
				.prop('disabled', true);
			$('#accept').removeAttr('action');

			requestSupport(thisAction);
		}
	});

	$('#system-info').on('click', '.resend', function(e) {
		e.preventDefault();
		thisAction = $(this);
		insertFormInput(true);
		thisAction
			.html(loader)
			.prop('disabled', true);
		$('#accept').removeAttr('action');

		requestSupport(thisAction);
	});
});

function requestSupport(thisAction) {
	who = 'CustomerSupport';
	where = data.action;

	callNovoCore(who, where, data, function (response) {
		if (data.action == 'temporaryLock' && response.success) {
			var statusText = $('#status').val() == '' ? lang.CUST_UNLOCK_CARD : lang.CUST_TEMPORARY_LOCK
			var statustextCard = $('#status').val() == '' ? lang.CUST_TEMPORARILY_LOCK : lang.CUST_UNLOCK
			$('.status-text1').text(statusText);
			$('.status-text2').text(statustextCard.toLowerCase());
			var status = $('#status').val() == '' ? 'PB' : ''
			$('#status').val(status);
		}

		if (response.code == 2) {
			$('#accept').addClass('send-otp');
			$('#accept').attr('action', data.action);

			inputModal = '<form id="OTPcodeForm" name="formVerificationOTP" class="mr-2" method="post" onsubmit="return false;">';

			if (response.data.cost) {
				inputModal += 	'<p class="pt-0 p-0">' + response.data.msg + '</p>';
			}

			inputModal += 	'<p class="pt-0 p-0">' + response.msg + '</p>';
			inputModal += 	'<div class="row">';
			inputModal += 		'<div class="form-group col-8">';
			inputModal += 			'<label for="otpCode">' + lang.GEN_OTP_LABEL_INPUT + '</label>'
			inputModal += 			'<input id="otpCode" class="form-control" type="text" name="otpCode" autocomplete="off" maxlength="10">';
			inputModal += 			'<div class="help-block"></div>'
			inputModal += 		'</div">';
			inputModal += 	'</div>';
			inputModal += '</form>';

			appMessages(response.title, inputModal, response.icon, response.modalBtn);
		} else if (response.code == 3) {
			$('#accept').addClass('resend');
			$('#accept').attr('action', data.action);
			appMessages(response.title, response.data.msg, response.icon, response.modalBtn);
		}

		if (data.action == 'twirlsCommercial' && response.code == 0) {
			$.each(response.data.dataTwirls, function (key, value) {
				$('#' + key).text(value);
			})

			$.each(response.data.shops, function (key, value) {
				var markCheck = value == '1' ? true : false;
				$('#' + key).prop('checked', markCheck);
			})

			$('.hide-out').removeClass('hide');
		}

		if (data.action == 'transactionalLimits' && response.code == 0) {
			$.each(response.data.dataLimits, function (key, value) {
				$('#' + key).text(value);
			})

			$.each(response.data.limits, function (key, value) {
				$('#' + key).val(value);
			})

			$('.hide-out').removeClass('hide');
		}

		if ((data.action == 'transactionalLimits' || data.action == 'twirlsCommercial') && response.code != 0) {
			$('.nav-item-config').removeClass('active');
		}

		if (thisAction.hasClass('btn')) {
			thisAction.html(btnText);
			insertFormInput(false);
		} else {
			$('#pre-loader-twins, #pre-loader-limit').addClass('hide');
		}

		$('.nav-config-box').removeClass('no-pointer');
	});
}
