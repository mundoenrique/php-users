<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['urlWS'] = WS_URL;
$config['keyNovo'] = WS_KEY;
$config['active_recaptcha'] = ACTIVE_RECAPTCHA;
$config['client'] = 'novo';
$config['channel'] = 'personasWeb';
$config['keyAES256'] = KEY_AES256;
$config['ivAES256'] = IV_AES256;
$config['session_time'] = SESS_EXPIRATION * 1000;
//url API
$config['urlAPI'] = URL_API;
//Credenciales oauth
$config['clientId'] = CLIENT_ID;
$config['clientSecret'] = CLIENT_SECRET;
$config['format_date'] = 'j/m/Y';
$config['format_time'] = 'g:i A';
$config['oauth_url'] = OAUTH_URL;
$config['scores_recapcha'] = [
	'development' => [
		'score' => 0
	],
	'testing' => [
		'score' => 0.3
	],
	'production' => [
		'score' => 0.4
	],
];
