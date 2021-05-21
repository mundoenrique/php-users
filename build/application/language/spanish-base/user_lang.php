<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//SIGN IN
$lang['USER_SIGNIN_TITLE'] = '';
$lang['USER_SIGNIN_ACCESS_RECOVER'] = 'Recuperar acceso';
$lang['USER_SIGNIN_NO_USER'] = '¿No posees usuario?';
$lang['USER_SIGNIN_SINGN_UP'] = 'Regístrate';
$lang['USER_SIGNIN_INCORRECTLY_CLOSED'] = '<div><h5 class="regular">Tu última sesión se cerró de manera incorrecta. Ten en cuenta que para salir de la aplicación debes seleccionar <strong>"Cerrar Sesión"</strong>.</h5></div>';
$lang['USER_SIGNIN_RECAPTCHA_VALIDATE'] = 'El sistema ha detectado una actividad no autorizada, por favor intenta nuevamente';
$lang['USER_SIGNIN_INVALID_USER']= "Usuario o contraseña inválido";
$lang['USER_SIGNIN_WILL_BLOKED']= "Al siguiente intento fallido tu usuario será bloqueado";
$lang['USER_SIGNIN_SUSPENDED_USER'] = 'Tu usuario ha sido bloqueado por intentos fallidos de conexión, recuperalo  <a class="primary hyper-link" href="%s">aquí</a>';
$lang['USER_IP_ASSERT'] = 'Confirmo que estoy ingresando desde un equipo de uso frecuente.';
$lang['USER_SIGNIN_PASS_EXPIRED'] = 'Tu contraseña temporal ha vencido, solicita una nueva <a class="primary hyper-link" href="%s">aquí</a>. Recuerda cambiarla en un plazo menor a 24 horas.';
//GENERAL LANGUAGE
$lang['USER_PASS_TEMPORAL'] = 'Tu contraseña es temporal. Por motivos de seguridad es necesario que la cambies antes de continuar en nuestro sistema "<strong>%s</strong>".';
$lang['USER_PASS_EXPIRED'] = 'Tu contraseña está vencida. Por motivos de seguridad es necesario que la cambies antes de continuar en nuestro sistema "<strong>%s</strong>".';
$lang['USER_ACCEPT_TERMS'] = 'Acepto las condiciones de uso de este sistema.';
$lang['USER_ACCEPT_PROTECTION'] = 'Aceptar protección de datos personales.';
$lang['USER_ACCEPT_CONTRACT'] = 'Acepto el contrato de cuenta dinero electrónico.';
$lang['USER_PASS_CHANGE'] = 'Si deseas cambiar tu contraseña en "<strong>%s</strong>", por favor completa los siguientes datos.';
$lang['USER_PASS_CURRENT'] = 'Contraseña actual';
$lang['USER_PASS_NEW'] = 'Contraseña nueva';
$lang['USER_PASS_CONFIRM'] = 'Confirma la contraseña';
$lang['USER_INFO_TITLE'] = 'Requisitos para crear la contraseña:';
$lang['USER_INFO_1'] = 'De 8 a 15 <strong>caracteres</strong>.';
$lang['USER_INFO_2'] = 'Al menos una <strong>letra minúscula</strong>.';
$lang['USER_INFO_3'] = 'Al menos una <strong>letra mayúscula</strong>.';
$lang['USER_INFO_4'] = 'De 1 a 3 <strong>números</strong>.';
$lang['USER_INFO_5'] = 'Al menos un <strong>caracter especial</strong> (ej: ! @ * - ? ¡ ¿ + / . , _ #).';
$lang['USER_INFO_6'] = 'No debe tener más de 2 <strong>caracteres</strong> iguales consecutivos.';
$lang['USER_PASS_CHANGED'] = 'La contraseña fue cambiada exitosamente. %s';
$lang['USER_PASS_LOGIN'] = '<br>Por motivos de seguridad es necesario que inicies sesión nuevamente.';
$lang['USER_PASS_USED'] = 'La nueva contraseña no debe coincidir <strong>con las últimas cinco usadas</strong>.';
$lang['USER_PASS_INCORRECT'] = 'La contraseña actual es incorrecta, verifícala e intenta de nuevo.';
$lang['USER_RECOVER_VERIFY_DATA'] = 'Verificación de datos';
$lang['USER_RECOVER_PASS'] = 'Para recuperar tu usuario o restablecer tu contraseña de acceso a <span class="bold">%s</span>, debes seleccionar la opción correspondiente e ingresar los datos requeridos.';
$lang['USER_RECOVER_NEED'] = 'Necesito recuperar mi';
$lang['USER_RECOVER_SUCCESS'] = 'Enviamos un correo a %s, %s';
$lang['USER_RECOVER_PASS_TEMP'] = 'con una contraseña temporal.';
$lang['USER_RECOVER_USERNAME'] = 'con tu usuario.';
$lang['USER_RECOVER_DATA_INVALID'] = 'Correo o documento de identidad inválido. Por favor verifica tus datos, e intenta nuevamente.';
$lang["USER_LEGAL_STEP"]='Legales';
$lang["USER_TERMS_TITLE"]='Términos y condiciones.';
$lang["USER_TERMS_SUBTITLE"]='Tarjetahabiente.';
$lang["USER_TERMS_CONTENT"] = '
<ol>
	<li>
		<p><b>Objeto</b></p>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id est vitae nisi ultrices consequat nec sit amet ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus at sapien facilisis, gravida quam non, cursus risus. Quisque feugiat elementum nisi. Sed hendrerit massa eu velit efficitur tempus. Maecenas euismod tempus tortor quis lobortis. Pellentesque diam nunc, dignissim nec mauris sit amet, lacinia convallis dolor. Pellentesque eu turpis eget justo auctor sagittis non vel urna. Vestibulum ligula purus, tempor non imperdiet ut, aliquam id nisi. Sed laoreet at leo vitae lacinia. In et sodales mauris. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris tortor enim, ultrices eget lacinia sit amet, ultrices ac purus. Praesent pulvinar, dui viverra vestibulum malesuada, risus turpis mattis tellus, in tincidunt ante nunc ac ligula. Sed efficitur erat mauris, eget sollicitudin lectus dapibus eget. Pellentesque ac finibus dolor.
		</p>
	</li>
	<li>
		<p><b>Definiciones</b></p>
		<p>
			Duis nibh sem, tristique ac ipsum vitae, egestas volutpat lectus. Nulla facilisi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque pharetra bibendum tellus. Morbi a consequat augue. Duis ac purus magna. Vivamus dignissim blandit congue. In viverra ornare sem et mattis. Pellentesque massa nulla, dictum at pretium in, sollicitudin ac sem. Nunc ultricies arcu nisi, nec suscipit ex ultrices non. Quisque vestibulum molestie ipsum vel dignissim. Duis pulvinar dui sed feugiat sodales. Praesent egestas erat id nisi accumsan euismod. Integer nec lacus tempor, auctor purus nec, finibus nunc. Mauris eget mattis nunc, sed sodales orci.
		</p>
	<li>
		<p><b>Uso de la Tarjeta de Débito:</b></p>
		<p>
			Quisque ac lacinia nisi. Aenean at scelerisque velit, at hendrerit nisi. Vivamus ullamcorper egestas sollicitudin. Vivamus sollicitudin ante vel purus efficitur semper. Sed suscipit urna ac turpis tincidunt accumsan. Aliquam ut tempus felis. Proin mollis dui vel nisi laoreet, sit amet varius odio aliquam. Praesent pharetra metus ut ullamcorper pharetra. In efficitur suscipit semper. Aliquam tortor ex, faucibus nec rhoncus eget, pretium quis dui. Phasellus sodales, ex vitae tincidunt auctor, metus felis sodales ligula, sed blandit leo risus ac orci. Pellentesque ac dui ut erat mollis faucibus.
		</p>
	</li>
	<li>
		<p>
			Sed sit amet velit sodales, mattis ligula sit amet, pharetra dolor. Praesent laoreet vehicula dui non luctus. Vestibulum sollicitudin ex malesuada posuere dignissim. Proin sagittis eleifend ex at iaculis. Nulla facilisi. Sed odio elit, lobortis et erat at, feugiat efficitur velit. Fusce mauris neque, imperdiet et mauris quis, hendrerit porta libero. Curabitur in est et libero lacinia elementum.
		</p>
	</li>
	<li>
		<p><b>Domicilios; notificaciones</b></p>
		<p>
			Pellentesque quam diam, tristique in est eu, cursus pharetra ex. Morbi eu elit feugiat, aliquam turpis et, sagittis felis. Maecenas mollis fermentum sem at facilisis. Vestibulum finibus ex non mi sodales faucibus. Duis porta est pulvinar nunc euismod auctor. Nam tincidunt fermentum odio, a sollicitudin orci tempor non. Integer quis convallis magna. Nulla pulvinar nec leo at eleifend. Vivamus finibus, enim non rutrum feugiat, ipsum sem vestibulum quam, at molestie nisi sem non lectus. Aliquam a ullamcorper massa. Curabitur malesuada erat ut dui gravida, nec laoreet mauris accumsan. Maecenas vulputate consectetur est vitae malesuada. In fringilla metus nisi, in porta ipsum posuere in. Nunc id efficitur dolor. Vestibulum consectetur maximus enim eget ultricies.
		</p>
	</li>
	<li>
		<p><b>Integridad, autenticidad y archivo de los mensajes de datos</b></p>
		<p>
			Cras ut nulla eget enim posuere tincidunt nec at eros. Curabitur ante nisl, varius vitae fermentum id, faucibus ut metus. In dapibus odio non est fringilla, ut iaculis magna dapibus. Suspendisse auctor tempor metus eget molestie. In fermentum auctor aliquam. Quisque placerat nibh sit amet rhoncus pellentesque. Duis et tellus vel urna ornare mollis. Maecenas sit amet rutrum purus. Donec iaculis est vitae purus lobortis, ut dignissim metus imperdiet. In consequat pretium viverra. Phasellus eget ex nec libero laoreet volutpat. Nullam porttitor, massa porttitor euismod bibendum, odio neque vehicula nisl, non porttitor magna orci vitae quam. Nunc vehicula non tellus eu aliquet. Nulla pharetra vehicula purus, nec tempus quam posuere accumsan. In hac habitasse platea dictumst. Morbi at placerat magna.
		</p>
	</li>
