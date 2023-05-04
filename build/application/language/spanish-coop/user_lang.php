<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['USER_SIGNIN_TITLE'] = 'Personas';
$lang['USER_SIGNIN_ACCESS_RECOVER'] = '¿Olvidaste tu usuario o contraseña?';
$lang['USER_SIGNIN_NO_USER'] = '¿Eres nuevo? - ';
$lang["USER_TERMS_TITLE"]='Términos y Condiciones de la Tarjeta de Débito Empresarial Banco Cooperativo Coopcentral';
$lang["USER_TERMS_SUBTITLE"]='Tarjetahabiente autorizado';
$lang["USER_TERMS_CONTENT"] = '
<div class="justify pr-3">
	<ol>
		<li>
			Terminos y condiciones
		</li>
	</ol>
</div>
';
$lang['USER_ADD_F_DOC'] = 'Agregar anverso del documento de identidad';
$lang['USER_ADD_B_DOC'] = 'Agregar reverso del documento de identidad';
$lang['USER_RECOVER_DATA_INVALID'] = 'Correo o documento de identidad inválido, verifica tus datos e intenta de nuevo.';
$lang['USER_RECOVER_DOC_TYPE'] = [
	'' => 'Selecciona',
	'C' => 'Cédula de ciudadanía',
	'E' => 'Cédula extranjería',
	'F' => 'Tarjeta extranjería',
	'N' => 'Nit',
	'U' => 'Nuip',
	'P' => 'Pasaporte',
	'T' => 'Tarjeta Identidad',
];
$lang['USER_UPDATE_FAIL'] = 'No fue posible actualizar los datos del usuario.';
$lang['USER_INVALID_DATE'] = 'No fue posible validar tus datos.';
$lang['USER_SIGNIN_INVALID_USER']= "Usuario o contraseña inválido, verifica e intenta de nuevo.";
$lang['USER_SIGNIN_WILL_BLOKED']= "Al siguiente intento incorrecto, tu usuario será bloqueado.";
$lang['USER_SIGNIN_SUSPENDED_USER'] = 'Tu usuario ha sido bloqueado por intentos incorrectos de acceso, recupéralo <a class="primary hyper-link" href="%s">aquí</a>';