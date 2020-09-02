'use strict';
var $$ = document;
var interval;
var btnTrigger, txtBtnTrigger;
var arrDialogContent = [];
var systemMSg = $$.getElementById('system-msg');
var verificationMsg;
var timeLiveModal;

moment.updateLocale('en', {
	monthsShort: [
		"Ene", "Feb", "Mar", "Abr", "May", "Jun",
		"Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
	]
});

$$.addEventListener('DOMContentLoaded', function () {
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

	var i, movementsPaginate, transitPaginate;

	var loading = createElement('div', {
		id: "loading",
		class: "flex justify-center mt-5 py-4"
	});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';
	var noMovements = createElement('div', {
		class: "my-5 py-4 center"
	});
	noMovements.innerHTML = '<span class="h4">No se encontraron movimientos</span>';

	//core
	arrDialogContent = [{
			id: 'notice',
			body:
			`<div class="justify">
				Los datos que serán mostrados a continuación requieren de tu cuidado y protección, se agradece no exponerlos a lugares y redes públicas, cuida de las personas que se encuentran cercanas ya que los mismos son sensibles; nosotros hemos tomado precauciones a nivel de seguridad por ejemplo hemos desactivado la función copiar y pegar.
			</div>`
		},
		{ id: 'otpRequest',
			body:
			`<form id="formGetDetail" class="mr-2" method="post">
				<div id="verificationOTP">
					<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
					<div class="row">
						<div class="form-group col-7">
							<label for="codeOTP">Código de verificación <span class="danger">*</span></label>
							<input id="codeOTP" class="form-control" type="text" name="codeOTP" autocomplete="off">
							<div id="msgErrorCodeOTP" class="help-block"></div>
						</div>
					</div>
					<p id="verificationMsg" class="mb-1 h5"></p>
				</div>
			</form>`
		},
		{
			id: 'cardDetails',
			body:
			`<div class="row">
				<div class="form-group col-6">
					<label class="nowrap" for="cardNumber">Número de la tarjeta</label>
					<div class="show-card-info">
						<button id="open-card-details" class="flex items-baseline btn btn-link btn-small px-0">
							<i aria-hidden="true" class="icon-view"></i>&nbsp;Mostrar
						</button>
						<input id="cardNumber" class="form-control-plaintext nowrap none" type="text" value="" readonly>
					</div>
				</div>
				<div class="form-group col-6">
					<label class="nowrap" for="cardholderName">Nombre del tarjetahabiente</label>
					<div class="show-card-info">
						<button id="open-card-details" class="flex items-baseline btn btn-link btn-small px-0">
							<i aria-hidden="true" class="icon-view"></i>&nbsp;Mostrar
						</button>
						<input id="cardholderName" class="form-control-plaintext nowrap none" type="text" value="" readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-6">
					<label class="nowrap" for="expirationDate">Fecha de vencimiento</label>
					<div class="show-card-info">
						<button id="open-card-details" class="flex items-baseline btn btn-link btn-small px-0">
							<i aria-hidden="true" class="icon-view"></i>&nbsp;Mostrar
						</button>
						<input id="expirationDate" class="form-control-plaintext nowrap none" type="text" value="" readonly>
					</div>
				</div>
				<div class="form-group col-6">
					<label class="nowrap" for="securityCode">Código de seguridad</label>
					<div class="show-card-info">
						<button id="open-card-details" class="flex items-baseline btn btn-link btn-small px-0">
							<i aria-hidden="true" class="icon-view"></i>&nbsp;Mostrar
						</button>
						<input id="securityCode" class="form-control-plaintext nowrap none" type="text" value="" readonly>
					</div>
				</div>
			</div>
			<p class="mb-1 h5">Tiempo restante:<span id="timeLiveModal" class="ml-1 danger"></span></p>`
		}
	];

	// Gráficas de estadísticas total abonos y cargos
	if (movementsList.querySelector(".feed-item")) {
		if (movementsList.querySelectorAll(".feed-item").length >= 10) {
			$('#movementsList').easyPaginate({});
			movementsPaginate = movementsList.nextElementSibling;
			movementsPaginate.id = 'movementsPaginate';
		}

		movementsStats.addClass('fade-in');

		invokeChart(movementsStats, parseFloat(data.totalExpenseMovements), parseFloat(data.totalIncomeMovements));
	}

	if (transitList != null) {
		if (transitList.querySelectorAll(".feed-item").length >= 10) {
			$('#transitList').easyPaginate({});
			transitPaginate = transitList.nextElementSibling;
			transitPaginate.id = 'transitPaginate';
			transitPaginate.classList.add('none');
		}

		transitToogle.classList.remove('is-disabled');
		transitToogle.querySelector('input').disabled = false;

		invokeChart(transitStats, parseFloat(data.totalExpensePendingTransactions), parseFloat(data.totalIncomePendingTransactions));
	}

	transitToogle.addEventListener('click', function () {
		if (!this.classList.contains('is-disabled') && !this.classList.contains('active')) {
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
	});

	movementsToogle.addEventListener('click', function () {
		if (!this.classList.contains('active')) {
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
	});

	$$.getElementById('buscar').addEventListener('click', function () {
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
		stackItems[0].classList.add('is-disabled');
		stackItems[1].classList.add('is-disabled');
		transactions.appendChild(loading);

		callNovoCore('post', 'Product', 'loadMovements', dataRequest, function (response) {
			if (response.data.length > 0) {

				var totalExpense = 0,
					totalIncome = 0;

				response.data.forEach(function callback(currentValue, index, array) {
					var date = moment(currentValue.fecha, "DD/MM/YYYY").format('DD/MMM/YYYY').split('/'),
						day = date[0],
						month = date[1],
						year = date[2],
						concept = currentValue.concepto,
						reference = currentValue.referencia,
						sign = currentValue.signo,
						amount = currentValue.monto;

					var feedItem, feedDate, dateDay, dateMonth, dateYear, feedConcept, feedProduct, feedMeta, feedConcept, feedAmount;

					feedItem = createElement('li', {
						class: 'feed-item ' + (sign === '+' ? "feed-income" : "feed-expense") + ' flex py-1 items-center'
					});

					feedDate = createElement('div', {
						class: 'flex px-2 flex-column items-center feed-date'
					});
					dateDay = createElement('span', {
						class: 'h5 feed-date-day'
					});
					dateDay.textContent = day;
					dateMonth = createElement('span', {
						class: 'h5 feed-date-month'
					});
					dateMonth.textContent = month;
					dateYear = createElement('span', {
						class: 'h5 feed-date-year'
					});
					dateYear.textContent = year;
					feedDate.appendChild(dateDay);
					feedDate.appendChild(dateMonth);
					feedDate.appendChild(dateYear);

					feedConcept = createElement('div', {
						class: 'flex px-2 flex-column mr-auto'
					});
					feedProduct = createElement('span', {
						class: 'h5 semibold feed-product'
					});
					feedProduct.textContent = concept;
					feedMeta = createElement('span', {
						class: 'h6 feed-metadata'
					});
					feedMeta.textContent = reference;
					feedConcept.appendChild(feedProduct);
					feedConcept.appendChild(feedMeta);

					feedAmount = createElement('span', {
						class: 'px-2 feed-amount items-center'
					});
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
				if (movementsList.querySelectorAll(".feed-item").length >= 10) {
					$('#movementsList').easyPaginate({});
					movementsPaginate = movementsList.nextElementSibling;
					movementsPaginate.id = 'movementsPaginate';
				}
				invokeChart(movementsStats, totalExpense, totalIncome);
				movementsStats.addClass('fade-in');
				if ($$.getElementById('filterMonth').value != 0) {
					stackItems[0].classList.remove('is-disabled');
					stackItems[1].classList.remove('is-disabled');
				}
			} else {
				movementsList.appendChild(noMovements);
			}
			transactions.removeChild(transactions.lastChild);
			movementsList.classList.add('fade-in');
		});
	});

	//functions
	$$.getElementById('filterMonth').addEventListener('change', function () {

		if (this.value == 0) {
			stackItems[2].classList.add('is-disabled');
			$$.getElementById('filterYear').disabled = true;
			$$.getElementById('filterYear').selectedIndex = 0;
		} else {
			stackItems[2].classList.remove('is-disabled');
			$$.getElementById('filterYear').options[0].disabled = true;
			if (parseInt(this.value) > new Date().getMonth() + 1) {
				$$.getElementById('filterYear').options[1].disabled = true;
				$$.getElementById('filterYear').selectedIndex = 2;
			} else {
				$$.getElementById('filterYear').options[1].disabled = false;
				$$.getElementById('filterYear').selectedIndex = 1;
			}
			$$.getElementById('buscar').disabled = false;
			$$.getElementById('filterYear').disabled = false;
		}
	});

	btnExportPDF.addEventListener('click', function (e) {

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'pdf';
		processForm();
	});

	btnExportXLS.addEventListener('click', function (e) {

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'xls';
		processForm();
	});

	btnExportExtract.addEventListener('click', function (e) {

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'ext';
		processForm();
	});

	if (openCardDetails != null) {
		openCardDetails.addEventListener('click', function (e) {
			var dialogCardTitle, dialogCardBody, dialogData, data, cardDetails, idContentDialog;
			dialogCardTitle = 'Detalles de tarjeta';
			dialogCardBody = createElement('div', {
				id: arrDialogContent[0].id,
				class: 'dialog-detail-card pr-1'
			});
			dialogCardBody.innerHTML = arrDialogContent[0].body;

			dialogData = {
				btn1: {
					link: false,
					action: 'wait',
					text: txtBtnAcceptNotiSystem
				},
				btn2: {
					link: false,
					action: 'close',
					text: txtBtnCloseNotiSystem
				}
			};

			notiSystem(dialogCardTitle, dialogCardBody, iconInfo, dialogData);
			$("#system-info").dialog("option", "minWidth", 480);
			$("#system-info").dialog("option", "position", {
				my: "center top+100",
				at: "center top",
				of: window
			});

			btnTrigger = $$.getElementById('accept');
			txtBtnTrigger = btnTrigger.innerHTML.trim();
			systemMSg.classList.add("w-100");

			$$.getElementById("cancel").addEventListener('click', function (e) {
				e.preventDefault();
				clearInterval(interval);
				systemMSg.innerHTML = "";
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
				$("#system-info").dialog("close");
				$("#system-info").dialog("destroy");
				$("#system-info").addClass("none");
				$(this).off('click');
			})

			btnTrigger.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopImmediatePropagation();

				let divSectionView = systemMSg.querySelector("div");

				if (divSectionView != null) {

					switch (divSectionView.id) {
						case 'notice':
							btnTrigger.innerHTML = msgLoadingWhite;
							btnTrigger.disabled = true;
							proccessPetition({});
							break;

						case 'otpRequest':
							var form = $('#formGetDetail');
							var inpCodeOTP = $$.getElementById('codeOTP');
							validateForms(form, {
								handleMsg: true
							});

							if (form.valid()) {
								btnTrigger.innerHTML = msgLoadingWhite;
								btnTrigger.disabled = true;
								inpCodeOTP.disabled = true;
								proccessPetition({
									'codeOTP': CryptoJS.MD5(inpCodeOTP.value).toString(),
									noTarjeta: window.data.noTarjeta,
									id_ext_per: window.data.id_ext_per
								});
							}
							break;

						case 'cardDetails':
							clearInterval(interval);
							systemMSg.innerHTML = "";
							$("#system-info").dialog('close');
							$("#system-info").dialog("destroy");
							$("#system-info").addClass("none");
							break;

						case 'notisystem':
							$("#system-info").dialog('close');
							$("#system-info").dialog("destroy");
							$("#system-info").addClass("none");
							break;
					}
				}
			});
		});
	}

	function processForm() {

		var monthRequest = $$.getElementById('filterMonth').options[$$.getElementById('filterMonth').selectedIndex].value,
			yearRequest = $$.getElementById('filterYear').options[$$.getElementById('filterYear').selectedIndex].value,
			objDate = new Date(),
			fullYear = objDate.getFullYear();

		$$.getElementsByName("frmMonth")[0].value = monthRequest == '0' ? '' : monthRequest;
		$$.getElementsByName("frmYear")[0].value = yearRequest;
		if ($$.getElementsByName("frmTypeFile")[0].value === 'ext') {

			$$.getElementsByName("frmYear")[0].value = yearRequest;
		}

		$$.getElementsByTagName('form')[1].submit();
	}


	function proccessPetition(dataRequest) {
		callNovoCore('POST', 'Product', 'getDetail', dataRequest, function (response) {
			btnTrigger.innerHTML = txtBtnTrigger;
			btnTrigger.disabled = false;
			switch (response.code) {
				case 0:
					clearInterval(interval);

					systemMSg.querySelector("div").innerHTML = arrDialogContent[2].body;
					systemMSg.querySelector("div").id = arrDialogContent[2].id;
					$$.getElementById("cancel").classList.add("none");

					$$.getElementById("cardNumber").value = response.dataDetailCard.cardNumber;
					$$.getElementById("cardholderName").value = response.dataDetailCard.cardholderName;
					$$.getElementById("expirationDate").value = response.dataDetailCard.expirationDate;
					$$.getElementById("securityCode").value = response.dataDetailCard.securityCode;

					$$.getElementById("cardNumber").style.cursor = "default";
					$$.getElementById("cardholderName").style.cursor = "default";
					$$.getElementById("expirationDate").style.cursor = "default";
					$$.getElementById("securityCode").style.cursor = "default";

					var showCardInfo = $$.querySelectorAll('.show-card-info');
					for (i = 0; i < showCardInfo.length; i++) {
						showCardInfo[i].addEventListener('mouseenter', function (e) {
							this.querySelector('button').classList.add("none");
							this.querySelector('button').classList.remove("flex");
							this.querySelector('input').classList.remove("none");
						});
						showCardInfo[i].addEventListener('mouseleave', function (e) {
							this.querySelector('input').classList.add("none");
							this.querySelector('button').classList.add("flex");
							this.querySelector('button').classList.remove("none");

						});
					}

					timeLiveModal = $$.getElementById("timeLiveModal");
					startTimer(response.timeLiveModal, timeLiveModal);
					break;

				case 1:
					clearInterval(interval);

					systemMSg.querySelector("div").innerHTML = arrDialogContent[1].body;
					systemMSg.querySelector("div").id = arrDialogContent[1].id;

					verificationMsg = $$.getElementById("verificationMsg");
					showVerificationMsg(`${msgResendOTP} Tiempo restante:<span id="validityTime" class="ml-1 danger"></span>`, response.validityTime);
					interceptLinkResendCode();
					break;

				case 2:
					systemMSg.querySelector("div").innerHTML = response.msg;
					systemMSg.querySelector("div").id = 'notisystem';
					$$.getElementById("cancel").classList.add("none");
					break;

				case 3:
					clearOTPSection();

					showVerificationMsg(`${response.msg} ${msgResendOTP}`);
					interceptLinkResendCode();
					break;

				default:
					break;
			}
		});
	}

	function invokeChart(selector, cargos, abonos) {
		selector.kendoChart({
			chartArea: {
				background: "transparent",
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
		var timer = duration,
			minutes, seconds;
		interval = setInterval(myTimer, 1000);

		function myTimer() {
			minutes = parseInt(timer / 60, 10)
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.textContent = minutes + ":" + seconds;

			if (--timer < 0) {
				if (display.id == "validityTime") {
					clearOTPSection();
					showVerificationMsg(`Tiempo expirado. ${msgResendOTP}`)
					interceptLinkResendCode();
				} else {
					clearInterval(interval);
					systemMSg.innerHTML = "";
					btnTrigger.innerHTML = txtBtnTrigger;
					btnTrigger.disabled = false;
					$("#system-info").dialog('close');
					$("#system-info").dialog("destroy");
					$("#system-info").addClass("none");
				}




			}
		}
	}

	function showVerificationMsg(message, validityTime = false) {

		verificationMsg.innerHTML = message;
		verificationMsg.classList.add("semibold", "danger");
		verificationMsg.querySelector("a").setAttribute('id', 'resendCode');

		if (validityTime) {
			verificationMsg.classList.remove("semibold", "danger");
			startTimer(validityTime, verificationMsg.querySelector("span"));
		}

	}

	function interceptLinkResendCode() {
		$$.getElementById('resendCode').addEventListener('click', function (e) {
			e.preventDefault();
			clearOTPSection();
			verificationMsg.innerHTML = msgLoading;
			proccessPetition({});
		});
	}

	function clearOTPSection() {
		clearInterval(interval);
		btnTrigger.disabled = true;
		btnTrigger.innerHTML = txtBtnTrigger;

		$$.getElementById('codeOTP').value = '';
		$$.getElementById('codeOTP').disabled = true;
		$$.getElementById("msgErrorCodeOTP").innerHTML = '';

		// verificationMsg.innerHTML = msgLoading;
	}

});
