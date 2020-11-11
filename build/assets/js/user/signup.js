'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#nickName').on('blur', function() {
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

	$('#signUpBtn').on('click', function(e) {
		e.preventDefault()
		form = $('#signUpForm');
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.newPass = cryptoPass(data.newPass);
			data.confirmPass = cryptoPass(data.confirmPass);
			$(this).html(loader);
			insertFormInput(true);
			where = 'SignUpData';
			getResponseServ(where);
		} else {
			scrollTopPos($('#signUpForm').offset().top);
		}
	})
})

function getResponseServ(currentaction) {
	who = 'User';

	callNovoCore(who, where, data, function(response) {
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
