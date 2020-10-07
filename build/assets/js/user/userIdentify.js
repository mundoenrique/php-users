'use strict'
var radioType = 'input:radio[name=cardType]';
var loginIpMsg,btnTex,formcodeOTP,btnTextOtp;

$(function () {
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$("#emailCard").addClass('ignore');
	$("#cardPIN").removeClass('ignore');
	form = $('#identityForm');

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		formInputTrim(form)
		validateForms(form);
		btnText = $(this).html();
		data = getDataForm(form);
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
					if($('#emailCard').val().trim()!=''){
						response.data.emailCard = $('#emailCard').val().trim();
					}
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

					appMessages(response.title, loginIpMsg, response.icon,response.data);

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
		if($(this).attr("value")=="virtual"){
				$("#divNumberCard").hide();
				$("#physicalCardPIN").hide();
				$("#divEmail").show();
				$("#numberCard").addClass('ignore')
				$("#cardPIN").addClass('ignore')
				$("#emailCard").removeClass('ignore')
		} else {
			  $("#divNumberCard").show();
				$("#physicalCardPIN").show();
				$("#divEmail").hide();
				$("#numberCard").removeClass('ignore')
				$("#cardPIN").removeClass('ignore')
				$("#emailCard").addClass('ignore')
		}
	});
});
