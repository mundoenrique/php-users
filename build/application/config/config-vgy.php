<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Usd';
$config['customer_uri'] = 'vgy';
$config['customer_lang'] ='vg';
$config['customer_style'] = $config['customer_lang'];
$config['customer_files'] = $config['customer_lang'];
$config['base_url']	= BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language']	= BASE_LANGUAGE . '-' . $config['customer_lang'];
$config['channel'] = 'voygoPersonal';
