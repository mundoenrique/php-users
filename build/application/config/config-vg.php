<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Usd';
$config['customer-uri'] = 'vg';
$config['customer_style'] = $config['customer-uri'];
$config['customer_program'] = $config['customer-uri'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer-uri'];
$config['channel'] = 'voygoPersonal';
