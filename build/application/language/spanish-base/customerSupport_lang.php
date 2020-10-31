<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['CUST_REPLACE_REQUEST'] = 'Solicitud %s de reposición';
$lang['CUST_INACTIVE_PRODUCT'] = 'Tu tarjeta se encuentra inactiva';
$lang['CUST_PERMANENT_LOCK'] = 'Tu tarjeta tiene una reposición pendiente';
$lang['CUST_TWIRLS_COMMERCIAL'] = 'Giros comerciales';
$lang['CUST_TRANS_LIMITS'] = 'Limites transaccionales';
$lang['CUST_CARD_NUMBER'] = 'Nro. de tarjeta';
$lang['CUST_NAME']='Nombre';
$lang['CUST_DNI'] = 'DNI';
$lang['CUS_SERVICES'] = [
	'cardLock' => '110',
	'replacementRequest' => '111',
	'pinManagement' => '112, 117, 120',
	'twirlsCommercial' => '130',
	'transactionalLimits' => '217',
];
$lang['CUS_MANAGE_PIN'] = [
	'changePin' => '112',
	'generatePin' => '120',
	'requestPin' => '117'
];
$lang['CUST_SHOPS'] = [
	'agenciaViajes' => 'travelAgency',
	'aseguradoras' => 'insurers',
	'beneficencia' => 'charity',
	'colegios' => 'collegesUniversities',
	'entretenimiento' => 'entertainment',
	'estacionamientos' => 'parking',
	'gasolineras' => 'gaStations',
	'gobiernos' => 'governments',
	'hospitales' => 'hospitals',
	'hoteles' => 'hotels',
	'peajes' => 'debit',
	'rentaAuto' => 'toll',
	'restaurantes' => 'restaurants',
	'supermercados' => 'supermarkets',
	'telecomunicaciones' => 'telecommunication',
	'transporteAereo' => 'airTransport',
	'transporteTerrestre' => 'passengerTransportation',
	'ventasDetalle' => 'retailSales',
];
$lang['CUST_LIMITS'] = [
	"compraDiarioCant" => "numberDayPurchasesCtp",
	"compraSemanalCant" => "numberWeeklyPurchasesCtp",
	"compraMensualCant" => "numberMonthlyPurchasesCtp",
	"compraDiarioMonto" => "dailyPurchaseamountCtp",
	"compraSemanalMonto" => "weeklyAmountPurchasesCtp",
	"compraMensualMonto" => "monthlyPurchasesAmountCtp",
	"compraMontoTrx" => "purchaseTransactionCtp",
	"compraNoDiarioCant" => "numberDayPurchasesStp",
	"compraNoSemanalCant" => "numberWeeklyPurchasesStp",
	"compraNoMensualCant" => "numberMonthlyPurchasesStp",
	"compraNoDiarioMonto" => "dailyPurchaseamountStp",
	"compraNoSemanalMonto" => "weeklyAmountPurchasesStp",
	"compraNoMensualMonto" => "monthlyPurchasesAmountStp",
	"compraNoMontoTrx" => "purchaseTransactionStp",
	"retiroDiarioCant" => "dailyNumberWithdraw",
	"retiroSemanalCant" => "weeklyNumberWithdraw",
	"retiroMensualCant" => "monthlyNumberWithdraw",
	"retiroDiarioMonto" => "dailyAmountWithdraw",
	"retiroSemanalMonto" => "weeklyAmountWithdraw",
	"retiroMensualMonto" => "monthlyAmountwithdraw",
	"retiroMontoTrx" => "WithdrawTransaction",
	"abonoDiarioCant" => "dailyNumberCredit",
	"abonoSemanalCant" => "weeklyNumberCredit",
	"abonoMensualCant" => "monthlyNumberCredit",
	"abonoDiarioMonto" => "dailyAmountCredit",
	"abonoSemanalMonto" => "weeklyAmountCredit",
	"abonoMensualMonto" => "monthlyAmountCredit",
	"abonoMontoTrx" => "CreditTransaction"
];
$lang['CUST_UPDATE_CURRENT'] = 'Fecha de actualización:';
$lang['CUST_NON_RESULTS'] = 'No fue posible encontrar los registros de tu tarjeta, por favor vuelve a intentarlo; si continuas viendo este mensaje comunícate con el representante de tu empresa.';
$lang['CUST_CARD_TEMPORARY_LOCK'] = 'La tarjeta presenta un bloqueo temporal, para realizar esta consulta debes desbloquearla.';
$lang['CUST_CARD_CANCELED'] = 'La tarjeta esta cancelada, no puedes hacer esta consulta.';
$lang['CUST_CARD_UNAVAILABLE'] = 'La tarjeta no esta disponible para realizar esta consulta.';
$lang['CUST_REPLACE_REASON'] = [
	'41' => 'Tarjeta perdida',
	'43' => 'Tarjeta robada',
	'TD' => 'Tarjeta deteriorada',
	'TR' => 'Reemplazar tarjeta',
];
$lang['CUST_REQUEST_REASON'] = 'Fraude';
