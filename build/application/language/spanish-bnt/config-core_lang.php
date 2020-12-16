<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//SCORE RECAPTCHA
$lang['CONF_SCORE_CAPTCHA'] = [
	'development' => 0,
	'testing' => 0,
	'production' => 0
];
//VALIDATE FORMS
$lang['CONF_VALID_POSITION'] = 'right';
//VALIDATE IP
$lang['CONF_VALIDATE_IP'] = 'OFF';
//CARD STYLES
$lang['CONF_CARD_COLOR'] = 'text';
//SIGNIN
$lang['CONF_SIGNIN_IMG'] = 'ON';
$lang['CONF_WIDGET_CONTACT_INFO'] = 'ON';
$lang['CONF_WIDGET_REST_COUNTRY'] = 'ON';
//FOOTER
$lang['CONF_FOOTER_NETWORKS'] = 'ON';
$lang['CONF_FOOTER_LOGO'] = 'OFF';
//USER IDENTITY
$lang['CONF_SECRET_KEY'] = 'OFF';
//SIGNUP-PROFILE
$lang['CONF_UPDATE_NAME'] = 'OFF';
$lang['CONF_LANDLINE'] = 'OFF';
$lang['CONF_OTHER_PHONE'] = 'OFF';
$lang['CONF_PROFESSION'] = 'OFF';
$lang['CONF_CONTAC_DATA'] = 'OFF';
$lang['CONF_CHECK_NOTI_EMAIL'] = 'OFF';
$lang['CONF_CHECK_NOTI_SMS'] = 'OFF';
$lang['CONF_LOAD_DOCS'] = 'ON';
$lang['CONF_LOAD_DOC_F_ID'] = 'ON';
$lang['CONF_LOAD_DOC_B_ID'] = 'ON';
// UPLOAD FILES
$lang['CONF_CONFIG_UPLOAD_FILE'] = [
	'allowed_types' => 'jpeg|png|jpg',
	'detect_mime' => true,
	'min_size' => 10, // 10KB
	'max_size' => 6291456, //6291456 Kbytes son 6mb (6291456Kb/1048576=6MB)
	'encrypt_name' => FALSE,
	'overwrite'=> TRUE,
];
