<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Environment variables
|--------------------------------------------------------------------------
|
| Constants expected as environment variables on the instance to be used
| as part of global configuration settings.
|
*/
define('BASE_URL', $_SERVER['BASE_URL']);
define('BASE_CDN_URL', $_SERVER['BASE_CDN_URL']);
define('BASE_CDN_PATH', $_SERVER['BASE_CDN_PATH']);
define('WS_URL', $_SERVER['WS_URL']);
define('WS_KEY', $_SERVER['WS_KEY']);
define('ENCRYPTION_KEY', isset($_SERVER['ENCRYPTION_KEY']) ?
	$_SERVER['ENCRYPTION_KEY'] : 'n0v0p4ym3nt'
);
define('SESS_DRIVER', isset($_SERVER['SESS_DRIVER']) ?
	$_SERVER['SESS_DRIVER'] : 'files'
);
define('SESS_COOKIE_NAME', isset($_SERVER['SESS_COOKIE_NAME']) ?
	$_SERVER['SESS_COOKIE_NAME'] : 'cpo_session'
);
define('SESS_EXPIRATION', isset($_SERVER['SESS_EXPIRATION'])
&& filter_var($_SERVER['SESS_EXPIRATION'], FILTER_VALIDATE_INT) ?
	intval($_SERVER['SESS_EXPIRATION']) : 0
);
define('SESS_SAVE_PATH', isset($_SERVER['SESS_SAVE_PATH']) ?
	$_SERVER['SESS_SAVE_PATH'] : NULL
);
define('SESS_MATCH_IP', isset($_SERVER['SESS_MATCH_IP'])
&& filter_var($_SERVER['SESS_MATCH_IP'], FILTER_VALIDATE_BOOLEAN) ?
	boolval($_SERVER['SESS_MATCH_IP']) : FALSE
);
define('SESS_TIME_TO_UPDATE', isset($_SERVER['SESS_TIME_TO_UPDATE'])
&& filter_var($_SERVER['SESS_TIME_TO_UPDATE'], FILTER_VALIDATE_INT) ?
	intval($_SERVER['SESS_TIME_TO_UPDATE']) : 0
);
define('COOKIE_PREFIX', isset($_SERVER['COOKIE_PREFIX']) ?
	$_SERVER['COOKIE_PREFIX'] : 'cpo_'
);
define('COOKIE_DOMAIN', isset($_SERVER['COOKIE_DOMAIN']) ?
	$_SERVER['COOKIE_DOMAIN'] : ''
);
define('COOKIE_PATH', isset($_SERVER['COOKIE_PATH']) ?
	$_SERVER['COOKIE_PATH'] : '/'
);
define('COOKIE_SECURE', isset($_SERVER['COOKIE_SECURE'])
&& filter_var($_SERVER['COOKIE_SECURE'], FILTER_VALIDATE_BOOLEAN) ?
	boolval($_SERVER['COOKIE_SECURE']) : FALSE
);
define('URL_API', isset($_SERVER['URL_API']) ?
	$_SERVER['URL_API'] : '');
define('CLIENT_ID', isset($_SERVER['CLIENT_ID']) ?
	$_SERVER['CLIENT_ID'] : '');
define('CLIENT_SECRET', isset($_SERVER['CLIENT_SECRET']) ?
	$_SERVER['CLIENT_SECRET'] : '');

define('THRESHOLD', $_SERVER['CI_ENV'] === 'development' ? 4 : 2);

define('CYPHER_BASE', isset($_SERVER['CYPHER_BASE']) ?
	$_SERVER['CYPHER_BASE'] : ''
);

define('OAUTH_URL', isset($_SERVER['OAUTH_URL']) ?
	$_SERVER['OAUTH_URL'] : ''
);

define('PROXY_IPS', isset($_SERVER['PROXY_IPS']) ?
	$_SERVER['PROXY_IPS'] : ''
);

define('DB_HOSTNAME', isset($_SERVER['DB_HOSTNAME']) ?
	$_SERVER['DB_HOSTNAME'] : 'localhost'
);
define('DB_PORT', isset($_SERVER['DB_PORT'])
&& filter_var($_SERVER['DB_PORT'], FILTER_VALIDATE_INT) ?
	intval($_SERVER['DB_PORT']) : NULL
);
define('DB_USERNAME', isset($_SERVER['DB_USERNAME']) ?
	$_SERVER['DB_USERNAME'] : ''
);
define('DB_PASSWORD', isset($_SERVER['DB_PASSWORD']) ?
	$_SERVER['DB_PASSWORD'] : ''
);
define('DB_NAME', isset($_SERVER['DB_NAME']) ?
	$_SERVER['DB_NAME'] : ''
);
define('DB_DRIVER', isset($_SERVER['DB_DRIVER']) ?
	$_SERVER['DB_DRIVER'] : 'mysqli'
);
define('DB_CHARSET', isset($_SERVER['DB_CHARSET']) ?
	$_SERVER['DB_CHARSET'] : 'utf8'
);
define('DB_COLLATION', isset($_SERVER['DB_COLLATION']) ?
	$_SERVER['DB_COLLATION'] : 'utf8_general_ci'
);

$arrayUri = explode('/', $_SERVER['REQUEST_URI']);
$lang = end($arrayUri);
define('LANGUAGE', $lang === 'en' ? 'en' : 'es');
unset($arrayUri, $lang);

define('ACTIVE_RECAPTCHA', isset($_SERVER['ACTIVE_RECAPTCHA'])
&& filter_var($_SERVER['ACTIVE_RECAPTCHA'], FILTER_VALIDATE_BOOLEAN) ?
	boolval($_SERVER['ACTIVE_RECAPTCHA']) : FALSE
);

$uriSegments  =  explode( "/", parse_url($_SERVER[ 'REQUEST_URI'], PHP_URL_PATH ));
define('SUBCLASS_PREFIX', $uriSegments[1] == 'bdb' ?
	'BDB_' : 'NOVO_'
);
unset($uriSegments);
define('IP_PROXI', $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ?
$_SERVER['REMOTE_ADDR'] : ''
);
