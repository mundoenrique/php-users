<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['customer'] = 'Pe';
$config['customer_uri'] = 'pe';
$config['customer_lang'] = $config['customer_uri'];
$config['customer_files'] = $config['customer_uri'];
$config['base_url'] = BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language'] = BASE_LANGUAGE . '-' . $config['customer_lang'];
