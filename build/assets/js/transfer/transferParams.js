"use strict";

var transferParams = {};

function setTransferParams(params) {
	Object.entries(params).forEach(([param, value]) => {
		switch (param) {
			case "dobleAutenticacion":
			case "idOperacion":
				transferParams[param] = value;
				break;
			case "cantidadOperacionesDiarias":
			case "cantidadOperacionesSemanales":
			case "cantidadOperacionesMensual":
			case "acumCantidadOperacionesDiarias":
			case "acumCantidadOperacionesSemanales":
			case "acumCantidadOperacionesMensual":
				transferParams[param] = parseInt(value);
				break;
			default:
				transferParams[param] = parseFloat(value);
				break;
		}
	});

	transferParams.montoMinOperaciones = parseFloat(params.montoMinOperaciones);
	totalAmount = commission = 0;
}

function validateTransferParams() {
	if (transferParams.idOperacion !== "P2P") {
		commission = Math.max(
			transferParams.montoComision,
			amount * (transferParams.porcentajeComision / 100)
		);
	}
	totalAmount = amount + commission;

	// Valida monto de transferencias
	if (
		amount < transferParams.montoMinOperaciones ||
		amount > transferParams.montoMaxOperaciones
	) {
		paramsValidationMessage = lang.TRANSF_MINIMUM_MAXIMUM_AMOUNT.replace(
			/%s/,
			numberToCurrency(transferParams.montoMinOperaciones, true)
		).replace(/%s/, numberToCurrency(transferParams.montoMaxOperaciones, true));

		return false;
	}
	if (totalAmount > availableBalance) {
		paramsValidationMessage = lang.TRANSF_AMOUNT_EXCEEDS_BALANCE;

		return false;
	}
	if (
		transferParams.montoAcumMensual + amount >
		transferParams.montoMaxMensual
	) {
		paramsValidationMessage = lang.TRANSF_MONTHLY_MAXIMUM_AMOUNT.replace(
			/%s/,
			numberToCurrency(transferParams.montoMaxMensual, true)
		).replace(/%s/, numberToCurrency(transferParams.montoAcumMensual, true));

		return false;
	}
	if (
		transferParams.montoAcumSemanal + amount >
		transferParams.montoMaxSemanal
	) {
		paramsValidationMessage = lang.TRANSF_WEEKLY_MAXIMUM_AMOUNT.replace(
			/%s/,
			numberToCurrency(transferParams.montoMaxSemanal, true)
		).replace(/%s/, numberToCurrency(transferParams.montoAcumSemanal, true));

		return false;
	}
	if (transferParams.montoAcumDiario + amount > transferParams.montoMaxDiario) {
		paramsValidationMessage = lang.TRANSF_DAILY_MAXIMUM_AMOUNT.replace(
			/%s/,
			numberToCurrency(transferParams.montoMaxDiario, true)
		).replace(/%s/, numberToCurrency(transferParams.montoAcumDiario, true));

		return false;
	}

	//Valida cantidad de operaciones
	if (
		transferParams.acumCantidadOperacionesMensual >=
		transferParams.cantidadOperacionesMensual
	) {
		paramsValidationMessage = lang.TRANSF_MAXIMUM_MONTHLY_OPERATIONS.replace(
			/%s/,
			transferParams.cantidadOperacionesMensual
		);

		return false;
	}
	if (
		transferParams.acumCantidadOperacionesSemanales >=
		transferParams.cantidadOperacionesSemanales
	) {
		paramsValidationMessage = lang.TRANSF_MAXIMUM_WEEKLY_OPERATIONS.replace(
			/%s/,
			transferParams.cantidadOperacionesSemanales
		);

		return false;
	}
	if (
		transferParams.acumCantidadOperacionesDiarias >=
		transferParams.cantidadOperacionesDiarias
	) {
		paramsValidationMessage = lang.TRANSF_MAXIMUM_DAILY_OPERATIONS.replace(
			/%s/,
			transferParams.cantidadOperacionesDiarias
		);

		return false;
	}

	return true;
}
