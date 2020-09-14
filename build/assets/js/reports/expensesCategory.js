'use strict'
$(function () {
	var action;

	$('input[type=hidden][name="cardNumber"]').each(function (pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher)
	});

	$('.date-picker').datepicker({
		onSelect: function (selectedDate) {
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

	$('#annualMovesForm').on('click', 'input', function(e) {
		$(this).prop('checked', true);
		action = '0';
		getMovements(action);
	})

	$('#system-info').on('click', '.dashboard-item', function (e) {
		action = '0';
		getMovements(action);
	});

	$('#monthtlyMovesBtn').on('click', function (e) {
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
	$('#no-result').addClass('hide');
	$('#movements').addClass('hide');
	$('#downloads').addClass('hide');
	$('#pre-loader').removeClass('hide');
	$('#movements thead, #movements tbody').empty();
	form = $('#operation');
	data = getDataForm(form);
	data.action = action
	data.initDate = '01/01/' + $('input[name="year"]:checked').val();
	data.finalDate = '31/12/' + $('input[name="year"]:checked').val();

	if (action == '1') {
		data.initDate = $('#initDate').val();
		data.finalDate = $('#finalDate').val();
		$('input[type=radio]').prop('checked', false);
	} else {
		$('#monthtlyMovesForm')[0].reset();
	}

	insertFormInput(true);

	callNovoCore(who, where, data, function (response) {
		$('#pre-loader').addClass('hide');

		if (response.code == 0) {
			var header = '';
			var body = '';
			var date = action == '0' ? 'Meses' : 'Días';

			header += '<tr>';
			header += '<th class="bold">' + date + '</th>';

			$.each(response.data.headers, function (pos, value) {
				header += '<th><span aria-hidden="true" class="' + pos + ' h3" title="' + value + '" data-toggle="tooltip"></span></th>';
			});

			header += '<th class="bold">Total (' + lang.GEN_CURRENCY + ')</th>'
			header += '</tr>';
			$('#movements thead').append(header);

			$.each(response.data.body, function (key, amount) {
				var bold = key == 'Total' ? 'class="bold"' : '';

				body += '<tr>';
				body += '<td ' + bold + '>' + key + '</td>';

				$.each(amount, function (pos, value) {
					body += '<td class="text-right">' + value + '</td>';
				});
				body += '</tr>';
			});

			$('#movements tbody').append(body);
			$('#movements').removeClass('hide');
			$('#downloads').removeClass('hide');
		}

		if (response.code == 1) {
			$('#no-result').removeClass('hide');
		}

		insertFormInput(false);
	});
}
