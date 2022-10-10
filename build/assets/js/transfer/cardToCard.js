"use strict";
$(function () {
	var liOptions = $(".nav-item-config");
	var operationType = "P2T";

	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

	$.each(liOptions, function (pos, liOption) {
		$("#" + liOption.id).on("click", function (e) {
			var liOptionId = e.currentTarget.id;
			$(liOptions).removeClass("active");
			$(this).addClass("active");
			$(".transfer-operation").hide();
			$("#manageAffiliateView").hide();
			$("#" + liOptionId + "View").fadeIn(700, "linear");
		});
	});

	$("#editAffiliate, #toTransferBtn").on("click", function (e) {
		$("#manageAffiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
	});

	$("#affiliateCancelBtn").on("click", function (e) {
		e.preventDefault();
		$("#manageAffiliateView").hide();
		$("#manageAffiliationsView").fadeIn(700, "linear");
	});

	$("#manageAffiliateBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#manageAffiliate");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			$(this).html(loader);
			who = "transfer";
			where = "affiliate";
			data = getDataForm(form);
			data.operationType = operationType;
			insertFormInput(true);
			callNovoCore(who, where, data, function (response) {
				$(e.target).html(btnText);
				insertFormInput(false);
				console.log(response);
				if (response.code == 0) {
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

	$("#transferBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#transferForm");
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentOperKey = cryptoPass(data.currentOperKey);
			$(this).html(loader);
			insertFormInput(true);
		}
	});
});
