<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Ec-pb';
$config['customer-uri'] = 'pb';
$config['client_style'] = $config['customer-uri'];
$config['base_url']	= BASE_URL.'/'.$config['customer-uri'].'/';
$config['language']	= BASE_LANGUAGE.'-'.$config['customer-uri'];
