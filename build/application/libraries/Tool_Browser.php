<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tool_Browser {

	public function getInfo()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$platform = $this->getNamePlataform ($user_agent);
		$info_browser = $this->getInfoBrowser ($user_agent);
		$version_browser = $this->getVersion($user_agent, $info_browser['ub']);

		return array(
			'platform' => $platform,
			'name' => $info_browser['browser_name'],
			'version' => $version_browser
		);
	}

	public function validateBrowser () {

		$resultValidation = FALSE;

		$validBrowser = [
			'Internet Explorer' => 11,
			'Edge' => 14,
			'Mozilla Firefox' => 30,
			'Google Chrome' => 48,
			'Apple Safari' => 10,
			'Opera' => 35
		];

		$getInfoBrowser = $this->getInfo();

		if ($getInfoBrowser['platform'] !== 'mobile') {

			if (intval($getInfoBrowser['version']) > $validBrowser[$getInfoBrowser['name']]) {
				$resultValidation = TRUE;
			}
		}
		return [
			'platform' => $getInfoBrowser['platform'],
			'valid' => $resultValidation
		];
	}

	function getNamePlataform ($user_agent) {

		$platform = 'Unknown';

		switch ($user_agent) {
			case preg_match('/linux/i', $user_agent):
				$platform = 'linux';
				break;

			case preg_match('/macintosh/i', $user_agent):
				$platform = 'mac';
				break;

			case preg_match('/windows/i', $user_agent):
				$platform = 'windows';
				break;

			case preg_match('/iPod/i', $user_agent):
				$platform = 'i';
				break;

			case preg_match('/iPhone/i', $user_agent):
				$platform = 'i';
				break;

			case preg_match('/iPad/i', $user_agent):
				$platform = 'i';
				break;

			case preg_match('/Android/i', $user_agent):
				$platform = 'a';
				break;

			case preg_match('/webOS/i', $user_agent):
				$platform = 'webos';
				break;
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
