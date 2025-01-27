<?php
defined('BASEPATH') or exit('No direct script access allowed');

//País
$config['country'] = 'bdb';
$config['country_uri'] = 'bdbo';
$config['language'] = 'core-bdb';
$config['base_url']  = BASE_URL . '/' . 'bdbo/';
$config['language_file_specific'] = [];
$config['language_form_validate'] = FALSE;
$config['client'] = 'banco-bog';
$config['layout'] = 'designFullPage';
$config['setTimerOTP'] = 5 * 60;
$config['timeIdleSession'] = 6 * 60000;
$config['listReasonReposition'] = [
  ['value' => '43', 'tagTranslation' => 'GENE_BLOCKING_REASONS_STOLE']
];
$config['nameImageOfProduct'] = [
  'efectiva' => 'efectiva',
  'default' => 'bdb_default'
];
