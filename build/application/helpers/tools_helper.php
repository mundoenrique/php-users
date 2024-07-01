<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ------------------------------------------------------------------------
if (!function_exists('np_hoplite_log')) {
  /**
   * [np_hoplite_log description]
   * @param  [type] $username
   * @param  [type] $canal
   * @param  [type] $modulo
   * @param  [type] $function
   * @param  [type] $operacion
   * @return [type]
   */
  function np_hoplite_log($sessionId, $username, $canal, $modulo, $function, $operacion)
  {
    $CI = &get_instance();

    $logAcceso = array(
      "sessionId" => $sessionId,
      "userName" => $username,
      "canal" => $canal,
      "modulo" => $modulo,
      "function" => $function,
      "operacion" => $operacion,
      "RC" => 0,
      "IP" => $CI->input->ip_address(),
      "dttimesstamp" => date("m/d/Y H:i"),
      "lenguaje" => "ES"
    );
    return $logAcceso;
  }
}

if (!function_exists('np_hoplite_countryCheck')) {
  /**
   * [np_hoplite_countryCheck description]
   * @param  [type] $countryISO [description]
   * @return [type]             [description]
   */
  function np_hoplite_countryCheck($countryISO)
  {
    $CI = &get_instance();

    $iso = strtolower($countryISO);
    if (strtolower($iso) !== '') {
      $CI->config->load('conf-' . $iso . '-config');
    }
  }
}

if (!function_exists('np_hoplite_byteArrayToFile')) {
  /**
   * [np_hoplite_byteArrayToFile description]
   * @param  [type] $bytes [description]
   * @return [type]        [description]
   */
  function np_hoplite_byteArrayToFile($bytes, $typeFile, $filename)
  {
    $CI = &get_instance();

    switch ($typeFile) {
      case 'pdf':
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
        header('Pragma: no-cache');
        header('Expires: 0');
        break;
      case 'xls':
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename . '.xls');
        header('Pragma: no-cache');
        header('Expires: 0');
        break;
      default:
        break;
    }
    foreach ($bytes as $chr) {
      echo chr($chr);
    }
  }
}

if (!function_exists('np_hoplite_jsontoiconsector')) {
  /**
   * [np_hoplite_jsontoiconsector description]
   * @param  [type] $bytes    [description]
   * @param  [type] $typeFile [description]
   * @param  [type] $filename [description]
   * @return [type]           [description]
   */
  function np_hoplite_jsontoiconsector($nroIcon)
  {
    $string = file_get_contents("/opt/httpd-2.4.4/vhost/online/application/eol/uploads/sector.json");
    $json_a = json_decode($string);
    $icon = $json_a->pe->{$nroIcon};

    return $icon;
  }
}


if (!function_exists('np_hoplite_existeLink')) {
  /**
   * [np_hoplite_existeLink description]
   * @param  [type] $menuP    [description]
   * @param  [type] $link [description]
   * @return [type]           [description]
   */
  function np_hoplite_existeLink($menuP, $link)
  {

    $arrayMenu = unserialize($menuP);
    $modulos = "";

    if ($arrayMenu != "") {

      foreach ($arrayMenu as $value) {
        foreach ($value->modulos as $modulo) {
          $modulos .= strtolower($modulo->idModulo) . ",";
        }
      }
      return strrpos($modulos, strtolower($link));
    } else {
      return false;
    }
  }
}


if (!function_exists('np_hoplite_modFunciones')) {
  /**
   * [np_hoplite_modFunciones description]
   * @param  [type] $menuP    [description]
   * @return [type]           [description]
   */
  function np_hoplite_modFunciones($menuP)
  {

    $arrayMenu = unserialize($menuP);
    $funciones = "";

    if ($arrayMenu != "") {

      foreach ($arrayMenu as $value) {
        foreach ($value->modulos as $modulo) {
          foreach ($modulo->funciones as $func) {
            $funciones .= strtolower($func->accodfuncion) . ",";
          }
        }
      }

      return explode(',', strtolower($funciones));
    } else {
      return false;
    }
  }
}

function np_hoplite_verificLogin()
{

  $CI = &get_instance();

  if (!($CI->session->userdata('logged_in'))) {
    $append = '';
    $skin = get_cookie('skin', TRUE);
    if ($skin !== false && $skin !== 'default') {
      $append = '/' . $skin . '/home';
    }

    redirect($CI->config->item('base_url') . $append);
  }
}

function np_hoplite_verificSession()
{

  $CI = &get_instance();

  if ($CI->session->userdata('logged_in') === true) {
    redirect($CI->config->item('base_url') . '/dashboard');
  }
}

if (!function_exists('getFaviconLoader')) {
  function getFaviconLoader()
  {
    $CI = &get_instance();
    $favicon = $CI->config->item('favicon');
    $loader = 'loading-';
    switch ($CI->config->item('country')) {
      case 'Ec-bp':
        $ext = 'ico';
        $loader .= 'bp.gif';
        break;
      default:
        $ext = 'png';
        $loader .= 'novo.gif';
    }

    $faviconLoader = new stdClass();
    $faviconLoader->favicon = $favicon;
    $faviconLoader->ext = $ext;
    $faviconLoader->loader = $loader;

    return $faviconLoader;
  }
}



