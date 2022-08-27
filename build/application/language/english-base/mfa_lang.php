<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//MULTIFACTOR AUTENTICATION
$lang['MFA_TWO_FACTOR_EMAIL'] = 'email';
$lang['MFA_TWO_FACTOR_APP'] = 'app';
$lang["MFA_TWO_FACTOR_RESEND_CODE"] = 'The authentication code has been resent to your email %s';
$lang["MFA_TWO_FACTOR_ENABLED"] = 'Two-factor authentication is enabled.';
$lang["MFA_TWO_FACTOR_DISABLED_REDIRECT"] = 'Two-factor authentication is disabled. You will be redirected to enable it.';
$lang["MFA_TWO_FACTOR_EMAIL_TEXT"] = 'We have sent an authentication code to your email {$maskMail$}. Enter the same next.';
$lang["MFA_TWO_FACTOR_ENABLEMENT_CONTENT"] = '
<p>Two-factor authentication is not yet enabled.</p>
<p>To increase security when performing transactional operations with your product, we need you to activate the security mechanism (Double authentication factor).</p>';
$lang["MFA_TWO_FACTOR_CODE_APP"] = 'Use an app on your phone to get two-factor authentication codes when prompted. We recommend using apps like: ';
$lang["MFA_TWO_FACTOR_IMG"] = 'Scan the image below with the two-factor authentication app on your phone.';
$lang["MFA_TWO_FACTOR_SCAN"] = 'After scanning the QR code image, the app will display a code that you can enter next.';
$lang["MFA_TWO_FACTOR_QR_TEXT"] = "If you can't use the QR code, use this code in your authenticator app instead";
$lang['MFA_ACCOUNT_VERIFICATION'] = 'Account Verification';
$lang['MFA_VERIFY_MSG_EMAIL'] = 'Please verify that you can receive messages in the email registered in the application.';
$lang['MFA_ACTIVATION_TYPE'] = 'Activation type';
$lang['MFA_USING_AN_APP'] = 'Authentication app';
