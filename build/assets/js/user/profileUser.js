'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.cover-spin').hide()

	$('#acceptTerms').on('click', function() {
		data = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'close'
			},
			maxHeight: 600,
			width: 800,
			posMy: 'top',
			posAt: 'top'
		}
		var inputModal = '<h1 class="h0">'+lang.USER_TERMS_SUBTITLE+'</h1>';
		inputModal+= lang.USER_TERMS_CONTENT;

		notiSystem(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_INFO, data);
		$(this).prop('disabled','disabled');
	})

	$('#birthDate').datepicker({
		yearRange: '-90:' + currentDate.getFullYear(),
		maxDate: '-18y',
		changeMonth: true,
		changeYear: true,
		onSelect: function (selectedDate) {
			$(this).focus();
			$('#genderMale').focus();
		}
	})

	$('#phoneType').change(function () {
		var selectedOption = $(this).children('option:selected').val();
		var disableInput = false;

		if (selectedOption == '') {
			$('#otherPhoneNum').val('');
			disableInput = true;
		}

		$('#otherPhoneNum').prop('disabled', disableInput);
	})

	$('#profileUserBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#profileUserForm');
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.address = $('#address').val();
			data.notEmail = $('#notEmail').is(':checked') ? '1' : '0';
			data.notSms = $('#notSms').is(':checked') ? '1' : '0';
			$(this).html(loader);
			insertFormInput(true);
			who = 'User'; where = 'updateProfile';

			callNovoCore(who, where, data, function(response) {
				$('#profileUserBtn').text(btnText);
				insertFormInput(false);
			})
		}
	})
})
