<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['customer'] = 'Usd';
$config['customer_uri'] = 'usd';
$config['customer_lang'] = 'pe';
$config['customer_files'] = 'us';
$config['base_url'] = BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language'] = BASE_LANGUAGE . '-' . $config['customer_lang'];
