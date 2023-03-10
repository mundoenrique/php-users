<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Ec-bg';
$config['customer-uri'] = 'bg';
$config['customer_program'] = $config['customer_uri'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer-uri'];
