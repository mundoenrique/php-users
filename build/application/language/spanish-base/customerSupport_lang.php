<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['CUST_CHANGE_PIN_TITLE'] = 'Cambio de PIN';
$lang['CUST_REPLACE_REQUEST'] = 'Solicitud %s de reposición';
$lang['CUST_INACTIVE_PRODUCT'] = 'Tu tarjeta se encuentra inactiva';
$lang['CUST_PERMANENT_LOCK'] = 'Tu tarjeta tiene una reposición pendiente';
$lang['CUST_TWIRLS_COMMERCIAL'] = 'Giros comerciales';
$lang['CUST_TRANS_LIMITS'] = 'Limites transaccionales';
$lang['CUST_CARD_NUMBER'] = 'Nro. de tarjeta';
$lang['CUST_NAME']='Nombre';
$lang['CUST_DNI'] = 'DNI';
$lang['CUST_SERVICES'] = [
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
$lang['CUST_TEMPORARY_LOCK_REASON'] = [
	'Tarjeta perdida',
	'Bloqueo preventivo',
];
$lang['CUST_REPLACE_MSG'] = 'Se ha generado una nueva tarjeta, la puede ver en la lista consolidada.';
$lang['CUST_STOLEN_CARD'] = '43';
$lang['CUST_REPLACE_CARD'] = ' Si realmente deseas reponer tu tarjeta, presiona continuar para asignar una nueva.';
$lang['CUST_SUCCESS_CHANGE_PIN'] = 'El PIN de la tarjeta %s, ha sido cambiado exitosamente';
$lang['CUST_SUCCESS_OPERATION_RESPONSE'] = 'La tarjeta %s, ha sido %s.';
$lang['CUST_SPECIFIC_INACTIVE_PRODUCT'] = 'La tarjeta %s se encuentra inactiva';
$lang['CUST_SPECIFIC_PERMANENT_LOCK'] = 'La tarjeta %s tiene una reposición pendiente';
$lang['CUST_SPECIFIC_REVEWAL_LOCK'] = 'La tarjeta %s tiene una renovación pendiente';
$lang['CUST_EXPIRED_CARD'] = 'No es posible realizar esta acción la tarjeta %s está vencida';
$lang['CUST_LOCK_CARD'] = 'La tarjeta %s se encuentra bloqueada';
$lang['CUST_PIN_NOT_VALID'] = 'El PIN actual no es válido, verifica e intenta nuevamente.';
$lang['CUST_DATA_INVALIDATED'] = 'Los campos introducidos son inválidos, verifica e intenta nuevamente.';
$lang['CUST_FAILED_ATTEMPTS'] = 'Has superado la cantidad de intentos fallidos por el día de hoy, por favor intenta mañana.';
$lang['CUST_PIN_NOT_CHANGED'] = 'No fue posible cambiar el PIN de la tarjeta %s, por favor vuelve a intentarlo';
$lang['CUST_REPLACEMENT_COST'] = 'La reposición tendra un costo de %s %s';
$lang['CUST_REPLACEMENT_NOT_PROCCESS'] = 'No fue posible realizar el cobro de la reposición';
$lang['CUST_LIMIT_REPLACEMENTS'] = 'Has alcanzado el limite de reposiciones.';
$lang['CUST_NOT_LOCKED'] = 'No fue posible realizar el bloqueo %s, intenta de nuevo.';
$lang['CUST_INVALID_EXPIRATION_DATE'] = 'No fue posible obtener la fecha de vencimiento de la tarjeta %s, por favor vuelve a intentarlo';
$lang['CUST_NOT_PROCCESS'] = 'Tu solicitud no pudo ser procesada, por favor vuelve a intentarlo';
$lang['CUST_INSUFFICIENT_FUNDS'] = 'Cliente no tiene fondos.';
$lang['CUST_PIN_MANAGEMENT'] = 'Gestión de PIN';
$lang['CUST_REASON_REQUEST'] = 'Motivo de la solicitud';
$lang['CUST_SELECTION_OPERATION'] = 'Seleccione los la operación que desea realizar:';
$lang['CUST_PIN_CHANGE'] = 'Cambiar PIN';
$lang['CUST_OPERATIONS'] = 'Operación:';
$lang['CUST_ACTION_TAKE'] = 'Si realmente deseas <span class="status-text2 lowercase">%s</span> tu tarjeta, presiona continuar.';
$lang['CUST_TEMPORARY_LOCK'] = 'Bloqueo temporal';
$lang['CUST_UNLOCK_CARD'] = 'Desbloquear tarjeta';
$lang['CUST_UNLOCK'] = 'Desbloquear';
$lang['CUST_TEMPORARILY_LOCK'] = 'Bloquear temporalmente';
$lang['CUST_RETRIEVE_PIN'] = 'Recuperar PIN';
$lang['CUST_GENERATE_PIN'] = 'Generar PIN';
$lang['CUST_REQUEST_PIN'] = 'Solicitud de PIN';
$lang['CUST_CURRENT_PIN'] = 'PIN actual';
$lang['CUST_NEW_PIN'] = 'Nuevo PIN';
$lang['CUST_CONFIRM_PIN'] = 'Confirmar PIN';
$lang['CUST_REQUEST_PIN_INFO'] = '<p>Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en Conexión Empresas Online, para poder emitir el nuevo PIN.</p><p>Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en un máximo de 5 días hábiles en un sobre de seguridad a la dirección de tu empresa.</p>';
$lang['CUST_TRAVEL_AGENCY'] = 'Agencia de viajes';
$lang['CUST_INSURERS'] = 'Aseguradoras';
$lang['CUST_CHARITY'] = 'Beneficencia';
$lang['CUST_ENTERTAINMENT'] = 'Entretenimiento';
$lang['CUST_PARKING'] = 'Estacionamientos';
$lang['CUST_GASTATIONS'] = 'Gasolineras';
$lang['CUST_GOVERNMENTS'] = 'Gobiernos';
$lang['CUST_HOSPITALS'] = 'Hospitales';
$lang['CUST_HOTELS'] = 'Hoteles';
$lang['CUST_DEBIT'] = 'Peaje';
$lang['CUST_TOLL'] = 'Renta de autos';
$lang['CUST_RESTAURANTS'] = 'Restaurantes';
$lang['CUST_SUPERMARKETS'] = 'Supermercados';
$lang['CUST_TELECOMMUNICATION'] = 'Telecomunicaciones';
$lang['CUST_AIR_TRANSPORT'] = 'Transporte aéreo';
$lang['CUST_COLLEGES_UNIVERSITIES'] = 'Colegios y universidades';
$lang['CUST_RETAIL_SALES'] = 'Ventas al detalle (retail)';
$lang['CUST_PASSENGER_TRANSPORTATION'] = 'Transporte terrestre de pasajeros';
$lang['CUST_WITH_CARD_PRESENT'] = 'Con tarjeta presente';
$lang['CUST_NO_CARD_PRESENT'] = 'Sin tarjeta presente';
$lang['CUST_NUM_DAY_PURCHASES'] = 'Número de compras diarias';
$lang['CUST_NUM_WKLY_PURCHASES'] = 'Número de compras semanales';
$lang['CUST_NUM_MON_PURCHASES'] = 'Número de compras mensuales';
$lang['CUST_DAY_PURCHASE_AMOUNT'] = 'Monto diario de compras';
$lang['CUST_WKLY_PURCHASE_AMOUNT'] = 'Monto semanal de compras';
$lang['CUST_MON_PURCHASE_AMOUNT'] = 'Monto mensual de compras';
$lang['CUST_SHOPPING_TXN_AMOUNT'] = 'Monto por transacción de compras';
$lang['CUST_WITHDRAWAL'] = 'Retiros';
$lang['CUST_DAY_NUM_WITHDRAWAL'] = 'Número diario de retiros';
$lang['CUST_WKLY_NUM_WITHDRAWAL'] = 'Número semanal de retiros';
$lang['CUST_MON_NUM_WITHDRAWAL'] = 'Número mensual de retiros';
$lang['CUST_DAY_AMOUNT_WITHDRAWAL'] = 'Monto diario de retiros';
$lang['CUST_WKLY_AMOUNT_WITHDRAWAL'] = 'Monto semanal de retiros';
$lang['CUST_MON_AMOUNT_WITHDRAWAL'] = 'Monto mensual de retiros';
$lang['CUST_AMOUNT_WITHDRAWAL_TXN'] = 'Monto por transacción de retiros';
$lang['CUST_CREDIT'] = 'Abonos';
$lang['CUST_DAY_NUM_CREDIT'] = 'Número diario de abonos';
$lang['CUST_WKLY_NUM_CREDIT'] = 'Número semanal de abonos';
$lang['CUST_MON_NUM_CREDIT'] = 'Número mensual de abonos';
$lang['CUST_DAY_AMOUNT_CREDIT'] = 'Monto diario de abonos';
$lang['CUST_WKLY_AMOUNT_CREDIT'] = 'Monto semanal de abonos';
$lang['CUST_MON_AMOUNT_CREDIT'] = 'Monto mensual de abonos';
$lang['CUST_AMOUNT_CREDIT_TXN'] = 'Monto por transacción de abonos';
$lang['CUST_NOTE'] = 'Nota';
$lang['CUST_CHECK_COLOR'] = 'Si el check se encuentra en color';
$lang['CUST_PURCHASES_RESTRICTED'] = 'las compras en este tipo de comercio están restringidas.';
$lang['CUST_CONFIG_PRODUCT_LIMIT'] = 'Si el campo es igual a 0, se tomara como limite el valor configurado para el producto.';
$lang['CUST_UNLOCK_MESSAGE'] = 'No fue posible realizar el desbloqueo, intenta de nuevo.';
$lang['CUST_PERMANENT'] = 'permanente';
$lang['CUST_TEMPORARY'] = 'temporal';
