<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Ec-bg';
$config['customer-uri'] = 'bg';
$config['customer_lang'] = $config['customer-uri'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer_lang'];
