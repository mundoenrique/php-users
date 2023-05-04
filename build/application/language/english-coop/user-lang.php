<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['USER_SIGNIN_TITLE'] = 'Customers';
$lang['USER_SIGNIN_ACCESS_RECOVER'] = 'Forgot your username or password?';
$lang['USER_SIGNIN_NO_USER'] = 'Are you new? - ';
$lang["USER_TERMS_TITLE"]='Terms and Conditions of the Banco Cooperativo Coopcentral Business Debit Card';
$lang["USER_TERMS_SUBTITLE"]='Authorized cardholder';
$lang["USER_TERMS_CONTENT"] = '
<div class="justify pr-3">
	<ol>
		<li>
		Terms and Conditions
		</li>
	</ol>
</div>
';
$lang['USER_ADD_F_DOC'] = 'Add front of identity document';
$lang['USER_ADD_B_DOC'] = 'Add back of identity document';
$lang['USER_RECOVER_DATA_INVALID'] = 'Invalid email or identity document, verify your information and try again.';
$lang['USER_RECOVER_DOC_TYPE'] = [
	'' => 'Select',
	'C' => 'Citizenship card',
	'E' => 'Foreign ID',
	'F' => 'Foreigner card',
	'N' => 'Nit',
	'U' => 'Nuip',
	'P' => 'Passport',
	'T' => 'Identity card',

];
$lang['USER_UPDATE_FAIL'] = 'It was not possible to update the user data.';
$lang['USER_INVALID_DATE'] = 'It was not possible to validate your data.';
$lang['USER_SIGNIN_INVALID_USER']= "User or password invalid, please check and try again.";
$lang['USER_SIGNIN_WILL_BLOKED']= "The next incorrect attempt, your user will be blocked.";
$lang['USER_SIGNIN_SUSPENDED_USER'] = 'Your user has been blocked due to incorrect access attempts, recover it <a class="primary hyper-link" href="%s">here</a>';