'use strict';
var $$ = document;
var data = {};
var interval;
var btnTrigger, txtBtnTrigger;
var arrDialogContent = [];
var systemMSg = $$.getElementById('system-msg');

moment.updateLocale('en', {
  monthsShort : [
    "Ene", "Feb", "Mar", "Abr", "May", "Jun",
    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
  ]
});

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var transactions = $$.getElementById('transactions'),
			movementsTitle = $$.getElementById('period'),
			movementsList = $$.getElementById('movementsList'),
			movementsStats = $('#movementsStats'),
			transitTitle = $$.getElementById('transitTitle'),
			transitList = $$.getElementById('transitList'),
			transitStats = $('#transitStats'),
			movementsToogle = $$.getElementById('movementsToogle'),
			transitToogle = $$.getElementById('transitToogle'),
			btnOptions = $$.querySelectorAll('.btn-options'),
			stackItems = $$.querySelectorAll('.stack-item'),
			btnExportPDF = $$.getElementById('downloadPDF'),
			btnExportXLS = $$.getElementById('downloadXLS'),
			btnExportExtract = $$.getElementById('downloadExtract'),
			openCardDetails = $$.getElementById('open-card-details');

	var	i, movementsPaginate, transitPaginate, verificationMsg;

	var loading = createElement('div', {id: "loading", class: "flex justify-center mt-5 py-4"});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';
	var noMovements = createElement('div', {class: "my-5 py-4 center"});
	noMovements.innerHTML = '<span class="h4">No se encontraron movimientos</span>';

	//core

	arrDialogContent = [
		{ id: 'notice',
			body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean in sem nec ipsum dictum blandit. Ut vel scelerisque eros. Sed vel aliquet mi, vitae interdum enim.'
		},
		{ id: 'otpRequest',
			body:
			`<form id="formGetDetail" class="mr-2" method="post">
				<div id="verificationOTP">
					<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
					<div class="row">
						<div class="form-group col-lg-6">
							<label for="codeOTP">Código de validación <span class="danger">*</span></label>
							<input id="codeOTP" class="form-control" type="text" name="codeOTP">
							<div class="help-block"></div>
						</div>
					</div>
					<p id="verificationMsg" class="mb-1 h5"></p>
				</div>
			</form>`
		},
		{ id: 'cardDetails',
			body:
			`<div class="row">
					<div class="form-group col-lg-6">
						<label class="nowrap" for="cardNumber">Número de la tarjeta</label>
						<input id="cardNumber" class="form-control-plaintext nowrap" type="text" value="4193280000300080" readonly>
					</div>
					<div class="form-group col-lg-6">
						<label class="nowrap" for="cardholderName">Nombre del tarjetahabiente</label>
						<input id="cardholderName" class="form-control-plaintext nowrap" type="text" value="SERGIO QUIJANO" readonly>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-lg-6">
						<label class="nowrap" for="expirationDate">Fecha de vencimiento</label>
						<input id="expirationDate" class="form-control-plaintext nowrap" type="text" value="19/20" readonly>
					</div>
					<div class="form-group col-lg-6">
						<label class="nowrap" for="securityCode">Código de seguridad</label>
						<input id="securityCode" class="form-control-plaintext nowrap" type="text" value="837" readonly>
					</div>
				</div>`
		}
	];

	// Gráficas de estadísticas total abonos y cargos
	if (movementsList.querySelector(".feed-item")) {
		$('#movementsList').easyPaginate({});
		movementsPaginate = movementsList.nextElementSibling;
		movementsPaginate.id = 'movementsPaginate';
		movementsStats.addClass('fade-in');

		invokeChart(movementsStats, parseFloat(data.totalExpenseMovements), parseFloat(data.totalIncomeMovements));
	}

	if (transitList != null) {
		$('#transitList').easyPaginate({});
		transitPaginate = transitList.nextElementSibling;
		transitPaginate.id = 'transitPaginate';
		transitPaginate.classList.add('none');

		transitToogle.classList.remove('is-disabled');
		transitToogle.querySelector('input').disabled = false;

		invokeChart(transitStats, parseFloat(data.totalExpensePendingTransactions), parseFloat(data.totalIncomePendingTransactions));
	}

	transitToogle.addEventListener('click', function(){
		if ( !this.classList.contains('is-disabled') && !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			movementsTitle.classList.add('none');
			movementsPaginate.classList.add('none');
			movementsList.classList.remove('fade-in');
			movementsStats.removeClass('fade-in');
			transitTitle.classList.remove('none');
			transitPaginate.classList.remove('none');
			transitList.classList.add('fade-in');
			transitStats.addClass('fade-in');
		}
	})

	movementsToogle.addEventListener('click', function(){
		if ( !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			transitTitle.classList.add('none');
			transitPaginate.classList.add('none');
			transitList.classList.remove('fade-in');
			transitStats.removeClass('fade-in');
			movementsTitle.classList.remove('none');
			movementsPaginate.classList.remove('none');
			movementsList.classList.add('fade-in');
			movementsStats.addClass('fade-in');
		}
	})

	$$.getElementById('buscar').addEventListener('click', function(){
		var filterMonth = $$.getElementById('filterMonth');
		var filterYear = $$.getElementById('filterYear');

		var monthSelected = filterMonth.options[filterMonth.selectedIndex];
		var yearSelected = filterYear.options[filterYear.selectedIndex];

		var dataRequest = {
			noTarjeta: data.noTarjeta,
			month: monthSelected.value,
			year: yearSelected.value,
		};

		while (movementsList.firstChild) {
			movementsList.removeChild(movementsList.firstChild);
		}
		movementsList.classList.remove('fade-in');
		if (movementsPaginate != null) {
			movementsPaginate.remove();
		}
		movementsStats.removeClass('fade-in');
		for (i = 0; i < stackItems.length; ++i) {
			stackItems[i].classList.add('is-disabled');
		}
		transactions.appendChild(loading);

		callNovoCore('post', 'Product', 'loadMovements', dataRequest, function(response) {
			if (response !== '--') {

				var totalExpense = 0, totalIncome = 0;

				response.forEach(function callback(currentValue, index, array) {
					var date = moment(currentValue.fecha, "DD/MM/YYYY").format('DD/MMM/YYYY').split('/'),
							day = date[0],
							month = date[1],
							year = date[2],
							concept = currentValue.concepto,
							reference = currentValue.referencia,
							sign = currentValue.signo,
							amount = currentValue.monto;

					var feedItem, feedDate, dateDay, dateMonth, dateYear, feedConcept, feedProduct, feedMeta, feedConcept, feedAmount;

					feedItem = createElement('li', {class: 'feed-item ' + (sign === '+' ? "feed-income" : "feed-expense") + ' flex py-1 items-center'});

					feedDate = createElement('div', {class: 'flex px-2 flex-column items-center feed-date'});
					dateDay = createElement('span', {class: 'h5 feed-date-day'});
					dateDay.textContent = day;
					dateMonth = createElement('span', {class: 'h5 feed-date-month'});
					dateMonth.textContent = month;
					dateYear = createElement('span', {class: 'h5 feed-date-year'});
					dateYear.textContent = year;
					feedDate.appendChild(dateDay);
					feedDate.appendChild(dateMonth);
					feedDate.appendChild(dateYear);

					feedConcept = createElement('div', {class: 'flex px-2 flex-column mr-auto'});
					feedProduct = createElement('span', {class: 'h5 semibold feed-product'});
					feedProduct.textContent = concept;
					feedMeta = createElement('span', {class: 'h6 feed-metadata'});
					feedMeta.textContent = reference;
					feedConcept.appendChild(feedProduct);
					feedConcept.appendChild(feedMeta);

					feedAmount = createElement('span', {class: 'px-2 feed-amount items-center'});
					if (sign === '-') {
						totalExpense += parseFloat(amount.replace(/\./g, "").replace(",", "."));
						sign = "- ";
					} else {
						totalIncome += parseFloat(amount.replace(/\./g, "").replace(",", "."));
						sign = "";
					}
					feedAmount.textContent = sign + coinSimbol + ' ' + amount;

					feedItem.appendChild(feedDate);
					feedItem.appendChild(feedConcept);
					feedItem.appendChild(feedAmount);

					movementsList.appendChild(feedItem);
				});
				$('#movementsList').easyPaginate({});
				movementsPaginate = movementsList.nextElementSibling;
				movementsPaginate.id = 'movementsPaginate';
				invokeChart(movementsStats, totalExpense, totalIncome);
				movementsStats.addClass('fade-in');

				if (filterMonth.selectedIndex != 0) {
					for (i = 0; i < stackItems.length; ++i) {
						stackItems[i].classList.remove('is-disabled');
					}
				}
			} else {
				movementsList.appendChild(noMovements);
			}
			transactions.removeChild(transactions.lastChild);
			movementsList.classList.add('fade-in');
		});
	});

	//functions
	$$.getElementById('filterMonth').addEventListener('change', function() {

		if (this.value == 0) {

			$$.getElementById('filterYear').disabled = true;
			$$.getElementById('filterYear').selectedIndex = 0;
		}else{
			$$.getElementById('filterYear').options[0].disabled = true;
			if (parseInt(this.value) > new Date().getMonth()+1) {
				$$.getElementById('filterYear').options[1].disabled = true;
				$$.getElementById('filterYear').selectedIndex = 2;
			}else{
				$$.getElementById('filterYear').options[1].disabled = false;
				$$.getElementById('filterYear').selectedIndex = 1;
			}
			$$.getElementById('buscar').disabled = false;
			$$.getElementById('filterYear').disabled = false;
		}
	});

	btnExportPDF.addEventListener('click', function(e){

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'pdf';
		processForm();
	});

	btnExportXLS.addEventListener('click', function(e){

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'xls';
		processForm();
	});

	btnExportExtract.addEventListener('click', function(e){

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'ext';
		processForm();
	});

	openCardDetails.addEventListener('click', function(e){
		var dialogCardTitle, dialogCardBody, dialogData, data, cardDetails, idContentDialog;
		dialogCardTitle = 'Detalles de tarjeta';
		dialogCardBody = createElement('div', { id: arrDialogContent[0].id, class: 'dialog-detail-card'});
		dialogCardBody.innerHTML = arrDialogContent[0].body;

		dialogData = {
			btn1: { link: false, action: 'wait', text: txtBtnAcceptNotiSystem },
			btn2: { link: false, action: 'close', text: txtBtnCloseNotiSystem }
		};

		notiSystem(dialogCardTitle, dialogCardBody, iconInfo, dialogData);

		$( "#system-info" ).dialog( "option", "minWidth", 480 );

		// verificationMsg = $$.getElementById("verificationMsg");
		// verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
		// var countdown = verificationMsg.querySelector("span");
		// startTimer(10, countdown);

		// $$.getElementById('codeOTP').disabled = false;

		btnTrigger = $$.getElementById('accept');
		txtBtnTrigger = btnTrigger.innerHTML.trim();

		btnTrigger.addEventListener('click',function(e){
			e.preventDefault();
			idContentDialog = systemMSg.querySelector("div").id;

			switch (idContentDialog) {
				case 'notice':
					btnTrigger.innerHTML = msgLoadingWhite;
					btnTrigger.disabled = true;
					systemMSg.querySelector("div").innerHTML = "loading";
					proccessPetition({});
					break;
				case 'otpRequest':

					break;
				case 'cardDetails':

					break;

				default:
					break;
			}

			// var form = $('#formGetDetail');
			// var inpCodeOTP = $$.getElementById('codeOTP');
			// var md5CodeOTP = '';

			// validateForms(form, {handleMsg: true});
			// if(form.valid()) {
			// 	inpCodeOTP.disabled = true;
			// 	btnTrigger.innerHTML = msgLoadingWhite;
			// 	btnTrigger.disabled = true;
			// 	data = {'codeOTP':  CryptoJS.MD5(inpCodeOTP.value).toString()}
			// 	console.log(data);
			// 	cardDetails = null;


			// 	// $$.getElementById('system-msg').innerHTML = ;

			// 	callNovoCore('POST', 'Product', 'getDetail', data, function(response)
			// 	{
			// 		console.log(response.data);

			// 		if (response.code === 0){
			// 			var cardNumber, cardholderName, expirationDate, securityCode;
			// 			cardNumber = response.data.cardNumber;
			// 			cardholderName = response.data.cardholderName;
			// 			expirationDate = response.data.expirationDate;
			// 			securityCode = response.data.securityCode;
			// 		}
			// 		else{
			// 		}
			// 	});
			// }

		});

	});

	function processForm() {

		var monthRequest = $$.getElementById('filterMonth').options[$$.getElementById('filterMonth').selectedIndex].value,
		yearRequest = $$.getElementById('filterYear').options[$$.getElementById('filterYear').selectedIndex].value,
		objDate = new Date(),
		fullYear = objDate.getFullYear();

		$$.getElementsByName("frmMonth")[0].value = monthRequest == '0'? '': monthRequest;
		$$.getElementsByName("frmYear")[0].value = yearRequest == fullYear? '': yearRequest;
		if ($$.getElementsByName("frmTypeFile")[0].value === 'ext') {

			$$.getElementsByName("frmYear")[0].value = yearRequest;
		}

		$$.getElementsByTagName('form')[1].submit();
	}


});