</ol>
';
$lang['USER_ACCOUNT_VERIFICATION'] = 'Verificación de cuenta';
$lang['USER_MSG_ACCESS_ACCOUNT'] = '<p>Si aún no posees usuario para acceder al sistema <strong>%s</strong>, a continuación debes proporcionar los siguientes datos relacionados con tu cuenta:</p>';
$lang["USER_CONT_PROTECTION_TITLE"]='Contrato de protección';
$lang["USER_CONT_PROTECTION_SUBTITLE"]='Protección de datos personales';
$lang["USER_CONT_PROTECTION_CONTENT"] = '
<div class="justify pr-3">
	<p>Se informa que los datos personales proporcionados por el CLIENTE a TEBCA quedan incorporados al banco de datos de clientes de TEBCA. Dicha información será utilizada para efectos de la gestión de los servicios objeto del presente Contrato (incluyendo procesamiento de datos, remisión de correspondencia, entre otros), la misma que podrá ser realizada a través de terceros.</p>
	<p>TEBCA protege el banco de datos y sus tratamientos con todas las medidas de índole técnica y organizativa necesarias para resguardar su seguridad y evitar alteración, pérdida, tratamiento o acceso no autorizado.</p>
	<p>Mediante la aceptación a estos términos, usted autoriza a TEBCA a utilizar, en tanto esta autorización no sea revocada, sus datos personales, incluyendo datos sensibles, que hubieran sido proporcionados directamente a TEBCA, aquellos que pudieran encontrarse en fuentes accesibles para el público o los que hayan sido obtenidos de terceros; para tratamientos que supongan desarrollo de acciones comerciales, incluyendo la remisión (vía medio físico, electrónico o telefónico) de publicidad, información u ofertas/promociones (personalizadas o generales) de servicios de TEBCA y/o de otras empresas del Grupo Intercorp y sus socios estratégicos, entre las que se encuentran aquellas difundidas en el portal de la Superintendencia del Mercado de Valores (<a	href="http://www.smv.gob.pe" target="_blank">www.smv.gob.pe</a>) así como en el portal <a	href="http://www.intercorp.com.pe/es" target="_blank">www.intercorp.com.pe/es.</a> El CLIENTE autoriza a TEBCA la cesión, transferencia o comunicación de sus datos personales, a dichas empresas y entre ellas.</p>
	<p>El otorgamiento de la presente autorización es libre y voluntaria por lo que no condiciona el otorgamiento y/o gestión de los servicios ofrecidos por TEBCA.</p>
  <p>Usted puede revocar la autorización para el tratamiento de sus datos personales en cualquier momento, así como ejercer los derechos de acceso, rectificación, cancelación y oposición para el tratamiento de sus datos personales. Para ejercer este derecho, o cualquier otro previsto en las normas de protección de datos personales, usted deberá presentar su solicitud en la oficina de TEBCA o a través del Centro de Contacto.</p>
