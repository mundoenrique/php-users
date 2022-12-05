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

function setHistoryDataTable(data) {
	var li, className, ref, row;
	historyData = data;
	$("#movementsList").html("");

	data.forEach((value, index) => {
		className = `feed-item ${
			value.estatusOperacion == "1" ? "" : "feed-expense"
		} flex py-2 items-center`;
		li = $("<li></li>").addClass(className);
		ref =
			value.estatusOperacion == "1"
				? `<span class="block p-0 h6">${lang.TRANSF_FAILED_OPERATION}</span>`
				: `<span class="btn btn-small btn-link block p-0 h6" data-index="${index}" data-action="showVoucher">
					${value.referencia}
				</span>`;

		row = `<div class="flex px-2 flex-column items-center feed-date">
			<span class="h5">${value.fechaTransferencia}</span>
		</div>
		<div class="flex px-2 flex-column mr-auto">
			<span class="h5 semibold feed-product">
				${value.beneficiario}${value.concepto != "" ? "		|		" + value.concepto : ""}
			</span>
			${ref}
		</div>
		<span class="px-2 feed-amount items-center">${numberToCurrency(
			value.montoTransferencia,
			true
		)}</span>`;

		li.html(row);
		$("#movementsList").append(li);
	});

	$("#historyView #results").fadeIn(700, "linear");
}
