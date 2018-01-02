<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = 'http://personas.novopayment.test';
$config['base_url_cdn'] = 'http://personas.novopayment.test/assets/';
$config['base_path_cdn'] = '/var/www/html/assets/';
$config['keyNovo'] = '12345678';
$config['urlWS'] = 'http://172.24.6.102:8005/NovoInterfaceMovilesWS/webresources/';
$config['log_threshold'] = 4;
$config['encryption_key'] = 'n0v0p4ym3nt-t3st';
$config['cookie_domain']	= 'personas.novopayment.test';
$config['cookie_secure']	= FALSE;
$config['proxy_ips'] = array(
	'172.17.0.2',
	'192.168.65.0/24'
);
