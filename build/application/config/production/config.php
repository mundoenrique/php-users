<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = 'https://personas.novopayment.com';
$config['base_url_cdn'] = 'https://personas.novopayment.com/assets/';
$config['base_path_cdn'] = '/var/www/html/assets/';
$config['keyNovo'] = '12345678';
$config['urlWS'] = 'http://172.24.6.101:8005/NovoInterfaceMovilesWS/webresources/';
$config['log_threshold'] = 4;
$config['encryption_key'] = 'n0v0p4ym3nt';
$config['cookie_domain']	= 'personas.novopayment.com';
$config['cookie_secure']	= TRUE;
$config['proxy_ips'] = array(
	'172.17.0.2',
	'192.168.65.0/24'
);
