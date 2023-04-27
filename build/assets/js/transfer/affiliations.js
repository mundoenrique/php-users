"use strict";
$(function () {
	// Carga tabla lista de afiliados
	$("#affiliations").on("click", function (e) {
		e.preventDefault();
		$("#transferRecord").hide();
		$("#searchAffiliate").hide();
		$("#affiliationsView #no-moves").hide();
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
				lang.SETT_ICON_INFO,
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
		data.idAfiliation = currentAffiliaton.idAfilTerceros;
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

			if (data.hasOwnProperty("destinationAccount")) {
				data.destinationAccount = data.destinationAccount.replace(/-/g, "");
			}
			if ($(this).data("action") == "edit") {
				data.idAfiliation = currentAffiliaton.idAfilTerceros;
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

	// Al crear/editar/eliminar un afiliado, recargar lista de afiliados
	$("#system-info").on("click", ".to-affiliations", function (e) {
		e.preventDefault();
		modalDestroy(true);
		$("#affiliations").click();
	});
});

function setAffiliateDataTable(data) {
	var columns, row, tdOptions;
	affiliationsList = data;
	$("#affiliationTable tbody").html("");

	switch (operationType) {
		case "P2P":
			columns = ["NombreCliente", "id_ext_per", "noTarjetaConMascara"];
			break;
		case "PCI":
			columns = ["beneficiario", "banco", "noCuentaConMascara"];
			break;
		case "PMV":
			columns = ["beneficiario", "banco", "telefono"];
			break;
	}

	data.forEach((value, index) => {
		row = $("<tr></tr>");
		columns.forEach((element) => {
			if (element == "noCuentaConMascara") {
				value["telefono"] != ""
					? row.append(`<td>${value["telefono"]}</td>`)
					: row.append(`<td>${value[element]}</td>`);
			} else {
				row.append(`<td>${value[element]}</td>`);
			}
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

function showManageAffiliateView(action) {
	resetForms($("#manageAffiliate"));
	$("#affiliationsView").hide();
	$("#manageAffiliateView").fadeIn(700, "linear");
	$("#manageAffiliateBtn")
		.text(action == "create" ? lang.TRANSF_AN_AFFILIATE : lang.GEN_BTN_SAVE)
		.data("action", action);
	$("#affiliateTitle").text(
		action == "create" ? lang.TRANSF_NEW_AFFILIATE : lang.TRANSF_EDIT_AFFILIATE
	);
	disableFields("#manageAffiliate", false);
	switch (operationType) {
		case "P2P":
			$("#affiliateMessage").text(
				action == "create"
					? lang.TRANSF_NEW_AFFILIATE_CARD_MSG
					: lang.TRANSF_EDIT_AFFILIATE_MSG
			);
			break;
		case "PCI":
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

	if (operationType != "P2P") {
		getBanks("affiliation", action);
	}

	if (action == "edit") {
		setFieldNames("affiliation");
		disableFields("#manageAffiliate", true);
	}

	disableIdNumber($("#manageAffiliate #typeDocument"));
}

function disableFields(formID, disabled) {
	$(`${formID} input, ${formID} select`)
		.not("#beneficiary, #mobilePhone, #beneficiaryEmail")
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
