'use strict'
var radioType = 'input:radio[name=cardType]';
var numberCard = 'label[for=numberCard]';
var input = 'input[type="text"]';
var loginIpMsg, formcodeOTP;

$(function () {
	insertFormInput(false);
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('#cardPIN').removeClass('ignore');
	form = $('#identityForm');

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		validateForms(form);
		btnText = $(this).html();

		if (lang.CONF_CHANGE_VIRTUAL == 'ON') {
			if ($('input:radio[name=cardType]:checked').val()=='virtual') {
				delete data.cardPIN;
				delete data.physicalCard;
			} else {
				delete data.virtualCard;
			}
		}

		if (form.valid()) {
			data = getDataForm(form);
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
		formcodeOTP = $('#formVerificationOTP');
		e.preventDefault();
		e.stopImmediatePropagation();
		validateForms(formcodeOTP);

		if (formcodeOTP.valid()) {
			$('#formVerificationOTP input').attr('disabled', true);
			$(this)
				.off('click')
				.html(loader)
				.removeClass('send-otp');
			data.codeOtp = $('#codeOTP').val();

			getRecaptchaToken('UserIdentifyOTP', function (recaptchaToken) {
				data.token = recaptchaToken;
				validateIdentity();
			});
		}
	});
});

function validateIdentity() {
	who = 'user'; where = 'UserIdentify'
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				var dataUser = response.data;
				dataUser = JSON.stringify({dataUser});
				dataUser = cryptoPass(dataUser);
				$('#signupForm')
					.append('<input type="hidden" name="dataUser" value="'+dataUser+'">')
					.submit();
			break;
			case 2:
				$('#identityBtn').html(btnText);
				$('#accept').addClass('send-otp');

				loginIpMsg ='<form id="formVerificationOTP" name="formVerificationOTP" class="mr-2" method="post" onsubmit="return false;">';
				loginIpMsg+='<p class="pt-0 p-0">'+response.msg+'</p>';
				loginIpMsg+='<div class="row">';
				loginIpMsg+=	'<div class="form-group col-8">';
				loginIpMsg+=	'<label id="label_codeOTP" for="codeOTP">'+response.labelInput+'</label>';
				loginIpMsg+=	'<input id="codeOTP" class="form-control" type="text" name="codeOTP" autocomplete="off">';
				loginIpMsg+=    '<div id="msgErrorCodeOTP" class="help-block"></div>';
				loginIpMsg+=	'</div>';
				loginIpMsg+='</div>';
				loginIpMsg+='</form>';

				appMessages(response.title, loginIpMsg, response.icon, response.modalBtn);
			break;
			default:
				insertFormInput(false);
				$('#identityBtn').html(btnText);
			break;
		}
	})
}

function resetInput(){
	form.find('input:text').val('').removeAttr('aria-describedby');
	form.find('.help-block').text('');
	form.find('.has-error').removeClass('has-error');
}
