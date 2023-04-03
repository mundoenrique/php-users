'use strict'
var radioType = 'input:radio[name=cardType]';
var numberCard = 'label[for=numberCard]';
var input = 'input[type="text"]';

$(function () {
	insertFormInput(false);
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('#cardPIN').removeClass('ignore');

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#identityForm');
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);

			if (lang.SETT_CHANGE_VIRTUAL === 'ON') {
				if ($('input:radio[name=cardType]:checked').val() == 'virtual') {
					delete data.cardPIN;
					delete data.physicalCard;
				} else {
					delete data.virtualCard;
				}
			}

			$(this).html(loader);
			insertFormInput(true);
			getRecaptchaToken('UserIdentify', function (recaptchaToken) {
			  data.token = recaptchaToken;
				validateIdentity();
			});
		}
	});

	$(radioType).change(function() {
		if($(this).attr('value') == 'virtual'){
			$('#physicalCardPIN').hide();
			$('#cardPIN').addClass('ignore')
			$(numberCard).text(lang.USER_EMAIL);
			$('#numberCard').attr('maxlength', '100').attr('id','email');
			$('#email').attr('name','email');
		} else {
			$('#physicalCardPIN').show();
			$('#cardPIN').removeClass('ignore')
			$(numberCard).text(lang.GEN_NUMBER_CARD);
			$('#email').attr('id','numberCard');
			$('#numberCard').attr('name','numberCard').attr('maxlength','16');
		}

		resetInput();
	});

	$('#system-info').on('click', '.send-otp', function (e) {
		form = $('#formVerificationOTP');
		e.preventDefault();
		e.stopImmediatePropagation();
		validateForms(form);

		if (form.valid()) {
			data.codeOtp = $('#codeOTP').val();
			$(this)
				.html(loader)
				.prop('disabled', true);
			insertFormInput(true);

			getRecaptchaToken('UserIdentifyOTP', function (recaptchaToken) {
				data.token = recaptchaToken;
				validateIdentity();
			});
		}
	});
});

function validateIdentity() {
	who = 'user';
	where = 'UserIdentify';

	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				var dataUser = response.data;
				form = $('#requestForm');
				dataUser = cryptography.encrypt(dataUser);

				if (traslate) {
					form.append('<input type="hidden" name="request" value="' + dataUser + '">');
				} else {
					dataUser = JSON.parse(dataUser);
					$.each(dataUser, function(item, value) {
						form.append('<input type="hidden" name="' + item + '" value="' + value + '">');
					});
				}

				insertFormInput(true, form);
				form
					.attr('action', baseURL + lang.SETT_LINK_SIGNUP)
					.submit();
			break;
			case 2:
				inputModal ='<form id="formVerificationOTP" name="formVerificationOTP" class="mr-2" method="post" onsubmit="return false;">';
				inputModal+='<p class="pt-0 p-0">' + response.msg + '</p>';
				inputModal+='<div class="row">';
				inputModal+=	'<div class="form-group col-8">';
				inputModal+=	'<label id="label_codeOTP" for="codeOTP">' + response.labelInput + '</label>';
				inputModal+=	'<input id="codeOTP" class="form-control" type="text" name="codeOTP" autocomplete="off">';
				inputModal+=    '<div id="msgErrorCodeOTP" class="help-block"></div>';
				inputModal+=	'</div>';
				inputModal+='</div>';
				inputModal+='</form>';

				$('#accept').addClass('send-otp');
				appMessages(response.title, inputModal, response.icon, response.modalBtn);
			break;
		}

		if(response.code !== 0) {
			insertFormInput(false);
			$('#identityBtn').html(btnText);
		}
	})
}

function resetInput(){
	$('#identityForm').find('input:text, input:password').val('').removeAttr('aria-describedby');
	$('#identityForm').find('.help-block').text('');
	$('#identityForm').find('.has-error').removeClass('has-error');
}
