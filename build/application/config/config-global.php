<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['session_time'] = SESS_EXPIRATION * 1000;
$config['session_call_server'] = $config['session_time'] < 30000 ? ceil($config['session_time'] * 50 / 100) : 15000;
$config['channel'] = 'personasWeb';
$config['format_date'] = 'j/m/Y';
$config['format_time'] = 'g:i A';
$config['scores_recapcha'] = [
	'development' => [
		'score' => 0
	],
	'testing' => [
		'score' => 0
	],
	'production' => [
		'score' => 0
	],
];
