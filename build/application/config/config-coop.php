<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'coop';
$config['customer-uri'] = $config['customer'];
$config['customer_style'] = $config['customer-uri'];
$config['customer_lang'] = $config['customer'];
$config['customer_program'] = $config['customer'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer_lang'];
