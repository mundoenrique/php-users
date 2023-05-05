"use strict";
var operationType, liOptions, OperationTypeAffiliations, bankList, cardData;
var affiliationsList, currentAffiliaton, historyData, transferData;
var transferResult, modalTitle, paramsValidationMessage, currentVaucherData;
var availableBalance, amount, commission, totalAmount;

$(function () {
	operationType = $("#transferView").attr("operation-type");
	liOptions = $(".nav-item-config");
	OperationTypeAffiliations = {
		P2P: "cuentaDestinoPlata",
		PMV: "pagoMovil",
		PCI: "creditoInmediato",
	};
	var title = {
		P2P: lang.TRANSF_TRANSFER_TO_CARD,
		PMV: lang.GEN_MENU_MOBILE_PAYMENT,
		PCI: lang.TRANSF_BANK_TRANSFER,
	};
	modalTitle = title[operationType];

	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

	// Si existe una sola tarjeta
	if ($("#productdetail").attr("call-balance") == "1") {
		getBalance();
		showTransferView();
	}

	// Al seleccionar una tarjeta
	$("#system-info").on("click", ".dashboard-item", function (e) {
		e.preventDefault();
		getBalance();
		resetForms($("#toTransferView form"));
		resetForms($("#manageAffiliateView form"));
		resetForms($("#historyView form"));
		showTransferView();
	});

	// Mostrar vista correspondiente al seleccionar una operación
	// (Transferir|Adm. Afiliaciones|Historial)
	$(liOptions).on("click", function (e) {
		e.preventDefault();
		var liOptionId = e.currentTarget.id;
		var currentView = $("#" + liOptionId + "View");
		$(liOptions).removeClass("active");
		$(cardData ? liOptions : "#affiliations").removeClass("no-pointer");
		$(this).addClass("active no-pointer");
		$(".transfer-operation").hide();
		$("#manageAffiliateView").hide();
		resetForms($("#toTransferView form"));
		resetForms($("#manageAffiliateView form"));
		resetForms($("#historyView form"));
		currentView.fadeIn(700, "linear");
	});

	// Mostrar vista de Transferir/Realizar pago
	$("#toTransfer").on("click", function (e) {
		e.preventDefault();
		showTransferView();
	});

	// Mostrar campo correspondiente a intrumento seleccionado
	// (Cuenta | Teléfono)
	$("input[name=destinationInstrument]").change(function (e) {
		e.preventDefault();
		if (!currentAffiliaton) {
			$("#mobilePhone").val("");
			$("#destinationAccount").val("");
		}
		if ($("#account").is(":checked")) {
			$("#mobilePhoneField").hide();
			$("#destinationAccountField").show();
		} else {
			$("#destinationAccountField").hide();
			$("#mobilePhoneField").show();
		}
	});

	// Click en Borrar (form Transferencia|Pago)
	$("#deleteBtn").on("click", function (e) {
		cleanDirectory();
		resetForms($("#transferForm"));
		hideDestinationFields();
		disableAffiliationFields("#transferForm", false);
		$("transferForm input#idNumber").prop("disabled", true);
	});

	// Submit en formulario de Transferencia y mostrar el resumen
	$("#transferBtn").on("click", function (e) {
		e.preventDefault();
		var valid;
		form = $("#transferForm");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			transferData = getDataForm(form);
			amount = currencyToNumber(transferData.amount);
			valid = validateTransferParams();
			if (valid) {
				buildTransferSummaryModal();
			} else {
				modalBtn = {
					btn1: {
						text: lang.GEN_BTN_ACCEPT,
						action: "destroy",
					},
				};

				appMessages(
					modalTitle,
					paramsValidationMessage,
					lang.SETT_ICON_INFO,
					modalBtn
				);
			}
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
			amount: amount,
			expDateCta: transferData.filterMonth + transferData.filterYear.slice(-2),
			idDocument: transferData.typeDocument + transferData.idNumber,
			instrumento: $("input[name=destinationInstrument]:checked").val(),
			...cardData,
		};

		if (transferData.hasOwnProperty("instrumento")) {
			data.instrumento = $("input[name=destinationInstrument]:checked").val();
		}
		if (transferData.hasOwnProperty("destinationAccount")) {
			data.destinationAccount = data.destinationAccount.replace(/-/g, "");
		}
		if (transferData.hasOwnProperty("destinationCard")) {
			data.destinationCard = data.destinationCard.replace(/-/g, "");
		}
		if (currentAffiliaton) {
			data.idAfiliation = currentAffiliaton.idAfilTerceros;
		}
		transferData = data;

		insertFormInput(true);
		$(this).html(loader).prop("disabled", true);
		$("#cancel").prop("disabled", true);
		$(".nav-config-box").addClass("no-pointer");

		callNovoCore(who, where, data, function (response) {
			insertFormInput(false);
			modalDestroy(true);
			$(".nav-config-box").removeClass("no-pointer");

			switch (response.code) {
				case 1:
				case 4:
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
					break;
				case 2:
					getBalance();
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
					break;
				default:
					transferResult = response.data;
					getBalance();
					buildTransferResultModal();
					break;
			}
		});
	});

	// Modal para recargar vista
	$("#system-info").on("click", ".reload-view", function (e) {
		e.preventDefault();
		modalDestroy(true);
		showTransferView();
	});

	// Modal para agregar afiliado al concluir operación exitosa
	$("#system-info").on("click", ".want-save-beneficiary", function (e) {
		e.preventDefault();
		modalDestroy(true);
		$("#accept").addClass("save-beneficiary");
		$("#cancel").addClass("reload-view");

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
			lang.SETT_ICON_INFO,
			modalBtn
		);
	});

	// Enviar petición agregar afiliado luego de operación exitosa
	$("#system-info").on("click", ".save-beneficiary", function (e) {
		e.preventDefault();
		$(this).html(loader).prop("disabled", true);
		$("#cancel").prop("disabled", true);

		var dataRequest = {
			P2P: {
				beneficiary: transferResult.nombreBeneficiario,
				idDocument:
					transferResult.idExtPer ||
					transferData.typeDocument + transferData.idNumber,
				destinationCard: transferResult.ctaDestino,
				beneficiaryEmail: transferResult.email || transferData.beneficiaryEmail,
			},
			PMV: {
				beneficiary: transferResult.nombreBeneficiario,
				bank: transferResult.bancoDestino,
				idDocument: transferResult.idExtPer,
				mobilePhone: transferResult.telefonoDestino,
				beneficiaryEmail: transferResult.email,
			},
			PCI: {
				beneficiary: transferResult.nombreBeneficiario,
				bank: transferResult.bancoDestino,
				idDocument: transferResult.idExtPer,
				destinationAccount: transferResult.ctaDestino,
				mobilePhone: transferResult.telefonoDestino,
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

	// Datepicker fecha de vencimiento
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

	// Funcionalidad del selector/buscador directorio
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
		resetForms($("#transferForm"));
		hideDestinationFields();
		setFieldNames("transfer");
	});

	$("input#destinationAccount").mask("0000-0000-0000-0000-0000");
	$("input#destinationCard").mask("0000-0000-0000-0000");

	// Formatea monto de transferencia/pago
	$("#amount").mask(
		"#" + lang.SETT_THOUSANDS + "##0" + lang.SETT_DECIMAL + "00",
		{ reverse: true }
	);
	$("#amount").on("keyup", function () {
		$(this).val(function (index, value) {
			if (value.indexOf("0") != -1 && value.indexOf("0") == 0) {
				value = value.replace(0, "");
			}

			if (value.length == 1 && /^[0-9,.]+$/.test(value)) {
				value = "00" + lang.SETT_DECIMAL + value;
			}

			return value;
		});
	});

	// Deshabilita campos número documento
	$("input#idNumber").prop("disabled", true);

	// Habilita campo número doc. al seleccionar el tipo doc.
	$("select#typeDocument").change(function () {
		disableIdNumber($(this));
	});
});