</div>
';
$lang["USER_CONT_BENEFITS_TITLE"]='Contrato de dinero electrónico';
$lang["USER_CONT_BENEFITS_SUBTITLE"]='Contrato de cuenta dinero electrónico Plata Beneficios';
$lang["USER_CONT_BENEFITS_CONTENT"] = '
<div class="justify pr-3">
  <p>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at posuere ex. Quisque maximus, ligula vitae porta fringilla, libero massa dapibus neque, non gravida leo odio eu est. Nam sit amet turpis turpis. Nunc aliquet dolor quis iaculis tincidunt.
  </p>
	<p><b>PRIMERA. DEFINICIONES:</b></p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non blandit nulla. Donec.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sodales. </p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque auctor ipsum sed magna elementum lobortis. Praesent.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium. Phasellus a euismod neque. In eu quam id urna aliquet interdum. Nulla facilisi.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium. Phasellus a euismod neque. In eu quam id urna aliquet interdum.</p>

	<p><b>SEGUNDA. OBJETO:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium. Phasellus a euismod neque.</p>

	<p><b>TERCERA. CONDICIÓN PARA LA PRESTACIÓN DEL SERVICIO:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium. Phasellus a euismod neque. In eu quam id urna aliquet interdum.</p>

	<p><b>CUARTA. CARACTERÍSTICAS Y CONDICIONES DE LAS OPERACIONES, LÍMITES Y RESTRICCIONES:</b></p>
	<p>4.1 Operaciones</p>
	<ol type="a">
		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin.</li>
		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin sollicitudin erat id pellentesque. Donec porttitor sollicitudin pharetra. Aenean vulputate ac lectus vitae finibus. Maecenas interdum quam in massa aliquam pretium. Phasellus a euismod neque. In eu quam id urna aliquet interdum.</li>
		<li> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis mi rutrum, eu interdum leo ultricies. Praesent molestie nisi eu pretium pretium. Nunc arcu erat, pretium quis turpis luctus, eleifend sollicitudin nunc.</li>
		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim.</li>
	</ol>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi.</p>
	<p>4.2 Límites y Restricciones</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo.</p>

	<p style="font-size:75%; border-top: 1px solid #000; padding-top:5px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel.</p>

	<p><b>QUINTA. CONDICIONES DE USO DE LA TARJETA:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis mi rutrum, eu interdum leo ultricies. Praesent molestie nisi eu pretium pretium.</p>

	<p><b>SEXTA. CLAVE SECRETA:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis mi rutrum, eu interdum leo ultricies.</p>

	<p><b>SÉPTIMA. BLOQUEO DE TARJETAS:</b></p>
	<p><b>A. POR HURTO, ROBO, EXTRAVIO DE TARJETA O PERDIDA DE CLAVE SECRETA</b></p>
	<p>7.1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim.</p>
	<p>7.2. En caso exista saldo remanente en la Cuenta bloqueada:</p>
	<p> (i) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo.</p>
	<p>(ii) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur.</p>
	<p><b>B. POR OTROS MOTIVOS</b></p>
	<p>7.3. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam.</p>
	<p>7.4. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis mi rutrum.</p>
	<p><b>C. POR PARTE DE SERVITEBCA</b></p>
	<p>7.5. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis.</p>

	<p><b>OCTAVA. EXCLUSIÓN DE RESPONSABILIDAD:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo.</p>

	<p style="font-size:75%; border-top: 1px solid #000; padding-top:5px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus.</p>

	<p><b>NOVENA. PLAZO:</b> El presente Contrato es de plazo indeterminado.</p>

	<p><b>DÉCIMA. RESOLUCIÓN:</b>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam:</p>
	<p>a) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam;</p>
	<p>b) Lorem ipsum dolor sit amet;</p>
	<p>c) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus;</p>
	<p>d) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam;</p>
	<p>e) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus.</p>

	<p><b>UNDÉCIMA. TARIFAS DE SERVICIOS:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor, est tortor viverra enim, quis feugiat orci dui sed ligula. Nam suscipit turpis quis mi rutrum, eu interdum leo ultricies. Praesent molestie nisi eu pretium pretium. Nunc arcu erat, pretium quis turpis luctus, eleifend sollicitudin nunc.</p>

	<p><b>DUODÉCIMA. OBLIGACIONES DE SERVITEBCA:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim. Nam fringilla, elit nec rutrum auctor.</p>

	<p><b>DÉCIMO TERCERA. OBLIGACIONES DE EL CLIENTE:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia tempus quam. Aliquam at mauris dapibus, consequat elit auctor, accumsan mi. Ut scelerisque urna odio, ut ullamcorper risus gravida vel. Suspendisse fermentum ultricies tempus. Etiam eget scelerisque augue, vel ultricies justo. Nam eu est a enim sollicitudin finibus. Nullam ex diam, accumsan vitae efficitur consequat, finibus non enim.</p>

	<p><b>DÉCIMO CUARTA. COMUNICACIONES:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna. Nunc convallis consequat massa ut fermentum. Praesent interdum massa nulla, eu viverra purus feugiat consequat. Mauris ultricies volutpat accumsan. Phasellus lobortis elit orci, eget aliquam magna ultrices a. Quisque tincidunt, magna auctor feugiat facilisis, erat enim malesuada lectus, sed tristique velit nibh eu leo. Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</p>

	<p style="font-size:75%; border-top: 1px solid #000; padding-top:5px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna. Nunc convallis consequat massa ut fermentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

	<p><b>DÉCIMO QUINTA. AUTORIZACIÓN:</b>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna. Nunc convallis consequat massa ut fermentum. Praesent interdum massa nulla, eu viverra purus feugiat consequat. Mauris ultricies volutpat accumsan. Phasellus lobortis elit orci, eget aliquam magna ultrices a. Quisque tincidunt, magna auctor feugiat facilisis, erat enim malesuada lectus, sed tristique velit nibh eu leo.</p>

	<p><b>DÉCIMO SEXTA. PROTECCIÓN DE DATOS PERSONALES<span style="font-size:85%;"><b><sup>4</sup></b></span>:Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna. Nunc convallis consequat massa ut fermentum. Praesent interdum massa nulla, eu viverra purus feugiat consequat. Mauris ultricies volutpat accumsan. Phasellus lobortis elit orci, eget aliquam magna ultrices a. Quisque tincidunt, magna auctor feugiat facilisis, erat enim malesuada lectus, sed tristique velit nibh eu leo. Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur. </p>
	<p>Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur. </p>

	<p style="font-size:75%; border-top: 1px solid #000; padding-top:5px;">Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur.</p>

	<p><b>DÉCIMO SÉPTIMA. DOMICILIO, SOLUCIÓN DE CONTROVERSIAS, LEGISLACIÓN APLICABLE Y DECLARACIÓN DE CONFORMIDAD:</b> Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur. </p>

	<p><b>DÉCIMO OCTAVA. TEXTO DEL CONTRATO:</b> Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis.</p>

