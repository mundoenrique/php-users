'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

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
			$(this).html(loader);
			insertFormInput(true);
		}
	})
})
