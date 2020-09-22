'use strict'
var numberCard = 'label[for=numberCard]';
var radioType = 'input:radio[name=cardType]';
$(function () {
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

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
				} else {
					insertFormInput(false)
					$('#identityBtn').html(btnText)
				}
			})
		}
	})

	$(radioType).change(function(){
		if($(this).attr("value")=="virtual"){
				$(numberCard).text("Correo electrónico");
				$("#numberCard").attr( "maxlength", "32" );
				$("#physicalCardPIN").fadeOut("fast").hide(300);
		} else {
				$(numberCard).text("Número de tarjeta");
				$("#numberCard").attr( "maxlength", "16" );
				$("#physicalCardPIN").fadeIn("fast").show(300);
		}
	});
});

/* validator = $('#signupForm').validate();
validator.destroy();
form.submit(); */
