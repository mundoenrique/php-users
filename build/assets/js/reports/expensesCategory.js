'use strict'
var dateFilter;
$(function () {
	var typeInquiry;

	$('input[type=hidden][name="cardNumber"]').each(function (pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher);
	});

	$('.date-picker').datepicker({
		onSelect: function (selectedDate) {
			$('input[type=radio]').prop('checked', false);
			$(this)
				.focus()
				.blur();
			var dateSelected = selectedDate.split('/');
			dateSelected = dateSelected[1] + '/' + dateSelected[0] + '/' + dateSelected[2];
			dateSelected = new Date(dateSelected);
			var inputDate = $(this).attr('id');

			if (inputDate == 'initDate') {
				$('#finalDate').datepicker('option', 'minDate', selectedDate);
				var maxTime = new Date(dateSelected.getFullYear(), dateSelected.getMonth() + 1, dateSelected.getDate() - 1);

				if (currentDate > maxTime) {
					$('#finalDate').datepicker('option', 'maxDate', maxTime);
				} else {
					$('#finalDate').datepicker('option', 'maxDate', currentDate);
				}
			}
		}
	});

	if ($('#productdetail').attr('call-moves') == '1') {
		typeInquiry = '0';
		getMovements(typeInquiry);
	}

	$('#annualMovesForm').on('click', 'input', function(e) {
		$('#monthtlyMovesForm')[0].reset();
		$(this).prop('checked', true);
		typeInquiry = '0';
		getMovements(typeInquiry);
	})

	$('#system-info').on('click', '.dashboard-item', function (e) {
		$('#annualMovesForm').find('input[type=radio]').last().prop('checked', true)
		typeInquiry = '0';
		getMovements(typeInquiry);
	});

	$('#monthtlyMovesBtn').on('click', function (e) {
		e.preventDefault();
		form = $('#monthtlyMovesForm');
		validateForms(form);

		if (form.valid()) {
			typeInquiry = '1';
			getMovements(typeInquiry);
		}
	});

	$('#downloadFiles').on('click', 'a', function(e) {
		e.preventDefault();
		var event = $(e.currentTarget);
		form = $('#operation');
		data = getDataForm(form);
		data.id = event.attr('id');
		data.action = event.attr('action');
		data.typeInquiry = $('#dType').val();
		data.initDate = $('#dInitDate').val();
		data.finalDate = $('#dFinalDate').val();
		who = "Reports"; where = "DownloadInquiry";
		coverSpin(true);

		callNovoCore(who, where, data, function (response) {
			if (data.action == 'download' && response.code == 0) {
				delete (response.data.btn1);
				downLoadfiles(response.data);
			} else {
				coverSpin(false);
			}
		});
	});
});

function getMovements(typeInquiry) {
	who = "Reports"; where = "GetMovements";
	$('#downd-send input').val('');
	$('#no-result').addClass('hide');
	$('#movements').addClass('hide');
	$('.hide-downloads').addClass('hide');
	$('#pre-loader').removeClass('hide');
	$('#movementsStats').addClass('hide');
	$('#movements thead, #movements tbody').empty();
	form = $('#operation');
	data = getDataForm(form);
	data.typeInquiry = typeInquiry
	data.initDate = '01/01/' + $('input[name="year"]:checked').val();
	data.finalDate = '31/12/' + $('input[name="year"]:checked').val();

	if (typeInquiry == '1') {
		data.initDate = $('#initDate').val();
		data.finalDate = $('#finalDate').val();
	}

	insertFormInput(true);

	callNovoCore(who, where, data, function (response) {
		$('#pre-loader').addClass('hide');
		$('#dType').val(typeInquiry);
		$('#dInitDate').val(data.initDate);
		$('#dFinalDate').val(data.finalDate);

		if (response.code == 0) {
			var header = '';
			var body = '';
			var date = action == '0' ? lang.GEN_MONTHS : lang.GEN_DAYS;

			header += '<tr>';
			header += '<th class="bold">' + date + '</th>';

			$.each(response.data.headers, function (pos, value) {
				header += '<th><span aria-hidden="true" class="' + pos + ' h3" title="' + value + '" data-toggle="tooltip"></span></th>';
			});

			header += '<th class="bold">Total (' + lang.CONF_CURRENCY + ')</th>'
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

			var chart;
			var graphicLabel = [];
			var graphicValue = [];
			var graphicColour = [];
			var setValues, setCategory;

			$.each(response.data.grafic, function(key, val){
				graphicLabel.push(response.data.grafic[key].category);
				graphicValue.push(response.data.grafic[key].value);
				graphicColour.push(response.data.grafic[key].color);
			})

			chart = new Chart($('#movementsStats'), {
				type: 'doughnut',
				data: {
					labels: graphicLabel,
					datasets: [{
						label: '',
						data: graphicValue,
						backgroundColor: graphicColour,
						borderColor: graphicColour,
						borderWidth: 1
					}]
				},
				options: {
					tooltips: {
						callbacks: {
							label: function(tooltipItem) {
								setValues = response.data.labels[tooltipItem.index];
								setCategory =  response.data.grafic[tooltipItem.index].category;
								return setCategory+ ": " + lang.CONF_CURRENCY + " " + setValues;
							}
						}
					},
					responsive: true,
					manteinaspectRatio: 2,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display:false
						},
							ticks: {
									display: false
							}
						}],
						xAxes: [{
							gridLines: {
								display:false
							},
							ticks: {
								display: false
							}
						}]
					}
				}
			});

			$('#movements tbody').append(body);
			$('#movements').removeClass('hide');
			$('#movementsStats').removeClass('hide');
			$('.hide-downloads').removeClass('hide');
		}

		if (response.code == 1) {
			$('#no-result').removeClass('hide');
		}

		insertFormInput(false);
	});
}
