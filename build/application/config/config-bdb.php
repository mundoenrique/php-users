<?php
defined('BASEPATH') or exit('No direct script access allowed');

//País
$config['country'] = 'bdb';
$config['language'] = 'spanish-bdb';
$config['base_url']	= BASE_URL . '/' . 'bdb/';
$config['language_file_specific'] = [];
$config['language_form_validate'] = FALSE;
$config['layout'] = 'designFullPage';
$config['setTimerOTP'] = 5*60;

$config['timeIdleSession'] = 6*60000;

$config['listReasonReposition'] = [
	['value'=>'59','tagTranslation'=>'GENE_BLOCKING_REASONS_STOLE'],
	['value'=>'17','tagTranslation'=>'GENE_BLOCKING_REASONS_FRAUD'],
	['value'=>'41','tagTranslation'=>'GENE_BLOCKING_REASONS_CANCELLED'],
];
