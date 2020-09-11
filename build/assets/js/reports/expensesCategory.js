'use strict'
$(function () {
	var action;
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('input[type=hidden][name="cardNumber"]').each(function (pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher)
	});

	$('.date-picker').datepicker({
		onSelect: function(selectedDate) {
			$(this)
				.focus()
				.blur();
			var dateSelected = selectedDate.split('/');
			dateSelected = dateSelected[1] + '/' + dateSelected[0] + '/' + dateSelected[2];
			var inputDate = $(this).attr('id');
			var maxTime = new Date(dateSelected);

			if (inputDate == 'initDate') {
				$('#finalDate').datepicker('option', 'minDate', selectedDate);
				maxTime.setDate(maxTime.getDate() - 1);
				maxTime.setMonth(maxTime.getMonth() + 1);

				if (currentDate > maxTime) {
					$('#finalDate').datepicker('option', 'maxDate', maxTime);
				} else {
					$('#finalDate').datepicker('option', 'maxDate', currentDate);
				}
			}
		}
	});

	if ($('#productdetail').attr('call-moves') == '1') {
		action = '0';
		getMovements(action);
	}

	$('#system-info').on('click', '.dashboard-item', function (e) {
		action = '0';
		getMovements(action);
	});

	$('#monthtlyMovesBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#monthtlyMovesForm');
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			action = '1';
			getMovements(action);
		}
	});
});

function getMovements(action) {
	who = "Reports"; where = "GetMovements";
	insertFormInput(true);
	form = $('#operation');
	data = getDataForm(form);
	data.action = action
	data.initDate = '01/01/' + currentDate.getFullYear();
	data.finalDate = '31/12/' + currentDate.getFullYear();

	if (action == '1') {
		data.initDate = $('#initDate').val();
		data.finalDate = $('#finalDate').val();
	}

	callNovoCore(who, where, data, function(response) {
		insertFormInput(false);
	});
}