// ------------------------------------------------------------------------
if (!function_exists('np_hoplite_decimals')) {
  //AFILIACIÓN DE NÚMERO
  /**
   * @access public
   * @params: $number
   * @info: Función para agregar decimales a valores según país
   * @autor: Alexander Cuestas
   * @date:  17/03/2018
   */
  function np_hoplite_decimals($number, $pais)
  {
    if (($pais === 'Pe') || ($pais === 'Usd') || ($pais === 'Ec-bp')) {
      $result = number_format($number, 2, '.', ',');
    } else if (($pais === 'Ve') || ($pais === 'Co')) {
      $result = number_format($number, 2, ',', '.');
    }
    return $result;
  }
}

if (!function_exists('clientCheck')) {
  function clientCheck($client)
  {
    $CI = &get_instance();

    switch ($client) {
      case 'bdb':
        $CI->config->load('config-' . $client);
        break;
      default:
        redirect('/');
    }
  }
}

if (!function_exists('logAccess')) {
  function logAccess($dataAccessLog)
  {
    $CI = &get_instance();

    return [
      "sessionId" => $CI->session->userdata('sessionId') ?: '',
      "userName" => strtoupper($CI->session->userdata('userName')) ?: strtoupper($dataAccessLog->userName),
      "canal" => $CI->config->item('channel'),
      "modulo" => $dataAccessLog->modulo,
      "function" => $dataAccessLog->function,
      "operacion" => $dataAccessLog->operation,
      "RC" => 0,
      "IP" => $CI->input->ip_address(),
      "dttimesstamp" => date('m/d/Y H:i'),
      "lenguaje" => strtoupper(LANGUAGE)
    ];
  }
}

if (!function_exists('loadLanguage')) {
  function loadLanguage($client = 'default_lang', $langFiles = FALSE)
  {
    $CI = &get_instance();
    $langFiles = $langFiles ?: $CI->router->fetch_method();
    $languages = [];
    $lanGeneral = ['bp', 'co', 've', 'bdb'];
    $loadlanguages = FALSE;
    log_message('INFO', 'NOVO HELPER loadLanguage Initialized for controller ' . $CI->router->fetch_class() . ' and method ' . $langFiles . ' for ' . $client);

    switch ($client) {
      case 'bp':
        $languages = [];
        break;
      case 'bdb':
        $languages = [];
        break;
      case 'co':
        $languages = [];
        break;
      case 'pe':
        $languages = [];
        break;
      case 'us':
        $languages = [];
        break;
      case 've':
        $languages = [];
        break;
      default:
        $languages = [
          'login' => ['login', 'signin'],
          'validatecaptcha' => ['login'],
          'RecoverPass'  => ['password-recover'],
          'changePassword'  => ['password-change'],
          'changePasswordProfile'  => ['password-change'],
          'benefits'  => ['benefits'],
          'terms'  => ['terms'],
          'rates'  => ['rates'],
          'getEnterprises'  => ['enterprise'],
          'getProducts'  => ['enterprise'],
        ];
    }

    if (array_key_exists($langFiles, $languages)) {
      $languages = $languages[$langFiles];
      $loadlanguages = TRUE;
    }
    if (in_array($client, $lanGeneral)) {
      array_unshift($languages, 'general');
      $loadlanguages = TRUE;
    }
    if ($loadlanguages) {
      $CI->lang->load($languages);
    }
  }
}

if (!function_exists('countryCheck')) {
  function countryCheck($country)
  {
    $CI = &get_instance();
    $CI->config->load('config-' . $country);
  }
}

if (!function_exists('mask_account')) {
  function mask_account($account, $start = 4, $end = 7)
  {
    $len = strlen($account);
    return substr($account, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($account, $len - $end, $end);
  }
}

if (!function_exists('validateUrl')) {
  function validateUrl($client)
  {
    $CI = &get_instance();
    $accessUrl = ACCESS_URL;
    $uri = SUBCLASS_PREFIX === 'BDB_' ? '/inicio' : '/sign-in';

    if (!in_array($client, $accessUrl)) {
      $baseUrl = str_replace("$client/", "$accessUrl[0]/", base_url($uri));

      switch ($accessUrl[0]) {
        case 'default':
          $baseUrl = str_replace("$client/", "", base_url());
          break;

        case 'pichincha':
          $baseUrl = base_url($accessUrl[0] . '/home');
          break;

        default:
          $baseUrl = base_url($accessUrl[0] . $uri);
      }

      redirect($baseUrl, 'Location', 302);
      exit;
    }
  }
}

if (!function_exists('changeCoreUrl')) {
  function changeCoreUrl($countryUri)
  {
    switch ($countryUri) {
      case "Usd":
        $codCountryUri = "us";
        break;
      case "Pe":
        $codCountryUri = "pe";
        break;
      case "Co":
        $codCountryUri = "co";
        break;
      case "Ve":
        $codCountryUri = "ve";
        break;
      case "Ec-bp":
        $codCountryUri = "bp";
        break;
    }
    return $codCountryUri;
  }
}