function disableIdNumber(typeDocument) {
	var selectedOption = typeDocument.children("option:selected").val();
	var idNumber = typeDocument.closest(".form-row").find("#idNumber");
	var disableInput = false;

	if (selectedOption == "") {
		idNumber.val("");
		disableInput = true;
	}

	idNumber.prop("disabled", disableInput);
}

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
		availableBalance = currencyToNumber(response.msg);
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

	bankField.attr("readonly", true).addClass("bg-tertiary border no-pointer");
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

		if (action != "edit") {
			bankField
				.attr("readonly", false)
				.removeClass("bg-tertiary border no-pointer");
		}
	});
}

function setAffiliateSelectSearch(data) {
	var li;
	affiliationsList = data;

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

function showTransferView() {
	cleanDirectory();
	disableAffiliationFields("#transferForm", false);
	$(liOptions).removeClass("active");
	$("#toTransfer").addClass("active no-pointer");
	$("#manageAffiliateView").hide();
	$("#historyView").hide();
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
				let transferParams = response.data.parametrosTransferencias;

				if (transferParams) {
					setTransferParams(transferParams[0]);
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

function disableAffiliationFields(formID, disabled) {
	$(`${formID} input, ${formID} select`)
		.not("#amount, #concept, #expDateCta")
		.each(function () {
			$(this).attr("readonly", disabled);
			disabled
				? $(this).addClass(
						`bg-tertiary border${$(this).is("select") ? " no-pointer" : ""}`
				  )
				: $(this).removeClass(
						`bg-tertiary border${$(this).is("select") ? " no-pointer" : ""}`
				  );
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
			PCI: {
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
			PCI: {
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
		disableAffiliationFields("#transferForm", true);
	}
}

function buildTransferSummaryModal() {
	var setObjectSummary, objectSummary, summaryValueObject;
	var span, summaryValue, inputModal;

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
			amount: lang.TRANSF_AMOUNT_DETAILS,
			concept: lang.TRANSF_CONCEPT,
		},
		PCI: {
			beneficiary: lang.TRANSF_BENEFICIARY,
			bank: lang.TRANSF_BANK,
			dni: lang.GEN_DNI,
			destinationAccount: lang.TRANSF_ACCOUNT_NUMBER,
			mobilePhone: lang.GEN_PHONE_MOBILE,
			amount: lang.TRANSF_AMOUNT_DETAILS,
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
		dni: transferData.typeDocument + transferData.idNumber,
		amount: lang.SETT_CURRENCY + " " + transferData.amount,
		commission: numberToCurrency(commission, true),
		total: numberToCurrency(totalAmount, true),
	};

	objectSummary = setObjectSummary[operationType];
	inputModal = $("<div></div>").addClass("flex flex-column");
	console.log(transferData);

	Object.entries(objectSummary).forEach(([name, text]) => {
		if (
			operationType == "PCI" &&
			((name == "destinationAccount" && !$("#account").is(":checked")) ||
				(name == "mobilePhone" && !$("#phone").is(":checked")))
		) {
			return;
		}
		summaryValue = summaryValueObject[name] ?? transferData[name];
		span = $("<span></span>")
			.addClass("list-inline-item")
			.text(text + ": " + summaryValue);
		inputModal.append(span);
	});

	appMessages(
		lang.TRANSF_OPERATION_SUMMARY,
		inputModal,
		lang.SETT_ICON_INFO,
		modalBtn
	);
}

function buildTransferResultModal() {
	var setObjectResult, objectResult, resultValueObject;
	var span, resultValue, inputModal, thirdPartyAffiliate;

	thirdPartyAffiliate =
		operationType == "P2P"
			? transferResult.idAfilTerceros != ""
			: transferResult.dataTransaccion.terceroAfiliado;

	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: "none",
		},
	};

	$("#accept").addClass(
		!thirdPartyAffiliate ? "want-save-beneficiary" : "reload-view"
	);

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
		PCI: {
			reference: lang.TRANSF_REFERENCE,
			beneficiary: lang.TRANSF_BENEFICIARY,
			bank: lang.TRANSF_BANK,
			dni: lang.GEN_DNI,
			destinationAccount: lang.TRANSF_ACCOUNT_NUMBER,
			mobilePhone: lang.GEN_PHONE_MOBILE,
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
		reference: getRefNumber(transferResult.dataTransaccion),
		bank: $("#bank option:selected").text(),
		dni:
			transferResult.idExtPer ||
			transferData.typeDocument + transferData.idNumber,
		amount: lang.SETT_CURRENCY + " " + transferData.amount,
		date: transferResult.logAccesoObject.dttimesstamp,
		destinationCard: transferResult.ctaDestinoConMascara,
		destinationAccount: transferResult.ctaDestinoConMascara,
	};

	objectResult = setObjectResult[operationType];
	inputModal = $("<div></div>").addClass("flex flex-column");

	Object.entries(objectResult).forEach(([name, text]) => {
		if (
			operationType == "PCI" &&
			((name == "destinationAccount" && transferData["instrumento"] != "c") ||
				(name == "mobilePhone" && transferData["instrumento"] != "t"))
		) {
			return;
		}
		resultValue = resultValueObject[name] ?? transferData[name];
		span = $("<span></span>")
			.addClass("list-inline-item")
			.text(text + ": " + resultValue);
		inputModal.append(span);
	});

	appMessages(
		lang.TRANSF_OPERATION_RESULT,
		inputModal,
		lang.SETT_ICON_INFO,
		modalBtn
	);

	resetForms($("#toTransferView form"));
	cleanDirectory();
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
		PCI: {
			referencia: lang.TRANSF_REFERENCE,
			beneficiario: lang.TRANSF_BENEFICIARY,
			banco: lang.TRANSF_BANK,
			identificacion: lang.GEN_DNI,
			ctaDestino_Mascara: lang.TRANSF_ACCOUNT_NUMBER,
			telefonoDestino: lang.GEN_PHONE_MOBILE,
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
		montoTransferencia: numberToCurrency(
			currentVaucherData.montoTransferencia,
			true
		),
		referencia:
			currentVaucherData?.estatusOperacion &&
			currentVaucherData?.estatusOperacion != "0"
				? currentVaucherData.billnumber
				: currentVaucherData.referencia,
	};

	objectResult = setObjectResult[operationType];
	inputModal = $("<div></div>").addClass("flex flex-column");

	Object.entries(objectResult).forEach(([name, text]) => {
		if (
			operationType == "PCI" &&
			((name == "ctaDestino_Mascara" &&
				currentVaucherData["ctaDestino"] == "") ||
				(name == "telefonoDestino" && currentVaucherData[name] == ""))
		) {
			return;
		}
		resultValue = resultValueObject[name] ?? currentVaucherData[name];
		span = $("<span></span>")
			.addClass("list-inline-item")
			.text(text + ": " + resultValue);
		inputModal.append(span);
	});

	appMessages(
		lang.TRANSF_PAYMENT_VOUCHER,
		inputModal,
		lang.SETT_ICON_INFO,
		modalBtn
	);
}

function getRefNumber(data) {
	if (operationType == "P2P") {
		return data.referencia;
	} else {
		return data?.transferenciaRealizada
			? data.codConfirmacion
			: data.billnumber;
	}
}

function cleanDirectory() {
	currentAffiliaton = null;
	$("#transferView #bank")
		.attr("readonly", false)
		.removeClass("no-pointer bg-tertiary border");
	$("#affiliationList li").removeClass("active");
	$("#directoryValue, #directory").val("");
}

function hideDestinationFields() {
	$("#destinationAccountField").hide();
	$("#mobilePhoneField").hide();
}

function numberToCurrency(number, withCurrencySymbol) {
	var num = typeof number == "string" ? Number(number) : number;
	var formatter = new Intl.NumberFormat("es-VE", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});
	var currencyNumber = formatter.format(num);

	return withCurrencySymbol
		? lang.SETT_CURRENCY + " " + currencyNumber
		: currencyNumber;
}

function currencyToNumber(currency) {
	return Number(currency.replace(/[^0-9-,]+/g, "").replace(",", "."));
}
