<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Ve';
$config['customer_uri'] = 've';
$config['customer_lang'] = $config['customer_uri'];
$config['customer_images'] = $config['customer_uri'];
$config['base_url']	= BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language']	= BASE_LANGUAGE . '-' . $config['customer_lang'];
