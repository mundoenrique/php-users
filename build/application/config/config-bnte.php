<?php
defined('BASEPATH') or exit('No direct script access allowed');
$config['customer'] = 'Mx-Bn';
$config['customer_uri'] = 'bnte';
$config['customer_lang'] = 'bnt';
$config['customer_style'] = $config['customer_lang'];
$config['customer_files'] = $config['customer_lang'];
$config['base_url']  = BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language']  = BASE_LANGUAGE . '-' . $config['customer_lang'];
