<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['CONF_MAINTENANCE'] = 'OFF';
$lang['CONF_ACTIVE_RECAPTCHA'] = ACTIVE_RECAPTCHA;
$lang['CONF_KEY_RECAPTCHA'] = '6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-';
$lang['CONF_CYPHER_DATA'] = ACTIVE_SAFETY ?? 'ON';
$lang['CONF_DUPLICATE_SESSION'] = ACTIVE_SAFETY ?? 'ON';
$lang['CONF_ARGON2_ACTIVE'] = 'OFF';
$lang['CONF_CURRENCY'] = '$';
$lang['CONF_DECIMAL'] = '.';
$lang['CONF_THOUSANDS'] = ',';
$lang['CONF_VALIDATE_CAPTCHA'] = [
	'signin',
	'accessRecover',
	'userIdentify'
];
//SUPPORT IE 11
$lang['CONF_SUPPORT_IE'] = 'OFF';
//SCORE RECAPTCHA
$lang['CONF_SCORE_CAPTCHA'] = [
	'development' => 0,
	'testing' => 0.2,
	'production' => 0.5
];
//VALIDATE FORMS
$lang['CONF_VALID_ERROR'] = 'has-error';
$lang['CONF_VALID_VALID'] = 'has-success';
$lang['CONF_VALID_SUCCESS'] = ' ';
$lang['CONF_VALID_IGNORE'] = '.ignore';
$lang['CONF_VALID_ELEMENT'] = 'div';
$lang['CONF_VALID_INVALID_USER'] = 'invalid-user';
$lang['CONF_VALID_INACTIVE_USER'] = 'inactive-user';
$lang['CONF_VALID_POSITION'] = 'left';
//VALIDATE IP
$lang['CONF_VALIDATE_IP'] = 'ON';
//MODAL STYLES
$lang['CONF_MODAL_WIDTH'] = 370;
//ICONS MODALS
$lang['CONF_ICON'] = 'mt-0 ui-icon';
$lang['CONF_ICON_SUCCESS'] = 'ui-icon-circle-check';
$lang['CONF_ICON_INFO'] = 'ui-icon-info';
$lang['CONF_ICON_WARNING'] = 'ui-icon-alert';
$lang['CONF_ICON_DANGER'] = 'ui-icon-closethick';
//CARD STYLES
$lang['CONF_CARD_COLOR'] = 'white';
$lang['CONF_RESTAR_USERNAME'] = 'OFF';
$lang['CONF_BUSINESS_NAME'] = 'ON';
$lang['CONF_HEADER_BORDER'] = 'OFF';
//MENU
$lang['CONIFG_SIGIN'] = 'ON';
$lang['CONF_CARD_LIST'] = 'ON';
$lang['CONF_CARD_DETAIL'] = 'ON';
$lang['CONF_PAYS_TRANSFER'] = 'OFF';
$lang['CONF_BETWEEN_CARDS'] = 'ON';
$lang['CONF_BANKS'] = 'ON';
$lang['CONF_CREDIT_CARDS'] = 'ON';
$lang['CONF_SERVICES'] = 'ON';
$lang['CONF_TELEPHONY'] = 'ON';
$lang['CONF_CUSTOMER_SUPPORT'] = 'ON';
$lang['CONF_REPORTS'] = 'ON';
$lang['CONF_PORFILE'] = 'ON';
$lang['CONF_NOTIFICATIONS'] = 'OFF';
$lang['CONF_PROFILE'] = 'ON';
//SIGNIN
$lang['CONF_SIGNIN_IMG'] = 'OFF';
$lang['CONF_SIGNIN_WIDGET_CONTACT'] = 'ON';
$lang['CONIFG_SIGIN_RECOVER_PASS'] = 'ON';
$lang['CONF_WIDGET_REST_COUNTRY'] = 'OFF';
$lang['CONF_LONG_TEXT'] = '';
//SIGNUP
$lang['CONF_SECRET_KEY'] = 'ON';
$lang['CONF_CHANGE_VIRTUAL'] = 'OFF';
$lang['CONF_TIMER_MODAL_VIRTUAL'] = 60;
$lang['CONF_COUNTRY_CODE'] = [
	'Pe' => 1,
	'Usd' => 1,
	'Ve' => 3,
	'Ec-bp' => 3,
	'Ec-pb' => 3,
	'Ec-bg' => 3,
	'Co' => 4,
	'Mx-Bn' => 15,
];
$lang['CONF_COUNTRY_DOCUMENT'] = [
	'Pe' => '1',
	'Usd' => '1',
	'Ve' => '3',
	'Ec-bp' => '3',
	'Ec-pb' => '3',
	'Ec-bg' => '3',
	'Co' => '4',
	'Mx-Bn' => '16',
];
//SIGNUP-PROFILE
$lang['CONF_UPDATE_USER'] = 'ON';
$lang['CONF_UPDATE_NAME'] = 'ON';
$lang['CONF_UPDATE_SECOND_NAME'] = 'ON';
$lang['CONF_UPDATE_PHONE_MOBILE'] = 'ON';
$lang['CONF_UPDATE_EMAIL'] = 'ON';
$lang['CONF_LANDLINE'] = 'ON';
$lang['CONF_OTHER_PHONE'] = 'ON';
$lang['CONF_PROFESSION'] = 'ON';
$lang['CONF_CONTAC_DATA'] = 'ON';
$lang['CONF_CHECK_NOTI_EMAIL'] = 'ON';
$lang['CONF_CHECK_NOTI_SMS'] = 'ON';
$lang['CONF_OPER_KEY'] = 'OFF';
$lang['CONF_SMS_KEY'] = 'OFF';
$lang['CONF_LOAD_DOCS'] = 'OFF';
$lang['CONF_LOAD_SELFIE'] = 'OFF';
$lang['CONF_LOAD_DOC_F_ID'] = 'OFF';
$lang['CONF_LOAD_DOC_B_ID'] = 'OFF';
$lang['CONF_LOAD_DOC_F_PASS'] = 'OFF';
$lang['CONF_LOAD_DOC_B_PASS'] = 'OFF';
$lang['CONF_ACCEPT_MASKED_MOBILE'] = 'OFF';
$lang['CONF_ACCEPT_MASKED_LANDLINE'] = 'OFF';
//RECOVER ACCESS
$lang['CONF_RECOVER_ID_TYPE'] = 'OFF';
$lang['CONF_RECOVER_SHOW_OPTIONS'] = 'ON';
//CARDS DETAIL
$lang['CONF_IN_TRANSIT'] = 'OFF';
$lang['CONF_SEND_MOVEMENTS'] = 'OFF';
$lang['CONF_TYPE_TRANSACTION'] = 'OFF';
$lang['CONF_PICKER_MINDATE'] = '-48m';
//FOOTER
$lang['CONF_FOOTER_NETWORKS'] = 'OFF';
$lang['CONF_FOOTER_LOGO'] = 'ON';
// API
$lang['CONF_FILTER_ATTRIBUTES_LOG'] = ['password'];
$lang['CONF_CONFIG_UPLOAD_FILE'] = [
	'allowed_types' => 'jpeg|png|jpg',
	'detect_mime' => TRUE,
	'min_size' => 10,
	'max_size' => 1024,
	'encrypt_name' => FALSE,
	'overwrite'=> TRUE,
	'file_ext_tolower'=> TRUE,
];
// CUSTOMER SUPPORT
$lang['CONF_TEMPORARY_LOCK_REASON'] = 'OFF';
//EXTERNAL LINKS
$lang['GEN_NO_LINK'] = 'javascript:';
$lang['CONF_LINK_SIGNIN'] = 'sign-in';
$lang['CONF_LINK_SIGNUP'] = 'sign-up';
$lang['CONF_LINK_SIGNOUT'] = 'sign-out/';
$lang['CONF_LINK_SIGNOUT_START'] = 'start';
$lang['CONF_LINK_SIGNOUT_END'] = 'end';
$lang['CONF_LINK_RECOVER_ACCESS'] = 'recover-access';
$lang['CONF_LINK_USER_IDENTIFY'] = 'user-identify';
$lang['CONF_LINK_CHANGE_PASS'] = 'change-password';
$lang['CONF_LINK_USER_PROFILE'] = 'user-profile';
$lang['CONF_LINK_CARD_LIST'] = 'card-list';
$lang['CONF_LINK_CARD_DETAIL'] = 'card-detail';
$lang['GEN_LINK_PAYS_TRANSFER'] = $lang['GEN_NO_LINK'];
$lang['GEN_LINK_BETWEEN_CARDS'] = $lang['GEN_NO_LINK'];
$lang['GEN_LINK_BANKS'] = $lang['GEN_NO_LINK'];
$lang['GEN_LINK_CREDIT_CARDS'] = $lang['GEN_NO_LINK'];
$lang['GEN_LINK_SERVICES'] = $lang['GEN_NO_LINK'];
$lang['GEN_LINK_TELEPHONY'] = $lang['GEN_NO_LINK'];
$lang['CONF_LINK_REPORTS'] = 'reports';
$lang['CONF_LINK_CUSTOMER_SUPPORT'] = 'customer-support';
$lang['CONF_LINK_NOTIFICATIONS'] = 'notifications';
$lang['GEN_FOTTER_NETWORKS_LINK'] = [
	'facebook' => $lang['GEN_NO_LINK'],
	'twitter' => $lang['GEN_NO_LINK'],
	'youtube' => $lang['GEN_NO_LINK'],
	'instagram' => $lang['GEN_NO_LINK'],
];
//INTERNAL LINKS
$lang['CONF_LINK_SERVICE_RECOVER_ACCESS'] = 'AccessRecover';
//LANGUAGE
$lang['CONF_BTN_LANG'] = 'OFF';
//REGEX
$lang['CONF_REGEX_ONLY_NUMBER'] = '^[0-9]{2,20}$';
$lang['CONF_REGEX_ONLY_ONE_NUMBER'] = '^[0-9]{1}$';
$lang['CONF_REGEX_ONLY_ONE_LETTER'] = '^[SCV]{1}$';
$lang['CONF_REGEX_NAMES_VALID'] = '^([a-zñáéíóú.]+[\s]*)+$';
$lang['CONF_REGEX_NICKNAME'] = '^[a-z0-9_]{6,16}$';
$lang['CONF_REGEX_NICKNAME_PROFILE'] = '^[a-z0-9 .,+-_@*]{6,16}$';
$lang['CONF_REGEX_SHORT_PHRASE'] = '^[a-z0-9ñáéíóú ().]{4,25}$';
$lang['CONF_REGEX_LONG_PHRASE'] = '^[a-z0-9ñáéíóú ().,:;-]{5,150}$';
$lang['CONF_REGEX_ALPHA_NAME'] = '^[a-zñáéíóú ]{1,50}$';
$lang['CONF_REGEX_ALPHA_LETTER'] = '^[a-zñáéíóú]{4,20}$';
$lang['CONF_REGEX_EMAIL_VALID'] = '^([\.0-9a-zA-Z_\-])+\@(([\.0-9a-zA-Z\-])+\.)+([a-zA-Z0-9]{2,4})+$';
$lang['CONF_REGEX_ALPHANUM_UNDER'] = '^([\w.\-+&ñÑ .,_\@\* ]+)+$';
$lang['CONF_REGEX_ALPHANUM'] = '^[a-z0-9]+$';
$lang['CONF_REGEX_NUMERIC'] = '^[0-9]+$';
$lang['CONF_REGEX_PHONE'] = '^[0-9]{7,15}$';
$lang['CONF_REGEX_PHONE_MASKED'] = '^[0-9*]{7,15}$';
$lang['CONF_REGEX_FLOAT_AMOUNT'] = '^[0-9]+(\.[0-9]{2})?$';
$lang['CONF_REGEX_DATE_DMY'] = '^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/[0-9]{4}$';
$lang['CONF_REGEX_DATE_MY'] = '^(0?[1-9]|1[012])\/[0-9]{4}$';
$lang['CONF_REGEX_DATE_Y'] = '^[0-9]{4}$';
$lang['CONF_REGEX_TRANS_TYPE'] = '^([-|+])$';
