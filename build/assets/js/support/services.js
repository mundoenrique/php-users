'use strict'
$(function () {
	var ulOptions = $('.nav-item-config');
	var pinManagement = $('input[type=radio][name="recovery"]');

	$('input[type=hidden][name="expireDate"]').each(function(pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher)
	})

	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$.each(ulOptions, function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$(ulOptions).removeClass('active');
			$('.option-service').hide();
			$(this).addClass('active');
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		})
	})

	$('.slide-slow').click(function () {
		$('.section').fadeOut(400, 'linear');
		$(this).next('.section').slideToggle('slow');
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

	$('#donor').on('click', function () {
		cardModal()
	})

	$('#productdetail').on('click', '#other-product', function () {
		cardModal()
	})

	$('#system-info').on('click', '.dashboard-item', function (e) {
		var cardDetail;
		var event = e.currentTarget;
		var img = $(event).find('img').attr('src');
		var productName = $(event).find('.item-category').text();
		var cardNumber = $(event).find('input[type=hidden][name="cardNumber"]').val();
		var cardNumberMask = $(event).find('input[type=hidden][name="cardNumberMask"]').val();
		var expireDate = $(event).find('input[type=hidden][name="expireDate"]').val();
		var prefix = $(event).find('input[type=hidden][name="prefix"]').val();
		var status = $(event).find('input[type=hidden][name="status"]').val();
		var brand = $(event).find('input[type=hidden][name="brand"]').val();

		cardDetail =  '<div class="flex flex-colunm justify-center col-6 py-5">';
		cardDetail += 	'<div class="product-presentation relative">';
		cardDetail += 		'<div class="item-network ' + brand + '"></div>';
		cardDetail += 		'<img class="card-image" src="' + img + '">';
		cardDetail += 	'</div>';
		cardDetail += '</div>';
		cardDetail += '<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">';
		cardDetail += 	'<p class="semibold mb-0 h5 truncate">' + productName + '</p>';
		cardDetail += 	'<p id="card" class="mb-2">' + cardNumberMask + '</p>';
		cardDetail += 	'<a id="other-product" class="btn hyper-link btn-small p-0" href="' + lang.GEN_NO_LINK + '">';
		cardDetail += 		'<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto';
		cardDetail += 	'</a>';
		cardDetail += '</div>';
		$('#donor, #accountSelect').remove();
		$('#productdetail').html(cardDetail);
		$('#system-info').dialog('destroy');
		$('.nav-config-box').removeClass('no-events');
		$('#cardNumber').val(cardNumber);
		$('#cardNumberMask').val(cardNumberMask);
		$('#expireDate').val(expireDate);
		$('#prefix').val(prefix);
		$('#status').val(status);
	})

	$('.send').on('click', function(e) {
		e.preventDefault();
		var action = $(this).attr('action')
		$('#action').val(action);
	})

	$('#blockBtn').on('click', function (e) {
		e.preventDefault();
		form = $('#operation');
		btnText = $(this).text().trim()
		data = getDataForm(form);
		insertFormInput(true);
		$(this).html(loader);
		who = 'CustomerSupport'; where = data.action

		callNovoCore(who, where, data, function (response) {
			if (data.action == 'TemporaryLock' && response.success) {
				var statusText = $('#status').val() == '' ? 'Desbloquear' : 'Bloquear'
				$('.status-text1').text(statusText);
				$('.status-text2').text(statusText.toLowerCase());
				var status = $('#status').val() == '' ? 'PB' : ''
				$('#status').val(status);
				insertFormInput(false);
				$('#blockBtn').html(btnText);
			}
		})
	})
})

function cardModal() {
	var inputModal = $('#cardList').html();
	data = {
		btn1: {
			text: lang.GEN_BTN_CANCEL,
			action: 'close'
		},
		maxHeight: 600,
		width: 655,
		posMy: 'top+60px',
		posAt: 'top+60px',
	}
	notiSystem(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_SUCCESS, data);
}
