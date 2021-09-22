<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['CUST_CHANGE_PIN_TITLE'] = 'Change PIN';
$lang['CUST_REPLACE_REQUEST'] = 'Replacement %s request';
$lang['CUST_INACTIVE_PRODUCT'] = 'Your card is inactive';
$lang['CUST_PERMANENT_LOCK'] = 'Your card has a pending replacement';
$lang['CUST_TWIRLS_COMMERCIAL'] = 'Business lines';
$lang['CUST_TRANS_LIMITS'] = 'Transactional limits';
$lang['CUST_CARD_NUMBER'] = 'Card number';
$lang['CUST_NAME']='Name';
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
$lang['CUST_UPDATE_CURRENT'] = 'Update date:';
$lang['CUST_NON_RESULTS'] = 'Your card records could not be found, please try again; If you continue to see this message, contact your company representative.';
$lang['CUST_CARD_TEMPORARY_LOCK'] = 'The card has a temporary lock, to perform this query you must unlock it.';
$lang['CUST_CARD_CANCELED'] = 'The card is canceled, you cannot make this query.';
$lang['CUST_CARD_UNAVAILABLE'] = 'The card is not available for this query.';
$lang['CUST_REPLACE_REASON'] = [
	'41' => 'Lost card',
	'43' => 'Stolen card',
	'TD' => 'Damaged card',
	'TR' => 'Replace card',
];
$lang['CUST_TEMPORARY_LOCK_REASON'] = [
	'Lost card',
	'Preventive blocking',
];
$lang['CUST_REPLACE_MSG'] = 'A new card has been generated, you can see it in the consolidated list.';
$lang['CUST_STOLEN_CARD'] = '43';
$lang['CUST_REPLACE_CARD'] = 'If you really want to replace your card, press continue to assign a new one.';
$lang['CUST_SUCCESS_CHANGE_PIN'] = 'The PIN of the card %s has been changed successfully.';
$lang['CUST_SUCCESS_OPERATION_RESPONSE'] = 'The card %s, has been %s.';
$lang['CUST_SPECIFIC_INACTIVE_PRODUCT'] = 'The card %s is inactive.';
$lang['CUST_SPECIFIC_PERMANENT_LOCK'] = 'The card %s has a pending replacement.';
$lang['CUST_SPECIFIC_REVEWAL_LOCK'] = 'The card %s has a pending renewal.';
$lang['CUST_EXPIRED_CARD'] = 'It is not possible to perform this action the card %s is expired.';
$lang['CUST_LOCK_CARD'] = 'The card %s is locked.';
$lang['CUST_PIN_NOT_VALID'] = 'The current PIN is invalid, please check and try again.';
$lang['CUST_DATA_INVALIDATED'] = 'The fields entered are invalid, please check and try again.';
$lang['CUST_FAILED_ATTEMPTS'] = 'You have exceeded the number of failed attempts for today, please try tomorrow.';
$lang['CUST_PIN_NOT_CHANGED'] = 'It was not possible to change the PIN of the card %s, please try again.';
$lang['CUST_REPLACEMENT_COST'] = 'Replacement will cost %s %s';
$lang['CUST_REPLACEMENT_NOT_PROCCESS'] = 'It was not possible to charge the replacement.';
$lang['CUST_LIMIT_REPLACEMENTS'] = 'You have reached the replenishment limit.';
$lang['CUST_NOT_LOCKED'] = 'Unable to %s lock, please try again.';
$lang['CUST_INVALID_EXPIRATION_DATE'] = 'It was not possible to get the expiration date of the card %s, please try again.';
$lang['CUST_NOT_PROCCESS'] = 'Your request could not be processed, please try again.';
$lang['CUST_INSUFFICIENT_FUNDS'] = 'Client has no funds.';
$lang['CUST_PIN_MANAGEMENT'] = 'PIN management.';
$lang['CUST_REASON_REQUEST'] = 'Reason for the request.';
$lang['CUST_SELECTION_OPERATION'] = 'Select the operation you want to perform:';
$lang['CUST_PIN_CHANGE'] = 'Change PIN';
$lang['CUST_OPERATIONS'] = 'Operation:';
$lang['CUST_ACTION_TAKE'] = 'If you really want to <span class="status-text2 lowercase">%s</span> your card, press continue.';
$lang['CUST_TEMPORARY_LOCK'] = 'Temporary lock';
$lang['CUST_UNLOCK_CARD'] = 'Unlock card';
$lang['CUST_UNLOCK'] = 'Unlock';
$lang['CUST_TEMPORARILY_LOCK'] = 'Temporarily block';
$lang['CUST_RETRIEVE_PIN'] = 'Retrieve PIN';
$lang['CUST_GENERATE_PIN'] = 'Generate PIN';
$lang['CUST_REQUEST_PIN'] = 'PIN request';
$lang['CUST_CURRENT_PIN'] = 'Current PIN';
$lang['CUST_NEW_PIN'] = 'New PIN';
$lang['CUST_CONFIRM_PIN'] = 'Confirm PIN';
$lang['CUST_REQUEST_PIN_INFO'] = '<p> This request generates a replacement Lot that your company must authorize in Online Business Connection, in order to issue the new PIN. </p> <p> If you really want to request the replacement of your PIN, press continue. The PIN will be sent in a maximum of 5 business days in a security envelope to the address of your company. </p>';
$lang['CUST_TRAVEL_AGENCY'] = 'Travel agency.';
$lang['CUST_INSURERS'] = 'Insurers';
$lang['CUST_CHARITY'] = 'Charity';
$lang['CUST_ENTERTAINMENT'] = 'Entertainment';
$lang['CUST_PARKING'] = 'Parking lots';
$lang['CUST_GASTATIONS'] = 'Gas stations';
$lang['CUST_GOVERNMENTS'] = 'Governments';
$lang['CUST_HOSPITALS'] = 'Hospitals';
$lang['CUST_HOTELS'] = 'Hotels';
$lang['CUST_DEBIT'] = 'Toll';
$lang['CUST_TOLL'] = 'Car rental';
$lang['CUST_RESTAURANTS'] = 'Restaurants';
$lang['CUST_SUPERMARKETS'] = 'Supermarkets';
$lang['CUST_TELECOMMUNICATION'] = 'Telecomumunication';
$lang['CUST_AIR_TRANSPORT'] = 'Air transport';
$lang['CUST_COLLEGES_UNIVERSITIES'] = 'Colleges and universities';
$lang['CUST_RETAIL_SALES'] = 'Retail sales';
$lang['CUST_PASSENGER_TRANSPORTATION'] = 'Passenger land transportation';
$lang['CUST_WITH_CARD_PRESENT'] = 'With card present';
$lang['CUST_NO_CARD_PRESENT'] = 'Without card present';
$lang['CUST_NUM_DAY_PURCHASES'] = 'Number of daily purchases';
$lang['CUST_NUM_WKLY_PURCHASES'] = 'Number of weekly purchases';
$lang['CUST_NUM_MON_PURCHASES'] = 'Number of monthly purchases';
$lang['CUST_DAY_PURCHASE_AMOUNT'] = 'Daily amount of purchases';
$lang['CUST_WKLY_PURCHASE_AMOUNT'] = 'Weekly purchase amount';
$lang['CUST_MON_PURCHASE_AMOUNT'] = 'Monthly amount of purchases';
$lang['CUST_SHOPPING_TXN_AMOUNT'] = 'Amount per purchase transaction';
$lang['CUST_WITHDRAWAL'] = 'Withdrawal';
$lang['CUST_DAY_NUM_WITHDRAWAL'] = 'Daily number of withdrawals';
$lang['CUST_WKLY_NUM_WITHDRAWAL'] = 'Weekly number of withdrawals';
$lang['CUST_MON_NUM_WITHDRAWAL'] = 'Monthly number of withdrawals';
$lang['CUST_DAY_AMOUNT_WITHDRAWAL'] = 'Daily amount of withdrawals';
$lang['CUST_WKLY_AMOUNT_WITHDRAWAL'] = 'Weekly amount of withdrawals';
$lang['CUST_MON_AMOUNT_WITHDRAWAL'] = 'Monthly amount of withdrawals ';
$lang['CUST_AMOUNT_WITHDRAWAL_TXN'] = 'Amount per withdrawal transaction';
$lang['CUST_CREDIT'] = 'Deposit';
$lang['CUST_DAY_NUM_CREDIT'] = 'Daily number of deposits';
$lang['CUST_WKLY_NUM_CREDIT'] = 'Weekly number of deposits';
$lang['CUST_MON_NUM_CREDIT'] = 'Monthly number of deposits';
$lang['CUST_DAY_AMOUNT_CREDIT'] = 'Daily deposit amount';
$lang['CUST_WKLY_AMOUNT_CREDIT'] = 'Weekly deposit amount';
$lang['CUST_MON_AMOUNT_CREDIT'] = 'Monthly deposit amount';
$lang['CUST_AMOUNT_CREDIT_TXN'] = 'Amount per deposit transaction';
$lang['CUST_NOTE'] = 'Note';
$lang['CUST_CHECK_COLOR'] = 'If the check is in color';
$lang['CUST_PURCHASES_RESTRICTED'] = 'Purchases in this type of business are restricted.';
$lang['CUST_CONFIG_PRODUCT_LIMIT'] = 'If the field is equal to 0, the value configured for the product will be taken as the limit.';
$lang['CUST_UNLOCK_MESSAGE'] = 'Unlocking was not possible, please try again. ';
$lang['CUST_PERMANENT'] = 'permanent';
$lang['CUST_TEMPORARY'] = 'temporary';
$lang['CUST_LOCKED'] = 'Locked';
$lang['CUST_UNLOCKED'] = 'Unlocked';
$lang['CUST_LOCK'] = 'Lock';
$lang['CUST_UNLOCK'] = 'Unlock';
$lang['CUST_LOCK_PERMANENT'] = 'locked permanently.';
$lang['CUST_LOGIN'] = 'Login';
$lang['CUST_PASS_CHANGE'] = 'Password change';
$lang['CUST_PIN_CHANGE'] = 'PIN change';
$lang['CUST_CARD_REPLACE'] = 'Card replacement';
$lang['CUST_TEMP_LOCK'] = 'Temporary lock';
$lang['CUST_TEMP_UNLOCK'] = 'Card unlocking';
$lang['CUST_NOTIFY_OPTIONS'] = [
	'11' => $lang['CUST_LOGIN'],
	'12' => $lang['CUST_PASS_CHANGE'],
	'13' => $lang['CUST_PIN_CHANGE'],
	'14' => $lang['CUST_CARD_REPLACE'],
	'15' => $lang['CUST_TEMP_LOCK'],
	'16' => $lang['CUST_TEMP_UNLOCK'],
];
