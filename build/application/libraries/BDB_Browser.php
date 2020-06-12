<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BDB_Browser {

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('user_agent');
	}

	public function getInfo () {

		$responseInfoBrowse = new stdClass();

		$responseInfoBrowse->platform = $this->CI->agent->platform;
		$responseInfoBrowse->name = $this->CI->agent->browser;
		$responseInfoBrowse->version = $this->CI->agent->version;
		$responseInfoBrowse->isIE = $this->CI->agent->browser === 'Internet Explorer';
		$responseInfoBrowse->isBrowser = $this->CI->agent->is_browser;
		$responseInfoBrowse->isRobot = $this->CI->agent->is_robot;
		$responseInfoBrowse->isMobile = $this->CI->agent->is_mobile;

		return $responseInfoBrowse;
	}

	public function validateBrowser () {

		$resultValidation = FALSE;

		$validBrowser = [
			'Internet Explorer' => 11,
			'Edge' => 14,
			'Firefox' => 30,
			'Chrome' => 48,
			'Apple Safari' => 10,
			'Netscape' => 9,
			'OPR' => 35,
			'Opera' => 35,
			"Safari" => 10
		];

		$getInfoBrowser = $this->getInfo();

		if ($getInfoBrowser->isBrowser) {

			if (!$getInfoBrowser->isIE && !$getInfoBrowser->isMobile && !$getInfoBrowser->isRobot) {

				if (intval($getInfoBrowser->version) > $validBrowser[$getInfoBrowser->name]) {
					$resultValidation = TRUE;
				}
			}
		}

		return [
			'isValid' => $resultValidation,
			'isMobile' => $getInfoBrowser->isMobile,
			'plataform' => $getInfoBrowser->platform,
			'info' => $getInfoBrowser
		];
	}
}
