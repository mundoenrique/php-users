'use strict'
var radioType = 'input:radio[name=cardType]';
var numberCard = 'label[for=numberCard]';
var input = 'input[type="text"]';
var loginIpMsg,btnTex,formcodeOTP,btnTextOtp;

$(function () {
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('#cardPIN').removeClass('ignore');
	form = $('#identityForm');

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		formInputTrim(form)
		validateForms(form);
		btnText = $(this).html();
		data = getDataForm(form);
		if (lang.CONF_CHANGE_VIRTUAL == 'ON'){
			if($('input:radio[name=cardType]:checked').val()=='virtual'){
				delete data.cardPIN;
				delete data.physicalCard;
			}else{
				delete data.virtualCard;
			}
		}
		if (form.valid()) {
			$(this).html(loader)
			insertFormInput(true)
			validateIdentity(data);
		}
	})

	function validateIdentity(data) {
		who = 'user'; where = 'UserIdentify'
		callNovoCore(who, where, data, function(response) {
			switch (response.code) {
				case 0:
					var dataUser = response.data;
					dataUser = JSON.stringify({dataUser})
					dataUser = cryptoPass(dataUser);
					$('#signupForm')
					.append('<input type="hidden" name="dataUser" value="'+dataUser+'">')
					.submit()
				break;
				case 2:
					$('#identityBtn').html(btnText);
					var oldID = $('#accept').attr('id');
					$('#accept').attr('id', 'send-otp-btn');

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

					formcodeOTP = $('#formVerificationOTP');

					$('#send-otp-btn').on('click', function(e) {
						e.preventDefault();
						e.stopImmediatePropagation();
						btnTextOtp = $('#send-otp-btn').html();
						formInputTrim(formcodeOTP);
						validateForms(formcodeOTP);
						if(formcodeOTP.valid()){
							$('#formVerificationOTP input').attr('disabled', true);
							$(this)
							.off('click')
							.html(loader)
							.attr('id', oldID);
							data.codeOtp = $('#codeOTP').val();
							validateIdentity(data);
						}
					});

					$('#cancel').on('click', function() {
						insertFormInput(false);
					});
					$('#send-otp-btn').html(btnTextOtp);
				break;
				default:
					insertFormInput(false);
					$('#identityBtn').html(btnText);
				break;
			}
		})
	}

	$(radioType).change(function(){
		if($(this).attr('value')=='virtual'){
				$('#physicalCardPIN').hide();
				$('#cardPIN').addClass('ignore')
				$(numberCard).text(lang.USER_EMAIL);
				$('#numberCard').attr('id','emailCard');
				$('#emailCard').attr('name','emailCard').attr('maxlength','32');
				resetInput();
		} else {
				$('#physicalCardPIN').show();
				$('#cardPIN').removeClass('ignore')
				$(numberCard).text(lang.GEN_NUMBER_CARD);
				$('#emailCard').attr('id','numberCard');
				$('#numberCard').attr('name','numberCard').attr('maxlength','16');
				resetInput();
		}
	});

	function resetInput(){
		form.find('input:text').val('').removeAttr('aria-describedby');
		form.find('.help-block').text('');
		form.find('.has-error').removeClass('has-error');
	}
});