function proccessPetition(data)
{
	callNovoCore('POST', 'Product', 'getDetail', data, function(response) {

		switch (response.code) {
			case 0:

				break;
			case 1:
				systemMSg.querySelector("div").innerHTML = arrDialogContent[1].body;
				systemMSg.querySelector("div").id = arrDialogContent[1].id;
				break;
			case 2:

				break;
			case 3:

				break;

			default:
				break;
		}
	});
}

function invokeChart(selector, cargos, abonos) {
	selector.kendoChart({
		chartArea: {
			background:"transparent",
			width: 300,
			height: 250
		},
		legend: {
			position: "top",
			visible: false
		},
		seriesDefaults: {
			labels: {
				template: "#= category # - #= kendo.format('{0:P}', percentage)#",
				position: "outsideEnd",
				visible: false,
				background: "transparent",
			}
		},
		seriesColors: ["#cc0000", "#007e33"],
		series: [{
			type: "donut",
			overlay: {
				gradient: "none"
			},
			data: [{
				category: "Cargos",
				value: parseFloat(cargos.toFixed(1))
			}, {
				category: "Abonos",
				value: parseFloat(abonos.toFixed(1))
			}]
		}],
		tooltip: {
			visible: true,
			template: "#= category # - #= kendo.format('{0:P}', percentage) #",
			padding: {
				right: 4,
				left: 4
			},
			color: "#ffffff"
		}
	});
}

