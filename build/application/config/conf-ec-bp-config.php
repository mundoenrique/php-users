<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['base_url'] = BASE_URL;
$config['asset_url'] = ASSET_URL;
$config['asset_path'] = ASSET_PATH;
$config['country'] = 'Ec-bp';
$config['language'] = 'ec-bp-spanish';
$config['sess_expiration'] = 0;
$config['scores_recapcha'] = [
  'development' => [
    'score' => 0
  ],
  'testing' => [
    'score' => 0
  ],
  'production' => [
    'score' => 0
  ],
];