</div>
';
$lang["USER_CONT_GENERAL_TITLE"]='Contrato de dinero electrónico';
$lang["USER_CONT_GENERAL_SUBTITLE"]='Contrato de cuenta dinero electrónico PN cuenta general';
$lang["USER_CONT_GENERAL_CONTENT"] = '
<div class="justify pr-3">
	<ol>
		<li>
			<p><b>DEFINICIONES:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna. Nunc convallis consequat massa ut fermentum. Praesent interdum massa nulla, eu viverra purus feugiat consequat. Mauris ultricies volutpat accumsan. Phasellus lobortis elit orci, eget aliquam magna ultrices a. Quisque tincidunt, magna auctor feugiat facilisis, erat enim malesuada lectus, sed tristique velit nibh eu leo. Vestibulum luctus felis in viverra tincidunt. Pellentesque sagittis neque in elit ullamcorper, sit amet auctor nibh porta. Cras varius pulvinar libero, eu vulputate eros. Maecenas et purus nec odio accumsan rutrum eu et est. Ut efficitur imperdiet enim eget fringilla. Cras nec lorem at nisl placerat pretium vel vitae turpis. Donec porttitor efficitur mi eu suscipit. Nunc mollis mauris nec venenatis auctor. Curabitur dictum interdum molestie. Curabitur.</p>
			</ul>
		</li>
		<li>
			<p><b>OBJETO:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</p>
			</ul>
		</li>
		<li>
			<p><b>CONDICIÓN PARA LA PRESTACIÓN DEL SERVICIO:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</p>
			</ul>
		</li>
		<li>
			<p><b>CARACTERÍSTICAS Y CONDICIONES DE LAS OPERACIONES, LÍMITES Y RESTRICCIONES:</b></p>
			<ol>
				<p>4.1 Operaciones</p>
				<ol type="a">
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna.</li>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl.</p>
				</ol>
				<p>4.2 Límites y Restricciones</p>
				<ol>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices.</p>
				</ol>
			</ol>
		</li>
		<li>
			<p><b>CONDICIONES DE USO DE LA TARJETA:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna.</p>
			</ul>
		</li>
		<li>
			<p><b>CLAVE SECRETA:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna.</p>
			</ul>
		</li>
		<li>
			<p><b>BLOQUEO DE TARJETAS:</b></p>
			<ol type="A">
				<li>POR HURTO, ROBO, EXTRAVIO DE TARJETA O PERDIDA DE CLAVE SECRETA</li>
				<ol>
					<p>7.1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien. Phasellus venenatis finibus orci, egestas consectetur urna.</p>
				</ol>
				<ol>
					<p>En caso exista saldo remanente en la Cuenta bloqueada:</p>
					<ol type="i">
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh.</li>
					</ol>
				</ol>
				<li>POR OTROS MOTIVOS</li>
				<ol>
					<p>7.3 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl.</p>
					<p>7.4 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh.</p>
				</ol>
				<li>POR PARTE DE SERVITEBCA</li>
				<ol>
					<p>7.5 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien.</p>
				</ol>
			</ol>
		</li>
		<li>
			<p><b>EXCLUSIÓN DE RESPONSABILIDAD:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie.</p>
			</ul>
		</li>
		<li>
			<p><b>PLAZO:</b></p>
			<ul>
				<p>El presente Contrato es de plazo indeterminado.</p>
			</ul>
		</li>
		<li>
			<p><b>RESOLUCIÓN:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed:</p>
				<ol type="a">
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed;</li>
					<li>Lorem ipsum dolor sit amet;</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien;</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed;</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed;</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie.</li>
				</ol>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</p>
			</ul>
		</li>
		<li>
			<p><b>TARIFAS DE SERVICIOS:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec. Maecenas sed dolor sapien.</p>
			</ul>
		</li>
		<li>
			<p><b>OBLIGACIONES DE SERVITEBCA:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo, eget tristique lorem venenatis nec.</p>
			</ul>
		</li>
		<li>
			<p><b>OBLIGACIONES DE EL CLIENTE:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien. Donec consectetur arcu nisl, ac pretium massa aliquam ultrices. Ut metus mi, semper in luctus et, commodo eu nibh. Morbi diam sapien, auctor id tortor eu, pulvinar vehicula libero. Sed euismod ullamcorper molestie. Ut gravida maximus justo.</p>
			</ul>
		</li>
		<li>
			<p><b>COMUNICACIONES:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dictum aliquet magna, eget posuere elit finibus ut. Sed ut interdum arcu. Suspendisse egestas dapibus eros nec imperdiet. Donec suscipit urna maximus ligula pretium, id consectetur nisi dignissim. Nunc laoreet egestas ante vitae eleifend. Nam aliquet metus a nulla semper, at tempor elit congue. Aenean in varius dui. Aliquam id libero nec lectus vehicula sodales. In mattis est quis consectetur tempus. Praesent blandit dui in est hendrerit, dictum auctor est volutpat. Donec fringilla fringilla dictum. Nam condimentum mattis metus, a semper turpis posuere vitae. Aliquam libero dui, placerat nec consectetur ut, cursus feugiat elit. Nulla tempus non nisl at consectetur. Nam vitae laoreet quam, sit amet cursus nunc. Maecenas imperdiet malesuada augue ut lobortis. Ut at auctor lectus, quis tincidunt mauris. Nam mattis fermentum viverra. Nunc euismod arcu sed leo vehicula, vitae facilisis mauris pharetra. Nulla auctor, nulla a pulvinar suscipit, metus est sodales turpis, in imperdiet purus nisi eu arcu. Vivamus semper fermentum justo, id vestibulum enim dapibus eu. Aenean ultrices aliquam hendrerit. Donec at ex vel sapien venenatis tristique. Cras mattis est arcu, ut imperdiet massa dapibus id. Curabitur id viverra sapien, non tristique nisi. Mauris non ipsum augue. Praesent sed metus at purus vehicula sagittis. Mauris mattis bibendum mattis. Integer ut turpis urna. Sed at pellentesque mi. Morbi finibus erat id quam fermentum, ut consectetur enim molestie. Nulla commodo, turpis ut ullamcorper consequat, ex tellus vehicula augue, in sodales dui quam eu tellus. Sed tristique tincidunt lacus sit amet porta. Phasellus ante justo, vestibulum nec placerat eu, tristique id ante. Nullam sit amet luctus quam. Nam mauris velit, molestie tincidunt venenatis condimentum, tincidunt quis justo. In vehicula mi sit amet tincidunt tincidunt. Maecenas rhoncus facilisis velit, eu ultricies elit dapibus et. Aenean sollicitudin nisi tellus, vel lacinia dui.Integer ut turpis urna. Sed at pellentesque mi. Morbi finibus erat id quam fermentum, ut consectetur enim molestie. Nulla commodo, turpis ut ullamcorper consequat, ex tellus vehicula augue, in sodales dui quam eu tellus. Sed tristique tincidunt lacus sit amet porta. Phasellus ante justo, vestibulum nec placerat eu, tristique id ante. Nullam sit amet luctus quam. </p>
			</ul>
		</li>
		<li>
			<p><b>AUTORIZACIÓN:</b></p>
			<ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dictum aliquet magna, eget posuere elit finibus ut. Sed ut interdum arcu. Suspendisse egestas dapibus eros nec imperdiet. Donec suscipit urna maximus ligula pretium, id consectetur nisi dignissim. Nunc laoreet egestas ante vitae eleifend. Nam aliquet metus a nulla semper, at tempor elit congue. Aenean in varius dui. Aliquam id libero nec lectus vehicula sodales. In mattis est quis consectetur tempus. Praesent blandit dui in est hendrerit, dictum auctor est volutpat. Donec fringilla fringilla dictum. Nam condimentum mattis metus, a semper turpis posuere vitae. Aliquam libero dui, placerat nec consectetur ut, cursus feugiat elit. Nulla tempus non nisl at consectetur. Nam vitae laoreet quam, sit amet cursus nunc. Maecenas imperdiet malesuada augue ut lobortis. Ut at auctor lectus, quis tincidunt mauris. Nam mattis fermentum viverra. Nunc euismod arcu sed leo vehicula, vitae facilisis mauris pharetra.</p>
			</ul>
		</li>
		<li>
			<p><b>DOMICILIO, SOLUCIÓN DE CONTROVERSIAS, LEGISLACIÓN APLICABLE Y DECLARACIÓN DE CONFORMIDAD:</b></p>
			<ul>
				<p>16.1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.Ut gravida maximus justo.</p>
				<p>16.2. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis.</p>
				<p>16.3. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel, ultrices sapien.</p>
			</ul>
		</li>
		<li>
			<p><b>TEXTO DEL CONTRATO:</b></p>
			<ul>
				<p>17.1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis.</p>
				<p>17.2. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sem libero, sagittis bibendum ex sed, imperdiet fermentum nisi. Vestibulum eget risus bibendum, tincidunt massa in, sagittis nisl. Cras eget erat finibus, cursus est vel.</p>
			</ul>
		</li>
	</ol>