function startTimer(duration, display) {
	var timer = duration, minutes, seconds;
	interval = setInterval(myTimer, 1000);

	function myTimer() {
		minutes = parseInt(timer / 60, 10)
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;

		if (--timer < 0) {
			clearInterval(interval);

			$$.getElementById('codeOTP').value = '';
			$$.getElementById('codeOTP').disabled = true;
			verificationMsg.innerHTML =  `Tiempo expirado. <a id="resendCode" class="primary regular" href="#">Reenviar código.</a>`;
			verificationMsg.classList.add("semibold", "danger");
			btnTrigger.disabled = true;

			verificationMsg.querySelector("a").setAttribute('id','resendCode');
			$$.getElementById('resendCode').classList.add("regular");
			$$.getElementById('resendCode').addEventListener('click', function(e){
				e.preventDefault();
				// resendCodeOTP(coreOperation);
			});
		}
	}
}

// function resendCodeOTP (message) {
// 	verificationMsg.innerHTML = `${message} <a id="resendCode" class="primary regular" href="#">Reenviar código.</a>`;
// 	verificationMsg.classList.add("semibold", "danger");
// 	clearInterval(interval);
// 	btnTrigger.disabled = true;
// 	$$.getElementById('codeOTP').disabled = true;

// 	$$.getElementById('resendCode').addEventListener('click', function(e){
// 		e.preventDefault();

// 		$$.getElementById('codeOTP').value = '';
// 		disableInputsForm(true, msgLoadingWhite);
// 		data.codeOTP = '';
// 		callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
// 		{
// 			if (response.code == 0) {
// 				btnTrigger.disabled = false;
// 				btnTrigger.innerHTML = txtBtnTrigger;
// 				verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
// 				verificationMsg.classList.remove("semibold", "danger");
// 				$$.getElementById('codeOTP').disabled = false;
// 				var countdown = verificationMsg.querySelector("span");
// 				startTimer(response.validityTime, countdown);
// 			}
// 			else{
// 				notiSystem(response.title, response.msg, response.classIconName, response.data);
// 				disableInputsForm(false, txtBtnTrigger);
// 			}
// 		});
// 	});
// }
