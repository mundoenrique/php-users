'use strict'
var numberCard = 'label[for=numberCard]';
var radioType = 'input:radio[name=cardType]';
var loginIpMsg;

$(function () {
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$("#emailCard").removeClass( "required");

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#identityForm')
		formInputTrim(form)
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim()
			data = getDataForm(form);
			insertFormInput(true)
			who = 'user'; where = 'UserIdentify'
			$(this).html(loader)
			callNovoCore(who, where, data, function(response) {
				if (response.code == 0) {
					var dataUser = response.data;
					dataUser = JSON.stringify({dataUser})
					dataUser = cryptoPass(dataUser);
					$('#signupForm')
						.append('<input type="hidden" name="dataUser" value="'+dataUser+'">')
						.submit()
				}	else if (response.code == 2) {
					console.log(response);

					loginIpMsg ='<form id="formVerificationOTP" name="formVerificationOTP" class="mr-2" method="post" onsubmit="return false;">';
					loginIpMsg+='<p class="pt-0 p-0">'+response.msg+'</p>';
					loginIpMsg+='<div class="row">';
					loginIpMsg+=	'<div class="form-group col-6">';
					loginIpMsg+=	'<label id="label_codeOTP" for="codeOTP">'+response.labelInput+'</label>';
					loginIpMsg+=	'<input id="codeOTP" class="form-control" type="text" name="codeOTP" autocomplete="off">';
					loginIpMsg+=    '<div id="msgErrorCodeOTP" class="help-block"></div>';
					loginIpMsg+=	'</div>';
					loginIpMsg+='</div>';
					loginIpMsg+='</form>';

					appMessages(response.title, loginIpMsg, response.icon,response.data);

				} else {
					insertFormInput(false)
					$('#identityBtn').html(btnText)
				}
			})
		}
	})

	$(radioType).change(function(){
		if($(this).attr("value")=="virtual"){
				$("#divNumberCard").hide();
				$("#physicalCardPIN").hide();
				$("#divEmail").show();
				$("#cardPIN").removeClass( "required")
				$("#numberCard").removeClass( "required")
				$("#emailCard").addClass( "required")
		} else {
			  $("#divNumberCard").show();
				$("#physicalCardPIN").show();
				$("#divEmail").hide();
				$("#emailCard").removeClass( "required")
				$("#cardPIN").addClass( "required")
				$("#numberCard").addClass( "required")
		}
	});
});
