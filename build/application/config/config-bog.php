<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['customer'] = 'Bdb';
$config['customer_uri'] = 'bog';
$config['customer_lang'] = 'bdb'; //$config['customer_uri'];
$config['customer_style'] = 'bdb'; //$config['customer_uri'];
$config['customer_images'] = 'bdb'; //$config['customer_uri'];
$config['base_url']	= BASE_URL . '/' . $config['customer_uri'] . '/';
$config['language']	= BASE_LANGUAGE . '-' . $config['customer_lang'];
