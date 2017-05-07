<?php
$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
if ($skin == 'latodo') {
	$signupLink = $this->config->item('base_url') . '/registro/index_pe';
	$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin_pe';
	$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword_pe';
} else {
	$signupLink = $this->config->item('base_url') . '/registro';
	$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin';
	$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword';
}
?>
<div id="slideshow">
	<ul class="slides">
		<li class="slide current-slide" data-slide="">
			<p class="slide-title">Bienvenido a Conexión Personas Online</p>
			<p>Acceso directo a tu cuenta/tarjeta para consultas y operaciones, 7x24</p>
		</li>
	</ul>
</div>

<!-- MODAL -->

		 <div id="dialog-overlay" style='display:none'>
		 	<header>
				<h2>Contraseña temporal caducada</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Su contraseña temporal <strong>ha cadudado</strong>. Dirijase al módulo "Olvidé mi Contraseña", para restaurarla. Recuerde cambiar su contraseña en un plazo <strong>menor</strong> de 24 horas. </p>
				</div>
				<div class="form-actions">
					<button id="caducado">Aceptar</button>
				</div>
			</div>
		</div>
<!-- PASSWORD VENCIDOO -->

		 <div id="dialog-overlay1" style='display:none'>
		 	<header>
				<h2>Contraseña caducada</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Su contraseña <strong>ha cadudado</strong>. </p>
				</div>
				<div class="form-actions">
					<button id="caducado1">Aceptar</button>
				</div>
			</div>
		</div>

<!-- MODAL LOGIN O CLAVE INVALIDO -->

		 <div id="dialog-login" style='display:none'>
		 	<header>
				<h2>Usuario o Contraseña Inválido</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Usuario o Contraseña <strong>inválido</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido">Aceptar</button>
				</div>
			</div>
		</div>

<!-- MODAL ERROR -->

		 <div id="dialog-error" style='display:none'>
		 	<header>
				<h2>Error en el sistema</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Ha ocurrido un error en el sistema. Por favor <strong>inténtelo</strong> más tarde.</p>
				</div>
				<div class="form-actions">
					<button id="error">Aceptar</button>
				</div>
			</div>
		</div>

		<div id="dialog-voygo-error" style='display:none'>
		 	<header>
				<h2>Error de acceso</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Usted no posee un usuario del portal <strong>Voygo Usuarios</strong>.</p>
				</div>
				<div class="form-actions">
					<button id="error-voygo">Aceptar</button>
				</div>
			</div>
		</div>


		<!-- MODAL ERROR -->

		 <div id="dialog-bloq" style='display:none'>
		 	<header>
				<h2>Usuario Bloqueado</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>¿Olvidate tu <a href="<?php echo $recoverUserLink; ?>" rel="section">usuario</a> o <a href="<?php echo $recoverPwdLink; ?>" rel="section">contraseña</a>?</p>
				</div>
				<div class="form-actions">
					<button id="aceptar">Aceptar</button>
				</div>
			</div>
		</div>
