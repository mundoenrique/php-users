<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Ec-pb';
$config['customer-uri'] = 'pb';
$config['customer_style'] = $config['customer-uri'];
$config['customer_lang'] = $config['customer-uri'];
$config['customer_program'] = $config['customer-uri'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer_lang'];