</div>
';
//SIGNUP-PROFILE
$lang['USER_PROFILE_TITLE'] = 'Perfil de usuario';
$lang['USER_SIGNUP_MSG'] = 'Para crear tu usuario de <span class="semibold">%s,</span> es necesario que ingreses los datos requeridos a continuación';
$lang['USER_PERSONAL_DATA'] = 'Datos personales';
$lang['USER_CONTACT_DATA'] = 'Datos de contacto';
$lang['USER_DATA_USER'] = 'Datos de usuario';
$lang['USER_ID_TYPE'] = 'Tipo de identificación';
$lang['USER_ID_NUMBER'] = 'Número de identificación';
$lang['USER_FIRSTNAME'] = 'Primer nombre';
$lang['USER_MIDDLENAME'] = 'Segundo nombre';
$lang['USER_LASTNAME'] = 'Primer apellido';
$lang['USER_SURNAME'] = 'Segundo apellido';
$lang['USER_BIRTHDATE'] = 'Fecha de nacimiento';
$lang['USER_GENDER'] = 'Sexo';
$lang['USER_NATIONALITY'] = 'Nacionalidad';
$lang['USER_PLACEBIRTH'] = 'Lugar de nacimiento';
$lang['USER_CIVILSTATUS'] = 'Estado civil';
$lang['USER_CIVILSTATUS_LIST'] = [
	'' => 'Selecciona',
	'S' => 'Soltero',
	'C' => 'Casado',
	'V' => 'Viudo'
];
$lang['USER_EMPLOY_SITUATION_LIST'] = [
	'' => 'Selecciona',
	'0' => 'Independiente',
	'1' => 'Dependiente'
];
$lang['USER_VERIFIERCODE'] = 'Digito verificador';
$lang['USER_GENDER_MALE'] = 'Masculino';
$lang['USER_GENDER_FEMALE'] = 'Femenino';
$lang['USER_PROFESSION'] = 'Profesión';
$lang['USER_ADDRESS_TYPE'] = 'Tipo de dirección';
$lang['USER_ADDRESS'] = 'Dirección';
$lang['USER_DISTRICT'] = 'Distrito';
$lang['USER_ADDRESS_TYPE_LIST'] = [
	'' => 'Selecciona',
	'1' => 'Habitacional',
	'2' => 'Laboral',
	'3' => 'Comercial'
];
$lang['USER_POSTAL_CODE'] = 'Código postal';
$lang['USER_STATE'] = 'Departamento';
$lang['USER_CITY'] = 'Provincia';
$lang['USER_DISTRICT'] = 'Distrito';
$lang['USER_PHONE_LANDLINE'] = 'Teléfono fijo';
$lang['USER_PHONE_MOBILE'] = 'Teléfono móvil';
$lang['USER_PHONE_OTHER'] = 'Otro teléfono';
$lang['USER_OTHER_PHONE_LIST'] = [
	'' => 'Selecciona',
	'OFC' => 'Laboral',
	'FAX' => 'Fax',
	'OTRO' => 'Otro'
];
$lang['USER_EMAIL'] = 'Correo electrónico';
$lang['USER_CONFIRM_EMAIL'] = 'Confirmar correo electrónico';
$lang['USER_NICK_NAME'] = 'Nombre de usuario';
$lang['USER_REGISTRY_DATE'] = 'Fecha de registro';
$lang['USER_NOTIFICATIONS'] = 'Notificaciones';
$lang['USER_NOT_EMAIL'] = 'Correo electrónico';
$lang['USER_NOT_SMS'] = 'SMS';
$lang['USER_PASSWORD_CHANGE'] = 'Cambiar contraseña';
$lang['USER_OPER_PASS_CHANGE'] = 'Cambiar clave de operaciones';
$lang['USER_SMS_PASSS_CHANGE'] = 'Cambiar clave de SMS';
$lang['USER_LABOR_DATA'] = 'Datos laborales';
$lang['USER_FISCAL_REGISTRY'] = 'RUC.';
$lang['USER_WORK_CENTER'] = 'Centro laboral';
$lang['USER_EMPLOYMENT_STATUS'] = 'Situación laboral';
$lang['USER_EMPLOYMENT_STATUS_LIST'] = [
	'' => 'Selecciona',
	'0' => 'Independiente',
	'1' => 'Dependiente'
];;
$lang['USER_SENIORITY'] = 'Antigüedad laboral';
$lang['USER_OCCUPATION'] = 'Ocupación, oficio o profesión';
$lang['USER_CHARGE'] = 'Cargo';
$lang['USER_AVERAGE_MONTHLY'] = 'Ingreso promedio mensual';
$lang['USER_PUBLIC_OFFICE'] = '¿Desempeñó cargo público en los últimos 2 años?';
$lang['USER_PUBLIC_POSITION'] = 'Cargo público';
$lang['USER_INSTITUTION'] = 'Institución';
$lang['USER_ARTICLE_LAW'] = '¿Es sujeto obligado a informar UIF-Perú, conforme al artículo 3° de la ley N°29038?';
$lang['USER_LOAD_DOCS'] = 'Carga de documentos de identidad';
$lang['USER_LOAD_DOCS_STEP'] = 'Carga de documentos';
$lang['USER_ADD_PHOTO'] = 'Agregar foto';
$lang['USER_ADD_F_DOC'] = 'Agregar anverso del documento de identidad';
$lang['USER_ADD_B_DOC'] = 'Agregar reverso del documento de identidad';
$lang['USER_ADD_F_PASSPORT'] = 'Agregar anverso del pasaporte';
$lang['USER_ADD_B_PASSPORT'] = 'Agregar reverso del pasaporte';
$lang['USER_LOAD_DOCS_TITLE'] = 'Requisitos para la carga de imágenes:';
$lang['USER_LOAD_DOCS_INFO1'] = 'Es posible que se le soliciten documentos adicionales.';
$lang['USER_LOAD_DOCS_INFO2'] = 'Sólo se permiten archivos en formato PNG o JPEG.';
$lang['USER_LOAD_DOCS_INFO3'] = 'Las imágenes deben ser en color, claras y legibles.';
$lang['USER_LOAD_DOCS_INFO4'] = 'El tamaño del archivo debe ser mayor a %s kb y menor a %s kb.';
$lang['USER_LOAD_DOCS_INFO5'] = 'Su documento de Identidad debe encontrarse en vigencia.';
$lang['USER_UPDATE_SUCCESS'] = 'Los datos fueron actualizados exitosamente.';
$lang['USER_UPDATE_FAIL'] = 'No fue posible actualizar los datos del usuario, por favor intentalo de nuevo';
$lang['USER_IDENTIFY_EXIST'] = 'Ya existe un usuario de %s con los datos ingresados. Verifica tu información e intenta nuevamente.';
$lang['USER_INVALID_DATE'] = 'No fue posible validar tus datos, por favor vuelve a intentarlo.';
$lang['USER_STEP_TITLE_REGISTRY'] = [$lang['USER_PERSONAL_DATA'], $lang['USER_CONTACT_DATA'], $lang['USER_DATA_USER'], $lang['USER_LOAD_DOCS_STEP']];
$lang['USER_STEP_TITLE_REGISTRY_LONG'] = [$lang['USER_PERSONAL_DATA'], $lang['USER_CONTACT_DATA'], $lang['USER_LABOR_DATA'], $lang['USER_DATA_USER'], $lang['USER_LOAD_DOCS_STEP'], $lang['USER_LEGAL_STEP']];
$lang['USER_SAVE_BTN_MSG'] = '* Al presionar el boton guardar, se guardaran los pasos del 1 al ';
// RECOVER ACCESS
$lang['USER_RECOVER_DOC_TYPE'] = [
	'' => 'Selecciona',
	'CC' => 'Cédula de ciudadania',
	'PP' => 'Pasaporte',
];
$lang['USER_VALUE_DOCUMENT_ID'] = ['CC'];
//USER SIGN UP
$lang['USER_SATISFACTORY_REG'] = 'El registro se ha hecho satisfactoriamente, por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
$lang['USER_REG_NOT_CONFIRMED'] = 'El registro fue realizado; aunque no fue posible enviar el correo de confirmación. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
$lang['USER_REG_SOME_DATA'] = 'El registro fue realizado; algunos datos no fueron cargados en su totalidad.</br> Por favor complétalos en la sección de <strong>Perfil.</strong>"<br>. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
$lang['USER_REG_INACTIVE_CARD'] = 'El registro fue realizado; aunque tu tarjeta no fue activada. Comunícate con el <strong>Centro de Contacto</strong>.<br>. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
$lang['USER_REGISTERED_MAIL'] = 'El correo eléctronico que indicas ya se encuentra registrado, intenta con otro.';
$lang['USER_REGISTERED_PHONE'] = 'El telefóno movil que indicas ya se encuentra registrado, intenta con otro.';
$lang['USER_CHECK_DATA'] = 'Verifica tus datos e intenta de nuevo. <br>Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta.';
$lang['USER_NOT_VALIDATE_DATA'] = 'No fue posible validar tus datos, por favor verifícalos e intenta nuevamente.';
$lang['USER_VERIFY_DNI'] = 'Verifica tu DNI en RENIEC e intenta de nuevo. <br> Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta.';
$lang['USER_ACCEPT_TERMS'] = 'Debes aceptar los terminos y condiciones para continuar disfrutando del servicio.';
$lang['USER_ELECTRONIC_MONEY'] = 'Completa el formulario para activar tu tarjeta (Dinero electrónico).';
//CARD LIST
$lang['USER_CHECK_BALANCE'] = 'Click para consultar tu saldo';
//SESSION EXPIRE
$lang['USER_TIME_EXPIRE'] = 'El tiempo permitido para realizar la operación expiró, intenta nuevamente.';
