<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('writeLog')) {
	function writeLog($level, $message) {
		$CI = get_instance();
		$appUserName = '';
		$customer = '';
		$ip = $CI->input->ip_address();

		if ($CI->session->has_userdata('userName')) {
			$appUserName = $CI->session->userName;
		} elseif ($CI->input->post('userName') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('userName'));
		} elseif ($CI->input->post('idNumber') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('idNumber'));
		} elseif ($CI->input->post('documentId') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('documentId'));
		}

		if ($CI->session->has_userdata('customerSess')) {
			$customer = $CI->session->customerSess;
		} elseif ($CI->config->item('customer') !== NULL) {
			$customer = $CI->config->item('customer');
		}

		if ($customer === '') {
			$message = novoLang('NOVO [' . $appUserName . '] IP: %s, %s', [$ip, $message]);
		} else {
			$message = novoLang('NOVO [' . $appUserName . '] IP: %s, customer: %s, %s', [$ip, $customer, $message]);
		}


		log_message($level, $message);
	}
}
