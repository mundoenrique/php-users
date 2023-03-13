<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'coop';
$config['customer_uri'] = 'coop';
$config['customer_lang'] = $config['customer_uri'];
$config['customer_style'] = $config['customer_uri'];
$config['customer_images'] = $config['customer_uri'];
$config['base_url']	= BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language']	= BASE_LANGUAGE . '-' . $config['customer_lang'];
