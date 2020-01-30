<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tool_Browser {

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
		$responseInfoBrowse->isIE = !$this->CI->agent->browser === 'Internet Explorer';
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
			'Mozilla' => 30,
			'Chrome' => 48,
			'Apple Safari' => 10,
			'OPR' => 35
		];

		$getInfoBrowser = $this->getInfo();

		if ($getInfoBrowser->isBrowser) {

			if ($getInfoBrowser->notIsIE) {

				if (intval($getInfoBrowser['version']) > $validBrowser[$getInfoBrowser['name']]) {
					$resultValidation = TRUE;
				}
			}
		}

		$this->CI->session->set_flashdata('checkBrowser','pass');

		return [
			'valid' => $resultValidation,
			'reason' => $getInfoBrowser->platform,
		];
	}

	function getNamePlatform ($user_agent) {

		switch ($user_agent) {

			case preg_match('/windows/i', $user_agent):
				$platform = ['type' => 'pc', 'name' => 'windows'];
				break;

			case preg_match('/macintosh/i', $user_agent):
				$platform = ['type' => 'pc', 'name' => 'macintosh'];
			break;

			case preg_match('/linux/i', $user_agent):
				$platform = ['type' => 'pc', 'name' => 'linux'];
				break;

				case preg_match('/iPod/i', $user_agent):
				$platform = ['type' => 'mobile', 'name' => 'ipod'];
				break;

			case preg_match('/iPhone/i', $user_agent):
				$platform = ['type' => 'mobile', 'name' => 'iphone'];
				break;

			case preg_match('/iPad/i', $user_agent):
				$platform = ['type' => 'mobile', 'name' => 'ipad'];
				break;

			case preg_match('/Android/i', $user_agent):
				$platform = ['type' => 'mobile', 'name' => 'android'];
				break;

			case preg_match('/webOS/i', $user_agent):
				$platform = ['type' => 'smart', 'name' => 'webos'];
				break;

			default:
				$platform = ['type' => 'unknown', 'name' => 'unknown'];

		}
		return $platform;
	}

	function getInfoBrowser ($user_agent) {

		$browser_name = 'Unknown';
		$ub = 'Unknown';

    if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
    {
        $browser_name = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Trident/i',$user_agent))
    {
        $browser_name = 'Internet Explorer';
        $ub = "rv";
    }
    elseif(preg_match('/Firefox/i',$user_agent))
    {
        $browser_name = 'Mozilla Firefox';
        $ub = "Firefox";
		}
    elseif(preg_match('/Edge/i', $user_agent))
    {
        $browser_name = 'Edge';
        $ub = "Edge";
    }
    elseif(preg_match('/Chrome/i',$user_agent))
    {
        $browser_name = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$user_agent))
    {
        $browser_name = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$user_agent))
    {
        $browser_name = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$user_agent))
    {
        $browser_name = 'Netscape';
        $ub = "Netscape";
    }
		return array(
			'browser_name' => $browser_name,
			'ub' => $ub
		);
	}

	function getVersion ($user_agent, $ub) {

		if ($ub !== 'Unknown') {

			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) . ')[/|: ]+(?<version>[0-9.|a-zA-Z.]*)#';

			if (preg_match_all($pattern, $user_agent, $matches)) {

					$i = count($matches['browser']);
					if ($i != 1) {

							if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
									$version= $matches['version'][0];
							}
							else {
									$version= $matches['version'][1];
							}
					}
					else {
							$version= $matches['version'][0];
					}
			}
		}
		return isset($version)? $version: '?';
	}
}
