"use strict";
var cardData, affiliationsList, transferParameters, currentAffiliaton, bankList;
var montoMaxOperaciones, montoMinOperaciones, montoMaxDiario, montoMaxSemanal;
var montoMaxMensual, cantidadOperacionesDiarias, montoBase, montoComision;
var cantidadOperacionesSemanales, cantidadOperacionesMensual, montoAcumDiario;
var montoAcumSemanal, montoAcumMensual, acumCantidadOperacionesDiarias;
var acumCantidadOperacionesSemanales, acumCantidadOperacionesMensual;
var porcentajeComision, dobleAutenticacion, totalComision, monto;
var transferData, transferResult, historyData, currentVaucherData;

$(function () {
	var operationType = $("#transferView").attr("operation-type");
	var liOptions = $(".nav-item-config");
	var OperationTypeAffiliations = {
		P2P: "cuentaDestinoPlata",
		PMV: "pagoMovil",
		P2T: "creditoInmediato",
	};

	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

	// Si existe una sola tarjeta
	if ($("#productdetail").attr("call-balance") == "1") {
		getBalance();
		showTransferView();
	}

	$("#expDateCta").datepicker({
		yearRange: "-5:+10",
		minDate: "-5y",
		maxDate: "+10y",
		dateFormat: "mm/yy",
		showButtonPanel: true,
		closeText: lang.GEN_BTN_ACCEPT,

		onClose: function (dateText, inst) {
			$(this).datepicker(
				"setDate",
				new Date(inst.selectedYear, inst.selectedMonth, 1)
			);
			$(this).focus().blur();
			var monthYear = $("#expDateCta").val().split("/");
			$("#filterMonth").val(monthYear[0]);
			$("#filterYear").val(monthYear[1]);
		},

		beforeShow: function (input, inst) {
			inst.dpDiv.addClass("ui-datepicker-month-year");
		},
	});

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

	// Al seleccionar una tarjeta
	$("#system-info").on("click", ".dashboard-item", function (e) {
		e.preventDefault();
		getBalance();
		showTransferView();
	});

	// Filtro para buscar afiliado
	// Eliminar al validar la utilizacion de dataTable
	$("#search").on("keyup", function () {
		var valueSearch = $(this).val().toLowerCase();
		var tableTr = $("#affiliationTable tbody tr");

		tableTr.filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(valueSearch) > -1);
			if ($("#affiliationTable tbody tr:hidden").length == tableTr.length) {
				$("#no-moves").fadeIn(700, "linear");
			} else {
				$("#no-moves").hide();
			}
		});
	});

	// Mostrar vista correspondiente al seleccionar una operación
	// (Transferir|Adm. Afiliaciones|Historial)
	$(liOptions).on("click", function (e) {
		e.preventDefault();
		var liOptionId = e.currentTarget.id;
		$(liOptions).removeClass("active");
		$(cardData ? liOptions : "#affiliations").removeClass("no-pointer");
		$(this).addClass("active no-pointer");
		$(".transfer-operation").hide();
		$("#manageAffiliateView").hide();
		$("#" + liOptionId + "View").fadeIn(700, "linear");
	});

	// Mostrar vista de Transferir/Realizar pago
	$("#toTransfer").on("click", function (e) {
		e.preventDefault();
		showTransferView();
	});

	// Carga tabla lista de afiliados
	$("#affiliations").on("click", function (e) {
		e.preventDefault();
		$("#transferRecord").hide();
		$("#searchAffiliate").hide();
		$("#results no-moves").hide();
		$("#pre-loader").fadeIn(700, "linear");
		who = "Affiliations";
		where = "GetAffiliations";
		data = { operationType: operationType, ...cardData };

		callNovoCore(who, where, data, function (response) {
			switch (response.code) {
				case 0:
					let affiliations =
						response.data[OperationTypeAffiliations[operationType]];
					if (affiliations.length > 0) {
						setAffiliateDataTable(affiliations);
					} else {
						$("#no-moves").fadeIn(700, "linear");
					}
					break;
				case 1:
					$("#no-moves").fadeIn(700, "linear");
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
			$("#pre-loader").hide();
		});
	});

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

	$("#historySearch").on("click", function (e) {
		e.preventDefault();
		$("#historyView #results").hide();
		$("#historyView #no-moves").hide();
		$("#historyView #pre-loader").fadeIn(700, "linear");

		form = $("#historyForm");
		validateForms(form);

		if (form.valid()) {
			$("#pre-loader").fadeIn(700, "linear");
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

	// Al hacer click en Nueva afiliación
	$("#newAffiliate").on("click", (e) => showManageAffiliateView("create"));

	// Al hacer click en Editar afiliación
	$("#affiliationTable tbody").on(
		"click",
		"button[data-action='edit']",
		function () {
			currentAffiliaton = affiliationsList[$(this).data("index")];
			showManageAffiliateView("edit");
		}
	);

	// Al hacer click en Eliminar afiliación
	$("#affiliationTable tbody").on(
		"click",
		"button[data-action='delete']",
		function () {
			currentAffiliaton = affiliationsList[$(this).data("index")];
			$("#accept").addClass("sure-delete-affiliate");

			modalBtn = {
				btn1: {
					text: lang.GEN_BTN_ACCEPT,
					action: "none",
				},
				btn2: {
					text: lang.GEN_BTN_CANCEL,
					action: "destroy",
				},
			};

			appMessages(
				lang.TRANSF_DELETE_AFFILIATE,
				lang.TRANSF_SURE_DELETE_AFFILIATE,
				lang.CONF_ICON_INFO,
				modalBtn
			);
		}
	);

	// Modal para confirmar la eliminación de un afiliado
	$("#system-info").on("click", ".sure-delete-affiliate", function (e) {
		e.preventDefault();
		$(this).html(loader).prop("disabled", true);
		$("#cancel").prop("disabled", true);

		who = "Affiliations";
		where = "DeleteAffiliation";
		data.idAfiliation = currentAffiliaton.id_afiliacion;
		data.operationType = operationType;

		$(".nav-config-box").addClass("no-pointer");

		callNovoCore(who, where, data, function (response) {
			$(".nav-config-box").removeClass("no-pointer");
			modalDestroy(true);

			if (response.code == 0) {
				$("#accept").addClass("to-affiliations");
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			} else {
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			}
		});
	});

	$("#affiliateCancelBtn").on("click", function (e) {
		e.preventDefault();
		$("#manageAffiliateView").hide();
		$("#affiliationsView").fadeIn(700, "linear");
	});

	// Submit en formulario de Afiliación
	$("#manageAffiliateBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#manageAffiliate");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			who = "Affiliations";
			where = `Affiliation${operationType}`;
			data = getDataForm(form);
			data.idDocument = data.typeDocument + data.idNumber;

			if ($(this).data("action") == "edit") {
				data.idAfiliation = currentAffiliaton.id_afiliacion;
			}

			insertFormInput(true);
			$(this).html(loader);
			$(".nav-config-box").addClass("no-pointer");

			callNovoCore(who, where, data, function (response) {
				insertFormInput(false);
				$(e.target).html(btnText);
				$(".nav-config-box").removeClass("no-pointer");
				modalDestroy(true);

				if (response.code == 0) {
					$("#accept").addClass("to-affiliations");
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
				} else {
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
				}
			});
		}
	});

	// Al seleccionar un afiliado del directorio
	$("#affiliationList").on("click", "li:not(.no-results)", function (e) {
		e.preventDefault();
		var value, text, container;
		value = $(this).val();
		text = $(this).text().trim();
		container = $(this).closest(".select-by-search");

		container.find("input.select-search-input").val(text);
		container.find("li").removeClass("active");
		$(this).addClass("active").prependTo(container.find(".select-search"));
		container.find(".select-search").css("display", "none");
		$(".close-selector").css("display", "none");
		container.find("#directoryValue").val(value);

		currentAffiliaton = affiliationsList[value];
		setFieldNames("transfer");
	});

	// Submit en formulario de Transferencia y mostrar el resumen
	$("#transferBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#transferForm");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			transferData = getDataForm(form);
			buildTransferSummaryModal();
		}
	});

	// Confirmar transferencia/pago
	$("#system-info").on("click", ".confirm-transfer", function (e) {
		e.preventDefault();
		who = "Transfer";
		where =
			operationType == "PMV" ? "MobilePayment" : "Transfer" + operationType;
		data = {
			operationType: operationType,
			...transferData,
			amount: monto,
			expDateCta: transferData.filterMonth + transferData.filterYear.slice(-2),
			idDocument: transferData.typeDocument + transferData.idNumber,
			...cardData,
		};

		if (currentAffiliaton) {
			data.idAfiliation = currentAffiliaton.id_afiliacion;
		}

		insertFormInput(true);
		$(this).html(loader).prop("disabled", true);
		$("#cancel").prop("disabled", true);
		$(".nav-config-box").addClass("no-pointer");

		callNovoCore(who, where, data, function (response) {
			insertFormInput(false);
			modalDestroy(true);
			$(".nav-config-box").removeClass("no-pointer");

			if (response.code == 0) {
				transferResult = response.data;
				getBalance();
				buildTransferResultModal();
			} else {
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			}
		});
	});

	// Modal para agregar afiliado al realizar transferencia
	$("#system-info").on("click", ".want-save-beneficiary", function (e) {
		e.preventDefault();
		modalDestroy(true);
		$("#accept").addClass("save-beneficiary");

		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: "none",
			},
			btn2: {
				text: lang.GEN_BTN_CANCEL,
				action: "destroy",
			},
		};

		appMessages(
			lang.TRANSF_AFFILIATE_BENEFICIARY,
			lang.TRANSF_WANT_SAVE_BENEFICIARY,
			lang.CONF_ICON_INFO,
			modalBtn
		);
	});

	// Enviar petición agregar afiliado luego de transferencia
	$("#system-info").on("click", ".save-beneficiary", function (e) {
		e.preventDefault();
		$(this).html(loader).prop("disabled", true);
		$("#cancel").prop("disabled", true);

		var dataRequest = {
			P2P: {
				beneficiary: transferResult.nombreBeneficiario,
				idDocument: transferResult.idExtPer,
				destinationCard: transferResult.nroCuentaDestino,
				beneficiaryEmail: transferResult.email,
			},
			PMV: {
				beneficiary: transferResult.nombreBeneficiario,
				bank: transferResult.bancoDestino,
				idDocument: transferResult.idExtPer,
				mobilePhone: transferResult.telefonoDestino,
				beneficiaryEmail: transferResult.email,
			},
			P2T: {
				beneficiary: transferResult.nombreBeneficiario,
				bank: transferResult.bancoDestino,
				idDocument: transferResult.idExtPer,
				destinationAccount: transferResult.nroCuentaDestino,
				beneficiaryEmail: transferResult.email,
			},
		};

		who = "Affiliations";
		where = `Affiliation${operationType}`;
		data = dataRequest[operationType];

		insertFormInput(true);
		$(this).html(loader);
		$(".nav-config-box").addClass("no-pointer");

		callNovoCore(who, where, data, function (response) {
			insertFormInput(false);
			$(e.target).html(btnText);
			$(".nav-config-box").removeClass("no-pointer");
			modalDestroy(true);

			if (response.code == 0) {
				$("#accept").addClass("to-affiliations");
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			} else {
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			}
		});
	});

	// Vuelve a cargar la lista de afiliados
	$("#system-info").on("click", ".to-affiliations", function (e) {
		e.preventDefault();
		modalDestroy(true);
		$("#affiliations").click();
	});

	// Funcionalidad del selector/buscador
	$("body").on("focus", ".select-search-input", function () {
		var search = $(this).val().trim();
		$(this).val(search || "");
		var selector = $(this).next(".select-search");
		selector.css("display", "block");
		$(this)
			.closest(".select-by-search")
			.find(".close-selector")
			.css("display", "block");
	});

	$("body").on("input", ".select-search-input", function () {
		var selector = $(this).next(".select-search");
		var search = $(this).val().trim().toLowerCase();
		selector.find("li").addClass("hidden");
		var matches = selector.find('li:contains("' + search + '")');
		selector.find(".no-results").remove();
		if (matches.length == 0) {
			selector.append(
				'<li class="no-results">' + lang.GEN_NO_RESULTS + "</li>"
			);
		}
		matches.removeClass("hidden");
	});

	$("body").on("click", ".close-selector", function () {
		$(".select-search").css("display", "none");
		$(this).css("display", "none");
	});

	// Formatea monto de transferencia/pago
	$("#amount").mask(
		"#" + lang.CONF_THOUSANDS + "##0" + lang.CONF_DECIMAL + "00",
		{ reverse: true }
	);
	$("#amount").on("keyup", function () {
		$(this).val(function (index, value) {
			if (value.indexOf("0") != -1 && value.indexOf("0") == 0) {
				value = value.replace(0, "");
			}

			if (value.length == 1 && /^[0-9,.]+$/.test(value)) {
				value = "00" + lang.CONF_DECIMAL + value;
			}

			return value;
		});
	});

	function getBalance() {
		form = $("#operation");
		data = cardData = getDataForm(form);
		who = "Business";
		where = "GetBalance";
		$(".nav-config-box").removeClass("no-pointer");
		$("#currentBalance").text(lang.GEN_WAIT_BALANCE);
		$("#avaibleBalance").text(lang.TRANSF_AVAILABLE_BALANCE);

		callNovoCore(who, where, data, function (response) {
			$("#currentBalance").text(response.msg);
		});
	}

	function getBanks(operation, action = "") {
		var bankField =
			operation == "affiliation"
				? $("#manageAffiliateView #bank")
				: $("#transferView #bank");

		var currentBank =
			action == "edit" && currentAffiliaton?.codBanco
				? currentAffiliaton?.codBanco
				: "";

		bankField.prop("disabled", true);
		bankField.find("option").remove();
		bankField.append(
			currentBank == ""
				? `<option value="" selected disabled>${lang.TRANSF_WAITING_BANKS}</option>`
				: `<option value="${currentBank}" selected disabled>${currentAffiliaton.banco}</option>`
		);

		who = "Transfer";
		where = "GetBanks";

		callNovoCore(who, where, {}, function (response) {
			if (response.code == 0) {
				$.each(response.data, function (pos, bank) {
					if (currentBank != bank.codBcv) {
						bankField.append(
							`<option value="${bank.codBcv}">${bank.nomBanco}</option>`
						);
					}
				});

				if (currentBank == "") {
					bankField.find("option").first().text(lang.GEN_SELECTION);
				} else {
					bankField.find("option").first().prop("disabled", false);
				}
			}

			bankField.prop("disabled", false);
		});
	}

	function setAffiliateDataTable(data) {
		var columns, row, tdOptions;
		affiliationsList = data;
		$("#affiliationTable tbody").html("");

		switch (operationType) {
			case "P2P":
				columns = ["NombreCliente", "id_ext_per", "noTarjetaConMascara"];
				break;
			case "P2T":
				columns = ["beneficiario", "banco", "noCuenta"];
				break;
			case "PMV":
				columns = ["beneficiario", "banco", "telefono"];
				break;
		}

		data.forEach((value, index) => {
			row = $("<tr></tr>");
			columns.forEach((element) => {
				row.append(`<td>${value[element]}</td>`);
			});
			tdOptions = `<td class="py-0 px-1 flex justify-center items-center">
				<button class="btn mx-1 px-0" title="${lang.TRANSF_EDIT}" data-index="${index}" data-action="edit" data-toggle="tooltip">
					<i class="icon icon-edit" aria-hidden="true"></i>
				</button>
				<button class="btn mx-1 px-0 big-modal" title="${lang.TRANSF_DELETE}" data-index="${index}" data-action="delete" data-toggle="tooltip">
					<i class="icon icon-remove" aria-hidden="true"></i>
				</button>
			</td>`;
			row.append(tdOptions);
			$("#affiliationTable tbody").append(row);
		});

		$("#transferRecord").fadeIn(700, "linear");
		$("#searchAffiliate").fadeIn(700, "linear");
	}

	function setAffiliateSelectSearch(data) {
		var li;
		affiliationsList = data;

		li = $("<li></li>").val("").text(lang.TRANSF_WAITING_BANKS);
		$("#affiliationList").append(li);

		data.forEach((value, index) => {
			li = $("<li></li>")
				.val(index)
				.text(
					operationType == "P2P"
						? value.NombreCliente.toLowerCase()
						: value.beneficiario.toLowerCase()
				);
			$("#affiliationList").append(li);
		});

		$("#directory")
			.prop("placeholder", lang.GEN_BTN_SEARCH)
			.prop("disabled", false);
	}

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
			<span class="px-2 feed-amount items-center">${
				lang.CONF_CURRENCY + " " + numberToCurrency(value.montoTransferencia)
			}</span>`;

			li.html(row);
			$("#movementsList").append(li);
		});

		$("#historyView #results").fadeIn(700, "linear");
	}

	function showManageAffiliateView(action) {
		if (action == "create") {
			$("#manageAffiliate")[0].reset();
		}
		$("#affiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
		$("#manageAffiliateBtn")
			.text(action == "create" ? lang.TRANSF_AN_AFFILIATE : lang.GEN_BTN_SAVE)
			.data("action", action);
		$("#affiliateTitle").text(
			action == "create"
				? lang.TRANSF_NEW_AFFILIATE
				: lang.TRANSF_EDIT_AFFILIATE
		);

		switch (operationType) {
			case "P2P":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_CARD_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "P2T":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_BANK_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "PMV":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_PAY_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
		}

		if (action == "edit") {
			setFieldNames("affiliation");
		}

		if (operationType != "P2P") {
			getBanks("affiliation", action);
		}
	}

	function showTransferView() {
		$(liOptions).removeClass("active");
		$("#toTransfer").addClass("active no-pointer");
		$("#affiliationsView").css("display", "none");
		$("#toTransferView").show();

		who = "Affiliations";
		where = "GetAffiliations";
		data = { operationType: operationType, ...cardData };

		$("#directory")
			.prop("placeholder", lang.TRANSF_WAITING_AFFILIATES)
			.prop("disabled", true);
		$("#affiliationList").html("");

		callNovoCore(who, where, data, function (response) {
			$("#pre-loader").hide();
			switch (response.code) {
				case 0:
					let affiliations =
						response.data[OperationTypeAffiliations[operationType]];
					let transferParameters = response.data.parametrosTransferencias;

					if (transferParameters) {
						setTransferParameters(transferParameters[0]);
					}
					if (affiliations.length > 0) {
						setAffiliateSelectSearch(affiliations);
					} else {
						$("#directory")
							.prop("placeholder", "Sin afiliados")
							.prop("disabled", true);
					}
					break;
				case 1:
					$("#directory")
						.prop("placeholder", "Sin afiliados")
						.prop("disabled", true);
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
		});

		if (operationType != "P2P") {
			getBanks("transfer");
		}
	}

	function setValues(formID, objectValues) {
		Object.entries(objectValues).forEach(([fieldId, value]) => {
			$(`${formID} #${fieldId}`).val(value);
		});
	}

	function setFieldNames(operation) {
		var documentType, documentNumber, objectValues;

		if (currentAffiliaton.id_ext_per) {
			documentType = currentAffiliaton.id_ext_per.slice(0, 1);
			documentNumber = currentAffiliaton.id_ext_per.slice(1);
		}

		if (operation == "affiliation") {
			var setObjectValues = {
				P2P: {
					beneficiary: currentAffiliaton.NombreCliente,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationCard: currentAffiliaton.noTarjeta,
					beneficiaryEmail: currentAffiliaton.emailCliente,
				},
				P2T: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationAccount: currentAffiliaton.noCuenta,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
				PMV: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
			};

			objectValues = setObjectValues[operationType];
			setValues("#manageAffiliateView", objectValues);
		} else {
			var setObjectValues = {
				P2P: {
					beneficiary: currentAffiliaton.NombreCliente,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationCard: currentAffiliaton.noTarjeta,
					beneficiaryEmail: currentAffiliaton.emailCliente,
				},
				P2T: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationAccount: currentAffiliaton.noCuenta,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
				PMV: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
			};

			if (operationType != "P2P") {
				$("#transferView #bank option").each(function () {
					var val = $(this).val();
					$(this).prop("selected", currentAffiliaton.codBanco == val);
				});
			}

			objectValues = setObjectValues[operationType];
			setValues("#transferForm", objectValues);
		}
	}

	$("#movementsList").on(
		"click",
		"span[data-action='showVoucher']",
		function () {
			currentVaucherData = historyData[$(this).data("index")];
			buildVaucherModal();
		}
	);

	function setTransferParameters(parameters) {
		montoMaxOperaciones = parseFloat(parameters.montoMaxOperaciones);
		montoMinOperaciones = parseFloat(parameters.montoMinOperaciones);
		montoMaxDiario = parseFloat(parameters.montoMaxDiario);
		montoMaxSemanal = parseFloat(parameters.montoMaxSemanal);
		montoMaxMensual = parseFloat(parameters.montoMaxMensual);
		cantidadOperacionesDiarias = parseInt(
			parameters.cantidadOperacionesDiarias
		);
		cantidadOperacionesSemanales = parseInt(
			parameters.cantidadOperacionesSemanales
		);
		cantidadOperacionesMensual = parseInt(
			parameters.cantidadOperacionesMensual
		);
		montoAcumDiario = parseFloat(parameters.montoAcumDiario);
		montoAcumSemanal = parseFloat(parameters.montoAcumSemanal);
		montoAcumMensual = parseFloat(parameters.montoAcumMensual);
		acumCantidadOperacionesDiarias = parseInt(
			parameters.acumCantidadOperacionesDiarias
		);
		acumCantidadOperacionesSemanales = parseInt(
			parameters.acumCantidadOperacionesSemanales
		);
		acumCantidadOperacionesMensual = parseInt(
			parameters.acumCantidadOperacionesMensual
		);
		montoBase = parameters.montoBaseTransferencia
			? parseFloat(parameters.montoBaseTransferencia)
			: 0;
		montoComision = parseFloat(parameters.montoComision);
		porcentajeComision = parseFloat(parameters.porcentajeComision);
		totalComision = 0;
		dobleAutenticacion = parameters.dobleAutenticacion;
	}

	function buildTransferSummaryModal() {
		var setObjectSummary, objectSummary, summaryValueObject;
		var commission, span, summaryValue, inputModal;
		monto = currencyToNumber(transferData.amount);
		commission =
			monto <= montoBase ? montoComision : (monto * porcentajeComision) / 100;
		totalComision = monto + commission;

		$("#accept").addClass("confirm-transfer");

		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: "none",
			},
			btn2: {
				text: lang.GEN_BTN_CANCEL,
				action: "destroy",
			},
		};

		// dataValue: label
		setObjectSummary = {
			P2P: {
				beneficiary: lang.TRANSF_BENEFICIARY,
				dni: lang.GEN_DNI,
				destinationCard: lang.TRANSF_DESTINATION_CARD,
				amount: lang.TRANSF_AMOUNT,
				commission: lang.TRANSF_COMMISSION,
				total: lang.TRANSF_TOTAL,
				concept: lang.TRANSF_CONCEPT,
			},
			P2T: {
				beneficiary: lang.TRANSF_BENEFICIARY,
				bank: lang.TRANSF_BANK,
				dni: lang.GEN_DNI,
				destinationAccount: lang.TRANSF_ACCOUNT_NUMBER,
				amount: lang.TRANSF_AMOUNT,
				commission: lang.TRANSF_COMMISSION,
				total: lang.TRANSF_TOTAL,
				concept: lang.TRANSF_CONCEPT,
			},
			PMV: {
				beneficiary: lang.TRANSF_BENEFICIARY,
				bank: lang.TRANSF_BANK,
				dni: lang.GEN_DNI,
				mobilePhone: lang.GEN_PHONE_MOBILE,
				amount: lang.TRANSF_AMOUNT_DETAILS,
				commission: lang.TRANSF_COMMISSION,
				total: lang.TRANSF_TOTAL,
				concept: lang.TRANSF_CONCEPT,
			},
		};

		summaryValueObject = {
			bank: $("#bank option:selected").text(),
			dni: transferData.typeDocument + " " + transferData.idNumber,
			amount: lang.CONF_CURRENCY + " " + transferData.amount,
			commission: lang.CONF_CURRENCY + " " + numberToCurrency(commission),
			total: lang.CONF_CURRENCY + " " + numberToCurrency(totalComision),
		};

		objectSummary = setObjectSummary[operationType];
		inputModal = $("<div></div>").addClass("flex flex-column");

		Object.entries(objectSummary).forEach(([name, text]) => {
			summaryValue = summaryValueObject[name] ?? transferData[name];
			span = $("<span></span>")
				.addClass("list-inline-item")
				.text(text + ": " + summaryValue);
			inputModal.append(span);
		});

		appMessages(
			lang.TRANSF_OPERATION_SUMMARY,
			inputModal,
			lang.CONF_ICON_INFO,
			modalBtn
		);
	}

	function buildTransferResultModal() {
		var setObjectResult, objectResult, resultValueObject;
		var span, resultValue, inputModal, thirdPartyAffiliate;

		thirdPartyAffiliate =
			operationType == "PMV"
				? transferResult.dataTransaccion.terceroAfiliado
				: transferResult.id_afil_terceros != "";

		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: "destroy",
			},
		};

		if (!thirdPartyAffiliate) {
			$("#accept").addClass("want-save-beneficiary");
			modalBtn.btn1.action = "none";
		}

		// dataValue: label
		setObjectResult = {
			P2P: {
				reference: lang.TRANSF_REFERENCE,
				beneficiary: lang.TRANSF_BENEFICIARY,
				dni: lang.GEN_DNI,
				destinationCard: lang.TRANSF_DESTINATION_CARD,
				amount: lang.TRANSF_AMOUNT_DETAILS,
				concept: lang.TRANSF_CONCEPT,
				date: lang.TRANSF_DATE,
			},
			P2T: {
				reference: lang.TRANSF_REFERENCE,
				beneficiary: lang.TRANSF_BENEFICIARY,
				bank: lang.TRANSF_BANK,
				dni: lang.GEN_DNI,
				destinationAccount: lang.TRANSF_ACCOUNT_NUMBER,
				amount: lang.TRANSF_AMOUNT_DETAILS,
				concept: lang.TRANSF_CONCEPT,
				date: lang.TRANSF_DATE,
			},
			PMV: {
				reference: lang.TRANSF_REFERENCE,
				beneficiary: lang.TRANSF_BENEFICIARY,
				bank: lang.TRANSF_BANK,
				dni: lang.GEN_DNI,
				mobilePhone: lang.GEN_PHONE_MOBILE,
				amount: lang.TRANSF_AMOUNT_DETAILS,
				concept: lang.TRANSF_CONCEPT,
				date: lang.TRANSF_DATE,
			},
		};
		resultValueObject = {
			reference:
				operationType == "PMV"
					? transferResult.dataTransaccion.codConfirmacion
					: transferResult.dataTransaccion.referencia,
			bank: $("#bank option:selected").text(),
			dni: transferResult.idExtPer,
			amount: lang.CONF_CURRENCY + " " + transferData.amount,
			date: transferResult.logAccesoObject.dttimesstamp,
			destinationCard: transferResult.ctaDestinoConMascara,
		};

		objectResult = setObjectResult[operationType];
		inputModal = $("<div></div>").addClass("flex flex-column");

		Object.entries(objectResult).forEach(([name, text]) => {
			resultValue = resultValueObject[name] ?? transferData[name];
			span = $("<span></span>")
				.addClass("list-inline-item")
				.text(text + ": " + resultValue);
			inputModal.append(span);
		});

		appMessages(
			lang.TRANSF_OPERATION_RESULT,
			inputModal,
			lang.CONF_ICON_INFO,
			modalBtn
		);
	}

	function buildVaucherModal() {
		var setObjectResult, objectResult, resultValueObject;
		var span, resultValue, inputModal;

		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: "destroy",
			},
		};

		// dataValue: label
		setObjectResult = {
			P2P: {
				referencia: lang.TRANSF_REFERENCE,
				beneficiario: lang.TRANSF_BENEFICIARY,
				identificacion: lang.GEN_DNI,
				tarjetaDestinoMascara: lang.TRANSF_DESTINATION_CARD,
				montoTransferencia: lang.TRANSF_AMOUNT_DETAILS,
				concepto: lang.TRANSF_CONCEPT,
				fechaTransferencia: lang.TRANSF_DATE,
			},
			P2T: {
				referencia: lang.TRANSF_REFERENCE,
				beneficiario: lang.TRANSF_BENEFICIARY,
				banco: lang.TRANSF_BANK,
				identificacion: lang.GEN_DNI,
				cuentaDestino: lang.TRANSF_ACCOUNT_NUMBER,
				montoTransferencia: lang.TRANSF_AMOUNT_DETAILS,
				concepto: lang.TRANSF_CONCEPT,
				fechaTransferencia: lang.TRANSF_DATE,
			},
			PMV: {
				referencia: lang.TRANSF_REFERENCE,
				beneficiario: lang.TRANSF_BENEFICIARY,
				banco: lang.TRANSF_BANK,
				identificacion: lang.GEN_DNI,
				telefonoDestino: lang.GEN_PHONE_MOBILE,
				montoTransferencia: lang.TRANSF_AMOUNT_DETAILS,
				concepto: lang.TRANSF_CONCEPT,
				fechaTransferencia: lang.TRANSF_DATE,
			},
		};

		resultValueObject = {
			montoTransferencia:
				lang.CONF_CURRENCY +
				" " +
				numberToCurrency(currentVaucherData.montoTransferencia),
		};

		objectResult = setObjectResult[operationType];
		inputModal = $("<div></div>").addClass("flex flex-column");

		Object.entries(objectResult).forEach(([name, text]) => {
			resultValue = resultValueObject[name] ?? currentVaucherData[name];
			span = $("<span></span>")
				.addClass("list-inline-item")
				.text(text + ": " + resultValue);
			inputModal.append(span);
		});

		appMessages(
			lang.TRANSF_PAYMENT_VOUCHER,
			inputModal,
			lang.CONF_ICON_INFO,
			modalBtn
		);
	}

	function numberToCurrency(number) {
		var num = typeof number == "string" ? Number(number) : number;
		return num.toFixed(2).replace(".", ",");
	}

	function currencyToNumber(currency) {
		return Number(currency.replace(".", "").replace(",", "."));
	}
});
