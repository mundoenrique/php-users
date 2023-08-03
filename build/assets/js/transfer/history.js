"use strict";
$(function () {
	// Carga tabla historial
	$("#history").on("click", function (e) {
		e.preventDefault();
		var today = new Date();
		var mm = today.getMonth() + 1;
		var yyyy = today.getFullYear();
		$("#historyView #results").hide();
		$("#historyView #no-moves").hide();
		$("#historyView #pre-loader").fadeIn(700, "linear");
		$(".easyPaginateNav").remove();

		if (mm < 10) {
			mm = "0" + mm;
		}

		who = "Transfer";
		where = "History";
		data = {
			operationType: operationType,
			filterMonth: mm,
			filterYear: yyyy,
			...cardData,
		};

		callNovoCore(who, where, data, function (response) {
			switch (response.code) {
				case 0:
					if (response.data.length > 0) {
						setHistoryDataTable(response.data);
					} else {
						$("#historyView #no-moves").fadeIn(700, "linear");
					}
					break;
				case 1:
					$("#historyView #no-moves").fadeIn(700, "linear");
					break;
				default:
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
					break;
			}
			$("#historyView #pre-loader").hide();
		});
	});

	// Datepicker para filtrar historial por fecha(mes/año)
	$("#filterHistoryDate").datepicker({
		yearRange: "-90:" + currentDate.getFullYear(),
		minDate: "-90y",
		maxDate: currentDate.getFullYear(),
		dateFormat: "mm/yy",
		showButtonPanel: true,
		closeText: lang.GEN_BTN_ACCEPT,

		onClose: function (dateText, inst) {
			$(this).datepicker(
				"setDate",
				new Date(inst.selectedYear, inst.selectedMonth, 1)
			);
			$(this).focus().blur();
			var monthYear = $("#filterHistoryDate").val().split("/");
			$("#historyForm #filterMonth").val(monthYear[0]);
			$("#historyForm #filterYear").val(monthYear[1]);
		},

		beforeShow: function (input, inst) {
			inst.dpDiv.addClass("ui-datepicker-month-year");
		},
	});

	// Submit historial por fecha seleccionada
	$("#historySearch").on("click", function (e) {
		e.preventDefault();

		form = $("#historyForm");
		validateForms(form);

		if (form.valid()) {
			$("#historyView #results").hide();
			$("#historyView #no-moves").hide();
			$("#historyView #pre-loader").fadeIn(700, "linear");
			$(".easyPaginateNav").remove();

			who = "Transfer";
			where = "History";
			data = {
				operationType: operationType,
				...getDataForm(form),
				...cardData,
			};

			callNovoCore(who, where, data, function (response) {
				switch (response.code) {
					case 0:
						if (response.data.length > 0) {
							setHistoryDataTable(response.data);
						} else {
							$("#historyView #no-moves").fadeIn(700, "linear");
						}
						break;
					case 1:
						$("#historyView #no-moves").fadeIn(700, "linear");
						break;
					default:
						appMessages(
							response.title,
							response.msg,
							response.icon,
							response.modalBtn
						);
						break;
				}
				$("#historyView #pre-loader").hide();
			});
		}
	});

	// Al hacer click en ref. de historial, muestra comprobante de pago
	$("#movementsList").on(
		"click",
		"span[data-action='showVoucher']",
		function () {
			currentVaucherData = historyData[$(this).data("index")];
			buildVaucherModal();
		}
	);
});

function setMainTex(data) {
	return `<span class="h5 semibold feed-product">
	${
		data.estatusOperacion == "2"
			? data.concepto
			: `${data.beneficiario}${data.concepto != "" ? "		|		" + data.concepto : ""}`
	}
	</span>`;
}

function setSecondaryText(data, index) {
	var status = {
		0: `${lang.TRANSF_SUCCESSFUL_OPERATION}		|		`,
		1: `${lang.TRANSF_FAILED_OPERATION}		|		`,
		2: "",
		3: `${lang.TRANSF_DISPUTE_OPERATION}		|		`,
	};
	var spanStatus = `<span class="p-0 h6">${
		status[data.estatusOperacion]
	}</span>`;
	var refNumber =
		data.estatusOperacion == "0" || (data.estatusOperacion == "3" && data?.referencia > 0) ? data.referencia : data.billnumber;
	var spanRef =
		data.estatusOperacion == "2"
			? `<span class="p-0 h6">${refNumber}</span>`
			: `<span class="btn btn-small btn-link p-0 h6" data-index="${index}" data-action="showVoucher">${refNumber}</span>`;

	return `<span class="block p-0 h6">${spanStatus}${spanRef}</span>`;
}

function setHistoryDataTable(data) {
	var li, className, mainText, secondaryText, row;
	historyData = data;
	$("#movementsList").html("");

	data.forEach((value, index) => {
		className = `feed-item ${
			value.estatusOperacion == "0" || value.estatusOperacion == "2"
				? "feed-expense"
				: ""
		} flex py-2 items-center`;
		li = $("<li></li>").addClass(className);
		mainText = setMainTex(value);
		secondaryText = setSecondaryText(value, index);

		row = `<div class="flex px-2 flex-column items-center feed-date">
			<span class="h5">${value.fechaTransferencia}</span>
		</div>
		<div class="flex px-2 flex-column mr-auto">
			${mainText}
			${secondaryText}
		</div>
		<span class="px-2 feed-amount items-center">${numberToCurrency(
			value.estatusOperacion == "2"
				? value.amountfee
				: value.montoTransferencia,
			true
		)}</span>`;

		li.html(row);
		$("#movementsList").append(li);
	});

	$("#historyView #results").fadeIn(700, "linear");

	if ($("#movementsList > li").length > 10) {
		$("#movementsList").easyPaginate({
			paginateElement: "li",
			hashPage: lang.GEN_DATATABLE_PAGE,
			elementsPerPage: 10,
			effect: "default",
			slideOffset: 200,
			firstButton: true,
			firstButtonText: lang.GEN_DATATABLE_SFIRST,
			firstHashText: lang.GEN_DATATABLE_PAGE_FIRST,
			lastButton: true,
			lastButtonText: lang.GEN_DATATABLE_SLAST,
			lastHashText: lang.GEN_DATATABLE_PAGE_LAST,
			prevButton: true,
			prevButtonText: lang.SETT_DATATABLE_SPREVIOUS,
			prevHashText: lang.GEN_DATEPICKER_PREVTEXT,
			nextButton: true,
			nextButtonText: lang.SETT_DATATABLE_SNEXT,
			nextHashText: lang.GEN_DATEPICKER_NEXTTEXT,
		});
	}
}
