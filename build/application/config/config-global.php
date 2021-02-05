<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['session_time'] = SESS_EXPIRATION * 1000;
$config['client'] = 'novo';
$config['channel'] = 'personasWeb';
$config['format_date'] = 'j/m/Y';
$config['format_time'] = 'g:i A';
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
