<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['customer'] = 'Usd';
$config['customer_uri'] = 'vg';
$config['customer_lang'] = $config['customer_uri'];
$config['customer_style'] = $config['customer_uri'];
$config['customer_files'] = $config['customer_uri'];
$config['base_url'] = BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language'] = BASE_LANGUAGE . '-' . $config['customer_lang'];
$config['channel'] = 'voygoPersonal';
