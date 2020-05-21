<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('mainMenu'))
{
	function mainMenu() {
		return [
			'CARDS_LIST' => [],
			'PAYS_TRANSFER' => [
				'BETWEEN_CARDS' => [],
				'BANKS' => [],
				'CREDIT_CARDS' => [],
				'SERVICES' => [
					'TELEPHONY' => []
				]
			],
			'REPORTS' => [],
			'CUSTOMER_SUPPORT' => []
		];
	}
}
