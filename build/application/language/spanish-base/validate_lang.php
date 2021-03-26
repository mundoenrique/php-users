<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//VALIDATE FORMS
$lang['VALIDATE_USERLOGIN'] = '';
$lang['VALIDATE_USERPASS_REQ'] = 'Ambos campos son requeridos';
$lang['VALIDATE_USERPASS_PATT'] = 'Combinación incorrecta de usuario y contraseña';
$lang['VALIDATE_OTP_CODE'] = 'Ingresa un código de seguridad válido (letras y números)';
$lang['VALIDATE_RECOVER_OPTION'] = 'Selecciona una opción';
$lang['VALIDATE_EMAIL'] = 'Indica un correo válido "usuario@ejemplo.com"';
$lang['VALIDATE_REQUIRED_PHONE'] = 'El teléfono es requerido';
$lang['VALIDATE_ID_NUMBER'] = 'Se admiten números y letras';
$lang['VALIDATE_CURRENT_PASS'] = 'Indica tu contraseña actual';
$lang['VALIDATE_NEW_PASS'] = 'Indica tu nueva contraseña';
$lang['VALIDATE_DIFFERS_PASS'] = 'La nueva contraseña debe ser diferente a la actual';
$lang['VALIDATE_DIFFERS_PHONE'] = 'El número de teléfono debe ser diferente al de los otros teléfonos';
$lang['VALIDATE_REQUIREMENTS_PASS'] = 'La contraseña debe cumplir los requisitos';
$lang['VALIDATE_CONFIRM_PASS'] = 'Confirma tu contraseña';
$lang['VALIDATE_IQUAL_PASS'] = 'Debe ser igual a la nueva contraseña';
$lang['VALIDATE_FILTER_YEAR'] = 'Selecciona un año';
$lang['VALIDATE_NUMBER_CARD'] = 'Indica el número de tu tarjeta';
$lang['VALIDATE_DOCUMENT_ID'] = 'Indica el número de tu documento de identidad';
$lang['VALIDATE_CARD_PIN'] = 'Indica el PIN de tu tarjeta';
$lang['VALIDATE_ACCEPT_TERMS'] = 'Debes aceptar los términos de uso';
$lang['VALIDATE_AVAILABLE_NICKNAME'] = 'Usuario no disponible, intenta con otro';
$lang['VALIDATE_FIRST_NAME'] = 'Indica tu primer nombre (solo letras)';
$lang['VALIDATE_LAST_NAME'] = 'Indica tu primer apellido (solo letras)';
$lang['VALIDATE_MIDDLE_NAME'] = 'Indica tu segundo nombre (solo letras)';
$lang['VALIDATE_SUR_NAME'] = 'Indica tu segundo apellido (solo letras)';
$lang['VALIDATE_BIRTHDATE'] = 'Indica tu fecha de nacimiento';
$lang['VALIDATE_NATIONALITY'] = 'Indica tu nacionalidad, mín 4  máx 20 (solo letras)';
$lang['VALIDATE_BIRTHPLACE'] = 'Admite mín 4  máx 20 (solo letras)';
$lang['VALIDATE_VERIFIER_CODE'] = 'Indica el dígito verificador de tu DNI (solo un número)';
$lang['VALIDATE_GENDER'] = 'Indica tu género';
$lang['VALIDATE_CONFIRM_EMAIL'] = 'Debe ser igual a tu correo';
$lang['VALIDATE_PHONE'] = 'Indica un teléfono válido, mín 7 máx 15 (solo números)';
$lang['VALIDATE_WORKPLACE'] = 'Indica tu lugar de trabajo (letras, números y espacio)';
$lang['VALIDATE_POSITION'] = 'Indica tu cargo, mín 4 máx 25 (letras y espacio)';
$lang['VALIDATE_AMOUNT_REGEX'] = '^[0-9]+(\.[0-9]{2})?$';
$lang['VALIDATE_AVERAGE_INCOME'] = 'Indica un monto válido máx 9 (0.00)';
$lang['VALIDATE_MOBIL'] = '^[0-9]{7,15}$';
$lang['VALIDATE_MOBIL_MASKED'] = '^[0-9*]{7,15}$';
$lang['VALIDATE_MOBIL_PHONE'] = 'Indica un móvil válido, mín 7 máx 15 (solo números)';
$lang['VALIDATE_REGEX_NICKNAME'] = '^[a-z0-9_]{6,16}$';
$lang['VALIDATE_NICK_REQ'] = 'Indica tu nombre de usuario, mín 6 máx 16';
$lang['VALIDATE_NICK_PATT'] = 'Se admiten números, letras y "_", mín 6 máx 16';
$lang['VALIDATE_NICK_DIFFER'] = '';
$lang['VALIDATE_NICK_DIFFER_TEXT'] = 'Indica tu nombre de usuario, mín 6 máx 16';
$lang['VALIDATE_DATE_DMY'] = 'Indica una fecha válida dd/mm/aaaa';
$lang['VALIDATE_DATE_MY'] = 'Indica una fecha válida mm/aaaa';
$lang['VALIDATE_REPLACE_REASON'] = 'Indica un motivo';
$lang['VALIDATE_TEMPORARY_LOCK_REASON'] = 'Indica un motivo';
$lang['VALIDATE_CURRENT_PIN'] = 'Indica tu PIN actual';
$lang['VALIDATE_NEW_PIN'] = 'Indica tu nuevo PIN';
$lang['VALIDATE_DIFFERS_PIN'] = 'El nuevo PIN debe ser diferente al actual';
$lang['VALIDATE_CONFIRM_PIN'] = 'Confirma tu PIN';
$lang['VALIDATE_IQUAL_PIN'] = 'Debe ser igual a el nuevo pin';
$lang['VALIDATE_FORMAT_PIN'] = 'Debe ser de 4 dígitos (0-9) no consecutivos.';
$lang['VALIDATE_FILES_EXT'] = 'png|jpg|jpeg';
$lang['VALIDATE_FILE_TYPE'] = 'Elige un archivo permitido (png, jpg, jpeg)';
$lang['VALIDATE_FILE_SIZE'] = 'El archivo no cumple con el peso requerido.';
$lang['VALIDATE_CODE_RECEIVED'] = 'Coloca el código recibido.';
$lang['VALIDATE_INVALID_FORMAT'] = 'El formato de código es inválido.';
$lang['VALIDATE_INVALID_FORMAT_DOCUMENT_ID'] = 'El formato del documento de identidad es inválido.';
$lang['VALIDATE_ADDRESS'] = 'Indica una dirección válida, mín 5 máx 150 (letras, números, espacio -().;).';
$lang['VALIDATE_POSTAL_CODE'] = 'Indica un código postal válido, mín 2 máx 20 (solo números).';
$lang['VALIDATE_PROTECTION'] = 'Debes leer y aceptar la protección de datos personales.';
$lang['VALIDATE_CONTRACT'] = 'Debes leer y aceptar el contrato de cuenta dinero electrónico.';
$lang['VALIDATE_SHORT_PHRASE'] = 'mín 4 máx 25 (letras, números, espacio ().).';
$lang['VALIDATE_TYPE_DOCUMENT'] = 'Selecciona un tipo de documento válido.';
