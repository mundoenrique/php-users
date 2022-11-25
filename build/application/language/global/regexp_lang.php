<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['REGEX_ONLY_NUMBER'] = '^[0-9]{2,20}$';
$lang['REGEX_ONLY_ONE_NUMBER'] = '^[0-9]{1}$';
$lang['REGEX_ONLY_ONE_LETTER'] = '^[SCV]{1}$';
$lang['REGEX_NAMES_VALID'] = '^([a-zñáéíóú.]+[\s]*)+$';
$lang['REGEX_NICKNAME'] = '^[a-z0-9_]{6,16}$';
$lang['REGEX_NICKNAME_PROFILE'] = '^[a-z0-9 .,+-_@*]{6,16}$';
$lang['REGEX_SHORT_PHRASE'] = '^[a-z0-9ñáéíóú ().]{4,25}$';
$lang['REGEX_LONG_PHRASE'] = '^[a-z0-9ñáéíóú ().,:;-]{5,150}$';
$lang['REGEX_ALPHA_NAME'] = '^[a-zñáéíóú ]{1,50}$';
$lang['REGEX_ALPHA_LETTER'] = '^[a-zñáéíóú]{4,20}$';
$lang['REGEX_EMAIL_VALID'] = '^([a-zA-Z0-9]+[_.+\-]*)+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$';
$lang['REGEX_ALPHANUM_UNDER'] = '^([\w.\-+&ñÑ .,_\@\* ]+)+$';
$lang['REGEX_ALPHANUM'] = '^[a-z0-9]+$';
$lang['REGEX_NUMERIC'] = '^[0-9]+$';
$lang['REGEX_PHONE'] = '^[0-9]{7,15}$';
$lang['REGEX_TWO_FACTOR'] = '^[0-9]{6}$';
$lang['REGEX_PHONE_MASKED'] = '^[0-9*]{7,20}$';
$lang['REGEX_FLOAT_AMOUNT'] = '^[0-9\.,]+(\.,[0-9]{2})?$';
$lang['REGEX_DATE_DMY'] = '^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/[0-9]{4}$';
$lang['REGEX_DATE_MY'] = '^(0?[1-9]|1[012])\/[0-9]{4}$';
$lang['REGEX_DATE_Y'] = '^[0-9]{4}$';
$lang['REGEX_TRANS_TYPE'] = '^([-|+])$';
$lang['REGEX_CHECKED'] = '^([0|1])$';
$lang['REGEX_INT_CODE'] = '(^[\+]{1})+([0-9]{1,5})$';
