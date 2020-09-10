'use strict'
var reportsResults;
$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('input[type=hidden][name="cardNumber"]').each(function (pos, element) {
		var cypher = cryptoPass($(element).val());
		$(element).val(cypher)
	});

	if (getPropertyOfElement('call-moves', '#productdetail') == '1') {
		form = $('#operation');
		data = getDataForm(form);
		data.initDate = '01/01/'+currentDate.getFullYear();
		data.finalDate = '31/12/'+currentDate.getFullYear();
		data.action = '0';
		getMovements();
	}
});

function getMovements() {
	who = "Reports"; where = "GetMovements";

	callNovoCore(who, where, data, function(response) {

	});
}
