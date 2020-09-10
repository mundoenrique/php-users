'use strict'
var reportsResults;
$(function () {
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

			if (inputDate == 'datepicker_start') {
				$('#datepicker_end').datepicker('option', 'minDate', selectedDate);
				maxTime.setDate(maxTime.getDate() - 1);
				maxTime.setMonth(maxTime.getMonth() + 1);
				console.log(maxTime)
				if (currentDate > maxTime) {
					$('#datepicker_end').datepicker('option', 'maxDate', maxTime);
				} else {
					$('#datepicker_end').datepicker('option', 'maxDate', currentDate);
				}
			}
		}
	});

	if (getPropertyOfElement('call-moves', '#productdetail') == '1') {
		form = $('#operation');
		data = getDataForm(form);
		data.initDate = '01/01/'+currentDate.getFullYear();
		data.finalDate = '31/12/'+currentDate.getFullYear();
		data.action = '0';
		getMovements();
	}

	$('#system-info').on('click', '.dashboard-item', function (e) {
		form = $('#operation');
		data = getDataForm(form);
		data.initDate = '01/01/' + currentDate.getFullYear();
		data.finalDate = '31/12/' + currentDate.getFullYear();
		data.action = '0';
		getMovements();
	});

	$('#monthtlyMovesBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#monthtlyMovesForm');
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {

		}
	});
});

function getMovements() {
	who = "Reports"; where = "GetMovements";

	callNovoCore(who, where, data, function(response) {

	});
}
