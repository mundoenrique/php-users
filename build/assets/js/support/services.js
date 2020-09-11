'use strict'
$(function () {
	var ulOptions = $('.nav-item-config');
	var pinManagement = $('input[type=radio][name="recovery"]');

	/* $('input[type=hidden][name="expireDate"]').each(function(pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher)
	}) */

	$.each(ulOptions, function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$(ulOptions).removeClass('active');
			$('.option-service').hide();
			$(this).addClass('active');
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		})
	})

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

	pinManagement.first().prop('checked', true);
	$('#' + pinManagement.first().attr('id') + 'Input').removeClass('hide');
	$('#PinManagementBtn').attr('action', pinManagement.first().attr('id'));

	pinManagement.on('change', function (e) {
		var currentActions
		currentActions = e.currentTarget.id;
		$('#PinManagementForm').find('.row').addClass('hide');
		$('#PinManagementForm').find('input').prop('disabled', true);
		$('#' + currentActions + 'Input').removeClass('hide');
		$('#' + currentActions + 'Input').find('input').prop('disabled', false);
		$('#PinManagementBtn').attr('action', currentActions);
	})

	$('#system-info').on('click', '.dashboard-item', function (e) {
		var optionCheck = false;
		var event = e.currentTarget;
		var expireDate = $(event).find('input[type=hidden][name="expireDate"]').val();
		var services = JSON.parse($(event).find('input[type=hidden][name="services"]').val());
		var statusText = status == '' ? 'Bloquear' : 'Desbloquear';
		$('.status-text1').text(statusText);
		$('.status-text2').text(statusText.toLowerCase());
		$('.nav-config-box').removeClass('no-events');
		$('.nav-config-box > li').removeClass('active');
		$('#expireDate').val(expireDate);

		$('.nav-config-box > li').each(function(key, element) {
			$(element).hide();
			$('#'+element.id+'View').hide();
			$.each(services, function(pos, value) {
				if ((lang.CUS_SERVICES[element.id]).indexOf(value, 0) != -1) {
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
				$('.nav-config-box').addClass('no-events');
			}

			$('#activeServices > div').each(function(pos, element) {
				$(element).hide();
				$.each(services, function (pos, value) {
					var currentServ = (element.id).slice(0, -4)
					if ((lang.CUS_SERVICES[currentServ]).indexOf(value, 0) != -1) {
						$('#' + currentServ).addClass('active')
						$(element).show();
					}
				})
			})
		}
	});

	$('.send').on('click', function(e) {
		e.preventDefault();
		var thisAction = $(this);
		var action = thisAction.attr('action');
		var validForm = true;
		$('#action').val(action);

		if (action == 'replacement') {
			form = $('#replacementForm');
			validateForms(form);
			validForm = form.valid();
		}

		if (validForm) {
			form = $('#operation');
			data = getDataForm(form);
			$('.nav-config-box').addClass('no-events');

			if (thisAction.hasClass('btn')) {
				insertFormInput(true);
				btnText = thisAction.text().trim()
				thisAction.html(loader);

				if (action == 'replacement') {
					data.status = $('#replaceMotSol').val();
				}
			} else {
				$('#pre-loader-twins, #pre-loader-limit').removeClass('hide');
				$('.hide-out').addClass('hide');
			}

			who = 'CustomerSupport'; where = data.action;
			callNovoCore(who, where, data, function (response) {
				if (data.action == 'TemporaryLock' && response.success) {
					var statusText = $('#status').val() == '' ? 'Desbloquear' : 'Bloquear'
					$('.status-text1').text(statusText);
					$('.status-text2').text(statusText.toLowerCase());
					var status = $('#status').val() == '' ? 'PB' : ''
					$('#status').val(status);
				}

				if (data.action == 'twirlsCommercial' && response.code == 0) {
					$.each(response.data.dataTwirls, function(key, value) {
						$('#'+key).text(value);
					})

					$.each(response.data.shops, function(key, value) {
						var markCheck = value == '1' ? true : false;
						$('#' + key).prop('checked', markCheck);
					})

					$('.hide-out').removeClass('hide');
				}

				if (data.action == 'transactionalLimits' && response.code == 0) {
					$.each(response.data.dataLimits, function(key, value) {
						$('#'+key).text(value);
					})

					$.each(response.data.limits, function(key, value) {
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

				$('.nav-config-box').removeClass('no-events');
			})
		}
	});
})
